<div>
    <!-- Section: Design Block -->
    <section class="xmb-32 section2">
        <div class="block bg-gradient-to-l from-blue-200 to-blue-400 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
            <div class="md:container mx-auto">
                <div class="flex flex-wrap items-center">

                    <div class="
                    xw-full
                    w-8/12
                    shrink-0 grow-0 basis-auto x-lg:w-6/12 x-xl:w-8/12">
                        <div class="px-6 py-12 md:px-12">
                            @if($sentSuccessfully)
                                <div class="text-center text-green-500 bg-gradient p-4 rounded-lg">
                                    <h2 class="text-4xl font-bold">Сообщение отправлено</h2>
                                    <button wire:click="resetForm" class="bg-blue-300 px-4 py-2 rounded text-blue-800 hover:bg-blue-400 mt-4">
                                        Отправить ещё
                                    </button>
                                </div>
                            @else
                                <h2 class="mb-6 pb-2 text-4xl font-bold">Отправьте сообщение</h2>
                                <form wire:submit.prevent="submit" class="mb-6 pb-2 text-[1.5rem] text-brown-500 dark:text-brouwn-300">
                                    <textarea
                                        wire:focus="showFields"
                                        wire:model="inputMsg"
                                        class="w-full p-1"
                                        rows="5"
                                        placeholder="Отправьте своё сообщение, новость, рекламу, информацию о событии, вашу оценку нашего творчества и всё то, что вы хотите написать"
                                        required></textarea>
                                    @error('inputMsg') <span class="error text-red-500">{{ $message }}</span> @enderror

                                    @if($showAdditionalFields)
                                        <div class="additional-fields show">
                                            <div class="text-[1.5rem] mb-1">
                                                <span class="inline-block w-[30%] text-right">Как Вас зовут*:</span>
                                                <input type="text" wire:model="inputName" required />
                                                @error('inputName') <span class="error text-red-500">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="text-[1.5rem] mb-1">
                                                <span class="inline-block w-[30%] text-right">Телефон:</span>
                                                <input type="text" wire:model="inputPhone" />
                                            </div>
                                            <div class="text-[1.5rem] mb-1">
                                                <span class="inline-block w-[30%] text-right">Телеграмм:</span>
                                                <input type="text" wire:model="inputTelega" />
                                            </div>
                                            <div class="text-[1.5rem] mb-1">
                                                <span class="inline-block w-[30%] text-right">Промокод:</span>
                                                <input type="text" wire:model="inputPromo" />
                                            </div>
                                            <div class="text-center mt-3">
                                                @if($loading)
                                                    <button type="button" class="bg-gray-300 px-4 py-2 rounded text-gray-800 cursor-not-allowed">
                                                        Загружаю...
                                                    </button>
                                                @else
                                                    <button type="submit" class="bg-blue-300 px-4 py-2 rounded text-blue-800 hover:bg-blue-400">
                                                        Отправить!
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    @if($showBlock)
                                        <div class="mt-4 p-4 bg-yellow-100 border border-yellow-300 text-yellow-700 rounded">
                                            Блок виден, так как параметр ss равен 1.
                                        </div>
                                    @endif
                                </form>
                            @endif
                        </div>
                    </div>

                    @if(!$showAdditionalFields && !$sentSuccessfully)
                    <div class="text-center" >
                        <!-- Gismeteo informer START -->
                        <link rel="stylesheet" type="text/css" href="https://ost1.gismeteo.ru/assets/flat-ui/legacy/css/informer.min.css">
                        <div id="gsInformerID-DY31LG6T2yEkiM" class="gsInformer" style="width:210px;height:223px">
                            <div class="gsIContent">
                                <div id="cityLink">
                                    <a href="https://www.gismeteo.ru/weather-tyumen-4501/" target="_blank" title="Погода в Тюмени">
                                        <img src="https://ost1.gismeteo.ru/assets/flat-ui/img/gisloader.svg" width="24" height="24" alt="Погода в Тюмени">
                                    </a>
                                </div>
                                <div class="gsLinks">
                                    <table>
                                        <tr>
                                            <td>
                                                <div class="leftCol">
                                                    <a href="https://www.gismeteo.ru/" target="_blank" title="Погода">
                                                        <img alt="Погода" src="https://ost1.gismeteo.ru/assets/flat-ui/img/logo-mini2.png" align="middle" border="0" width="11" height="16" />
                                                        <img src="https://ost1.gismeteo.ru/assets/flat-ui/img/informer/gismeteo.svg" border="0" align="middle" style="left: 5px; top:1px">
                                                    </a>
                                                </div>
                                                <div class="rightCol">
                                                    <a href="https://www.gismeteo.ru/weather-tyumen-4501/2-weeks/" target="_blank" title="Погода в Тюмени на 2 недели">
                                                        <img src="https://ost1.gismeteo.ru/assets/flat-ui/img/informer/forecast-2weeks.ru.svg" border="0" align="middle" style="top:auto" alt="Погода в Тюмени на 2 недели">
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <script async src="https://www.gismeteo.ru/api/informer/getinformer/?hash=DY31LG6T2yEkiM"></script>
                        <!-- Gismeteo informer END -->
                    </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- Вставляем стили внутри первого блока div -->
        <style>
            .additional-fields {
                overflow: hidden;
                max-height: 0;
                transition: max-height 0.5s ease-in-out, opacity 0.5s ease-in-out;
                opacity: 0;
            }

            .additional-fields.show {
                max-height: 500px; /* Задайте значение больше, чем максимальная высота содержимого */
                opacity: 1;
            }

            .additional-fields input,
            .additional-fields button {
                opacity: 0;
                transition: opacity 0.5s ease-in-out;
            }

            .additional-fields.show input,
            .additional-fields.show button {
                opacity: 1;
                transition-delay: 0.3s; /* Задержка для плавного появления после роста блока */
            }

            .bg-gradient {
                background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(173,216,230,1) 50%, rgba(255,255,255,0) 100%);
            }

            .section2{
                clip-path: polygon(0 0, 100% 0, 100% 100%, 0 90% );
                margin-bottom: -10%;
            }
        </style>
    </section>
</div>
