@extends('mannik.layouts.app')

@section('content')

    <livewire:mannik.order-form />
    <livewire:mannik.indexComponent />

{{--    <div class="flex flex-col">--}}

{{--        <div class="w-full flex justify-center flex-row">--}}
{{--            <div class="w-1/2">фотка</div>--}}
{{--            <div class="w-1/2">описание манника</div>--}}
{{--        </div>--}}

{{--        <div class="w-full flex justify-center flex-row">--}}
{{--            <div class="w-1/2">Заказать манник</div>--}}
{{--            <div class="w-1/2">Звоните</div>--}}
{{--        </div>--}}

{{--        <livewire:skidki.index/>--}}

{{--        @if(request()->has('ss'))--}}
{{--            <livewire:skidki.addComponent/>--}}
{{--        @endif--}}

{{--    </div>--}}
@endsection
