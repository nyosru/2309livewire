<div>
    <h2>Список доменов</h2>

    @if(isset($domains['error']))
        <p>{{ $domains['error'] }}</p>
    @else
        <ul>
            @foreach($domains as $domain)
                <li>{{ $domain->name }}</li>
            @endforeach
        </ul>
    @endif
</div>
