<div>

    <h2 style="font-size: 2rem;">pays</h2>

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

        <div style="margin-left: 15px; margin-bottom: 5px;border-left: 2px solid green; padding: 10px; float: left;">
            {{--                                    <pre>                        {{ print_r($op) }}                        </pre>--}}
            id {{ $op->id }} <br/>
            ar_object_id {{ $op->ar_object_id }} <br/>
            ar_people_id {{ $op->ar_people_id }} <br/>
            {{--            price {{ $op->price }} <br/>--}}
            amount {{ $op->amount }} <br/>
            date {{ $op->date }} <br/>
            {{--            date_start {{ $op->date_start }} <br/>--}}
            opis {{ $op->opis }} <br/>
            {{--                        created_at                        {{ $op->created_at }}                        <br/>--}}
            {{--                        updated_at                        {{ $op->updated_at }}                        <br/>--}}
            {{--                        deleted_at                        {{ $op->deleted_at }}--}}

            {{--            [id] => 223--}}
            {{--            [ar_object_id] => 1--}}
            {{--            [ar_people_id] => 5--}}
            {{--            [amount] => 2400.00--}}
            {{--            [date] => 2023-12-25--}}
            {{--            [opis] =>--}}
            {{--            [json] =>--}}
            {{--            [created_at] => 2024-02-03 22:11:14--}}
            {{--            [updated_at] => 2024-02-03 22:11:14--}}
            {{--            [deleted_at] =>--}}

        </div>
    @endforeach

</div>
