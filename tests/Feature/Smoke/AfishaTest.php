<?php

namespace Tests\Feature\Smoke;

use Tests\TestCase;
use Tests\Feature\Smoke\Concerns\AssertsPageResponse;

class AfishaTest extends TestCase
{
    use AssertsPageResponse;

    private const DOMAIN = 'https://xn--80aaarrjmj0bg3a3c0dua.xn--p1ai';

    public function test_main_page(): void
    {
        $this->assertPageResponds(self::DOMAIN . '/');
    }

    public function test_afisha_add_page(): void
    {
        $this->assertPageResponds(self::DOMAIN . '/afisha/add');
    }

    public function test_holiday_page(): void
    {
        $this->markTestSkipped('Требуется таблица holidays в MySQL');
    }
}
