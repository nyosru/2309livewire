import test from 'node:test';
import assert from 'node:assert/strict';
import '../../browser-extension/protocol.js';

const protocol = globalThis.VkFriendManagerProtocol;

test('accepts a unique list of numeric friend IDs up to one VK page', () => {
    const result = protocol.validateStart({ type: 'VKFM_START', accountId: 12345, ids: [456, '789'] });
    assert.deepEqual(result, { accountId: '12345', ids: ['456', '789'] });
});

test('rejects malformed, duplicate, oversized, or unrelated messages', () => {
    assert.equal(protocol.validateStart({ type: 'OTHER', accountId: '1', ids: ['2'] }), null);
    assert.equal(protocol.validateStart({ type: 'VKFM_START', accountId: '1', ids: ['2', '2'] }), null);
    assert.equal(protocol.validateStart({ type: 'VKFM_START', accountId: '1', ids: ['2', 'x'] }), null);
    assert.equal(protocol.validateStart({ type: 'VKFM_START', accountId: '1', ids: Array(201).fill('2') }), null);
});

test('allows messages only from the production HTTPS site origin', () => {
    assert.equal(protocol.isAllowedSiteUrl('https://vk.php-cat.ru/'), true);
    assert.equal(protocol.isAllowedSiteUrl('http://vk.php-cat.ru/'), false);
    assert.equal(protocol.isAllowedSiteUrl('https://vk.php-cat.ru.attacker.example/'), false);
    assert.equal(protocol.isAllowedSiteUrl('https://vk.com/'), false);
});
