<?php

namespace Tests\Unit;

use App\Services\VkNotifierService;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Tests\TestCase;

class VkNotifierServiceTest extends TestCase
{
    public function test_it_sends_a_message_to_the_configured_vk_user(): void
    {
        config([
            'services.vk.token_order' => 'vk-test-token',
            'services.vk.vk_admin_id' => '5903492',
            'services.vk.api_version' => '5.199',
        ]);
        Http::fake([
            'api.vk.com/method/messages.send' => Http::response(['response' => 123], 200),
        ]);

        app(VkNotifierService::class)->send('Тестовое сообщение');

        Http::assertSent(fn ($request) => $request->method() === 'POST'
            && $request->url() === 'https://api.vk.com/method/messages.send'
            && $request['access_token'] === 'vk-test-token'
            && $request['user_id'] === '5903492'
            && $request['v'] === '5.199'
            && $request['message'] === 'Тестовое сообщение'
            && is_int($request['random_id']));
    }

    public function test_it_throws_when_vk_returns_an_error(): void
    {
        config([
            'services.vk.token_order' => 'vk-test-token',
            'services.vk.vk_admin_id' => '5903492',
        ]);
        Http::fake([
            'api.vk.com/method/messages.send' => Http::response([
                'error' => ['error_msg' => 'VK test error'],
            ], 200),
        ]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('VK test error');

        app(VkNotifierService::class)->send('Тестовое сообщение');
    }

    public function test_it_does_not_send_when_vk_credentials_are_missing(): void
    {
        config([
            'services.vk.token_order' => '',
            'services.vk.vk_admin_id' => '',
        ]);
        Http::fake();

        try {
            app(VkNotifierService::class)->send('Тестовое сообщение');
            $this->fail('Ожидалось исключение при отсутствующих настройках VK.');
        } catch (RuntimeException $exception) {
            $this->assertSame('Не настроены параметры отправки сообщения во ВКонтакте.', $exception->getMessage());
        }

        Http::assertNothingSent();
    }
}
