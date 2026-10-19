@props([
    'url',
    'text' => '',
])

@php
    $shareUrl = trim((string) $url);
    $shareText = (string) $text;

    if (! str_starts_with($shareUrl, 'http://') && ! str_starts_with($shareUrl, 'https://')) {
        $shareUrl = url('/'.ltrim($shareUrl, '/'));
    }

    $vkShareUrl = 'https://vk.com/share.php?'.http_build_query([
        'url' => $shareUrl,
        'title' => $shareText,
    ], '', '&', PHP_QUERY_RFC3986);

    $maxShareUrl = 'https://max.ru/:share?'.http_build_query([
        'text' => trim($shareText . "\n" . $shareUrl),
    ], '', '&', PHP_QUERY_RFC3986);

    $telegramShareUrl = 'https://t.me/share/url?'.http_build_query([
        'url' => $shareUrl,
        'text' => $shareText,
    ], '', '&', PHP_QUERY_RFC3986);

    $ariaSubject = $shareText !== '' ? ' «' . $shareText . '»' : '';
@endphp

<div {{ $attributes->class(['flex flex-wrap items-center gap-2']) }}>
    <span class="mr-1 text-sm text-gray-600">Поделиться:</span>

    <a href="{{ $vkShareUrl }}"
       rel="noopener noreferrer"
       aria-label="Поделиться{{ $ariaSubject }} во ВКонтакте"
       class="rounded-md bg-blue-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-blue-700">
        ВКонтакте
    </a>

    <a href="{{ $maxShareUrl }}"
       rel="noopener noreferrer"
       aria-label="Поделиться{{ $ariaSubject }} в MAX"
       class="rounded-md bg-purple-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-purple-700">
        MAX
    </a>

    <a href="{{ $telegramShareUrl }}"
       rel="noopener noreferrer"
       aria-label="Поделиться{{ $ariaSubject }} в Telegram"
       class="rounded-md bg-sky-500 px-3 py-1.5 text-sm font-medium text-white hover:bg-sky-600">
        Telegram
    </a>
</div>
