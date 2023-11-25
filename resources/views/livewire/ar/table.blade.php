<div>

    <h1>234234</h1>

    {{--    {{ $objects }}--}}

    <table>
        @foreach( $objects as $o )

            <tr>
                <td>
                    <h2 class="text-2xl font-bold">{{ $o->adres }} # {{ $o->nomer }}</h2>
                    <small>{{ $o->opis }}</small>
                    {{-- {{ $o }}--}}
                    <br/>
                    <br/>

                    <div>
                        <button wire:click="onoff({{ $o->id }})" class="bg-[#adadad] p-1">новый арендатор</button>
                    </div>
                    @if( isset($oo[$o->id]) && $oo[$o->id] > 0 )
                        @include('livewire.ar.addNewPrice')
                    @endif

                    {{--                    <br/>--}}
                    {{--                    <br/>--}}

                    {{--                    $o->prices<br/>--}}
                    {{--                    {{ $o->prices }}--}}
                    {{--                    <br/>--}}
                    {{--                    <br/>--}}
                    @if(1==2)
                        <div class="pl-5">
                            @foreach($o->prices as $p )
                                <div class="border-[2px]">
                                    ar_people_id {{ $p->ar_people_id }} /
                                    date_start {{ $p->date_start }} /
                                    price {{ $p->price }}
                                    <br/>
                                    {{ $p }}
                                </div>
                                <br/>
                                <br/>
                            @endforeach
                        </div>
                    @endif

                    @if(1==2)
                        <div class="pl-5">
                            @foreach($o->payes as $pa )
                                <div class="border-[5px] border-orange-400 mb-1">
                                    ar_people_id: {{ $pa->ar_people_id }} /
                                    amount: {{ $pa->amount }} <br/>
                                    amount: {{ $pa->date }} <br/>
                                    {{--                                {{ $pa }}--}}
                                    {{--                                ar_people_id {{ $p->ar_people_id }} /--}}
                                    {{--                                date_start {{ $p->date_start }} /--}}
                                    {{--                                price {{ $p->price }}--}}
                                    {{--                                <br/>--}}
                                    {{--                                {{ $p }}--}}
                                </div>
                                {{--                            <br/>--}}
                                {{--                            <br/>--}}
                            @endforeach
                        </div>
                    @endif
                    {{--                    ar_people_id: {{ $o->prices[0]['ar_people_id'] ?? '-no-' }} /--}}
                    {{--                    price: {{ $o->prices[0]['price'] ?? '-no-' }} /--}}
                    {{--                    <br/>--}}
                    {{--                    price_date: {{ $o->prices[0]['date_start'] ?? '-no-' }} /--}}
                    {{--                    <br/>--}}
                    {{--                    <br/>--}}
                    {{--                    price-man: {{ $o->prices[0]['man'][0]->name ?? '-no-' }}--}}
                    {{--                    <br/>--}}
                    {{--                    <br/>--}}
                </td>
                {{--            <td>{{ $o->payes }}</td>--}}
            </tr>
            {{--            <tr>--}}
            {{--                <td>{{ $o->adres }}</td>--}}
            {{--                <td>--}}
            {{--                    <b> $o->prices </b><br/>--}}
            {{--                    {{ $o->prices }}--}}
            {{--            </td>--}}
            {{--            <td>--}}
            {{--                    <br/>--}}
            {{--                    <b> $o->payes </b><br/>--}}
            {{--                    {{ $o->payes }}</td>--}}
            {{--            </tr>--}}
            {{--        {{ $o->id }}--}}
            {{--    <br/>--}}
            {{--        {{ $o }}--}}
            {{--        <br/>--}}
            {{--        <br/>--}}

        @endforeach
    </table>

    @include('livewire.ar.add')

</div>
