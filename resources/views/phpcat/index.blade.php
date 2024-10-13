@extends('phpcat.layouts.app')

@section('content')

    @if( request()->query('tutu') == 'domains' )

        <livewire:Phpcat.domain/>

    @else

        @include('phpcat.index_index')

        <livewire:Phpcat.services/>

        <livewire:Phpcat.bitrix/>
{{--        @include('phpcat.bitrix')--}}

        <livewire:Phpcat.develop/>

        <div
            {{--        class="container my-24 mx-auto md:px-6"--}}
            class=" xmy-24 xmx-auto xmd:px-6"
        >

            {{-- пожертвование--}}
            <livewire:Phpcat.money />

            {{--коллекция кружек--}}
            <livewire:Phpcat.caps />

        </div>

        <div class="block bg-blue-200">
            <div class="container mx-auto py-5">
                <h1 class="text-[2rem] font-bold">Помошники, пользуйтесь сразу</h1>
            </div>
        </div>

        <livewire:Phpcat.punny-converter />

    @endif
@endsection
