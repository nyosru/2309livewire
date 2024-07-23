<div>
    <!-- Section: Design Block -->
    <section class="xmb-32">
        <div class="block
{{--            bg-gradient-to-l from-yellow-200 to-blue-200--}}
            bg-gradient-to-l from-blue-200 to-blue-400
{{--            xrounded-lg xbg-white--}}
            shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)]
            dark:bg-neutral-700"
        >
            <div class="md:container mx-auto">
                <div class="flex flex-wrap items-center">

                    <div class="w-full shrink-0 grow-0 basis-auto x-lg:w-6/12 x-xl:w-8/12">
                        <div class="px-6 py-12 md:px-12">
                            <h2 class="mb-6 pb-2 text-4xl font-bold">
                                Отправьте сообщение
                            </h2>
                            <p class="mb-6 pb-2 text-[1.5rem] text-brown-500 dark:text-brouwn-300">

                                {{--                                <style>--}}
                                {{--                                    .additional-fields {--}}
                                {{--                                        opacity: 0;--}}
                                {{--                                        transition: opacity 0.5s ease-in-out;--}}
                                {{--                                    }--}}

                                {{--                                    .additional-fields[style*="display: block;"] {--}}
                                {{--                                        opacity: 1;--}}
                                {{--                                    }--}}
                                {{--                                </style>--}}

                                <textarea
                                    required="required"
                                    wire:focus="showFields"
                                    wire:model="inputMsg"
                                    class="w-full p-1"
                                    rows="5"
                                    placeholder="Отправте своё сообщение, новость, рекламу, информацию о событии, вашу оценку нашего творчества и всё то что вы хотите написать"></textarea>
                            {{--                                Отправить пожертвования на поддержание хорошего настроения и&nbsp;развитие проектов!--}}
                            {{--                            @if ($showAdditionalFields)--}}
{{--<br/>--}}
{{--                                $showAdditionalFields: {{ $showAdditionalFields ? 1 : 2  }}--}}
                            @if( $showAdditionalFields )

                                <div class="additional-fields" wire:transition>

                                    <div class="text-[1.5rem] mb-1">
                                        <span class="inline-block w-[30%] text-right">Как Вас зовут*:    </span>
                                        <input type="text" wire:model="inputName" required="required" />
                                    </div>
                                    <div class="text-[1.5rem] mb-1">
                                        <span class="inline-block w-[30%] text-right">Телефон:</span>
                                        <input type="text" wire:model="inputPhone"/>
                                    </div>
                                    <div class="text-[1.5rem] mb-1">
                                        <span class="inline-block w-[30%] text-right">Телеграмм*:</span>
                                        <input type="text" wire:model="inputTelega" required="required" />
                                    </div>
                                    <div class="text-[1.5rem] mb-1">
                                        <span class="inline-block w-[30%] text-right">Промокод:</span>
                                        <input type="text" wire:model="inputPromo"/>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button
                                            {{--                                        <a href="https://www.tinkoff.ru/rm/baklanov.sergey34/i4J5b154"--}}
                                            wire:click="submit"
                                            class="bg-blue-300 px-4 py-2   x-float-right   rounded   text-blue-800 hover:bg-blue-400"
                                            target="_blank">
                                            Отправить!
                                        </button>
                                    </div>

                                    @endif
                                </div>
                        </div>
                    </div>

                    {{--                    <div class="block--}}
                    {{--                    w-[95vw]--}}
                    {{--                    sm:w-4/12--}}

                    {{--                    mx-auto--}}

                    {{--                    shrink-0 grow-0 basis-auto--}}

                    {{--                    lg:flex--}}
                    {{--                    lg:w-5/12--}}

                    {{--                    xl:w-3/12--}}
                    {{--                    xxl:w-4/12--}}

                    {{--                    ">--}}
                    {{--                        <img src="/phpcat/sun.png" class="w-full"/>--}}
                    {{--                    </div>--}}

                </div>
            </div>
        </div>
    </section>

</div>
