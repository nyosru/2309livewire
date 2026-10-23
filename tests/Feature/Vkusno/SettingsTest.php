<?php

namespace Tests\Feature\Vkusno;

use App\Models\ApplicationSetting;
use App\Models\User;
use App\Models\Vkusno\Administrator;
use App\Models\Vkusno\Order;
use App\Services\Max\MaxService;
use App\Services\Max\MaxSettings;
use App\Services\Vkusno\SiteSettings;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    private string $host = 'http://vkusno.local';

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:',
            'vkusno.super_admin_vk_id' => '5903492',
            'vkusno.phone' => '+7 (912) 123-45-67', 'vkusno.delivery_fee' => null,
            'max.bot_token' => 'initial-test-token', 'max.bot_username' => 'initial_bot',
            'max.webhook_secret' => 'initial-test-secret', 'max.webhook_url' => 'https://example.test/api/max/webhook',
            'max.auth_driver' => 'bot',
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
        ] as $file) {
            (require database_path('migrations/'.$file))->up();
        }
    }

    private function user(string $id): User
    {
        return User::create(['name' => 'Test', 'email' => $id.'@example.test', 'password' => 'test-password', 'vk_id' => $id]);
    }

    private function payload(array $overrides = []): array
    {
        $site = app(SiteSettings::class)->all();

        return array_replace($site, [
            'fillings_text' => implode("\n", $site['fillings']),
            'max_bot_username' => 'initial_bot', 'max_auth_driver' => 'bot',
            'max_webhook_url' => 'https://example.test/api/max/webhook',
        ], $overrides);
    }

    public function test_migration_preserves_existing_values_and_database_is_the_source(): void
    {
        config(['vkusno.phone' => 'obsolete phone', 'max.bot_username' => 'obsolete_bot']);
        $this->assertSame('+7 (912) 123-45-67', app(SiteSettings::class)->get('phone'));
        $this->assertNull(app(SiteSettings::class)->get('delivery_fee'));
        $this->assertSame('https://max.ru/initial_bot', app(MaxService::class)->botUrl());
        $raw = DB::table('application_settings')->where('scope', 'max')->value('values');
        $this->assertStringNotContainsString('initial-test-token', $raw);
        $this->assertStringNotContainsString('initial-test-secret', $raw);
        $this->assertArrayNotHasKey('values', ApplicationSetting::findOrFail('max')->toArray());
    }

    public function test_only_super_admin_can_view_or_edit_settings(): void
    {
        $this->get($this->host.'/admin/settings')->assertRedirect($this->host.'/admin/login');
        $this->put($this->host.'/admin/settings', $this->payload())->assertRedirect();
        Administrator::create(['vk_id' => '123456', 'granted_by_vk_id' => '5903492']);
        $this->actingAs($this->user('123456'))->get($this->host.'/admin/settings')->assertForbidden();
        $this->put($this->host.'/admin/settings', $this->payload())->assertForbidden();
        $this->actingAs($this->user('5903492'))->get($this->host.'/admin/settings')
            ->assertOk()->assertSee('Настройки сайта')->assertDontSee('initial-test-token')->assertDontSee('initial-test-secret');
    }

    public function test_saved_settings_change_public_page_and_new_orders_without_changing_old_orders(): void
    {
        $this->actingAs($this->user('5903492'));
        $this->put($this->host.'/admin/settings', $this->payload([
            'phone' => '+7 (999) 123-45-67', 'address' => 'Новый адрес кафе', 'delivery_fee' => '250',
            'fillings_text' => "Новая начинка\nДругая начинка\nНовая начинка", 'cake_lead_days' => '7',
            'demo_menu' => '0', 'max_bot_username' => 'updated_bot',
        ]))->assertSessionHasNoErrors()->assertRedirect('/admin/settings');
        $this->get($this->host.'/')->assertOk()->assertSee('Новый адрес кафе')
            ->assertSee('+7 (999) 123-45-67')->assertSee('Новая начинка')
            ->assertViewHas('frontend', fn ($front) => $front['cakeDate'] === now('Asia/Yekaterinburg')->addDays(7)->toDateString());
        $this->get($this->host.'/privacy')->assertOk()->assertSee('+7 (999) 123-45-67');
        $this->assertSame('https://max.ru/updated_bot', app(MaxService::class)->botUrl());
        $this->assertSame(['Новая начинка', 'Другая начинка'], app(SiteSettings::class)->get('fillings'));
        $order = ['name' => 'Клиент', 'phone' => '+79121234567', 'fulfillment' => 'delivery', 'address' => 'Адрес клиента', 'consent' => true, 'items' => [['id' => 'pasta', 'quantity' => 1]]];
        $this->postJson($this->host.'/orders', $order)->assertCreated();
        $this->assertEquals(250, Order::firstOrFail()->delivery_fee);
        $this->put($this->host.'/admin/settings', $this->payload(['delivery_fee' => '0']))->assertSessionHasNoErrors();
        $this->assertSame(0, app(SiteSettings::class)->get('delivery_fee'));
        $this->assertEquals(250, Order::firstOrFail()->delivery_fee);
    }

    public function test_secret_replacement_is_encrypted_and_blank_fields_keep_it(): void
    {
        $this->actingAs($this->user('5903492'));
        $this->put($this->host.'/admin/settings', $this->payload(['max_bot_token' => 'replacement-token', 'max_webhook_secret' => 'replacement-secret']))->assertSessionHasNoErrors();
        $this->put($this->host.'/admin/settings', $this->payload(['max_bot_token' => '', 'max_webhook_secret' => '']))->assertSessionHasNoErrors();
        $this->assertSame('replacement-token', app(MaxSettings::class)->get('bot_token'));
        $this->get($this->host.'/admin/settings')->assertDontSee('replacement-token')->assertDontSee('replacement-secret');
        $this->assertStringNotContainsString('replacement-token', DB::table('application_settings')->where('scope', 'max')->value('values'));
    }

    public function test_invalid_settings_are_atomic_and_secrets_are_never_flashed(): void
    {
        $this->actingAs($this->user('5903492'));
        $before = app(SiteSettings::class)->all();
        $this->put($this->host.'/admin/settings', $this->payload([
            'phone' => 'changed', 'map_url' => 'javascript:alert(1)', 'cake_lead_days' => '-1',
            'max_bot_token' => 'never-flash-token', 'max_webhook_secret' => 'never-flash-secret',
        ]))->assertSessionHasErrors(['map_url', 'cake_lead_days']);
        $this->assertNull(session()->getOldInput('max_bot_token'));
        $this->assertNull(session()->getOldInput('max_webhook_secret'));
        $this->assertSame($before, app(SiteSettings::class)->all());
        $this->assertSame('initial-test-token', app(MaxSettings::class)->get('bot_token'));
        $this->put($this->host.'/admin/settings', $this->payload(['fillings_text' => str_repeat('a', 101)]))->assertSessionHasErrors('fillings_text');
        $this->assertSame($before, app(SiteSettings::class)->all());
    }
}
