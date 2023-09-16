@extends('phpcat.layouts.app')

@section('content')

    @include('phpcat.index_index')
    <livewire:Phpcat.services/>

    @if ( 1 == 2)
        @if (Route::currentRouteName() == 'phpcat.news')
            <livewire:Phpcat.news/>
        @elseif(Route::currentRouteName() == 'phpcat.torrent')
            2
        @elseif(Route::currentRouteName() == 'phpcat.money')
            3
        @elseif(Route::currentRouteName() == 'phpcat.services')
            <livewire:Phpcat.services/>
            {{-- @elseif( Route::currentRouteName() == 'phpcat.index' ) --}}
        @else
            @include('phpcat.index_index')
        @endif
    @endif

    {{--
    <livewire:showRoom :imgs="[1, 2, 55]" />
    <hr/>
    2
    <hr/>
    <livewire:Phpcat.money :imgs="[1, 2, 55]" />
    <hr/>
    3
    <hr/>
    <livewire:PhpcatMoney :imgs="[1, 2, 55]" /> --}}
@endsection




@if (1 == 2)
    <div>
        show room

        @foreach ($imgs as $im)
            @if ($im == $n)
                <button class="border-blue-700" wire:click="setset({{ $im }})">{{ $im }}</button>
            @else
                <button class="border-green-700" wire:click="setset({{ $im }})">{{ $im }}</button>
            @endif
            {{-- -  --}}
            {{-- <button class="bg-gray-300 border-green-700" wire:append="setset({{$im}})" >00{{ $im }}</button> --}}
        @endforeach

        @if ($n == 1)
            111
        @endif

        <br/>

        nn: {{ $n }}

    </div>
@endif
