{{--<div class="text-center pb-3">--}}

<a href="/" class="p-3 m-0 block text-center"><h1 class="text-2xl md:text-4xl lg:text-6xl ">Самые<b>Тюменские</b>Новости<span style="color:gray">.рф</span></h1></a>

<br/>

@if(1==2)

<a href="{{ route('stn.vk-enter') }}" class="btn btn-primary">    Войти через ВКонтакте</a>
<br/>

{{ $uuser ?? 'x-uuser' }}
<br/>
--- {{ __('Profile') }} ----
@if (Route::has('login'))
    7777
    {{ $user ?? 'xx'}}
@endif

@if(isset($user))
    Привет, {{ $user->name }}!
@else
    Вам необходимо авторизоваться.
@endif
@endif
