<div>
<div class="container m-auto">

    <div class="py-3">

        <h2 class="text-center text-2xl font-bold mb-2">
            {{--        <span class="bg-blue-300 p-2">vk.files.php-cat.com</span>--}}
            Поиск файлов во Вконтакте <sup><A href="https://vk.com" class="underline" target="_blank">VK.com</a></sup>
        </h2>

        <p class="mb-2">Файлы всего русского комьюнити, можно найти мне кажется всё что угодно,
            можно качать по прямым ссылкам (<u>бесплатное скачивание</u> при подключении доступа к социально значимым
            сервисам,
            доступно у всех мобильных операторов)</p>

        <p class="text-xl bg-yellow-100 py-5 text-center"><b>НЕ забывайте о безопасности,</b><br/>в файлах могут быть
            вирусы и всякие обманы, антивирус и бдительность должны быть включены 100%</p>

    </div>
</div>


<div class="bg-yellow-300 py-3 text-center" style="  position: sticky;  top: 0;">

    <div class="input-group mb-3">

        <input type="text"
               style="min-width: 60%; text-align: center;"
               placeholder="Поиск по названию файла и содержимому!"
               class="px-5 py-1 border-2"
               wire:model.live="searchTxt"
        />
        {{--    Фильтр по размеру файла:--}}
        <select wire:model.live="filterBig" class="bg-white px-5 py-2 border-2">
            <option value="0">Все размеры</option>
            <option value="100">100 Мб и больше</option>
            <option value="1000">1000 Мб и больше</option>
        </select>

    </div>

    @if ( !empty($searchTxt) )
        <p class="mt-2 p-2 bg-green-300 text-center">
            текущищй поиск: <u>{{ $searchTxt }}</u>
        </p>
    @endif

</div>
{{--    <button wire:click="refresh">Искать</button>--}}

<div class="container m-auto">

    <div class="py-3">

        <br/>
        {{--    $filterBig: {{ $filterBig  }}--}}
        {{--    <br/>--}}
        {{--    $searchTxt: {{ $searchTxt ?? 'x'}}--}}
        {{--    ss({{ $searchTxt }})--}}
        {{--    ss {{ $searchTxt2 ?? 'x'}}--}}
        {{--    <br/>--}}
        {{--    <h2>что нашли</h2>--}}

        {{--    <pre style="font-size:10px; max-height: 200px; overflow: auto;">{{ print_r($results) ?? 'x' }}</pre>--}}
        {{--    {{ print_r($resultsSearch) ?? 'x' }}--}}
        <Style>
            table tr:nth-child(2n) {
                background-color: rgba(0, 0, 0, 0.05);
            }
        </Style>
        {{--    {{$resultsSearch->links()}}--}}

        {{--    $searchTxt: {{ $searchTxt }}--}}
        <br/>


        {{--@if ( $resultsSearch )--}}
        <div wire:transition>

            <table style="margin: 0 auto;">
                <thead>
                <tr>
                    <th>нн</th>
                    <th>файл</th>
                    <th>размер</th>
                </tr>
                </thead>
                <tbody>
                {{--        {{ $count = 0 }}--}}
                @foreach( $resultsSearch as $i )
                    <tr
                        @if($i->size/1024/1024/1024 > 1) style="font-size: 150%; font-weight: bold; "
                        @elseif($i->size/1024/1024/100 > 1) style="font-size: 115%; font-weight: bold; "
                        @endif
                    >
                        <td>{{ $count++ }}</td>
                        <td class="p-1">
                            @if( $i->owner_id > 0 )
                            <small><abbr title="id пользователя в vk (иногда ошибочное значение)" ><a href="https://vk.com/id{{ $i->owner_id }}" target="_blank" style="float:right; background-color: rgba(120,255,255,0.7);" class="p-1" >{{ $i->owner_id }}</a></abbr></small>
                            @endif
                            <a href="{{ $i->url }}" class="text-blue-500 hover:underline"
                                           target="_blank">{{ $i->title }}
                                @if( $i->ext == 'jpg' || $i->ext == 'gif' || $i->ext == 'png' )
                                    {{--                        @if( $i->ext == 'jpg' )--}}
                                    <img src="{{ $i->url }}"
                                         style="max-height: 150px; float:left; padding-right: 5px;"/>
                                @endif
                            </a>

                            @if( !empty($i->preview->photo->sizes ) && $i->ext == 'jpg')
                                Превью:
                                @foreach( $i->preview->photo->sizes as $im )
                                    <A href="{{$im->src}}" class="bg-orange-500 m-2 p-2" target="_blank"
                                       title="">{{$im->type}}
                                        -> {{$im->width}}x{{$im->height}}</A>
                                @endforeach
                            @endif

                        </td>
                        <td>{{ round($i->size/1024/1024,2) }} Mb</td>
                    </tr>
                    {{--            {{ $count++ }}--}}
                    {{--            <tr>--}}
                    {{--                <td colspan="2">--}}
                    {{--                    <pre style="font-size: 8px;">{{ print_r($i) }}</pre>--}}
                    {{--                </td>--}}
                    {{--            </tr>--}}

                    {{--                    @else--}}
                    {{--                        <tr><Td>тю тю</Td></tr>--}}
                @endforeach

                @if( $count == 0 )
                    <tr>
                        <td colspan="4">
                            <div class="p-5 bg-yellow-300 alert-danger text-center">
                                нечего показывать, измените фильтры
                            </div>
                        </td>
                    </tr>
                @endif

                </tbody>
            </table>

        </div>
        {{--    @endif--}}

    </div>
</div>
