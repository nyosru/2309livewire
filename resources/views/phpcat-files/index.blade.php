@extends('phpcat-files.layouts.app')

@section('content')

    @include('phpcat-files.index_index')

    <livewire:Phpcat.files />

    {{--коллекция кружек--}}
@if(1==1)
{{--    <br clear="all"/>--}}
    <br clear="all"/>
    <!-- Container for demo purpose -->
    <div class="container my-24 mx-auto md:px-6">
        <!-- Section: Design Block -->
        <section class="mb-32">
            <div
                class="block rounded-lg bg-white shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)]">

                <div class="flex flex-wrap items-center">

                    <div class="block
                    xw-full
                    w-4/12
                    mx-auto
                    shrink-0 grow-0 basis-auto lg:flex
                    xlg:w-6/12
                    lg:w-5/12
                    xxl:w-4/12
                    xl:w-3/12
                    ">
{{--                        <img src="https://mdbcdn.b-cdn.net/img/new/ecommerce/vertical/012.jpg" alt="Trendy Pants and Shoes"--}}
                        <img src="/phpcat/img/cap.jpg"
                             class="w-full rounded-t-lg lg:rounded-tr-none lg:rounded-bl-lg" />
                    </div>
                    <div class="w-full shrink-0 grow-0 basis-auto lg:w-6/12 xl:w-8/12">
                        <div class="px-6 py-12 md:px-12">
                            <h2 class="mb-6 pb-2 text-4xl font-bold">
                                Коллекция кружек!
                            </h2>
                            <p class="mb-6 pb-2 text-[1.5rem] text-brown-500">
                                            Собираю коллекцию кружек со всех стран и городов, пить горячий сладкий кофе с молоком.<br/>
                                            Добавте свою частичку в коллекцию, было бы здорово!<br/>
                                            <a href="https://кружки.сергейсб.рф" class="text-blue-500 hover:underline" target="_blank">кружки.СергейСБ.рф</a>

{{--                                Nunc tincidunt vulputate elit. Mauris varius purus malesuada--}}
{{--                                neque iaculis malesuada. Aenean gravida magna orci, non--}}
{{--                                efficitur est porta id. Donec magna diam.--}}
                            </p>
@if(1==2)
                            <div class="grid gap-x-6 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3">
                                <div class="mb-6">
                                    <p class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                             stroke="currentColor" class="mr-3 h-6 w-6 text-neutral-900">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>Support
                                        24/7
                                    </p>
                                </div>

                                <div class="mb-6">
                                    <p class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                             stroke="currentColor" class="mr-3 h-6 w-6 text-neutral-900">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>Analytics
                                    </p>
                                </div>

                                <div class="mb-6">
                                    <p class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                             stroke="currentColor" class="mr-3 h-6 w-6 text-neutral-900">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>Components
                                    </p>
                                </div>
                                <div class="mb-6">
                                    <p class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                             stroke="currentColor" class="mr-3 h-6 w-6 text-neutral-900">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>Updates
                                    </p>
                                </div>

                                <div class="mb-6">
                                    <p class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                             stroke="currentColor" class="mr-3 h-6 w-6 text-neutral-900">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>Reports
                                    </p>
                                </div>

                                <div class="mb-6">
                                    <p class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                             stroke="currentColor" class="mr-3 h-6 w-6 text-neutral-900">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>Mobile
                                    </p>
                                </div>
                                <div class="mb-6">
                                    <p class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                             stroke="currentColor" class="mr-3 h-6 w-6 text-neutral-900">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>Modules
                                    </p>
                                </div>

                                <div class="mb-6">
                                    <p class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                             stroke="currentColor" class="mr-3 h-6 w-6 text-neutral-900">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>Blocks
                                    </p>
                                </div>

                                <div class="mb-6">
                                    <p class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                             stroke="currentColor" class="mr-3 h-6 w-6 text-neutral-900">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>Templates
                                    </p>
                                </div>
                            </div>
    @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section: Design Block -->
    </div>
    <!-- Container for demo purpose -->
@endif



@endsection
