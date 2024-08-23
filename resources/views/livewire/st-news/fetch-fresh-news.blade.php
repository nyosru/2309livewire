<div>
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <button wire:click="fetchNews" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700">
        Загрузить свеженькое
    </button>
</div>
