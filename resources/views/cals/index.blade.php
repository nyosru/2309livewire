@extends('cals.layout')

@section('title', 'Дерево звонков')

@section('content')
    <div class="intro">
        <h1>История разговоров</h1>
        <p class="muted">Звонки собраны в ветки по номерам и контактам. В каждой ветке события идут от ранних к поздним.</p>
    </div>
    <div class="toolbar">
        <form method="get" action="{{ route('cals.index') }}">
            <input type="search" name="q" value="{{ $search }}" placeholder="Найти человека, номер или тему">
            <button type="submit">Найти</button>
        </form>
        @if($search)<a class="button" href="{{ route('cals.index') }}">Сбросить</a>@endif
    </div>
    <div class="panels">
        <section>
            <div class="section-heading" style="margin-bottom:14px"><h2>Ветки контактов</h2><span class="count">{{ $contacts->count() }} контактов</span></div>
            @forelse($contacts as $contact)
                <article class="branch" x-data="{ expanded: true }">
                    <div class="branch-head">
                        <div class="contact-heading">
                            <button type="button" class="contact-open" data-contact-id="{{ $contact->id }}" x-data x-on:click="$dispatch('open-contact-modal', { contactId: {{ (int) $contact->id }} })">
                                <strong data-display-name>{{ $contact->display_name }}</strong>
                                @if($contact->name && $contact->phone)<span class="phone" data-phone>{{ $contact->phone }}</span>@endif
                                <span class="contact-meta" data-contact-meta @if(!$contact->company_name && !$contact->start_date) hidden @endif>{{ $contact->company_name }}@if($contact->company_name && $contact->start_date) · @endif{{ $contact->start_date?->format('d.m.Y') }}</span>
                            </button>
                            <span class="contact-edit-hint">Нажмите, чтобы изменить абонента</span>
                        </div>
                        <div class="branch-controls">
                            <span class="count">{{ $contact->calls_count }} звонков</span>
                            @if($contact->calls->isNotEmpty())
                                <button type="button" class="branch-toggle" x-on:click="expanded = !expanded" x-bind:aria-expanded="expanded" x-text="expanded ? 'Свернуть звонки' : 'Показать звонки'"></button>
                            @endif
                        </div>
                    </div>
                    @if($contact->calls->isNotEmpty())
                        <div class="timeline" x-show="expanded">
                            @foreach($contact->calls as $call)
                                @include('cals.call-entry', ['call' => $call, 'unassigned' => false])
                            @endforeach
                        </div>
                    @else
                        <p class="muted" style="margin:12px 0 0">Звонков пока нет. Добавьте первый звонок или заметку в карточке контакта.</p>
                    @endif
                </article>
            @empty
                <div class="empty">{{ $search ? 'По этому запросу ничего не найдено.' : 'Пока нет контактов. Создайте контакт или добавьте звонок.' }}</div>
            @endforelse
            @if($unassignedCalls->isNotEmpty())
                <article class="branch">
                    <div class="branch-head"><div><strong>Без привязки к человеку</strong><span class="phone">Отметьте звонки и привяжите их к контакту</span></div><span class="count">{{ $unassignedCalls->count() }}</span></div>
                    <form method="post" action="{{ route('cals.calls.attach-many') }}">@csrf
                        <div class="field" style="margin:12px 0"><label for="attach_contact_id">Привязать выбранные звонки к контакту</label><select id="attach_contact_id" name="contact_id" required>@foreach($contacts as $contact)<option value="{{ $contact->id }}">{{ $contact->display_name }}{{ $contact->phone ? ' · '.$contact->phone : '' }}</option>@endforeach</select></div>
                        <button type="submit" style="padding:8px 12px;font-size:13px">Привязать отмеченные</button>
                        <div class="timeline">
                        @foreach($unassignedCalls as $call)
                            @include('cals.call-entry', ['call' => $call, 'unassigned' => true])
                        @endforeach
                        </div>
                        <button type="submit" style="padding:8px 12px;font-size:13px;margin-top:12px">Привязать отмеченные</button>
                    </form>
                </article>
            @endif
        </section>
        <aside class="side-sticky">
            <div class="panel">
                <h2>Новый звонок</h2>
                <form method="post" action="{{ route('cals.calls.store') }}">@csrf
                    <div class="field"><label for="call_at">Дата и время</label><input id="call_at" name="call_at" type="datetime-local" required value="{{ old('call_at', now()->format('Y-m-d\TH:i')) }}"></div>
                    <div class="field"><label for="contact_id">Контакт, если известен</label><select id="contact_id" name="contact_id"><option value="">Не выбран</option>@foreach($contacts as $contact)<option value="{{ $contact->id }}" @selected(old('contact_id') == $contact->id)>{{ $contact->display_name }}{{ $contact->phone ? ' · '.$contact->phone : '' }}</option>@endforeach</select></div>
                    <div class="field"><label for="phone">Номер телефона</label><input id="phone" name="phone" value="{{ old('phone') }}" placeholder="+7 …"></div>
                    <div class="field"><label for="summary">Краткое описание</label><textarea id="summary" name="summary" rows="3" placeholder="О чём говорили">{{ old('summary') }}</textarea></div>
                    <button type="submit">Добавить звонок</button>
                    <p class="form-note">Новый номер станет контактом без имени, его можно будет подписать позже.</p>
                </form>
            </div>
            <div class="panel">
                <h2>Новый контакт</h2>
                <form method="post" action="{{ route('cals.contacts.store') }}">@csrf
                    <div class="field"><label for="name">Имя или название</label><input id="name" name="name" value="{{ old('name') }}" placeholder="Можно заполнить позже"></div>
                    <div class="field"><label for="new_phone">Телефон</label><input id="new_phone" name="phone" value="{{ old('phone') }}" placeholder="+7 …"></div>
                    <div class="field"><label for="new_company_name">Компания</label><input id="new_company_name" name="company_name" value="{{ old('company_name') }}" placeholder="Название компании"></div>
                    <div class="field"><label for="new_start_date">Дата начала</label><input id="new_start_date" name="start_date" type="date" value="{{ old('start_date') }}"></div>
                    <div class="field"><label for="notes">Заметка</label><textarea id="notes" name="notes" rows="3" placeholder="Дополнительные сведения">{{ old('notes') }}</textarea></div>
                    <button type="submit">Создать контакт</button>
                </form>
            </div>
        </aside>
    </div>

    <livewire:cals.contact-modal />

    @push('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('contact-modal-opened', () => document.body.classList.add('modal-open'));
                Livewire.on('contact-modal-closed', () => document.body.classList.remove('modal-open'));
                Livewire.on('contact-updated', (contact) => {
                    const button = document.querySelector(`.contact-open[data-contact-id="${contact.id}"]`);
                    if (!button) return;

                    button.querySelector('[data-display-name]').textContent = contact.displayName || contact.phone || 'Контакт без имени';
                    const phone = button.querySelector('[data-phone]');
                    if (contact.name && contact.phone) {
                        const phoneLabel = phone || document.createElement('span');
                        phoneLabel.className = 'phone';
                        phoneLabel.dataset.phone = '';
                        phoneLabel.textContent = contact.phone;
                        if (!phone) button.querySelector('[data-display-name]').after(phoneLabel);
                    } else if (phone) {
                        phone.remove();
                    }

                    const meta = button.querySelector('[data-contact-meta]');
                    const metaText = [contact.companyName, contact.startDateLabel].filter(Boolean).join(' · ');
                    meta.textContent = metaText;
                    meta.hidden = !metaText;
                });
            });
        </script>
    @endpush
@endsection
