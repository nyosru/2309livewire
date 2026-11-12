(function () {
  'use strict';

  const normalize = (value) => (value || '').replace(/\s+/g, ' ').trim().toLocaleLowerCase('ru');
  const visible = (element) => !!element && !!(element.offsetWidth || element.offsetHeight || element.getClientRects().length);
  const exactControl = (labels) => [...document.querySelectorAll('button,a,[role="button"],[role="menuitem"]')]
    .find((element) => visible(element) && labels.includes(normalize(element.innerText || element.getAttribute('aria-label') || element.title)));
  const wait = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

  function isSecurityScreen() {
    const url = location.href.toLocaleLowerCase();
    const body = normalize(document.body?.innerText);
    return /captcha|security_check|restore|act=security_check/.test(url)
      || /введите код|подтвердите, что это вы|подозрительная активность|защитить страницу|капч|робот/.test(body);
  }

  function getAccountId() {
    const profileLink = [...document.querySelectorAll('a[href]')].find((anchor) => {
      const label = normalize(`${anchor.innerText} ${anchor.getAttribute('aria-label')} ${anchor.title}`);
      return label === 'моя страница' || label.includes('моя страница');
    });
    const match = profileLink?.href.match(/(?:vk\.com)?\/(?:id)(\d+)(?:[/?#]|$)/i);
    return match?.[1] || null;
  }

  function inspectProfile(targetId) {
    if (isSecurityScreen()) return { state: 'security' };
    if (/\/login(?:[/?#]|$)/i.test(location.pathname)) return { state: 'login' };
    const canonical = document.querySelector('link[rel="canonical"]')?.href || '';
    const urlId = location.pathname.match(/^\/id(\d+)(?:[/?#]|$)/)?.[1];
    const canonicalId = canonical.match(/vk\.com\/id(\d+)(?:[/?#]|$)/)?.[1];
    const id = canonicalId || urlId;
    if (!id) {
      const body = normalize(document.body?.innerText);
      if (/страница удалена|профиль удалён|пользователь не найден|страница недоступна/.test(body)) return { state: 'unavailable' };
      return { state: 'unknown' };
    }
    if (id !== String(targetId)) return { state: 'wrong_profile', id };
    return { state: 'profile_ok', id };
  }

  async function removeFriend(targetId) {
    if (isSecurityScreen()) return { state: 'security' };
    const addButton = exactControl(['добавить в друзья', 'подписаться']);
    if (addButton) return { state: 'already_removed' };

    let removeButton = exactControl(['удалить из друзей', 'убрать из друзей']);
    if (!removeButton) {
      const menu = exactControl(['у вас в друзьях', 'вы друзья', 'действия']);
      if (menu) {
        menu.click();
        await wait(300);
        removeButton = exactControl(['удалить из друзей', 'убрать из друзей']);
      }
    }
    if (!removeButton) return { state: 'unknown_ui' };

    removeButton.click();
    await wait(500);
    if (isSecurityScreen()) return { state: 'security' };
    // VK can ask for a second confirmation. Only accept an exact, visible confirmation control.
    const confirmation = exactControl(['удалить из друзей', 'удалить']);
    if (confirmation && !exactControl(['добавить в друзья', 'подписаться'])) {
      confirmation.click();
      await wait(800);
    }

    if (isSecurityScreen()) return { state: 'security' };
    if (exactControl(['добавить в друзья', 'подписаться'])) return { state: 'removed' };
    if (exactControl(['удалить из друзей', 'убрать из друзей'])) return { state: 'not_removed' };
    return { state: 'unknown_ui' };
  }

  browser.runtime.onMessage.addListener(async (message) => {
    if (message?.type === 'VKFM_INSPECT_ACCOUNT') {
      if (isSecurityScreen()) return { state: 'security' };
      if (/\/login(?:[/?#]|$)/i.test(location.pathname)) return { state: 'login' };
      const accountId = getAccountId();
      return accountId ? { state: 'account_ok', accountId } : { state: 'account_unknown' };
    }
    if (message?.type === 'VKFM_REMOVE_ONE') {
      const result = inspectProfile(message.id);
      if (result.state !== 'profile_ok') return result;
      return removeFriend(message.id);
    }
    return undefined;
  });
})();
