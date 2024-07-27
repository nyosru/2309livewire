<div>
    <form wire:submit.prevent="addSkidka">
        <div>
            <label for="date">Дата</label>
            <input type="date" id="date" wire:model="dater">
            @error('dater') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="type">Тип</label>
            <input type="text" id="type" wire:model="type">
            @error('type') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="author">Автор</label>
            <input type="text" id="author" wire:model="author">
            @error('author') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Добавить</button>
    </form>

{{--    @if( !empty($skidkis) )--}}
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Дата</th>
            <th>Тип</th>
            <th>Автор</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>

{{ print_r($skidki_all,true) }}
        @foreach( $skidki_all ?? [] as $skidka)
            <tr>
                <td>{{ $skidka->id }}</td>
                <td>{{ $skidka->date }}</td>
                <td>{{ $skidka->type }}</td>
                <td>{{ $skidka->author }}</td>
                <td>
                    <button onclick="confirmDelete({{ $skidka->id }})">Удалить</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
{{--        @endif--}}
</div>

<script>
    function confirmDelete(id) {
        if (confirm('Вы уверены, что хотите удалить эту запись?')) {
            Livewire.emit('deleteSkidka', id);
        }
    }
</script>
