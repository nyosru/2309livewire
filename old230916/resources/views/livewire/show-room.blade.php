<div>
    show room

    @foreach ( $imgs as $im )
    
    @if( $im == $n )
    <button class="border-blue-700" wire:click="setset({{$im}})" >{{ $im }}</button>
    @else
    <button class="border-green-700" wire:click="setset({{$im}})" >{{ $im }}</button>
    @endif
    {{-- -  --}}
    {{-- <button class="bg-gray-300 border-green-700" wire:append="setset({{$im}})" >00{{ $im }}</button> --}}

    @endforeach

    @if( $n == 1)
    111
    @endif
    
    <br/>

    nn: {{ $n }}

</div>
