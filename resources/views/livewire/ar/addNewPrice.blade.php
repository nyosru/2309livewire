<div>
    <div class="max-w-[600px] mx-auto bg-white shadow-lg rounded pb-8 mb-4">

        <h2 class="w-full bg-[rgba(200,120,0,0.4)] p-2">Добавить участника</h2>

        <form class="px-8 pt-6 ">

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                           for="inline-full-name">
                        как зовут
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input
                        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                        id="inline-full-name" type="text" value="Jane Doe">
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                           for="inline-full-name">
                        телефон
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input
                        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                        id="inline-full-name" type="text" value="Jane Doe">
                </div>
            </div>


            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                           for="inline-full-name">
                        как зовут (запасной)
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input
                        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                        id="inline-full-name" type="text" value="Jane Doe">
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                           for="inline-full-name">
                        телефон (запасной)
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input
                        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                        id="inline-full-name" type="text" value="Jane Doe">
                </div>
            </div>


            <div class="md:flex md:items-center mb-6">
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">

                    <label
                        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 md:text-right"
                        for="grid-state">
                        Обьект
                    </label>
                </div>
                <div class="w-full md:w-2/3 px-3 mb-6 md:mb-0">

                    <div class="relative">
                        <select
                            class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-state">
                            <option>New Mexico</option>
                            <option>Missouri</option>
                            <option>Texas</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path
                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-2/3 pr-2">
                    первый платёж<br/>
                    <input
                        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                        id="inline-full-name" type="date" min="0" step="1" >
                </div>
                <div class="md:w-2/3">
                    сумма<br/>
                    <input
                        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                        id="inline-full-name" type="number" min="0" step="1" >
                </div>
            </div>




            <div class="xflex xitems-center xjustify-between text-center">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="button">
                    Добавить
                </button>
                {{--            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">--}}
                {{--                Forgot Password?--}}
                {{--            </a>--}}
            </div>

        </form>
    </div>


</div>
