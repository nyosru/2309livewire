<?php

namespace Tests\Feature\Smoke;

use Tests\TestCase;
use Tests\Feature\Smoke\Concerns\AssertsPageResponse;

class StNewsTest extends TestCase
{
    use AssertsPageResponse;

    private const DOMAIN = 'https://xn--80aeiaarcmpbmdnb6aghgm9nrc.xn--p1ai';

    public function test_main_page(): void
    {
        $this->assertPageResponds(self::DOMAIN . '/');
    }

    public function test_caddy_checker_page(): void
    {
        $this->assertPageResponds(self::DOMAIN . '/caddy');
    }

    public function test_caddy_fetcher_page(): void
    {
        $this->assertPageResponds(self::DOMAIN . '/caddy2');
    }

    public function test_moderation_page(): void
    {
        $this->assertPageResponds(self::DOMAIN . '/moderation');
    }

    public function test_vk_enter_page(): void
    {
        $this->assertPageResponds(self::DOMAIN . '/vk/enter');
    }

    public function test_nonexistent_route_redirects(): void
    {
        $response = $this->get(self::DOMAIN . '/this-does-not-exist');
        $response->assertStatus(302);
    }
}
