@if(config('app.debug') === false)
@persist('vkusno-development-ribbon')
<aside class="development-ribbon" data-development-ribbon aria-label="Сайт находится в разработке">
    <span>Идёт разработка <a href="https://php-cat.com" target="_blank" rel="noopener">( php-cat.com )</a></span>
    <button type="button" data-development-ribbon-close aria-label="Закрыть уведомление о разработке">×</button>
</aside>
@endpersist
@endif
