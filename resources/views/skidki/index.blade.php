@extends('skidki.layouts.app')

@section('content')
    <div class="text-center mt-5">
        <livewire:skidki.index/>

        @if(request()->has('ss'))
            <livewire:skidki.addComponent/>
        @endif

    </div>
@endsection
