@extends('phpcat.layouts.app')

@section('content')

    @if( 1 == 2 )

    @if( request()->query('tutu') == 'domains' )

        <livewire:Phpcat.domain/>

    @else

        @include('phpcat.index_index')

        <livewire:Phpcat.services/>

        <livewire:Phpcat.develop/>

        <div
                    class="container my-24 mx-auto md:px-6"
            class=" xmy-24 xmx-auto xmd:px-6"
        >

             пожертвование
            <livewire:Phpcat.money/>

            коллекция кружек
            <livewire:Phpcat.caps/>

        </div>
    @endif

    @endif

@endsection
