<div>
    <h2 style="font-size: 2rem;">prices</h2>

    <br/>
    {{--                    @foreach( $o->prices->getAttributes as $k2 => $op )--}}
    {{--                    @foreach( $o->getAttributes as $k2 => $op )--}}
    @foreach( $data as $op )

        {{--                        @foreach( array_keys($op) as $op3 )--}}
        {{--                        @foreach( $op as $k3 => $op3 )--}}
        {{--                            <br/>++{{ $k3 }} ++ {{ $op3 }}--}}
        {{--                        @endforeach--}}

        {{--                        <hr>--}}
        {{--                        <pre>                        {{ print_r($op) }}                        </pre>--}}

        <div style="margin-left: 15px; margin-bottom: 5px;border-left: 2px solid green; padding: 10px;">
            id {{ $op->id }} <br/>
            ar_object_id {{ $op->ar_object_id }} <br/>
            ar_people_id {{ $op->ar_people_id }} <br/>
            price {{ $op->price }} <br/>
            date_start {{ $op->date_start }} <br/>
            opis {{ $op->opis }} <br/>
            {{--                        created_at                        {{ $op->created_at }}                        <br/>--}}
            {{--                        updated_at                        {{ $op->updated_at }}                        <br/>--}}
            {{--                        deleted_at                        {{ $op->deleted_at }}--}}
            @foreach( $op->man as $m )
                <div style="margin-left: 15px; margin-bottom: 5px;border-left: 2px solid blue; padding: 10px;">
                    {{--                                    <pre>                        {{ print_r($op->man) }}                        </pre>--}}
                    {{--                                    <pre>                        {{ print_r($m) }}                        </pre>--}}
                    id {{ $m->id }} <br/>
                    name {{ $m->name }} <br/>
                    phone {{ $m->phone }} <br/>
                    phone2 {{ $m->phone2 }} <br/>
                    opis {{ $m->opis }} <br/>
                    {{--            [created_at] => 2024-02-03 22:11:13--}}
                    {{--            [updated_at] => 2024-02-03 22:11:13--}}
                    {{--            [deleted_at] =>--}}

                    @foreach( $payes as $p )
                        @if(
	$p->ar_people_id == $m->id &&
	$p->ar_object_id == $object_id
	)
                            <div
                                style="margin-left: 15px; margin-bottom: 5px;border-left: 2px solid blue; padding: 10px;">
                                {{--                            --}}{{--                                    <pre>                        {{ print_r($op->man) }}                        </pre>--}}
                                {{--                            <pre>                        {{ print_r($p) }}                        </pre>--}}

                                id {{ $p->id }} <br/>
                                {{--                            [id] => 223--}}
                                ar_object_id {{ $p->ar_object_id }} <br/>
                                ar_people_id {{ $p->ar_people_id }} <br/>
                                amount {{ $p->amount }} <br/>
                                date {{ $p->date }} <br/>
                                opis {{ $p->opis }} <br/>
                                {{--//                            [json] =>--}}
                                {{--//                            [created_at] => 2024-02-03 22:11:14--}}
                                {{--//                            [updated_at] => 2024-02-03 22:11:14--}}
                                {{--//                            [deleted_at] =>--}}
                                {{--                            name {{ $m1->name }} <br/>--}}
                                {{--                            price {{ $m1->price }} <br/>--}}
                                {{--                            amount {{ $m1->amount }} <br/>--}}
                                {{--                            phone {{ $m1->phone }} <br/>--}}
                                {{--                            phone2 {{ $m1->phone2 }} <br/>--}}
                                {{--                            opis {{ $m1->opis }} <br/>--}}
                                {{--                            --}}{{--            [created_at] => 2024-02-03 22:11:13--}}
                                {{--                            --}}{{--            [updated_at] => 2024-02-03 22:11:13--}}
                                {{--                            --}}{{--            [deleted_at] =>--}}
                            </div>
                        @endif
                    @endforeach

                </div>
            @endforeach
        </div>
    @endforeach

</div>
