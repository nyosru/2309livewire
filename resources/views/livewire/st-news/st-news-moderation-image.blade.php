<div class="inline-block">
    @if($deleted)
        <div class="text-green-500">удалено</div>
    @else
        <img src="{{$image->image_path}}" class="max-w-[10rem]"/>
        <button class="bg-red-300 rounded" wire:click="delete">Удалить</button>
    @endif
</div>
