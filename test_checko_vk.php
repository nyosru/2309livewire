<?php
require '/home/2309livewire/vendor/autoload.php';
$app = require_once '/home/2309livewire/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

config()->set('services.checko.vk_token', 'test-token');
config()->set('services.checko.vk_user_id', '5903492');
Illuminate\Support\Facades\Http::fake(['*messages.send*' => Illuminate\Support\Facades\Http::response(['response' => 123], 200)]);

$t = Livewire\Livewire::test(App\Livewire\Phpcat\Services\Checko::class)
    ->set('number', '4027148080')
    ->call('search');

echo "SEARCH OK\n";

Illuminate\Support\Facades\Http::assertSent(function ($request) {
    return str_contains($request->url(), 'messages.send')
        && (int) ($request['user_id'] ?? 0) === 5903492;
});

echo "VK SENT OK\n";
