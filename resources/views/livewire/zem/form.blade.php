<div>


    <div class="bg-gradient-to-br from-pink-500 to-purple-600 py-16 md:bg-gradient-to-r">
        <div class="container m-auto px-6 text-center md:px-12 lg:px-20">

            <h2 class="mb-8 text-4xl font-bold text-white md:text-4xl">
                Начать процесс приватизации
            </h2>

            {{--            <a--}}
            {{--                href="#"--}}
            {{--                class="relative flex h-12 w-full mx-auto items-center justify-center px-8 before:absolute before:inset-0 before:rounded-full before:bg-white before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 sm:w-max"--}}
            {{--            >--}}
            {{--      <span class="relative text-base font-semibold text-purple-600"--}}
            {{--      >Create an Account now</span--}}
            {{--      >--}}
            {{--            </a>--}}

            <input type="text" wire:model="phone" placeholder="Укажите Ваш телефон" class="font-semibold p-2 border-2 border-gray-300
            relative flex h-12 w-full mx-auto
            items-center justify-center px-8 before:absolute
            rounded-full
            before:inset-0 before:rounded-full
            before:bg-white before:transition before:duration-300
            hover:before:scale-105 active:duration-75 active:before:scale-95 sm:w-max
            "/>

        </div>
    </div>


    <div class="container">
        <div class="flex flex-row">

            <div class="basis-3/4">
                <label>
                    Ваш город <input type="text" wire:model="city" class="p-2 border-2 border-gray-300"/>
                </label>
                <br/>
                <label>
                    Телефон <input type="text" value="" wire:model="phone" class="p-2 border-2 border-gray-300"/>
                </label>
                <br/>
                <label>
                    Как Вас зовут <input type="text" value="" wire:model="name" class="p-2 border-2 border-gray-300"/>
                </label>
                <br/>
                <label>
                    Как называется кооператив <input type="text" value="" wire:model="cooperativ"
                                                     class="p-2 border-2 border-gray-300"/>
                </label>
                <br/>
                <label>
                    Номер гаража(ей) <input type="text" value="" wire:model="garage"
                                            class="p-2 border-2 border-gray-300"/>
                </label>
            </div>

            <div class="basis-1/4 xplace-content-center">
                123
            </div>

            {{--        <div class="basis-1/2">--}}
            {{--            222--}}
            {{--        </div>--}}

        </div>
        отправить заявку,<br/>
        позвоним спросим расскажем
    </div>

</div>
