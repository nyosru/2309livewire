<?php

namespace Tests\Feature\Smoke;

use Tests\TestCase;
use Tests\Feature\Smoke\Concerns\AssertsPageResponse;

class KrostuTest extends TestCase
{
    use AssertsPageResponse;

    public function test_krostu_com_main_page(): void
    {
        $this->assertPageResponds('https://krostu.com/');
    }

    public function test_krostu_rf_main_page(): void
    {
        $this->assertPageResponds('https://xn--j1aifffg.xn--p1ai/');
    }

    public function test_nonexistent_route_redirects(): void
    {
        $response = $this->get('https://krostu.com/this-does-not-exist');
        $response->assertStatus(302);
    }
}
