<?php

namespace Tests\Feature\Vkusno;

use App\Models\Max\Recipient;
use App\Models\Max\Verification;
use App\Models\User;
use App\Models\Vkusno\Administrator;
use App\Models\Vkusno\PhoneAdministrator;
use App\Services\Max\MaxAuthService;
use App\Services\Max\MaxService;
use App\Services\Max\PhoneNumber;
use App\Services\Max\RecipientRegistry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class MaxAuthTest extends TestCase
{
    private string $host = 'http://vkusno.local';

    private string $phone = '+79121234567';

    private string $context = 'a-browser-context-with-at-least-32-characters';

    private int $maxStatus = 200;

    private bool $tlsFailure = false;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:',
            'cache.default' => 'array', 'vkusno.super_admin_vk_id' => '5903492',
            'vkusno.super_admin_phone' => '+79000000001',
            'max.bot_token' => 'test-max-token', 'max.bot_username' => 'test_cafe_bot',
            'max.webhook_secret' => 'a-secret-webhook-value', 'max.auth_driver' => 'bot',
            'max.service_clients' => ['project-a' => str_repeat('a', 40), 'project-b' => str_repeat('b', 40)],
        ]);
        foreach ([
            '2014_10_12_000000_create_users_table.php',
            '2025_09_18_131036_add_vk_token_to_user_table.php',
            '2025_09_19_063324_create_permission_tables.php',
            '2026_10_22_000001_create_vkusno_orders_table.php',
            '2026_10_22_000002_create_vkusno_products_table.php',
            '2026_10_22_000003_create_vkusno_menu_catalogs.php',
            '2026_10_22_000004_create_vkusno_administrators_table.php',
            '2026_10_22_000005_create_max_auth_tables.php',
            '2026_10_23_000006_create_application_settings_table.php',
            '2026_10_25_000007_add_vkusno_semi_finished_section.php',
        ] as $file) {
            (require database_path('migrations/'.$file))->up();
        }
        Cache::flush();
        Http::preventStrayRequests();
        Http::fake(['platform-api2.max.ru/*' => function ($request) {
            if ($this->tlsFailure) {
                throw new \GuzzleHttp\Exception\RequestException('TLS certificate failure', new \GuzzleHttp\Psr7\Request('POST', 'https://platform-api2.max.ru/messages'));
            }
            if (str_contains($request->url(), '/me?') || str_ends_with($request->url(), '/me')) {
                return Http::response(['user_id' => 123456, 'username' => 'test_cafe_bot', 'is_bot' => true]);
            }
            if (str_contains($request->url(), '/subscriptions')) {
                return Http::response(['success' => true]);
            }

            return Http::response(['message' => ['body' => ['mid' => 'message-id']]], $this->maxStatus);
        }]);
    }

    private function grant(?string $phone = null): PhoneAdministrator
    {
        $phone ??= $this->phone;
        app(RecipientRegistry::class)->register($phone, '123456');

        return PhoneAdministrator::create(['phone' => $phone, 'name' => 'Менеджер MAX']);
    }

    private function lastCode(): string
    {
        $requests = Http::recorded();
        preg_match('/: ([0-9]{6})\n/', $requests->last()[0]['text'], $matches);
        $this->assertArrayHasKey(1, $matches);

        return $matches[1];
    }

    private function superUser(): User
    {
        return User::create(['name' => 'Super', 'email' => 'super@example.test', 'password' => 'random-password', 'vk_id' => '5903492']);
    }

    public function test_phone_normalization_accepts_common_russian_formats_only(): void
    {
        foreach (['8 (912) 123-45-67', '9121234567', '+7 912 123 45 67'] as $phone) {
            $this->assertSame($this->phone, PhoneNumber::normalize($phone));
        }
        foreach (['+15551234567', '----------', '+74951234567', 'abc89121234567'] as $phone) {
            try {
                PhoneNumber::normalize($phone);
                $this->fail('Invalid phone was accepted');
            } catch (ValidationException) {
                $this->assertTrue(true);
            }
        }
    }

    public function test_max_only_admin_can_log_in_once_without_vk_and_code_is_not_stored_plaintext(): void
    {
        $administrator = $this->grant();
        $this->post($this->host.'/admin/auth/max/request', ['phone' => '89121234567'])->assertRedirect('/admin/login');
        $challenge = session('vkusno_max_challenge');
        $browser = session('max_auth_browser');
        $this->get($this->host.'/admin/login')->assertOk()->assertSee('name="max_code"', false);
        $code = $this->lastCode();
        $verification = Verification::firstOrFail();
        $this->assertNotSame($code, $verification->code_hash);
        $this->assertStringNotContainsString($code, $verification->toJson());
        Http::assertSent(fn ($request) => $request->url() === 'https://platform-api2.max.ru/messages?user_id=123456'
            && $request->hasHeader('Authorization', 'test-max-token') && str_contains($request['text'], 'Вкусняжки72'));
        $this->assertGuest();
        $this->post($this->host.'/admin/auth/max/verify', ['max_code' => $code])->assertRedirect('/admin');
        $user = Auth::user();
        $this->assertNull($user->vk_id);
        $this->assertSame($user->id, $administrator->fresh()->user_id);
        $this->get($this->host.'/admin/products')->assertOk();
        $this->get($this->host.'/admin/access')->assertForbidden();
        $this->assertNotNull($verification->fresh()->consumed_at);
        $this->post($this->host.'/admin/logout')->assertRedirect('/admin/login');
        $this->withSession(['vkusno_max_challenge' => $challenge, 'max_auth_browser' => $browser])
            ->postJson($this->host.'/admin/auth/max/verify', ['max_code' => $code])->assertUnprocessable();
        $this->assertGuest();
    }

    public function test_unknown_phone_has_the_same_code_form_without_sending_or_granting_access(): void
    {
        $this->post($this->host.'/admin/auth/max/request', ['phone' => $this->phone])->assertRedirect('/admin/login');
        $this->get($this->host.'/admin/login')->assertOk()->assertSee('name="max_code"', false);
        $this->postJson($this->host.'/admin/auth/max/verify', ['max_code' => '123456'])->assertUnprocessable();
        Http::assertNothingSent();
        $this->assertSame(0, User::count());
        $this->assertSame(0, PhoneAdministrator::count());
    }

    public function test_wrong_codes_are_limited_and_never_flashed_back_to_the_session(): void
    {
        $this->grant();
        $this->post($this->host.'/admin/auth/max/request', ['phone' => $this->phone]);
        $code = $this->lastCode();
        for ($i = 0; $i < 5; $i++) {
            $this->post($this->host.'/admin/auth/max/verify', ['max_code' => '000000'])->assertSessionHasErrors('code');
            $this->assertNull(session('_old_input.max_code'));
        }
        $this->assertSame('failed', Verification::firstOrFail()->status);
        $this->postJson($this->host.'/admin/auth/max/verify', ['max_code' => $code])->assertUnprocessable();
        $this->assertGuest();
    }

    public function test_codes_are_bound_to_purpose_browser_and_expiration(): void
    {
        $this->grant();
        $max = app(MaxAuthService::class);
        $verification = $max->begin($this->phone, 'project.one', $this->context, '127.0.0.1');
        $code = $this->lastCode();
        $this->assertNull($max->confirm($verification->id, 'project.two', $this->context, $code));
        $this->assertNull($max->confirm($verification->id, 'project.one', str_repeat('x', 40), $code));
        $this->assertSame(0, $verification->fresh()->attempts);
        $this->travel(6)->minutes();
        $this->assertNull($max->confirm($verification->id, 'project.one', $this->context, $code));
        $this->assertSame('expired', $verification->fresh()->status);
    }

    public function test_resend_is_throttled_and_replaces_the_old_challenge(): void
    {
        $this->grant();
        $this->post($this->host.'/admin/auth/max/request', ['phone' => $this->phone]);
        $old = Verification::firstOrFail();
        $oldCode = $this->lastCode();
        $browser = session('max_auth_browser');
        $this->post($this->host.'/admin/auth/max/request', ['phone' => $this->phone])->assertSessionHasErrors('phone');
        Http::assertSentCount(1);
        $this->travel(61)->seconds();
        $this->post($this->host.'/admin/auth/max/request', ['phone' => $this->phone])->assertSessionHasNoErrors();
        $this->assertSame('superseded', $old->fresh()->status);
        $this->assertNull(app(MaxAuthService::class)->confirm($old->id, 'vkusno.admin', $browser, $oldCode));
        Http::assertSentCount(2);
    }

    public function test_delivery_failure_or_disabled_driver_does_not_create_a_valid_code(): void
    {
        $this->grant();
        $setting = \App\Models\ApplicationSetting::findOrFail('max');
        $setting->update(['values' => array_replace($setting->values, ['auth_driver' => 'disabled'])]);
        $this->get($this->host.'/admin/login')->assertOk()->assertSee('Вход через MAX пока не подключён');
        $this->post($this->host.'/admin/auth/max/request', ['phone' => $this->phone])->assertSessionHasErrors('phone');
        Http::assertNothingSent();
        $setting = \App\Models\ApplicationSetting::findOrFail('max');
        $setting->update(['values' => array_replace($setting->values, ['auth_driver' => 'bot'])]);
        $this->maxStatus = 500;
        $this->post($this->host.'/admin/auth/max/request', ['phone' => $this->phone])->assertSessionHasErrors('phone');
        $this->assertSame(0, Verification::count());
        $this->assertGuest();
    }

    public function test_max_super_admin_has_no_vk_and_can_grant_both_kinds_of_access(): void
    {
        $phone = '+79000000001';
        app(RecipientRegistry::class)->register($phone, '123456');
        $this->post($this->host.'/admin/auth/max/request', ['phone' => $phone]);
        $this->post($this->host.'/admin/auth/max/verify', ['max_code' => $this->lastCode()])->assertRedirect('/admin');
        $this->assertNull(Auth::user()->vk_id);
        $this->assertTrue(Administrator::isSuperAdmin(Auth::user()));
        $this->get($this->host.'/admin/access')->assertOk();
        $this->post($this->host.'/admin/access/phones', ['phone' => $this->phone, 'name' => 'Другой менеджер'])
            ->assertSessionHasNoErrors()->assertRedirect('/admin/access');
        $this->post($this->host.'/admin/access', ['vk_id' => '777777'])->assertSessionHasNoErrors();
        $this->assertSame(Auth::id(), Administrator::where('vk_id', '777777')->firstOrFail()->granted_by_user_id);
        $ownAccess = PhoneAdministrator::where('phone', $phone)->firstOrFail();
        $this->delete($this->host.'/admin/access/phones/'.$ownAccess->id)->assertSessionHasErrors('phone');
    }

    public function test_super_admin_can_revoke_max_access_and_conflicting_bindings_are_rejected(): void
    {
        $administrator = $this->grant();
        $this->post($this->host.'/admin/auth/max/request', ['phone' => $this->phone]);
        $this->post($this->host.'/admin/auth/max/verify', ['max_code' => $this->lastCode()]);
        $user = Auth::user();
        $this->post($this->host.'/admin/access/phones', ['phone' => '+79120000000', 'max_user_id' => '987654'])->assertForbidden();
        $this->actingAs($this->superUser());
        $this->post($this->host.'/admin/access/phones', ['phone' => $this->phone])->assertSessionHasErrors('phone');
        $this->delete($this->host.'/admin/access/phones/'.$administrator->id)->assertRedirect('/admin/access');
        $this->actingAs($user)->get($this->host.'/admin/products')->assertForbidden();
        $this->assertSame(1, Recipient::count());
    }

    public function test_webhook_requires_its_secret_and_returns_user_id_without_granting_access(): void
    {
        $event = ['update_type' => 'bot_started', 'timestamp' => 1234, 'user' => ['user_id' => 123456, 'is_bot' => false]];
        $this->postJson('/api/max/webhook', $event)->assertForbidden();
        Http::assertNothingSent();
        $this->withHeader('X-Max-Bot-Api-Secret', 'a-secret-webhook-value')->postJson('/api/max/webhook', $event)->assertOk();
        Http::assertSent(fn ($request) => $request['attachments'][0]['payload']['buttons'][0][0]['type'] === 'request_contact');
        $this->postJson('/api/max/webhook', $event)->assertOk();
        Http::assertSentCount(1);
        $this->assertSame(0, Recipient::count());
        $this->assertSame(0, PhoneAdministrator::count());
    }

    private function contactEvent(string $phone, string $sender = '123456'): array
    {
        $vcf = "BEGIN:VCARD\r\nVERSION:3.0\r\nTEL;TYPE=cell:".$phone."\r\nFN:Test\r\nEND:VCARD\r\n";

        return ['update_type' => 'message_created', 'message' => [
            'sender' => ['user_id' => $sender, 'is_bot' => false],
            'recipient' => ['chat_type' => 'dialog'],
            'body' => ['attachments' => [['type' => 'contact', 'payload' => [
                'vcf_info' => $vcf, 'hash' => hash_hmac('sha256', $vcf, 'test-max-token'),
                'max_info' => ['user_id' => $sender],
            ]]]],
        ]];
    }

    public function test_signed_contact_bootstraps_super_admin_without_manual_id(): void
    {
        $phone = (string) config('vkusno.super_admin_phone');
        $this->withHeader('X-Max-Bot-Api-Secret', 'a-secret-webhook-value')
            ->postJson('/api/max/webhook', $this->contactEvent($phone))->assertOk();
        $this->assertSame('123456', Recipient::where('phone', $phone)->firstOrFail()->max_user_id);
        $this->assertSame(0, PhoneAdministrator::count());
        $this->assertGuest();
        $this->post($this->host.'/admin/auth/max/request', ['phone' => $phone])->assertSessionHasNoErrors();
        $this->post($this->host.'/admin/auth/max/verify', ['max_code' => $this->lastCode()])->assertRedirect('/admin');
        $this->assertTrue(Administrator::isSuperAdmin(Auth::user()));
    }

    public function test_signed_contact_never_grants_other_phone_super_admin_or_panel_access(): void
    {
        $this->withHeader('X-Max-Bot-Api-Secret', 'a-secret-webhook-value')
            ->postJson('/api/max/webhook', $this->contactEvent($this->phone))->assertOk();
        Http::assertSentCount(1);
        $this->assertSame('123456', Recipient::where('phone', $this->phone)->firstOrFail()->max_user_id);
        $this->post($this->host.'/admin/auth/max/request', ['phone' => $this->phone]);
        Http::assertSentCount(1);
        $this->assertSame(0, PhoneAdministrator::count());
        $this->assertGuest();
    }

    public function test_unsigned_tampered_forwarded_or_other_users_contacts_are_rejected(): void
    {
        $original = $this->contactEvent($this->phone);
        $cases = [];
        $event = $original;
        unset($event['message']['body']['attachments'][0]['payload']['hash']);
        $cases[] = $event;
        $event = $original;
        $event['message']['body']['attachments'][0]['payload']['vcf_info'] = str_replace($this->phone, '+79129999999', $event['message']['body']['attachments'][0]['payload']['vcf_info']);
        $cases[] = $event;
        $event = $original;
        $event['message']['body']['attachments'][0]['payload']['max_info']['user_id'] = '999999';
        $cases[] = $event;
        $event = $original;
        $event['message']['link'] = ['type' => 'forward'];
        $cases[] = $event;
        foreach ($cases as $event) {
            $this->withHeader('X-Max-Bot-Api-Secret', 'a-secret-webhook-value')->postJson('/api/max/webhook', $event)->assertOk();
        }
        $this->assertSame(0, Recipient::count());
        $this->assertSame(0, PhoneAdministrator::count());
    }

    public function test_signed_contact_cannot_replace_existing_phone_binding(): void
    {
        app(RecipientRegistry::class)->register($this->phone, '654321');
        $this->withHeader('X-Max-Bot-Api-Secret', 'a-secret-webhook-value')
            ->postJson('/api/max/webhook', $this->contactEvent($this->phone))->assertOk();
        $this->assertSame('654321', Recipient::where('phone', $this->phone)->firstOrFail()->max_user_id);
    }

    public function test_shared_server_api_is_authenticated_and_isolates_clients(): void
    {
        $this->grant();
        $payload = ['phone' => $this->phone, 'context' => $this->context, 'label' => 'Проект A'];
        $this->postJson('/api/max/service/auth/start', $payload)->assertForbidden();
        $this->withHeaders(['X-Max-Service-Client' => 'project-a', 'X-Max-Service-Key' => str_repeat('a', 40)])
            ->postJson('/api/max/service/auth/start', $payload)->assertCreated()->assertJsonStructure(['verification_id', 'code_length', 'expires_at']);
        $verification = Verification::firstOrFail();
        $code = $this->lastCode();
        $check = ['verification_id' => $verification->id, 'context' => $this->context, 'code' => $code];
        $this->withHeaders(['X-Max-Service-Client' => 'project-b', 'X-Max-Service-Key' => str_repeat('b', 40)])
            ->postJson('/api/max/service/auth/check', $check)->assertUnprocessable();
        $this->withHeaders(['X-Max-Service-Client' => 'project-a', 'X-Max-Service-Key' => str_repeat('a', 40)])
            ->postJson('/api/max/service/auth/check', $check)->assertOk()->assertJson(['verified' => true, 'phone' => $this->phone]);
        $this->postJson('/api/max/service/auth/check', $check)->assertUnprocessable();
        $this->assertGuest();
    }

    public function test_shared_message_api_uses_direct_max_api_and_webhook_registration_is_correct(): void
    {
        $this->withHeaders(['X-Max-Service-Client' => 'project-a', 'X-Max-Service-Key' => str_repeat('a', 40)])
            ->postJson('/api/max/service/message', ['user_id' => '123456', 'text' => 'Сообщение из другого проекта'])->assertOk()->assertJson(['sent' => true]);
        Http::assertSent(fn ($request) => str_starts_with($request->url(), 'https://platform-api2.max.ru/messages?user_id=123456'));
        $setting = \App\Models\ApplicationSetting::findOrFail('max');
        $setting->update(['values' => array_replace($setting->values, ['webhook_url' => 'https://example.test/api/max/webhook'])]);
        $this->artisan('max:register-webhook')->assertSuccessful();
        Http::assertSent(fn ($request) => $request->url() === 'https://platform-api2.max.ru/subscriptions'
            && $request['secret'] === 'a-secret-webhook-value' && $request['update_types'] === ['bot_started', 'message_created']);
    }

    public function test_cli_bootstrap_grants_phone_access_without_creating_a_vk_user(): void
    {
        $this->artisan('vkusno:max-admin', ['phone' => '89121234567', 'max_id' => '123456', '--name' => 'Менеджер'])->assertSuccessful();
        $this->assertDatabaseHas('vkusno_phone_administrators', ['phone' => $this->phone, 'user_id' => null]);
        $this->assertDatabaseHas('max_recipients', ['phone' => $this->phone, 'max_user_id' => '123456']);
        $this->assertSame(0, User::count());
        Http::assertNothingSent();
    }

    public function test_bot_info_can_be_read_without_sending_a_message(): void
    {
        $this->assertSame('test_cafe_bot', app(MaxService::class)->getBotInfo()['username']);
        Http::assertSent(fn ($request) => $request->method() === 'GET' && $request->url() === 'https://platform-api2.max.ru/me');
        Http::assertSentCount(1);
    }

    public function test_tls_failure_is_sanitized_and_does_not_create_a_login_code(): void
    {
        $this->grant();
        $this->tlsFailure = true;
        $this->post($this->host.'/admin/auth/max/request', ['phone' => $this->phone])->assertSessionHasErrors('phone');
        $message = session('errors')->first('phone');
        $this->assertStringNotContainsString('test-max-token', $message);
        $this->assertStringNotContainsString('TLS certificate failure', $message);
        $this->assertSame(0, Verification::count());
    }

    public function test_missing_custom_ca_file_fails_closed_without_an_api_request(): void
    {
        config(['max.ca_bundle' => '/nonexistent/max-root-certificate.pem']);
        try {
            app(MaxService::class)->getBotInfo();
            $this->fail('An unreadable CA bundle must not disable TLS verification.');
        } catch (\App\Services\Max\MaxAuthException $exception) {
            $this->assertStringContainsString('MAX_CA_BUNDLE', $exception->getMessage());
        }
        Http::assertNothingSent();
    }
}
