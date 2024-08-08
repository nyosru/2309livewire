<div>

    {!! $string !!} <sup class="text-blue-400 cursor-pointer" wire:click="switcher">info</sup>

    @if( $show )
        <div
            class="inline-block max-w-full mr-1 max-h-[300px] overflow-auto border border-solid border-[5px] border-green-200 p-1">
            <pre class="block text-sm">{{ print_r($data,true) }}</pre>
        </div>
    @endif
</div>
