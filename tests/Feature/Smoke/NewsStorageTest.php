<?php

namespace Tests\Feature\Smoke;

use Tests\TestCase;
use Tests\Feature\Smoke\Concerns\AssertsPageResponse;

class NewsStorageTest extends TestCase
{
    use AssertsPageResponse;

    private const DOMAIN = 'https://news.api.php-cat.ru';

    public function test_main_page(): void
    {
        $this->assertPageResponds(self::DOMAIN . '/');
    }

    public function test_api_docs_page(): void
    {
        $this->assertPageResponds(self::DOMAIN . '/api-docs');
    }

    public function test_nonexistent_route_redirects(): void
    {
        $response = $this->get(self::DOMAIN . '/this-does-not-exist');
        $response->assertStatus(302);
    }
}
