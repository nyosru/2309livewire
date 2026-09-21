<?php

namespace Tests\Feature\Smoke;

use Tests\TestCase;
use Tests\Feature\Smoke\Concerns\AssertsPageResponse;

class PhpcatTest extends TestCase
{
    use AssertsPageResponse;

    public function test_main_page_php_cat_com(): void
    {
        $this->assertPageResponds('https://php-cat.com/');
    }

    public function test_develop_page(): void
    {
        $this->assertPageResponds('https://php-cat.com/develop/test-item');
    }

    public function test_msg_endpoint(): void
    {
        $this->assertPageResponds('https://php-cat.com/msg');
    }

    public function test_friends_page(): void
    {
        $this->assertPageResponds('https://php-cat.com/f');
    }

    public function test_show_page(): void
    {
        $this->assertPageResponds('https://php-cat.com/show_page/menu47');
    }

    public function test_seotel_ru_main_page(): void
    {
        $this->assertPageResponds('https://seotel.ru/');
    }

    public function test_1_php_cat_com_main_page(): void
    {
        $this->assertPageResponds('https://1.php-cat.com/');
    }

    public function test_nonexistent_route_redirects(): void
    {
        $response = $this->get('https://php-cat.com/this-does-not-exist');
        $response->assertStatus(302);
    }
}
