@extends('domainwaiter.layouts.app')

@section('content')
    654654
@endsection

@if(1==2)

{{--    @include('phpcat.index_index')--}}

7777


    {{--    <div class="bg-yellow-300 text-center p-2">--}}
{{--    <div>--}}
{{--        <p class="block">--}}
{{--            <img src="/phpcat/img/cap.jpg" class="float-left pr-3" style="max-height: 6rem;"/>--}}
{{--            Собираю коллекцию кружек со всех стран и городов, пить горячий сладкий кофе с молоком.<br/>--}}
{{--            Добавте свою частичку в коллекцию, было бы здорово!--}}
{{--            <a href="https://кружки.сергейсб.рф" class="text-blue-500 hover:underline" target="_blank">кружки.СергейСБ.рф</a>--}}
{{--            <br clear="all"/>--}}
{{--        </p>--}}
{{--    </div>--}}
    {{--    </div>--}}

@if(1==2)
    <!-- Container for demo purpose -->
    <div class="container my-24 mx-auto md:px-6">
        <!-- Section: Design Block -->
        <section class="mb-32 text-center lg:text-left">
            <div class="flex flex-wrap justify-center">
                <div class="w-full shrink-0 grow-0 basis-auto px-3 md:w-10/12 lg:w-11/12 xl:w-10/12">
{{--                    <div class="grid items-center gap-x-6 lg:grid-cols-2">--}}
                    <div class="grid items-right gap-x-6 lg:grid-cols-2">
                        <div class="mb-10 lg:mb-0">
                            <img src="/phpcat/img/cap.jpg" class="xfloat-left pr-3" style="max-height: 6rem;"/>
{{--                            <h2 class="text-3xl font-bold">--}}
{{--                                Do not miss any updates.--}}
{{--                                <br />--}}
{{--                                <span class="text-primary">Subscribe to the newsletter</span>--}}
{{--                            </h2>--}}
                        </div>

                        <div class="mb-6 flex-row md:mb-0 md:flex">
{{--                            <div class="relative mb-3 w-full md:mr-3 md:mb-0 xl:w-96" data-te-input-wrapper-init>--}}
{{--                                <input type="text"--}}
{{--                                       class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"--}}
{{--                                       id="exampleFormControlInput2" placeholder="Enter your email" />--}}
{{--                                <label for="exampleFormControlInput2"--}}
{{--                                       class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[2.15] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[1.15rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[1.15rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none">Enter--}}
{{--                                    your email--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                            <button type="submit"--}}
{{--                                    class="inline-block rounded bg-primary px-7 pt-3 pb-2.5 text-sm font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]"--}}
{{--                                    data-te-ripple-init data-te-ripple-color="light">--}}
{{--                                Subscribe--}}
{{--                            </button>--}}
                            Собираю коллекцию кружек со всех стран и городов, пить горячий сладкий кофе с молоком.<br/>
                            Добавте свою частичку в коллекцию, было бы здорово!
                            <a href="https://кружки.сергейсб.рф" class="text-blue-500 hover:underline" target="_blank">кружки.СергейСБ.рф</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section: Design Block -->
    </div>
    <!-- Container for demo purpose -->
@endif


    <livewire:Phpcat.services/>


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





    @if ( 1 == 2)
        @if (Route::currentRouteName() == 'phpcat.news')
            <livewire:Phpcat.news/>
        @elseif(Route::currentRouteName() == 'phpcat.torrent')
            2
        @elseif(Route::currentRouteName() == 'phpcat.money')
            3
        @elseif(Route::currentRouteName() == 'phpcat.services')
            <livewire:Phpcat.services/>
            {{-- @elseif( Route::currentRouteName() == 'phpcat.index' ) --}}
        @else
            @include('phpcat.index_index')
        @endif
    @endif

    {{--
    <livewire:showRoom :imgs="[1, 2, 55]" />
    <hr/>
    2
    <hr/>
    <livewire:Phpcat.money :imgs="[1, 2, 55]" />
    <hr/>
    3
    <hr/>
    <livewire:PhpcatMoney :imgs="[1, 2, 55]" /> --}}


@if (1 == 2)
    <div>
        show room

        @foreach ($imgs as $im)
            @if ($im == $n)
                <button class="border-blue-700" wire:click="setset({{ $im }})">{{ $im }}</button>
            @else
                <button class="border-green-700" wire:click="setset({{ $im }})">{{ $im }}</button>
            @endif
            {{-- -  --}}
            {{-- <button class="bg-gray-300 border-green-700" wire:append="setset({{$im}})" >00{{ $im }}</button> --}}
        @endforeach

        @if ($n == 1)
            111
        @endif

        <br/>

        nn: {{ $n }}

    </div>
@endif
@endif
