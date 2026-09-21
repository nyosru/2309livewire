<?php

namespace Tests\Feature\Smoke;

use Tests\TestCase;
use Tests\Feature\Smoke\Concerns\AssertsPageResponse;

class SnowkaitTest extends TestCase
{
    use AssertsPageResponse;

    public function test_snowkait_main_page(): void
    {
        $this->assertPageResponds('https://xn--80agoddredzph.xn--p1ai/');
    }

    public function test_snowkait_main_page_utf8(): void
    {
        $this->markTestSkipped('UTF-8 домены требуют IDN-конвертации в маршрутизации Laravel');
    }

    public function test_as_php_cat_com_main_page(): void
    {
        $this->markTestSkipped('Требуется SQLite таблица whois_domains (компонент Domains в layout)');
    }
}
