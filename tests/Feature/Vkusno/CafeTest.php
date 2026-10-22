<?php

namespace Tests\Feature\Vkusno;

use App\Models\Vkusno\Order;
use App\Models\User;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CafeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        $migration = require database_path('migrations/2026_10_22_000001_create_vkusno_orders_table.php');
        $migration->up();
    }

    public function test_cafe_is_available_on_both_domains_and_idn(): void
    {
        foreach (['vkusno.local', 'xn--72-dlcqkkbw9at8k.xn--p1ai'] as $host) {
            $this->get('http://'.$host.'/')->assertOk()->assertSee('Вкусняжки72')->assertSee('Корзина');
        }
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

    public function test_delivery_requires_address_and_records_unconfirmed_fee(): void
    {
        config(['vkusno.delivery_fee' => null]);
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
        $admin = (new User)->forceFill(['id' => 1, 'email' => '1@php-cat.com', 'name' => 'Admin']);
        $this->actingAs($admin)->get('http://vkusno.local/admin/orders')->assertOk()->assertSee('Тестовый клиент')->assertSee('Паста с песто');
    }

    public function test_order_details_are_not_publicly_available(): void
    {
        $this->get('http://vkusno.local/admin/orders')->assertRedirect();
    }
}
