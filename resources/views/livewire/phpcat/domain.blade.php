<div>
    <h2>Список сайтов</h2>
    data_file:
{{--    <pre>{{ print_r($data_file) }}</pre>--}}
    @foreach( $data_file as $v )
{{--        <pre>{{ print_r($v) }}</pre>--}}
        @foreach( $v['domains'] as $d )
            {{ $d }}
            <livewire:domain-check lazy :domain="$d"/>
            <br/>
        @endforeach
        <hr>
    @endforeach
</div>
