<div class="form-group">

    <label for="url">URL</label>
    <input type="text" id="url" name="url" value="{{ $url }}" wire:model="url"/>
    <button type="submit" wire:click="onSubmit">Показать</button>
    <div class="bg-yellow-500 p-1">{{ $iframeUrl ?? '' }}</div>

    <iframe src="{{ $iframeUrl ?? '' }}" style="border: 1px solid green; width: 80%; height: 400px;" frameborder="0"></iframe>

</div>
