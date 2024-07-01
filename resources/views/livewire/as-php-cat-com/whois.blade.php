<div>

    <button class="bg-blue-500 p-1" wire:click="getWhois">запросить данные</button>
    <A href="http://{{ $domain ?? 'x' }}" target="_blank" >{{ $domain ?? 'x' }}</A>
    <br/>
    {!! $domain_whois ?? '-' !!}
    @if( $loading )
        -- загружаю --
    @endif
    <br/>
    <small style="font-family: arial;">
    {!! $domain_whois0 ?? '' !!}
    </small>
</div>
