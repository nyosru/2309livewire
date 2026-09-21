<?php

namespace Tests\Feature\Smoke;

use Tests\TestCase;
use Tests\Feature\Smoke\Concerns\AssertsPageResponse;

class SkidkiTest extends TestCase
{
    use AssertsPageResponse;

    public function test_main_page(): void
    {
        $this->assertPageResponds('https://xn--d1ahbfc2b.xn--90adfbu3bff.xn--p1ai/');
    }
}
