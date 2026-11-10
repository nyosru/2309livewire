<article class="stn-card relative flex flex-col overflow-hidden rounded-xl border border-neutral-200 bg-white">
    <a href="/storage-news/{{ $item->id }}" class="flex flex-1 flex-col">
        @php($photo = $item->media->first(fn ($media) => in_array($media->type, ['image', 'photo'], true)))
        @if($photo)
            <img src="{{ $photo->url }}" alt="" loading="lazy" class="h-48 w-full object-cover">
        @endif

        <div class="flex flex-1 flex-col p-5">
            <div class="mb-2 flex flex-wrap gap-2 text-sm text-neutral-500">
                <time>{{ ($item->published_at ?? $item->created_at)?->format('d.m.Y') }}</time>
                @if($item->source)
                    <span>{{ $item->source->name }}</span>
                @endif
            </div>

            <h2 class="stn-headline mb-3 text-lg font-bold leading-snug text-neutral-900">{{ $item->title }}</h2>
            @if($item->summary)
                <p class="mb-4 text-sm text-neutral-600">{{ \Illuminate\Support\Str::limit($item->summary, 180) }}</p>
            @endif
            <span class="mt-auto text-sm font-semibold text-blue-600">Читать дальше</span>
        </div>
    </a>
</article>
