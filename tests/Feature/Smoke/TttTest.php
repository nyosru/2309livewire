<?php

namespace Tests\Feature\Smoke;

use Tests\TestCase;
use Tests\Feature\Smoke\Concerns\AssertsPageResponse;

class TttTest extends TestCase
{
    use AssertsPageResponse;

    public function test_ttt72_ru_main_page(): void
    {
        $this->assertPageResponds('https://ttt72.ru/');
    }

    public function test_ttt_rf_main_page(): void
    {
        $this->assertPageResponds('https://xn--72-qmcaa.xn--p1ai/');
    }
}
