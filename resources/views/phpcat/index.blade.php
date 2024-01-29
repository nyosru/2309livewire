@extends('phpcat.layouts.app')

@section('content')

    @include('phpcat.index_index')

    <livewire:Phpcat.services/>

    <livewire:Phpcat.develop/>

    <div
{{--        class="container my-24 mx-auto md:px-6"--}}
        class=" my-24 xmx-auto xmd:px-6"
    >

        {{-- пожертвование--}}
        <livewire:Phpcat.money/>

        {{--коллекция кружек--}}
        <livewire:Phpcat.caps/>

    </div>

@endsection
