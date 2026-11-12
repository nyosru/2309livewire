'use strict';

const protocol = globalThis.VkFriendManagerProtocol;
let activeJob = false;

function sendStatus(tabId, payload) {
  return browser.tabs.sendMessage(tabId, { type: 'VKFM_STATUS', ...payload }).catch(() => {});
}

function waitForTab(tabId, timeoutMs = 20000) {
  return new Promise((resolve, reject) => {
    let settled = false;
    const finish = (callback, value) => {
      if (settled) return;
      settled = true;
      clearTimeout(timer);
      browser.tabs.onUpdated.removeListener(listener);
      callback(value);
    };
    const timer = setTimeout(() => {
      finish(reject, new Error('VK долго загружает страницу.'));
    }, timeoutMs);
    const listener = (changedId, info) => {
      if (changedId !== tabId || info.status !== 'complete') return;
      finish(resolve);
    };
    browser.tabs.onUpdated.addListener(listener);
    browser.tabs.get(tabId).then((tab) => {
      if (tab.status === 'complete') finish(resolve);
    }).catch((error) => finish(reject, error));
  });
}

function waitForNavigation(tabId, timeoutMs = 20000) {
  return new Promise((resolve, reject) => {
    const timer = setTimeout(() => {
      browser.tabs.onUpdated.removeListener(listener);
      reject(new Error('VK долго загружает страницу.'));
    }, timeoutMs);
    const listener = (changedId, info) => {
      if (changedId !== tabId || info.status !== 'complete') return;
      clearTimeout(timer);
      browser.tabs.onUpdated.removeListener(listener);
      resolve();
    };
    browser.tabs.onUpdated.addListener(listener);
  });
}

async function waitAndMessage(tabId, message, timeoutMs = 10000) {
  const deadline = Date.now() + timeoutMs;
  let lastError;
  while (Date.now() < deadline) {
    try {
      return await browser.tabs.sendMessage(tabId, message);
    } catch (error) {
      lastError = error;
      await new Promise((resolve) => setTimeout(resolve, 250));
    }
  }
  throw lastError || new Error('Страница VK не ответила.');
}

async function runJob(siteTabId, request) {
  let vkTabId = null;
  let keepTab = false;
  const results = [];
  const finish = async (phase, message, extra = {}) => {
    await sendStatus(siteTabId, { phase, message, results, ...extra });
  };
  try {
    const tab = await browser.tabs.create({ url: 'https://vk.com/', active: true });
    vkTabId = tab.id;
    await waitForTab(vkTabId);
    const account = await waitAndMessage(vkTabId, { type: 'VKFM_INSPECT_ACCOUNT' });
    if (account.state === 'security') {
      keepTab = true;
      await finish('stopped', 'VK запросил проверку безопасности. Обработка остановлена; завершите проверку вручную в открытой вкладке.');
      return;
    }
    if (account.state === 'login') {
      keepTab = true;
      await finish('stopped', 'В этой вкладке нет активного входа в VK. Войдите вручную, затем начните удаление снова.');
      return;
    }
    if (account.state !== 'account_ok') {
      keepTab = true;
      await finish('stopped', 'Не удалось достоверно определить аккаунт VK по интерфейсу. Удаление не запускалось.');
      return;
    }
    if (String(account.accountId) !== request.accountId) {
      await finish('stopped', `Аккаунт VK (${account.accountId}) не совпадает с аккаунтом сайта (${request.accountId}). Ничего не удалено.`);
      return;
    }

    for (let index = 0; index < request.ids.length; index += 1) {
      const id = request.ids[index];
      await finish('progress', `Проверяю профиль ${index + 1} из ${request.ids.length}: VK ID ${id}.`, { current: id, index, total: request.ids.length });
      const loaded = waitForNavigation(vkTabId);
      try {
        await browser.tabs.update(vkTabId, { url: `https://vk.com/id${id}` });
      } catch (error) {
        await loaded.catch(() => {});
        throw error;
      }
      await loaded;
      const result = await waitAndMessage(vkTabId, { type: 'VKFM_REMOVE_ONE', id });

      if (result.state === 'security') {
        keepTab = true;
        await finish('stopped', `VK запросил проверку безопасности на профиле ${id}. Пакет остановлен.`, { current: id, index, total: request.ids.length });
        return;
      }
      const labels = {
        removed: 'Удалён', already_removed: 'Уже не в друзьях', unavailable: 'Профиль недоступен',
        wrong_profile: `Остановлено: VK открыл другой профиль (ID ${result.id || 'неизвестен'})`,
        not_removed: 'VK не подтвердил удаление', unknown_ui: 'Неожиданный интерфейс VK; действие не подтверждено',
        unknown: 'Не удалось надёжно проверить страницу VK',
      };
      results.push({ id, state: result.state, label: labels[result.state] || 'Не удалось обработать профиль' });
      await finish('progress', `Обработано ${index + 1} из ${request.ids.length}.`, { current: id, index: index + 1, total: request.ids.length });

      if (result.state === 'wrong_profile' || result.state === 'unknown_ui' || result.state === 'unknown') {
        keepTab = true;
        await finish('stopped', `${labels[result.state]} (VK ID ${id}). Остальные профили не обработаны.`, { current: id, index, total: request.ids.length });
        return;
      }
    }
    await finish('complete', `Обработка завершена: ${results.filter((item) => item.state === 'removed').length} удалено, ${results.filter((item) => item.state !== 'removed').length} с другим результатом.`, { total: request.ids.length });
  } catch (error) {
    keepTab = vkTabId !== null;
    await finish('stopped', `Обработка остановлена: ${error.message || 'страница VK не ответила'}`);
  } finally {
    if (vkTabId !== null && !keepTab) await browser.tabs.remove(vkTabId).catch(() => {});
    activeJob = false;
  }
}

browser.runtime.onMessage.addListener((message, sender) => {
  if (!message || message.type !== 'VKFM_START') return undefined;
  if (!sender.url || !protocol.isAllowedSiteUrl(sender.url)) return Promise.resolve({ accepted: false, message: 'Запуск разрешён только со страницы vk.php-cat.ru.' });
  const request = protocol.validateStart(message);
  if (!request) return Promise.resolve({ accepted: false, message: 'Список ID не прошёл проверку.' });
  if (activeJob) return Promise.resolve({ accepted: false, message: 'Обработка уже запущена. Дождитесь её завершения.' });
  activeJob = true;
  runJob(sender.tab.id, request);
  return Promise.resolve({ accepted: true });
});
