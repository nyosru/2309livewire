@extends('zem.layouts.app')

@section('content')

    @include('zem.index_index')

    <livewire:Zem.form/>
    <livewire:Zem.uslugi/>
    <livewire:Zem.form/>

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
