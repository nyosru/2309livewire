<div>


    @foreach( $skidki_all ?? [] as $skidka)
        {{--        День варенья {{ $skidka->date }}--}}
        {{--                / {{ $skidka->date_start }}--}}
        {{--                / {{ $skidka->date_finish }}--}}

        {{--            </td>--}}
        <div>
            <h3 class="bg-yellow-300 p-2 text-3xl">{{ $skidka->phone }}</h3>
            <h4 class="text-2xl">{{ $list_type[$skidka->type]['mag'] ?? '' }} / {{ $list_type[$skidka->type]['profit'] ?? '' }}</h4>

            @if( $list_type[$skidka->type] )
                <b>{{ $list_type[$skidka->type]['profit'] ?? '' }}</b>
                {!! $list_type[$skidka->type]['opis'] !!}
            @else

            @endif
        </div>

        {{--<td class="whitespace-nowrap px-6 py-4">{{ $skidka->type }}</td>--}}
        {{--<td class="whitespace-nowrap px-6 py-4">{{ $skidka->phone }}</td>--}}
        {{--<td class="whitespace-nowrap px-6 py-4">{{ $skidka->author }}</td>--}}

    @endforeach

@if(1==2)
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table
                        class="min-w-full text-left
            xtext-sm
            text-xl
            font-light text-surface dark:text-white">
                        <thead
                            class="border-b border-neutral-200 font-medium dark:border-white/10">
                        <tr>
                            <th scope="col" class="px-6 py-4">ID</th>
                            <th scope="col" class="px-6 py-4">Дата</th>
                            <th scope="col" class="px-6 py-4">Тип</th>
                            <th scope="col" class="px-6 py-4">ТЕлефон</th>
                            <th scope="col" class="px-6 py-4">Автор</th>
                            @if(request()->has('ss'))
                                <th scope="col" class="px-6 py-4">Действия</th>
                            @endif
                        </tr>
                        </thead>

                        <tbody>

                        {{--        {{ print_r($skidki_all,true) }}--}}
                        @foreach( $skidki_all ?? [] as $skidka)
                            <tr class="border-b border-neutral-200 dark:border-white/10">
                                <td class="whitespace-nowrap px-6 py-4">{{ $skidka->id }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ $skidka->date }}
                                    / {{ $skidka->date_start }}
                                    / {{ $skidka->date_finish }}

                                </td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $skidka->type }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $skidka->phone }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $skidka->author }}</td>
                                @if(request()->has('ss'))
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <button
                                            class="text-yellow-100 bg-red-400 p-2 rounded"
                                            {{--                                        onclick="confirmDelete({{ $skidka->id }})">Удалить--}}
                                            wire:click="deleteSkidka({{ $skidka->id }})">Удалить
                                        </button>

                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{--        @endif--}}


        <script>
            function confirmDelete(id) {
                if (confirm('Вы уверены, что хотите удалить эту запись?')) {
                    Livewire.emit('deleteSkidka', id);
                }
            }
        </script>
@endif

    </div>
