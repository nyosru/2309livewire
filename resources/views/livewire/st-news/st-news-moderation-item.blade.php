<tr>


    <td class="py-2 px-4 border-b">
        <b>{{ $item->title }}</b>
        @if( $item->moderation === True || $item->moderation === False )
            модерация: {{ $item->moderation ? 1 : 0 }}
        @else

            <br/>

            {{--        <pre class="text-xs overflow-auto max-w-[90%] max-h-[20rem]">{{ print_r($item,true) }}</pre>--}}

            <div>
                {{ $item->content ?? 'no content' }}
            </div>

            @foreach( $item->photos as $p )
                {{--<pre>{{ print_r($p) }}</pre>--}}
                <livewire:StNews.StNewsModerationImage :image="$p"/>
            @endforeach

            @if( 1==2 )
                @if( empty($item->summary) )
                    <button class="rounded-2xl bg-green-300 px-2 py-[2px]">загрузить содержимое</button>
                @else
                    {{ $item->summary }}
                    {{--                        <pre style="font-size: 10px;">{{ print_r($item->photos,true) }}</pre>--}}
                    {{--                        <pre style="font-size: 10px;">{{ print_r($item->firstPhoto()->getAttributes(),true) }}</pre>--}}
                @endif

            @endif

            <br/>
            <pre class="max-w-[40rem] overflow-auto"
                 style="font-size: 10px;">{{ print_r($item->getAttributes(),true) }}</pre>
        @endif
    </td>
    <td class="py-2 px-4 border-b">
        <button wire:click="moderation(true)"
                class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Пойдёт
        </button>
        <button wire:click="moderation(false)"
                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Не
        </button>
    </td>

</tr>
