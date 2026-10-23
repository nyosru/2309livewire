<?php

namespace Tests\Feature\Vkusno;

use App\Models\User;
use App\Models\Vkusno\Order;
use App\Models\Vkusno\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CafeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        $migration = require database_path('migrations/2026_10_22_000001_create_vkusno_orders_table.php');
        $migration->up();
        $products = require database_path('migrations/2026_10_22_000002_create_vkusno_products_table.php');
        $products->up();
        $catalogs = require database_path('migrations/2026_10_22_000003_create_vkusno_menu_catalogs.php');
        $catalogs->up();
        $administrators = require database_path('migrations/2026_10_22_000004_create_vkusno_administrators_table.php');
        $administrators->up();
        (require database_path('migrations/2026_10_22_000005_create_max_auth_tables.php'))->up();
        (require database_path('migrations/2026_10_23_000006_create_application_settings_table.php'))->up();
    }

    public function test_migration_imports_the_entire_current_catalog(): void
    {
        $this->assertSame(count(config('vkusno.products')), Product::count());

        foreach (config('vkusno.products') as $position => $expected) {
            $product = Product::findOrFail($expected['id']);
            foreach ($expected as $field => $value) {
                $this->assertSame($value, $product->getAttribute($field));
            }
            $this->assertTrue($product->is_active);
            $this->assertSame($position, $product->sort_order);
        }
    }

    public function test_database_catalog_drives_the_page_and_order_prices(): void
    {
        $product = Product::findOrFail('pasta');
        $product->update(['name' => 'Паста из базы данных', 'price' => 510]);
        config(['vkusno.products' => []]);

        $this->get('http://vkusno.local/')
            ->assertOk()->assertSee('Паста из базы данных')
            ->assertViewHas('frontend', fn ($frontend) => collect($frontend['products'])->firstWhere('id', 'pasta')['price'] === 510);
        $this->postJson('http://vkusno.local/orders', $this->payload())->assertCreated();

        $order = Order::firstOrFail();
        $this->assertSame(1020, $order->subtotal);
        $this->assertSame('Паста из базы данных', $order->items[0]['name']);
        $this->assertSame(510, $order->items[0]['price']);

        $product->delete();
        $order->refresh();
        $this->assertSame(510, $order->items[0]['price']);
        $this->assertSame('Паста из базы данных', $order->items[0]['name']);
    }

    public function test_inactive_products_are_hidden_and_cannot_be_ordered(): void
    {
        Product::findOrFail('pasta')->update(['is_active' => false]);

        $this->get('http://vkusno.local/')->assertOk()->assertDontSee('data-add="pasta"', false)
            ->assertViewHas('frontend', fn ($frontend) => ! collect($frontend['products'])->contains('id', 'pasta'));
        $this->postJson('http://vkusno.local/orders', $this->payload())
            ->assertUnprocessable()->assertJsonValidationErrors('items.0.id');
        $this->assertSame(0, Order::count());
    }

    public function test_cafe_is_available_locally_and_alias_redirects_to_canonical_domain(): void
    {
        $this->get('http://vkusno.local/')->assertOk()->assertSee('Вкусняжки72')->assertSee('Корзина');
        $this->get('http://xn--72-dlcyjau5ar6c5d.xn--p1ai/')->assertStatus(301)->assertRedirect('https://xn--72-dlcqkkbw9at8k.xn--p1ai/');
    }

    public function test_menus_are_shown_as_two_ordered_sections(): void
    {
        $this->get('http://vkusno.local/')
            ->assertOk()
            ->assertSeeInOrder(['data-menu-block="cafe"', 'data-menu-block="canteen"'], false)
            ->assertSee('Каша дня')->assertSee('Суп дня')->assertSee('Горячее с гарниром');
    }

    public function test_cafe_and_canteen_items_share_one_order(): void
    {
        $this->postJson('http://vkusno.local/orders', $this->payload([
            'items' => [['id' => 'pasta', 'quantity' => 1], ['id' => 'soup', 'quantity' => 2]],
        ]))->assertCreated();
        $order = Order::firstOrFail();
        $this->assertSame(770, $order->subtotal);
        $this->assertCount(2, $order->items);
    }

    public function test_photo_products_use_tag_prices_and_preserve_weight_unit(): void
    {
        $this->postJson('http://vkusno.local/orders', $this->payload([
            'items' => [
                ['id' => 'sochen-condensed', 'quantity' => 1, 'price' => 1],
                ['id' => 'blueberry-lemon-cake', 'quantity' => 2],
                ['id' => 'pizza-kaif-whole', 'quantity' => 1],
            ],
        ]))->assertCreated();
        $order = Order::firstOrFail();
        $this->assertSame(1328, $order->subtotal);
        $this->assertSame('100 г', $order->items[1]['unit']);
        $this->assertSame(190, $order->items[1]['price']);
    }

    public function test_canteen_tag_prices_and_units_are_used_in_order(): void
    {
        $this->postJson('http://vkusno.local/orders', $this->payload([
            'items' => [
                ['id' => 'canteen-beef-tongue', 'quantity' => 2, 'price' => 1],
                ['id' => 'canteen-macaroni', 'quantity' => 1],
                ['id' => 'canteen-juice-assorted', 'quantity' => 1],
            ],
        ]))->assertCreated();
        $order = Order::firstOrFail();
        $this->assertSame(735, $order->subtotal);
        $this->assertSame('100 г', $order->items[0]['unit']);
        $this->assertSame('200 мл', $order->items[2]['unit']);
    }

    private function payload(array $overrides = []): array
    {
        return array_replace([
            'name' => 'Тестовый клиент', 'phone' => '+7 (912) 123-45-67',
            'fulfillment' => 'pickup', 'consent' => true,
            'items' => [['id' => 'pasta', 'quantity' => 2, 'price' => 1]],
        ], $overrides);
    }

    public function test_order_uses_catalog_prices_and_is_persisted(): void
    {
        $response = $this->postJson('http://vkusno.local/orders', $this->payload());
        $response->assertCreated()->assertJsonStructure(['reference', 'message']);
        $order = Order::firstOrFail();
        $this->assertSame(900, $order->subtotal);
        $this->assertSame(450, $order->items[0]['price']);
        $this->assertSame(0, $order->delivery_fee);
        $this->assertSame($order->reference, $response->json('reference'));
    }

    public function test_new_order_is_sent_to_vk_like_the_ttt_lead_forms(): void
    {
        config([
            'services.vk.token_order' => 'vk-test-token',
            'services.vk.vk_admin_id' => '5903492',
            'services.vk.api_version' => '5.199',
        ]);
        Http::fake(['api.vk.com/method/messages.send' => Http::response(['response' => 1])]);

        $this->postJson('http://vkusno.local/orders', $this->payload([
            'address' => null,
            'comment' => 'Позвонить за час',
        ]))->assertCreated();

        Http::assertSent(fn ($request) => $request->url() === 'https://api.vk.com/method/messages.send'
            && $request['access_token'] === 'vk-test-token'
            && $request['user_id'] === '5903492'
            && $request['v'] === '5.199'
            && str_contains($request['message'], 'Новая заявка «Вкусняжки72»')
            && str_contains($request['message'], 'Тестовый клиент')
            && str_contains($request['message'], 'Паста с песто')
            && str_contains($request['message'], 'Самовывоз')
            && str_contains($request['message'], 'Позвонить за час'));
    }

    public function test_vk_notification_failure_does_not_discard_the_order(): void
    {
        config([
            'services.vk.token_order' => 'vk-test-token',
            'services.vk.vk_admin_id' => '5903492',
        ]);
        Http::fake(['api.vk.com/*' => Http::response(['error' => ['error_msg' => 'VK error']])]);

        $this->postJson('http://vkusno.local/orders', $this->payload())->assertCreated();
        $this->assertSame(1, Order::count());
    }

    public function test_delivery_requires_address_and_records_unconfirmed_fee(): void
    {
        $setting = \App\Models\ApplicationSetting::findOrFail('vkusno');
        $setting->update(['values' => array_replace($setting->values, ['delivery_fee' => null])]);
        $this->postJson('http://vkusno.local/orders', $this->payload(['fulfillment' => 'delivery']))
            ->assertUnprocessable()->assertJsonValidationErrors('address');
        $this->postJson('http://vkusno.local/orders', $this->payload(['fulfillment' => 'delivery', 'address' => 'Тестовая, 1']))->assertCreated();
        $this->assertSame('Тестовая, 1', Order::firstOrFail()->address);
        $this->assertNull(Order::firstOrFail()->delivery_fee);
    }

    public function test_invalid_and_empty_carts_and_missing_consent_are_rejected(): void
    {
        foreach ([['items' => []], ['phone' => '----------'], ['items' => [['id' => 'unknown', 'quantity' => 1]]], ['consent' => false], ['items' => [['id' => 'pasta', 'quantity' => -1]]], ['items' => [['id' => 'pasta', 'quantity' => 1], ['id' => 'pasta', 'quantity' => 1]]]] as $overrides) {
            $this->postJson('http://vkusno.local/orders', $this->payload($overrides))->assertUnprocessable();
        }
        $this->assertSame(0, Order::count());
    }

    public function test_cake_only_order_requires_lead_time_and_retains_details(): void
    {
        $data = $this->payload(['items' => [], 'cake' => ['filling' => 'Молочная девочка', 'weight' => 2, 'design' => 'С ягодами']]);
        $this->postJson('http://vkusno.local/orders', $data)->assertUnprocessable()->assertJsonValidationErrors('requested_date');
        $data['requested_date'] = now()->addDay()->toDateString();
        $this->postJson('http://vkusno.local/orders', $data)->assertUnprocessable();
        $data['requested_date'] = now()->addDays(5)->toDateString();
        $this->postJson('http://vkusno.local/orders', $data)->assertCreated();
        $this->assertSame('С ягодами', Order::firstOrFail()->cake['design']);
        $this->assertSame(0, Order::firstOrFail()->subtotal);
    }

    public function test_cake_lead_time_uses_cafe_timezone(): void
    {
        $this->travelTo(Carbon::parse('2026-10-22 21:00:00', 'UTC'));
        try {
            $data = $this->payload(['items' => [], 'cake' => ['filling' => 'Молочная девочка', 'weight' => 2], 'requested_date' => '2026-10-25']);
            $this->postJson('http://vkusno.local/orders', $data)->assertUnprocessable();
            $data['requested_date'] = '2026-10-26';
            $this->postJson('http://vkusno.local/orders', $data)->assertCreated();
        } finally {
            $this->travelBack();
        }
    }

    public function test_administrator_can_read_orders(): void
    {
        $permissions = require database_path('migrations/2025_09_19_063324_create_permission_tables.php');
        $permissions->up();
        $this->postJson('http://vkusno.local/orders', $this->payload())->assertCreated();
        config(['vkusno.super_admin_vk_id' => '5903492']);
        $admin = (new User)->forceFill(['id' => 1, 'vk_id' => '5903492', 'email' => '1@php-cat.com', 'name' => 'Admin']);
        $this->actingAs($admin)->get('http://vkusno.local/admin/orders')->assertOk()->assertSee('Тестовый клиент')->assertSee('Паста с песто');
    }

    public function test_order_details_are_not_publicly_available(): void
    {
        $this->get('http://vkusno.local/admin/orders')->assertRedirect();
    }
}
