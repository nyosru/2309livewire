<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h1 class="text-3xl font-bold mb-4">{{ $news->title }}</h1>
        <p class="text-gray-600 mb-6">{{ $news->published_at->format('d M Y') }}</p>
        <div class="text-lg text-gray-800 leading-7">
            {{ $news->content }}
        </div>

        @if ($news->firstPhoto())
            <div class="mt-6">
                <img src="{{ asset('storage/' . $news->firstPhoto()->image_path) }}" alt="{{ $news->title }}" class="w-full h-auto rounded-md">
            </div>
        @endif

        @if ($news->source)
            <div class="mt-4">
                <a href="{{ $news->source }}" target="_blank" class="text-blue-500 hover:underline">
                    Читать на источнике
                </a>
            </div>
        @endif
    </div>
</div>
