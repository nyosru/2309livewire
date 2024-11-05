<div>
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Имя</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($friends as $key => $friend)
            <tr wire:key="{{ $loop->index }}">
                <td>{{ $key + 1 }}</td>
                <td><img src="{{ $friend['photo_url'] }}" alt="" style="width: 50px;"> {{ $friend['first_name'] }} {{ $friend['last_name'] }}</td>
                <td>
                    <button wire:click="deleteFriend({{ $friend['id'] }})" class="btn btn-danger">Удалить</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
