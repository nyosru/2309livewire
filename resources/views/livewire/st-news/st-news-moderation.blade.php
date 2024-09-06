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
                <tr>
                    <td class="py-2 px-4 border-b">
                        <b>{{ $item->title }}</b>
                        <br/>

                        @foreach( $item->photos as $p )
                            <img src="{{ $p->image_path }}" style="max-height: 100px;"/>
                        @endforeach

                        @if( empty($item->summary) )
                            <button class="rounded-2xl bg-green-300 px-2 py-[2px]">загрузить содержимое</button>
                        @else
                            {{ $item->summary }}
                            {{--                        <pre style="font-size: 10px;">{{ print_r($item->photos,true) }}</pre>--}}
                            {{--                        <pre style="font-size: 10px;">{{ print_r($item->firstPhoto()->getAttributes(),true) }}</pre>--}}
                        @endif

                        <br/>
                        <pre style="font-size: 10px;">{{ print_r($item->getAttributes(),true) }}</pre>

                    </td>
                    <td class="py-2 px-4 border-b">
                        <button wire:click="approve({{ $item->id }})"
                                class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Approve
                        </button>
                        <button wire:click="reject({{ $item->id }})"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Reject
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
