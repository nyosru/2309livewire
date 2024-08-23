@extends('st_news.layouts.app')

@section('content')

    {{ $slot }}

{{--    @if(1==2)--}}
{{--        @if (request()->has('m'))--}}
{{--            @livewire('st-news.fetch-fresh-news')--}}
{{--            <livewire:st-news.st-news-moderation/>--}}
{{--        @else--}}
{{--        @endif--}}
{{--    @endif--}}

@endsection

