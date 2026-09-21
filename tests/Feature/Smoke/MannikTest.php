<?php

namespace Tests\Feature\Smoke;

use Tests\TestCase;
use Tests\Feature\Smoke\Concerns\AssertsPageResponse;

class MannikTest extends TestCase
{
    use AssertsPageResponse;

    public function test_main_page(): void
    {
        $this->assertPageResponds('https://xn--80aayihhat9j.xn--p1ai/');
    }

    public function test_nonexistent_route_redirects(): void
    {
        $response = $this->get('https://xn--80aayihhat9j.xn--p1ai/this-does-not-exist');
        $response->assertStatus(302);
    }
}
