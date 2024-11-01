<div>
    @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(count($friends))
        <ul>
            @foreach($friends as $friend)
                <li>
                    <img src="{{ $friend['photo_100'] }}" alt="{{ $friend['first_name'] }} {{ $friend['last_name'] }}" style="width:50px;height:50px;border-radius:50%;margin-right:10px;">
                    {{ $friend['first_name'] }} {{ $friend['last_name'] }}
                </li>
            @endforeach
        </ul>
    @else
        <p>Нет данных о друзьях.</p>
    @endif
</div>
