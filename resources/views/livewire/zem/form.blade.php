<div>

    <form wire:submit="save">
        <div class="bg-gradient-to-br from-pink-500 to-purple-600 py-16 md:bg-gradient-to-r">
            <div class="container m-auto px-6 text-center md:px-12 lg:px-20">

                <h2 class="mb-8 text-4xl font-bold text-white md:text-4xl">
                    Начнём процесс приватизации ?
                </h2>

                {{--            $this->show_form: {{ $show_form  }}--}}
                {{--            <br/>--}}

                @if( !$show_form )
                    <div
                        {{--                        wire:transition--}}
                    >
                        <a
                            href="#"
                            wire:click.prevent="$set('show_form',true)"
                            class="relative flex h-12 w-full mx-auto items-center justify-center px-8 before:absolute before:inset-0 before:rounded-full before:bg-white before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 sm:w-max"
                        >
                  <span class="relative text-base font-semibold text-purple-600"
                  >Начать!</span
                  >
                        </a>
                    </div>
                @else
                    <div
                        {{--                        wire:transition--}}
                    >
                        <div class="bg-gradient-to-br from-white to-purple-200 rounded-2xl p-4 text-2xl">

                            @if( !$show_res_ok )

                                <p>Заполните форму и позвоним, ответим на вопросы и начнём приватизацию.</p>
                                <br/>

                                @foreach( $polya as $pn => $p )
                                    <div class="flex flex-row mb-2">
                                        <div class="basis-1/3 text-right">
                                            {{ $p['name'] }}:
                                        </div>
                                        <div class="basis-2/3 pl-3 text-left">
                                            <input

                                                type="text"

                                                @if( $pn == 'phone' )
                                                    wire:model="phone"
                                                @elseif( $pn == 'name' )
                                                    wire:model="name"
                                                @elseif( $pn == 'city' )
                                                    wire:model="city"
                                                @elseif( $pn == 'kooperativ' )
                                                    wire:model="kooperativ"
                                                @elseif( $pn == 'nomer' )
                                                    wire:model="nomer"
                                                @elseif( $pn == 'promo_code' )
                                                    wire:model="promo_code"
                                                @endif

                                                @if( !empty($p['placeholder'] ) )
                                                    placeholder="Укажите Ваш телефон"
                                                @endif

                                                @if( $p['required'] )
                                                    required
                                                @endif

                                                class="
                                    font-semibold border-2 border-gray-300
                                    inline-block
                                    rounded-2xl
                                    pl-2
                                    sm:w-max
                                    "/>
                                            @if( !empty($p['comment']) )
                                                <div class="text-sm">{{ $p['comment'] }}</div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                                <div class="flex flex-row mb-2">
                                    <div class="basis-1/3 text-right">
                                        Разрешаете обрабатывать персональные данные:
                                    </div>
                                    <div class="basis-2/3 pl-3 text-left">
                                        <div style="zoom:350%;">
                                            <input type="checkbox" wire:model="lich"
                                                   required
                                                   value="da"
                                                   class="
                                    font-semibold border-2 border-gray-300
                                    inline-block
                                    rounded-2xl
                                    pl-2
                                    sm:w-max
                                        "/>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-row mb-2">
                                    <div class="basis-1/3 text-right">
                                        &nbsp;
                                    </div>
                                    <div class="basis-2/3 pl-3 text-left">
                                        <button type="submit" class="bg-yellow-300 px-3 py-2 rounded-2xl">Отправить
                                        </button>
                                    </div>
                                </div>

                            @else

                                Хорошо, данные отправлены, в ближайшее время позвоним познакомится,
                                подготавливайте документы для первого шага,
                                и отправляйте их на почту <a href="mailto:777@php-cat.com"
                                                             class="text-blue-600 underline">777@php-cat.com</a> или в
                                телеграм <a
                                    class="text-blue-600 underline" href="https://t.me/garag777">@garag777</a>

                            @endif


                        </div>
                    </div>
                @endif

            </div>
        </div>
    </form>
</div>
