@props(['footer' => false])

<a {{ $attributes->class(['brand', 'brand-footer' => $footer])->merge([
    'href' => '#top',
    'aria-label' => 'РААЛ — на главную',
]) }}>
    <span class="brand-mark" aria-hidden="true">Р</span>
    <span class="brand-copy">
        <span class="brand-name">РААЛ</span>
        <small>Работа Алгоритмов</small>
    </span>
</a>
