@extends('Afisha.layouts.app')

@section('content')

    @if( request()->query('ss') == 'add' )
        <livewire:Afisha.AddForm/>
    @else
{{--        <livewire:Afisha.Index/>--}}
        <livewire:Afisha.PosterComponent/>
    @endif

@endsection
