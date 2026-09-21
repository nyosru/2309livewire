<?php

namespace Tests\Feature\Smoke;

use Tests\TestCase;
use Tests\Feature\Smoke\Concerns\AssertsPageResponse;

class PhpcatRuTest extends TestCase
{
    use AssertsPageResponse;

    public function test_main_page(): void
    {
        $this->assertPageResponds('https://php-cat.ru/');
    }

    public function test_services_page(): void
    {
        $this->assertPageResponds('https://php-cat.ru/services');
    }

    public function test_blog_page(): void
    {
        $this->assertPageResponds('https://php-cat.ru/blog');
    }

    public function test_contacts_page(): void
    {
        $this->assertPageResponds('https://php-cat.ru/contacts');
    }

    public function test_cases_page(): void
    {
        $this->assertPageResponds('https://php-cat.ru/cases');
    }

    public function test_nonexistent_route_redirects(): void
    {
        $response = $this->get('https://php-cat.ru/this-does-not-exist');
        $response->assertStatus(302);
    }
}
