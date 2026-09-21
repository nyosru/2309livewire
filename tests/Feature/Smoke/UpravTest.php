<?php

namespace Tests\Feature\Smoke;

use Tests\TestCase;
use Tests\Feature\Smoke\Concerns\AssertsPageResponse;

class UpravTest extends TestCase
{
    use AssertsPageResponse;

    public function test_upravlyator_main_page(): void
    {
        $this->assertPageResponds('https://xn--80ae1ambgeod9j.xn--p1ai/');
    }

    public function test_commutator_main_page(): void
    {
        $this->assertPageResponds('https://xn--80atgaidonbh.xn--80ae1ambgeod9j.xn--p1ai/');
    }
}
