@extends('afisha.layouts.app')

@section('content')

{{--    @if(request()->query('ss') == 'add')--}}
{{--        <livewire:Afisha.AddForm/>--}}
{{--    @elseif(request()->routeIs('afisha.detail'))--}}
{{--        <livewire:Afisha.PosterDetail :posterId="request()->route('posterId')"/>--}}
{{--    @else--}}
{{--        <livewire:Afisha.PosterComponent/>--}}
{{--    @endif--}}

    {{ $slot }}

@endsection
