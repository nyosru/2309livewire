<div>
    <form wire:submit="save">
        <div class="bg-gradient-to-br from-pink-500 to-purple-600 md:bg-gradient-to-r py-10 shadow-2xl">
            <div class="container m-auto px-6 text-center md:px-12 lg:px-20">

                <h2 class="mb-8 text-4xl font-bold text-white md:text-4xl">
                    Начнём процес приватизации?
                </h2>

                @if( !$show_form && 1 == 2)
                    <div>
                        <a
                            href="#"
                            wire:click.prevent="$set('show_form',true)"
                            class="relative flex h-12 w-full mx-auto items-center justify-center px-8 before:absolute before:inset-0 before:rounded-full before:bg-white before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 sm:w-max"
                        >
                            <span class="relative text-base font-semibold text-purple-600">
                                Отправить заявку!
                            </span>
                        </a>
                    </div>
                @else
                    <div>
                        <div class="bg-gradient-to-br from-white to-purple-200 rounded-2xl p-4 text-2xl">

                            @if( !$show_res_ok )

                                <p>Заполните форму, и мы позвоним, ответим на вопросы и начнём приватизацию.</p>
                                <br/>

                                <!-- Формируем форму -->
                                <div class="flex flex-col md:flex-row md:flex-wrap">
                                    <div class="w-full md:basis-1/2 md:px-2">
                                        @foreach( $polya as $pn => $p )
                                            <div class="flex flex-col md:flex-row md:items-center mb-4">
                                                <!-- Название поля -->
                                                <div class="md:w-1/3 text-left mb-1 md:mb-0">
                                                    {{ $p['name'] }}:
                                                </div>
                                                <!-- Поле ввода -->
                                                <div class="md:w-2/3">
                                                    <input
                                                        type="text"
                                                        @if( $pn == 'phone' ) wire:model="phone"
                                                        @elseif( $pn == 'name' ) wire:model="name"
                                                        @elseif( $pn == 'city' ) wire:model="city"
                                                        @elseif( $pn == 'kooperativ' ) wire:model="kooperativ"
                                                        @elseif( $pn == 'nomer' ) wire:model="nomer"
                                                        @elseif( $pn == 'promo_code' ) wire:model="promo_code"
                                                        @endif
                                                        @if( !empty($p['placeholder'] ) )
                                                            placeholder="{{ $p['placeholder'] }}"
                                                        @endif
                                                        @if( !empty($p['required']) ) required @endif
                                                        class="font-semibold border-2 border-gray-300 rounded-2xl pl-2 w-full md:w-auto"
                                                    />
                                                    @if( !empty($p['comment']) )
                                                        <div class="text-sm">{{ $p['comment'] }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="w-full md:basis-1/2 md:px-2 mt-4 md:mt-0">
                                        <div class="text-[1.1rem]">
                                            <input type="checkbox" wire:model="lich" required value="da"
                                                   class="font-semibold border-2 border-gray-300 inline-block rounded-2xl pl-2"/>
                                            Разрешаете обрабатывать персональные данные:
                                        </div>

                                        <button type="submit" class="bg-yellow-300 px-3 py-2 mt-4 shadow rounded">
                                            Отправить
                                        </button>
                                    </div>
                                </div>

                            @else
                                Хорошо, данные отправлены. В ближайшее время позвоним познакомиться. Подготавливайте документы для первого шага и отправляйте их на почту <a href="mailto:777@php-cat.com" class="text-blue-600 underline">777@php-cat.com</a> или в телеграм <a class="text-blue-600 underline" href="https://t.me/garag777">@garag777</a>.
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>
