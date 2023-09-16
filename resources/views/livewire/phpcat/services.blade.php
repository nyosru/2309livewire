<div class="container mx-auto py-5">

    {{ $items->links() }}

    {{-- <div class="gap-2 columns-2xs columns-3md columns-5"> --}}
    {{-- <div class="flex flex-row:md gap-5"> --}}
    {{-- <div class="flex flex-wrap gap-5"> --}}
    <div
        class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-4 grid-auto-rows: auto; py-5"
{{--        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 grid-auto-rows: auto; py-5"--}}
    >
        {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
        {{-- news --}}
        {{-- {{ $data }} --}}
        @foreach ($items as $i)
            <div class="flex-1">
                {{-- {{ print_r($post) }} --}}
                <h2 class="bg-green-200">{{ $i->title }}</h2>
                {{-- <p>{{ $post->photo }}</p> --}}
                <p><a class="text-blue-500" href="{{ $i->link }}" target="_blank" >{{ $i->link_title }}</a></p>
                <img src="{{ $i->img_url }}" />
                <p>{{ $i->opis }}</p>
                <Br />

                <div style="max-height: 175px; overflow: auto; font-size: 12px; border: 1px solid green; padding: 3px;">
                {{ str_replace('"','" ',json_encode($i,true)) }}
                </div>
            </div>
        @endforeach

    </div>

    {{ $items->links() }}

</div>
