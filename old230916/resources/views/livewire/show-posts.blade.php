<div>
    <div>
        @foreach ($posts as $post)
            {{-- {{ print_r($post) }} --}}
            <h2 class="bg-green-200">{{ $post->title }}</h2>
            <p>{{ $post->photo }}</p>
            <p>{{ $post->text }}</p>
            <Br/>
        @endforeach
    </div>
 
    {{ $posts->links() }}
</div>