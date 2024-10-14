<div class="text-[1.1rem]">

    @if(!$show_form)
        <a class="underline text-blue" wire:click.prevent="switchShowForm" href="#">Взять домен в аренду</a>
    @else
{{--        $sentSuccessfully: {{$sentSuccessfully ? 1 : 2}}--}}
        @if($sentSuccessfully)
            <div class="bg-white rounded-2xl max-w-[500px] md:w-6/12 mx-auto py-3  text-center         ">
                Отправлено, спасибо
            </div>
        @else
            <div class="bg-white rounded-2xl max-w-[500px] md:w-6/12 mx-auto py-3  text-center         ">
                <a class="float-right text-gray-300 pr-4" wire:click.prevent="switchShowForm" href="#">x</a>
                Можете взять в аренду<br/>доменное имя {{ $domain }}<br/> есть&nbsp;предложение ?
                <br/>
                <br/>
                <form wire:submit="submitForm">
                    <div class="w-full xmd:w-6/12 mx-auto">
                        Аренда
                        <input
                            type="text"
                            wire:model="inputPrice"
                            class="
                        w-2/6
                            text-right rounded
                            border border-solid border-black
                            bg-white bg-clip-padding px-3
                            py-[0.25rem]
                            leading-[1.6]
                            transition duration-200 ease-in-out "

                            aria-label=""
                            value=""
                            required
                        /> р/месяц
                        <div class="">
                            <div class="my-1 ">
                                Как вас зовут <input
                                    wire:model="inputName"
                                    required
                                    type="text" class="bg-white border border-solid border-black">
                            </div>
                            Ваш телефон <input
                                wire:model="inputPhone"
                                required
                                type="phone" class="bg-white border border-solid border-black">
                        </div>
                        <div class="text-center py-2 mt-2">
                            @if($loading)
                                <span>... отправляю ...</span>
                            @else
                                <button
                                    type="submit"
                                    class="rounded bg-gradient-to-br from-blue-300 to-blue-700 px-2 py-1 text-white font-bold">
                                    Отправить
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

        @endif
    @endif
</div>
