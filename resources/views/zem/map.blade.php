<br/>
<div class="flex place-content-stretch">

    <div class="flex-initial flex flex-col items-center justify-center text-center  w-[49%]">
        <h2 class="text-4xl">Кооперативы и&nbsp;возможность провести приватизацию:</h2>
    </div>
    <div class="flex-initial w-[49%] flex flex-col items-center justify-center text-center">

<span class="bg-green-100 p-1">
<span class="bg-green-400 p-1">Зелёный</span>
    Приватизация проходит в обычном режиме
</span>
        <br/>
        <span class="bg-yellow-100 p-1">
<span class="bg-yellow-400 p-1">
Жёлтый</span>  есть нюансы, приватизацию можно провести
    </span>
        <br/>
        <span class="bg-red-100 p-1">
<span class="bg-red-400 p-1">
Красный</span>  Приватизацию не получится провести</span>
    </div>
</div>
<br/>

<div id="map" style="width: 100%; height: 400px;"></div>

<script src="https://api-maps.yandex.ru/2.1/?apikey=d459c05b-ae5a-4168-86ba-15c5487e307c&lang=ru_RU"
        type="text/javascript"></script>

<script type="text/javascript">
    ymaps.ready(function() {
        var myMap = new ymaps.Map('map', {
            center: [57.143606, 65.553551], // Центр карты
            zoom: 13
        });

        @foreach ($cooperatives as $cooperative)
        // Создаем метку для кооператива
        var placemark{{ $loop->index }} = new ymaps.Placemark(
            [{{ $cooperative->coordinate_x }}, {{ $cooperative->coordinate_y }}], {
                balloonContent: '<b>{{ $cooperative->name }}</b><br>{{ $cooperative->description }} {!! ( $cooperative->status == 'green' || $cooperative->status == 'yellow' ) ? '<br><a class="bg-green-300 p-1" href="#">Заказать приватизацию</a>' : "" !!}'
            }, {
                preset: '{{ $cooperative->status == 'green' ? 'islands#greenDotIconWithCaption' : ($cooperative->status == 'yellow' ? 'islands#yellowIcon' : 'islands#redIcon') }}', // Статус маркера
                iconCaption: '{{ $cooperative->name }}'
            });

        // Добавляем метку на карту
        myMap.geoObjects.add(placemark{{ $loop->index }});
        @endforeach
    });
</script>
