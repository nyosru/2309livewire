<div class="container-fluid mx-auto">
    <div class="mx-auto flex w-full max-w-7xl flex-col items-center gap-4 px-5 py-4 text-center lg:flex-row lg:justify-between lg:text-left">
        <div class="max-w-2xl">
            <h1 class="text-xl"><b>Коллекция кружек для питья горячего, сладкого кофе с молоком</b></h1>
            <p>на которой написано название страны, города или места где получилось ей обзавестись, купить, получить</p>
        </div>

        <div class="shrink-0 bg-yellow-200 px-5 py-3 text-center">
            <p>Как получится прислать кружку, присылайте! <b>Используйте Почту России.</b></p>
            <p>625062 г. Тюмень, ул. Революции 208а, кв. 1 · Сергей Бакланов · 8-922-262-22-89</p>
            <p>(так же присылайте, свой рекламный текст, адрес, телефон)</p>
        </div>
    </div>

    <livewire:cups.collection-map/>
    <livewire:cups.latest-cup/>

    <div class="columns-2 px-5 pt-10 md:columns-3 lg:columns-4 xl:columns-5">
        @foreach( $cups as $item )
            <livewire:cups.item :i="$item"/>
        @endforeach
    </div>

    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
</div>
