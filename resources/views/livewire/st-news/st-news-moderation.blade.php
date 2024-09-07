<div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4">News Moderation</h2>

    @if($news->isEmpty())
        <p>No pending news for moderation.</p>
    @else
        <table class="min-w-full bg-white shadow-md rounded">
            <thead>
            <tr>
                <th class="py-2 px-4 border-b">Title
                    {{--                </th>--}}
                    {{--                <th class="py-2 px-4 border-b">--}}
                    <br/>
                    Summary
                </th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($news as $item)

                <livewire:st-news.st-news-moderation-item :item="$item" />
                @if(1==2)
                    <tr>
                        <td class="py-2 px-4 border-b">
                            <b>{{ $item->title }}</b>
                            <br/>

                            @foreach( $item->photos as $p )
                                @if(1==2)
                                    <pre>
                            {{ print_r($p) }}
                                </pre>
                                    <img src="{{ $p->image_path }}" style="max-height: 100px;"/>
                                @else
                                    <livewire:StNews.StNewsModerationImage :image="$p"/>
                                @endif
                            @endforeach

                            @if( 1==2 )
                                @if( empty($item->summary) )
                                    <button class="rounded-2xl bg-green-300 px-2 py-[2px]">загрузить содержимое</button>
                                @else
                                    {{ $item->summary }}
                                    {{--                        <pre style="font-size: 10px;">{{ print_r($item->photos,true) }}</pre>--}}
                                    {{--                        <pre style="font-size: 10px;">{{ print_r($item->firstPhoto()->getAttributes(),true) }}</pre>--}}
                                @endif


                                <br/>
                                <pre class="max-w-[40rem] overflow-auto"
                                     style="font-size: 10px;">{{ print_r($item->getAttributes(),true) }}</pre>
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b">
                            <button wire:click="approve({{ $item->id }})"
                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Пойдёт
                            </button>
                            <button wire:click="reject({{ $item->id }})"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Не
                            </button>
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    @endif
</div>
