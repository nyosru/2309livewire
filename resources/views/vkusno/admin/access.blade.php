@extends('vkusno.admin.layout')
@section('title', 'Доступ к панели')
@section('content')
<h1>Доступ к панели</h1><p class="admin-muted">Только суперадминистратор может выдавать и отзывать доступ. Приглашённые администраторы управляют меню и видят заказы, но не могут добавлять других администраторов.</p>
<div class="admin-card"><h2>Суперадминистратор</h2><p><a href="https://vk.com/id{{ config('vkusno.super_admin_vk_id') }}" target="_blank" rel="noopener">VK ID {{ config('vkusno.super_admin_vk_id') }} ↗</a></p>@if(config('vkusno.super_admin_phone'))<p>Вход через MAX: {{ config('vkusno.super_admin_phone') }}</p>@endif<p class="admin-muted">Эти аккаунты имеют постоянный доступ после подтверждения входа.</p></div>
<form class="admin-card admin-form" method="post" action="/admin/access">@csrf<h2>Разрешить доступ</h2><div class="admin-grid"><label>VK ID<input name="vk_id" value="{{ old('vk_id') }}" required inputmode="numeric" pattern="[1-9][0-9]{0,19}" maxlength="20" placeholder="Например, 123456789"><small class="admin-muted">Числовой ID аккаунта, без «id» и ссылки.</small></label><label>Имя или подпись<input name="name" value="{{ old('name') }}" maxlength="100" placeholder="Например, Анна — менеджер"></label></div><button class="admin-button" type="submit">Выдать доступ</button></form>
<h2>Администраторы</h2>
@forelse($administrators as $administrator)
<article class="admin-card admin-access-row"><div><h3>{{ $administrator->name ?: 'Администратор' }}</h3><a href="https://vk.com/id{{ $administrator->vk_id }}" target="_blank" rel="noopener">VK ID {{ $administrator->vk_id }} ↗</a><p class="admin-muted">Доступ выдан {{ $administrator->created_at->format('d.m.Y H:i') }}</p></div><form method="post" action="/admin/access/{{ $administrator->id }}" onsubmit="return confirm('Отозвать доступ этого VK-аккаунта к панели?')">@csrf @method('DELETE')<button class="admin-button admin-button-danger" type="submit">Отозвать доступ</button></form></article>
@empty<p class="admin-card">Доступ пока есть только у суперадминистратора.</p>@endforelse
<form class="admin-card admin-form" method="post" action="/admin/access/phones">
    @csrf<h2>Разрешить вход через MAX</h2>
    <p class="admin-muted">Укажите телефон пользователя. Перед первым входом он должен запустить бота и нажать «Поделиться телефоном». MAX ID вводить не нужно, аккаунт VK не требуется.</p>
    <div class="admin-grid">
        <label>Телефон<input name="phone" type="tel" autocomplete="tel" value="{{ old('phone') }}" maxlength="32" placeholder="+7 (___) ___-__-__" required></label>
    </div>
    <label>Имя или подпись<input name="name" value="{{ old('name') }}" maxlength="100"></label>
    <button class="admin-button" type="submit">Разрешить вход через MAX</button>
</form>
<h2>Администраторы MAX</h2>
@forelse($phoneAdministrators as $administrator)
<article class="admin-card admin-access-row"><div><h3>{{ $administrator->name ?: 'Администратор MAX' }}</h3><p>{{ $administrator->phone }}</p><p class="admin-muted">Доступ выдан {{ $administrator->created_at->format('d.m.Y H:i') }}</p></div>
@if($administrator->phone === (string) config('vkusno.super_admin_phone'))<span class="admin-pill">Суперадминистратор</span>@else
<form method="post" action="/admin/access/phones/{{ $administrator->id }}" onsubmit="return confirm('Отозвать доступ этого телефона к панели?')">@csrf @method('DELETE')<button class="admin-button admin-button-danger" type="submit">Отозвать доступ</button></form>@endif
</article>
@empty<p class="admin-card">Телефоны для входа через MAX пока не добавлены.</p>@endforelse
@endsection
