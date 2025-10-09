<div id="service-dop-head" class="
{{--pb-10--}}
">

    <div class="block bg-blue-200">
        <div class="container mx-auto py-5">
            <h1 class="text-[2rem] font-bold">
                Инструменты для жизни
            </h1>
        </div>
    </div>

    <div class=" py-[5vh] bg-gradient-to-tl from-gray-100 to-red-100">
        <div class="container mx-auto xpy-5">
            <div class="flex flex-col space-y-2">


                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2
                items-center
                ">
                    <div class="p-4">
                        <a href="https://lk.finuslugi.ru/registration" class="text-blue-800 underline" target="_blank">
                            <img src="/logo/finuslugi_logo.svg"/>
                        </a>
                    </div>
                    <div class="mx-5 sm:mx-0  text-lg">
                        <b>Финуслуги от Московской биржи</b>
                        <br/>
                        Сервис подбора и анализа финансовых предложений от банков и других организаций.
                        <br/><br/>
                        Откройте первый вклад на Финуслугах с промокодом
                        <b  onclick="copyPromoCode()" class="cursor-pointer">
                            <u id="promo-code">RF2KXV9FX</u>
                            <sup>
                                <button

                                    class="px-1 py-0.5
{{--                                bg-white shadows--}}
                                rounded
{{--                                hover:bg-gray-400--}}
                                "
                                    title="Скопировать промо код"
                                >
                                    <img src="/icon/copy.svg" width="16" height="16">
                                </button>
                            </sup>
                        </b>
                        и&nbsp;получите бонус: <b>до&nbsp;+&nbsp;2`000 ₽</b>.
                        <br/>
                        Войти&nbsp;на&nbsp;Финуслуги:
                        <a href="https://lk.finuslugi.ru/registration" class="bg-yellow-300
                        hover:bg-gradient-to-tr hover:from-yellow-300 hover:to-yellow-400
                        font-bold
                        whitespace-nowrap p-3 rounded text-blue-800 underline inline-block"
                           target="_blank" >https://lk.finuslugi.ru/registration</a>
                        <br/><br/>
                        Попробуйте вклад&nbsp;под&nbsp;30%&nbsp;годовых, при&nbsp;заморозке 50тр&nbsp;на&nbsp;месяц, примерно&nbsp;1,250р&nbsp;процентами
                        выдадут!
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class=" py-[5vh] bg-gradient-to-tl from-gray-200 to-blue-100">
        <div class="container mx-auto xpy-5">
{{--            <div class="flex flex-col space-y-2">--}}


{{--                <div class="flex flex-row space-x-2">--}}
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2
                    items-center
                    ">
                    <div class="p-4">
                        <a href="https://lk.finuslugi.ru/registration" class="text-blue-800 underline" target="_blank">
                            <img src="/logo/vtb.svg" class="w-auto min-h-[110px]"/>
                        </a>
                    </div>
                    <div class="mx-5 sm:mx-0 text-lg">
                        <b>Банк ВТБ</b>
                        <br/>
                        Регистрируете первую карту (привезут) тратите 5тр в первый месяц и получаете бонус деньгами <b>+&nbsp;1`000&nbsp;₽</b>.
                        <br/>

                            <a
                                href="https://vtb.ru/l/8px4mk50"
                                class="bg-yellow-300
                        hover:bg-gradient-to-tr hover:from-yellow-300 hover:to-yellow-400
                        font-bold
                        whitespace-nowrap p-3 rounded text-blue-800 underline inline-block"
                               target="_blank" >
                            VTB.ru регистрация карты
                        </a>
                    </div>
{{--                </div>--}}


            </div>
            {{--        <div id="copy-message" class="text-green-700 font-semibold mt-2" style="display:none;">--}}
            {{--            Промо код скопирован--}}
            {{--        </div>--}}
        </div>
    </div>
</div>

<script>
    function copyPromoCode() {
        const promoCodeElement = document.getElementById('promo-code');
        const promoCode = promoCodeElement.textContent;

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(promoCode).then(() => {
                alert('Промо код скопирован');
            }).catch(() => {
                alert('Ошибка при копировании промо кода');
            });
        } else {
            const textarea = document.createElement('textarea');
            textarea.value = promoCode;
            document.body.appendChild(textarea);
            textarea.select();
            try {
                document.execCommand('copy');
                alert('\n\nПромо код скопирован,\n\n переходите в фин услуги и проходите регистрацию');
            } catch (err) {
                alert('Ошибка при копировании промо кода');
            }
            document.body.removeChild(textarea);
        }
    }
</script>
