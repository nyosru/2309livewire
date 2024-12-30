<div class="bg-gradient-to-br from-orange-200 to-cyan-200 min-h-[10rem] py-[3rem]">
<div class="container mx-auto">

    <h1 class="p-7 text-3xl font-bold">База знаний</h1>


    <div class="flex">
        <!-- Левый блок с заголовками -->
        <div class="w-1/4 border-r pr-4">
            @foreach ($pages as $key => $page)
                <a wire:click.prevent="$set('selectedPage', '{{ $key }}')" href="#"
                   class="block p-2 hover:bg-gray-100 {{ $selectedPage === $key ? 'font-bold bg-white/95' : '' }}">{{ $page['title'] }}</a>
            @endforeach
        </div>

        <!-- Правый блок с контентом -->
        <div class="w-3/4 pl-4 bg-white/95 py-[2rem]">
            <h2 class="mb-4 text-xl font-semibold">{{ $pages[$selectedPage]['title'] }}</h2>
            <p>{!! $pages[$selectedPage]['content'] !!}</p>
        </div>
    </div>

</div>
</div>
