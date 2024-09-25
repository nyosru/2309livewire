<div>
    @if(1==2)
    @livewire('st-news.fetch-fresh-news')
    @endif

    {{--    <livewire:st_news.backend/>--}}
    {{--    @include('st_news.index_index')--}}

    <div>
        <a href="https://vk.com/tymenskie" target="_blank">
            <!-- Section: Design Block -->
            <section class="xmb-32">
                <div class="block
{{--            bg-gradient-to-l from-yellow-200 to-blue-200--}}
            bg-gradient-to-l from-blue-200 to-blue-100
{{--            xrounded-lg xbg-white--}}
            shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)]
            dark:bg-neutral-700
            p-3
            text-center text-4xl
            "
                >
                    Присоединяйтесь заметно! и&nbsp;подпишитесь
                    <nobr>на <img src="/st_news/logo_tymenskie.png" class="pl-3 inline"
                                  style="height: 2rem;"/>
                    </nobr>
                </div>
            </section>
        </a>
    </div>


    <livewire:StNewsList/>

    <livewire:StNews.backword/>

    {{-- пожертвование--}}
    <livewire:StNews.money/>

</div>
