(function (root) {
  'use strict';

  const SITE_ORIGIN = 'https://vk.php-cat.ru';
  const MAX_SELECTION = 200;
  const isId = (value) => /^(?:[1-9]\d{0,14})$/.test(String(value));

  function validateStart(payload) {
    if (!payload || payload.type !== 'VKFM_START' || !isId(payload.accountId)) return null;
    if (!Array.isArray(payload.ids) || payload.ids.length < 1 || payload.ids.length > MAX_SELECTION) return null;
    const ids = payload.ids.map(String);
    if (!ids.every(isId) || new Set(ids).size !== ids.length) return null;
    return { accountId: String(payload.accountId), ids };
  }

  function isAllowedSiteUrl(url) {
    try {
      const parsed = new URL(url);
      return parsed.origin === SITE_ORIGIN && parsed.protocol === 'https:';
    } catch (_) {
      return false;
    }
  }

  root.VkFriendManagerProtocol = { SITE_ORIGIN, MAX_SELECTION, validateStart, isAllowedSiteUrl };
})(globalThis);
