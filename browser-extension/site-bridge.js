(function () {
  'use strict';

  const protocol = globalThis.VkFriendManagerProtocol;

  document.addEventListener('click', async (event) => {
    const button = event.target instanceof Element ? event.target.closest('#start-friend-removal') : null;
    if (!button || !event.isTrusted) return;
    const ids = [...document.querySelectorAll('#friends-list input[name="friends[]"]:checked')].map((input) => input.value);
    const accountId = document.querySelector('main[data-vk-user-id]')?.dataset.vkUserId;
    const request = protocol.validateStart({ type: 'VKFM_START', accountId, ids });
    if (!request) {
      window.postMessage({ type: 'VKFM_STATUS', phase: 'error', message: ids.length ? 'Список выбранных ID не прошёл проверку.' : 'Сначала отметьте друзей на этой странице.' }, protocol.SITE_ORIGIN);
      return;
    }
    if (!window.confirm(`Удалить ${request.ids.length} выбранных друзей через открытую сессию VK?`)) {
      window.postMessage({ type: 'VKFM_STATUS', phase: 'cancelled', message: 'Удаление отменено.' }, protocol.SITE_ORIGIN);
      return;
    }
    window.postMessage({ type: 'VKFM_STATUS', phase: 'progress', message: 'Передаю проверенный список расширению Firefox…' }, protocol.SITE_ORIGIN);
    try {
      const response = await browser.runtime.sendMessage({ type: 'VKFM_START', ...request });
      if (!response || response.accepted !== true) {
        window.postMessage({ type: 'VKFM_STATUS', phase: 'error', message: response?.message || 'Не удалось запустить расширение.' }, protocol.SITE_ORIGIN);
      }
    } catch (_) {
      window.postMessage({ type: 'VKFM_STATUS', phase: 'error', message: 'Расширение Firefox не найдено. Загрузите его через about:debugging и обновите страницу.' }, protocol.SITE_ORIGIN);
    }
  }, true);

  browser.runtime.onMessage.addListener((message) => {
    if (!message || message.type !== 'VKFM_STATUS') return;
    window.postMessage(message, protocol.SITE_ORIGIN);
  });
})();
