<div>
    список новостей
    <br/>
    <br/>
    <table>
        <thead>
        <tr>
            <th>сайт</th>
            <th>каталог</th>
            <th>id</th>
            <th>название</th>
            <th>содержимое</th>
        </tr>
        </thead>
        <tbody class="tr2_w_g">
        {{--    {{ $list_news }}--}}
        @foreach( $list_news as $n )
            {{--        {{ $n }}--}}
{{--            <tr>--}}
{{--                <td><span class="bg-orange-300 p-1">{{ $n->site_id }}</span></td>--}}
{{--                <td><span class="bg-blue-300 p-1">cat:{{ $n->cat_id }}</span></td>--}}
{{--                <td><span class="bg-green-300 p-1"># {{ $n->id }}</span></td>--}}
{{--                <td>{{ $n->title }}</td>--}}
{{--                <td>{{ substr($n->content,0,50) }}</td>--}}
{{--                <td style="font-size: 10px;"><pre>{{ print_r($n->toArray(),true) }}</pre></td>--}}
{{--            </tr>--}}
            <livewire:StNews.A.StANewsItem :news="$n"/>
        @endforeach
        </tbody>
    </table>
    <style>
        .tr2_w_g tr:nth-child(odd) {
            background-color: #ffffff; /* Белый фон для нечётных строк */
        }

        .tr2_w_g tr:nth-child(even) {
            background-color: #f0f0f0; /* Серый фон для чётных строк */
        }

    </style>
</div>
