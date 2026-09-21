<?php

namespace Tests\Feature\Smoke;

use Tests\TestCase;
use Tests\Feature\Smoke\Concerns\AssertsPageResponse;

class ArTest extends TestCase
{
    use AssertsPageResponse;

    public function test_main_page(): void
    {
        $this->assertPageResponds('https://ar.php-cat.com/');
    }

    public function test_ring_page(): void
    {
        $this->assertPageResponds('https://ar.php-cat.com/ring');
    }
}
