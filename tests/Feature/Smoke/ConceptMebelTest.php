<?php

namespace Tests\Feature\Smoke;

use Tests\TestCase;
use Tests\Feature\Smoke\Concerns\AssertsPageResponse;

class ConceptMebelTest extends TestCase
{
    use AssertsPageResponse;

    public function test_main_page(): void
    {
        $this->assertPageResponds('https://xn--90ahabvkdgim7a8b8e.xn--p1ai/');
    }

    public function test_nonexistent_route_redirects(): void
    {
        $response = $this->get('https://xn--90ahabvkdgim7a8b8e.xn--p1ai/this-does-not-exist');
        $response->assertStatus(302);
    }
}
