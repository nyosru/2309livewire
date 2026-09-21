<?php

namespace Tests\Feature\Smoke\Concerns;

trait AssertsPageResponse
{
    protected function setUp(): void
    {
        parent::setUp();
        $_SERVER['HTTP_HOST'] = 'localhost';
    }

    protected function assertPageResponds(string $url, string $label = ''): void
    {
        $label = $label ?: $url;

        $host = parse_url($url, PHP_URL_HOST);
        if ($host) {
            $_SERVER['HTTP_HOST'] = $host;
        }

        $response = $this->get($url);
        $status = $response->getStatusCode();

        if ($status === 500) {
            $body = (string) $response->getContent();
            $start = mb_strpos($body, '<!--', 0, 'UTF-8');
            $end = mb_strpos($body, '-->', $start ?: 0, 'UTF-8');
            $error = $start !== false && $end !== false
                ? trim(mb_substr($body, $start + 4, $end - $start - 4, 'UTF-8'))
                : 'unknown error';
            $this->fail("Smoke test failed for {$label}: 500 error: {$error}");
        }

        $this->assertTrue(
            in_array($status, [200, 301, 302], true),
            "Smoke test failed for {$label}: expected 200/301/302, got {$status}"
        );
    }
}
