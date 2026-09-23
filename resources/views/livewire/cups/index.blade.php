<div class="container-fluid mx-auto">
    <div class="w-full mt-10 text-center mb-5">
        <h1 class="text-xl"><b>Коллекция кружек для питья горячего, сладкого кофе с молоком</b></h1>
        <p>на которой написано название страны, города или места где получилось ей обзавестись, купить, получить</p>

        <br/>
        <div class="bg-yellow-200 p-5 inline-block">
            <p>Как получится прислать кружку, присылайте!</p>
            <p>
                <b>используйте почту россии,</b><br/>
                625062 г.Тюмень, ул. Революции 208а, кв 1<br/>
                Сергей Бакланов 8-922-262-22-89
            </p>
        </div>
    </div>

    <div class="columns-2 md:columns-3 lg:columns-4 xl:columns-5 px-5">
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
