<div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-md">
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-200 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Форма добавления комментария -->
    <form wire:submit.prevent="submit" class="space-y-4">

        <div>
            <textarea id="comment" wire:model="comment"
                      placeholder="Комментарий"
                      class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem]
                      border border-solid border-[2px] border-green-200
                      leading-[1.6] xoutline-none transition-all duration-200
                      ease-linear focus:placeholder:opacity-100 peer-focus:text-primary
                      data-[twe-input-state-active]:placeholder:opacity-100
                      motion-reduce:transition-none
                      dark:text-white dark:placeholder:text-neutral-300 dark:peer-focus:text-primary
                      [&:not([data-twe-input-placeholder-active])]:placeholder:opacity-0"

{{--                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"--}}
            ></textarea>

            @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <button type="submit"
                    class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Добавить комментарий
            </button>
        </div>
    </form>

    <!-- Список комментариев с пагинацией -->
    <div class="mt-6">
        <h3 class="text-lg font-medium text-gray-700">Комментарии</h3>
        @forelse ($comments as $comment)
            <div class="mt-4 p-4 bg-gray-100 rounded-md">
                <p class="text-sm text-gray-600">{{ date('d.m.Y H:i',strtotime($comment->created_at)) }}</p>
                <p class="text-gray-800">{{ $comment->comment }}</p>
                {{--                <p class="text-sm text-gray-600">{{ $comment->created_at->diffForHumans() }}</p>--}}
            </div>
        @empty
            <p class="mt-4 text-gray-500">Комментариев пока нет.</p>
        @endforelse

        <!-- Пагинация -->
        <div class="mt-4">
            {{ $comments->links() }}
        </div>
    </div>
</div>
