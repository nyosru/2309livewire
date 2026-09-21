<?php

namespace Tests\Feature\Smoke;

use Tests\TestCase;
use Tests\Feature\Smoke\Concerns\AssertsPageResponse;

class CfaTest extends TestCase
{
    use AssertsPageResponse;

    public function test_cfa_center_ru_main_page(): void
    {
        $this->assertPageResponds('https://cfa-center.ru/');
    }

    public function test_cfa_alternative_main_page(): void
    {
        $this->assertPageResponds('https://cfa-center.ru/aa/');
    }

    public function test_news_page(): void
    {
        $this->assertPageResponds('https://cfa-center.ru/news');
    }

    public function test_datar_page(): void
    {
        $this->assertPageResponds('https://cfa-center.ru/datar');
    }

    public function test_login_page_redirects(): void
    {
        $response = $this->get('https://cfa-center.ru/login');
        $response->assertStatus(302);
    }

    public function test_cfa_php_cat_com_main_page(): void
    {
        $this->assertPageResponds('https://cfa.php-cat.com/');
    }
}
