<tr>
    <td><span class="bg-orange-300 p-1">{{ $news->site_id }}</span></td>
    <td><span class="bg-blue-300 p-1">cat:{{ $news->cat_id }}</span></td>
    <td><span class="bg-green-300 p-1">#{{ $news->id }}</span></td>
    <td>
        @if (session()->has('message'))
            <div class="mb-4 p-2 bg-green-200 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('warn'))
            <div class="mb-4 p-2 bg-red-200 text-black-800 rounded">
                {{ session('warn') }}
            </div>
        @endif

        {{ $news->title }}</td>
    <td>
        <button class="bg-blue-300 px-2 py-1 rounded text-sm hover:bg-blue-400" wire:click="parseNewsFull">Сканировать
            контент
        </button>
        <div wire:loading wire:target="parseNewsFull" class="mt-4">
            <p>Загрузка данных, подождите...</p>
        </div>

        {{ substr($news->content,0,50) }}

        @if( !empty($data_parse) )
            <br/>
            {{ strlen($data_parse['content']) }} /
            {{ $data_parse['content'] }}
            {{--            <br/>--}}
            {{--                        {{ strlen($data_parse->content) }}--}}
            <br/>
            <pre>{{ print_r($data_parse,true) }}</pre>
        @endif
    </td>
    <td style="font-size: 10px;">
        <pre style="max-height: 100px; overflow: auto;">{{ print_r($news->toArray(),true) }}</pre>
    </td>
</tr>
