<?php

namespace Tests\Feature\Hleb;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LandingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        (require database_path('migrations/2026_10_29_100000_create_hleb_requests_table.php'))->up();
    }

    public function test_landing_is_available_on_local_and_production_hosts(): void
    {
        foreach (['hleb.local', 'xn--80ablnmob2dxa6f.xn--p1ai'] as $host) {
            $this->get('https://'.$host.'/')->assertOk()->assertSee('Выбирайте')->assertSee('Франшиза');
        }
    }

    public function test_franchise_page_is_available_for_both_hosts(): void
    {
        foreach (['hleb.local', 'xn--80ablnmob2dxa6f.xn--p1ai'] as $host) {
            $this->get('https://'.$host.'/franchise')->assertOk()->assertSee('400 000 ₽')->assertSee('3 621 522 ₽');
        }
    }

    public function test_order_uses_server_prices_and_encrypts_contact_details(): void
    {
        $this->postJson('https://hleb.local/requests', $this->payload() + [
            'items' => [['id' => 'karavay', 'quantity' => 2, 'price' => 1]], 'total' => 1,
        ])->assertCreated()->assertJsonStructure(['reference']);
        $order = DB::table('hleb_requests')->first();
        $this->assertSame(1400, $order->total);
        $this->assertStringNotContainsString('Тестовый покупатель', $order->contact);
        $this->assertSame('Тестовый покупатель', json_decode(decrypt($order->contact), true)['name']);
    }

    public function test_invalid_orders_are_not_saved(): void
    {
        foreach ([[], [['id' => 'unknown', 'quantity' => 1]], [['id' => 'karavay', 'quantity' => -1]], [['id' => 'karavay', 'quantity' => 100]]] as $items) {
            $this->postJson('https://hleb.local/requests', $this->payload() + ['items' => $items])->assertUnprocessable();
        }
        $this->assertSame(0, DB::table('hleb_requests')->count());
    }

    public function test_phone_without_digits_is_rejected(): void
    {
        $this->postJson('https://hleb.local/requests', array_merge($this->payload(), ['type' => 'franchise', 'phone' => '----------']))->assertUnprocessable();
        $this->assertSame(0, DB::table('hleb_requests')->count());
    }

    public function test_consent_is_required(): void
    {
        $this->postJson('https://hleb.local/requests', array_merge($this->payload(), ['type' => 'franchise', 'consent' => false]))->assertUnprocessable();
        $this->assertSame(0, DB::table('hleb_requests')->count());
    }

    public function test_franchise_enquiry_does_not_need_a_cart(): void
    {
        $this->postJson('https://hleb.local/requests', array_merge($this->payload(), ['type' => 'franchise']))->assertCreated();
        $this->assertSame('franchise', DB::table('hleb_requests')->first()->type);
    }

    private function payload(): array
    {
        return ['type' => 'order', 'name' => 'Тестовый покупатель', 'phone' => '+79990000000', 'city' => 'Екатеринбург', 'consent' => true];
    }
}
