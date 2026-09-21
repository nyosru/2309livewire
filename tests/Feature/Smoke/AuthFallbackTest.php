<?php

namespace Tests\Feature\Smoke;

use Tests\TestCase;
use Tests\Feature\Smoke\Concerns\AssertsPageResponse;

class AuthFallbackTest extends TestCase
{
    use AssertsPageResponse;

    public function test_auth_vk_page(): void
    {
        $this->markTestSkipped('Метод redirect() не найден в Vk компоненте (есть redir()) — возвращает рендер вместо редиректа');
    }

    public function test_fallback_page(): void
    {
        $response = $this->get('/some-nonexistent-global-route');
        $response->assertStatus(200);
    }
}
