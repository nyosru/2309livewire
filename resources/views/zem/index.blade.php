@extends('zem.layouts.app')

@section('content')

    {{--    @include('zem.index_index')--}}

    @if(request()->get('show') == 'page1')
        <div class="bg-gradient-to-br from-gray-300 to-blue-300 p-[3rem]">
            <div class="container mx-auto ">
                <div class="shadow-2xl rounded-2xl p-4 bg-white">
                    <livewire:Zem.page.step1/>
                </div>
            </div>
        </div>
    @endif


    <livewire:Zem.form/>
    <br/>
    <br/>

    {{--    <livewire:Zem.uslugi/>--}}
    {{--    @include('zem.map',['cooperatives' => $cooperatives ])--}}

    @include('zem.index_uslugi')
    <livewire:Zem.Mp3Pleer/>
    @include('zem.map')

    {{--<br/>--}}
    {{--<br/>--}}

    <livewire:Zem.form/>
    <livewire:Zem.BazaZnan/>
    <Br/>
    <Br/>

    @if(1==2)

        {{--    <livewire:Phpcat.services/>--}}
        {{--    <livewire:Phpcat.develop/>--}}

        <div
            {{--        class="container my-24 mx-auto md:px-6"--}}
            class=" xmy-24 xmx-auto xmd:px-6"
        >
            {{-- пожертвование--}}
            {{--        <livewire:Phpcat.money/>--}}
            {{--коллекция кружек--}}
            {{--        <livewire:Phpcat.caps/>--}}
        </div>
    @endif
@endsection
