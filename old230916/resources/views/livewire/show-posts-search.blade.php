<div>

    <div class="bg-green-800 p-5">
    <nav>
        <a href="/p1" wire:navigate>Dashboard</a>
        <a href="/p2" wire:navigate>Posts</a>
        <a href="/p3" wire:navigate>Users</a>
    </nav>
</div>

    <form wire:submit="search">
        <input type="text" wire:model="query">
 
        <button type="submit">Search posts</button>
    </form>
 
    <div>
        @foreach ($posts as $post)
             {{-- {{ print_r($post) }} --}}
             <h2 class="bg-green-200">{{ $post->title }}</h2>
             <p>{{ $post->photo }}</p>
             <p>{{ $post->text }}</p>
        @endforeach
    </div>
 
    {{ $posts->links() }}
</div>