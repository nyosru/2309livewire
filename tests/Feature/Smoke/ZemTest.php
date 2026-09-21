<?php

namespace Tests\Feature\Smoke;

use Tests\TestCase;
use Tests\Feature\Smoke\Concerns\AssertsPageResponse;

class ZemTest extends TestCase
{
    use AssertsPageResponse;

    public function test_privatization_garazha_main_page(): void
    {
        $this->assertPageResponds('https://xn--80aaaaahj0aehcc8fojz5e1i.xn--p1ai/');
    }

    public function test_zemelniy_kadastr_main_page(): void
    {
        $this->assertPageResponds('https://xn--80aalcakqihin5bmo2koa.xn--p1ai/');
    }
}
