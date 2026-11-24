@extends('calls.layout')
@section('title', 'Дерево проектов · Звонки и диктофон')
@section('content')
    <header>
        <h1>Дерево проектов</h1>
        <p class="sub">Звонки и записи диктофона, связанные с вашими проектами</p>
        <div class="stats">
            <span class="pill">Всего записей: {{ $total }}</span>
            <span class="pill">В ветках: {{ $assignedCount }}</span>
            <span class="pill">Без ветки: {{ $total - $assignedCount }}</span>
            <span class="pill">Веток: {{ $branches->count() }}</span>
        </div>
    </header>
    @if(session('status'))<div class="notice" role="status">{{ session('status') }}</div>@endif
    @if($errors->any())
        <div class="alert" role="alert">@foreach($errors->all() as $message)<div>{{ $message }}</div>@endforeach</div>
    @endif
    @foreach($errorsList as $message)<div class="alert">{{ $message }}</div>@endforeach
    <div class="workspace">
        <section class="tree-panel" aria-label="Дерево веток">
            <div class="section-heading"><h2>Ветки проектов</h2><span class="muted">От базы вверх</span></div>
            <p class="muted">Базовая ветка внизу, новые ответвления растут вверх. Записи внутри ветки: новые сверху, старые снизу.</p>
            <ul class="tree">
                @foreach($children['root'] ?? [] as $branch)
                    @include('calls.branch')
                @endforeach
            </ul>
        </section>
        <div class="record-list-panel">
        <nav class="record-lists" aria-label="Списки записей">
            <a class="btn {{ $listMode === 'ordinary' ? 'picker-selected' : '' }}" href="{{ route('calls.index', ['list' => 'ordinary']) }}">Обычные</a>
            <a class="btn {{ $listMode === 'hidden' ? 'picker-selected' : '' }}" href="{{ route('calls.index', ['list' => 'hidden']) }}">Скрытые</a>
            <a class="btn {{ $listMode === 'spam' ? 'picker-selected' : '' }}" href="{{ route('calls.index', ['list' => 'spam']) }}">Спам</a>
        </nav>
        @if($listMode === 'ordinary')
        <section id="inbox" aria-label="Записи без ветки">
            <div class="section-heading"><h2>Без ветки</h2><span class="muted">{{ $items->total() }} записей</span></div>
            <form class="panel filters" method="GET" action="{{ route('calls.index') }}#inbox">
                <label>Поиск<input name="q" value="{{ $search }}" maxlength="150" placeholder="Имя, телефон или дата"></label>
                <label>Источник<select name="source"><option value="">Все записи</option><option value="call" @selected($source === 'call')>Звонки</option><option value="recorder" @selected($source === 'recorder')>Диктофон</option></select></label>
                <button class="btn" type="submit">Найти</button>
                @if($search || $source)<a class="btn" href="{{ route('calls.index') }}#inbox">Сбросить</a>@endif
            </form>
            @include('calls.pagination')
            <div class="list">
                @forelse($items as $item)
                    <x-calls.recording :item="$item" :branches="$branches" :recent-branches="$recentBranches" :recent-tags="$recentTags" :all-tags="$allTags" :list-mode="$listMode" />
                @empty
                    <div class="empty">{{ $search || $source ? 'По вашему запросу записей нет.' : 'Непривязанных записей нет. Все записи уже в ветках или папки пока пусты.' }}</div>
                @endforelse
            </div>
            @include('calls.pagination')
        </section>
        @else
        <section id="inbox" aria-label="{{ $listMode === 'hidden' ? 'Скрытые записи' : 'Спам' }}">
            <div class="section-heading"><h2>{{ $listMode === 'hidden' ? 'Скрытые записи' : 'Спам' }}</h2><span class="muted">{{ $items->total() }} записей</span></div>
            <form class="panel filters" method="GET" action="{{ route('calls.index') }}">
                <input type="hidden" name="list" value="{{ $listMode }}">
                <label>Поиск<input name="q" value="{{ $search }}" maxlength="150" placeholder="Имя, телефон или дата"></label>
                <label>Источник<select name="source"><option value="">Все записи</option><option value="call" @selected($source === 'call')>Звонки</option><option value="recorder" @selected($source === 'recorder')>Диктофон</option></select></label>
                <button class="btn" type="submit">Найти</button>
            </form>
            @include('calls.pagination')
            <div class="list">
                @forelse($items as $item)
                    <x-calls.recording :item="$item" :branches="$branches" :recent-branches="$recentBranches" :recent-tags="$recentTags" :all-tags="$allTags" :list-mode="$listMode" />
                @empty
                    <div class="empty">{{ $listMode === 'hidden' ? 'Скрытых записей нет.' : 'Записей в спаме нет.' }}</div>
                @endforelse
            </div>
            @include('calls.pagination')
        </section>
        @endif
        </div>
    </div>
    <dialog id="contact-dialog" class="contact-dialog">
        <form method="POST" action="{{ route('calls.contacts.store') }}" class="contact-form">
            @csrf
            <div class="section-heading"><h2>Новый контакт</h2><button type="button" class="btn" data-close-contact aria-label="Закрыть">×</button></div>
            <label>Телефон<input id="contact-phone" name="phone" readonly required></label>
            <label>ФИО<input name="name" maxlength="255" required autocomplete="name"></label>
            <div class="comment-fields">
                <label>Комментарий<input name="comments[]" maxlength="10000" placeholder="Комментарий (необязательно)"></label>
            </div>
            <button type="button" class="btn" id="add-contact-comment">+ комментарий</button>
            <div class="dialog-actions"><button class="btn btn-primary" type="submit">Сохранить контакт</button><button class="btn" type="button" data-close-contact>Отмена</button></div>
        </form>
    </dialog>
    <dialog id="transcript-dialog" class="contact-dialog transcript-dialog">
        <div class="contact-form">
            <div class="section-heading"><h2>Транскрипция звонка</h2><button type="button" class="btn" data-close-transcript aria-label="Закрыть">×</button></div>
            <div id="transcript-dialog-content" class="scroll-block"></div>
            <div class="dialog-actions"><button type="button" class="btn" data-close-transcript>Закрыть</button></div>
        </div>
    </dialog>
    @include('calls.tags')
@endsection

@push('head')
    <style>
        .contact-owner { color:#207458; font-weight:700; }
        .contact-add { color:#1e40af; }
        .contact-dialog { width:min(520px, calc(100% - 24px)); border:1px solid var(--line); border-radius:16px; padding:22px; color:var(--ink); box-shadow:0 24px 80px #0f172a44; }
        .contact-dialog::backdrop { background:#11182788; }
        .contact-form { display:grid; gap:14px; }
        .contact-form .section-heading { margin:0; }
        .comment-fields { display:grid; gap:10px; }
        .dialog-actions { display:flex; justify-content:flex-end; gap:8px; margin-top:8px; }
        .pagination { display:flex; justify-content:center; align-items:center; gap:6px; margin:12px 0; flex-wrap:wrap; }
        .pagination-current { background:var(--accent); border-color:var(--accent); color:#fff; }
        .pagination-disabled { opacity:.45; pointer-events:none; }
        .pagination-gap { padding:0 3px; color:var(--muted); }
        .transcript-dialog { width:min(760px, calc(100% - 24px)); }
        .transcript-dialog .scroll-block { max-height:min(70vh, 700px); white-space:pre-wrap; }
        .transcript-preview { margin:12px 0 0; line-height:1.5; }
        .transcript-preview a { font-weight:600; white-space:nowrap; }
        .quick-picker { display:grid; gap:7px; margin-top:14px; font-size:14px; }
        .quick-buttons { display:flex; flex-wrap:wrap; gap:7px; }
        .quick-buttons form { margin:0; }
        .quick-buttons form { display:inline-flex; align-items:center; gap:3px; }
        .quick-unlink { border:0; padding:0 4px; background:transparent; color:#1e40af; font-size:18px; font-weight:700; line-height:1; font-family:inherit; cursor:pointer; }
        .quick-unlink:hover { color:var(--danger); }
        .picker-selected { border-color:var(--accent); background:var(--accent-soft); color:#1e40af; }
        .assignment-other { margin-top:10px; }
        .assignment-other label { max-width:380px; }
        .assignment-other select { width:100%; }
        .record-summary-content { display:grid; gap:5px; min-width:0; }
        .record-summary-meta { padding:0 12px 10px 36px; font-weight:400; }
        .record-branch-summary { color:var(--muted); font-size:14px; }
        .summary-tag { display:inline-flex; align-items:center; gap:5px; padding:2px 7px 2px 9px; border-radius:999px; background:var(--accent-soft); color:#1e40af; font-size:14px; font-weight:600; }
        .summary-tag form { margin:0; }
        .summary-tag-remove { border:0; padding:0 1px; background:transparent; color:#1e40af; font:inherit; cursor:pointer; line-height:1; }
        .summary-tag-remove:hover { color:var(--danger); }
        .record-no-tags { color:var(--muted); font-size:14px; }
        .record-lists { display:flex; gap:8px; margin:0 0 18px; }
        .record-list-panel { min-width:0; }
        .record-status-actions { padding:0 12px 10px 36px; }
        .record-status-actions form { display:inline-flex; gap:3px; margin:0; }
        .status-active { background:#bfdbfe; border-color:#60a5fa; color:#1e40af; font-weight:700; }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dialog = document.getElementById('contact-dialog');
            document.querySelectorAll('[data-contact-phone]').forEach(button => button.addEventListener('click', () => {
                document.getElementById('contact-phone').value = button.dataset.contactPhone;
                dialog.showModal();
                dialog.querySelector('[name="name"]').focus();
            }));
            dialog.querySelectorAll('[data-close-contact]').forEach(button => button.addEventListener('click', () => dialog.close()));
            document.getElementById('add-contact-comment').addEventListener('click', () => {
                const label = document.createElement('label');
                label.textContent = 'Комментарий';
                const input = document.createElement('input');
                input.name = 'comments[]';
                input.maxLength = 10000;
                input.placeholder = 'Комментарий (необязательно)';
                label.append(input);
                document.querySelector('.comment-fields').append(label);
                input.focus();
            });
            const transcriptDialog = document.getElementById('transcript-dialog');
            document.querySelectorAll('[data-transcript-url]').forEach(link => link.addEventListener('click', async event => {
                event.preventDefault();
                const output = document.getElementById('transcript-dialog-content');
                transcriptDialog.showModal();
                output.textContent = 'Загрузка транскрипции…';
                try {
                    const response = await fetch(link.dataset.transcriptUrl);
                    if (!response.ok) throw new Error('load');
                    output.textContent = await response.text();
                } catch (_) {
                    output.textContent = 'Не удалось загрузить транскрипцию.';
                }
            }));
            transcriptDialog.querySelectorAll('[data-close-transcript]').forEach(button => button.addEventListener('click', () => transcriptDialog.close()));

            const requestForm = form => fetch(form.action, {
                method: 'POST', body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            }).then(response => { if (!response.ok) throw new Error('save'); return response; });
            const addUnlinkButton = (form, label = 'Отвязать') => {
                if (form.querySelector('.quick-unlink')) return;
                const button = document.createElement('button');
                button.type = 'button'; button.className = 'quick-unlink'; button.textContent = '×';
                button.title = label; button.setAttribute('aria-label', label);
                form.append(button);
            };
            const markBranch = (form, selected) => {
                const record = form.closest('.record-entry');
                record.querySelectorAll('[data-quick-branch]').forEach(option => {
                    const active = selected && option === form;
                    option.querySelector('button[type="submit"]').classList.toggle('picker-selected', active);
                    option.querySelector('.quick-unlink')?.remove();
                    if (active) addUnlinkButton(option, 'Отвязать от ветки');
                });
                const meta = record.querySelector('[data-record-branch-meta]');
                if (selected) {
                    meta.classList.add('summary-tag', 'record-branch-summary');
                    meta.textContent = form.querySelector('button[type="submit"]').textContent.trim();
                    meta.dataset.recordBranchMeta = '';
                    const removeForm = document.createElement('form');
                    removeForm.method = 'POST'; removeForm.action = form.action; removeForm.dataset.asyncBranchDetach = '';
                    ['_token', '_method'].forEach(name => {
                        const input = document.createElement('input'); input.type = 'hidden'; input.name = name;
                        input.value = form.querySelector(`[name="${name}"]`).value; removeForm.append(input);
                    });
                    const branchId = document.createElement('input'); branchId.type = 'hidden'; branchId.name = 'branch_id'; branchId.value = ''; removeForm.append(branchId);
                    const remove = document.createElement('button'); remove.type = 'submit'; remove.className = 'summary-tag-remove'; remove.textContent = '×'; remove.setAttribute('aria-label', 'Отвязать ветку'); removeForm.append(remove);
                    meta.append(removeForm); removeForm.addEventListener('submit', detachBranch);
                } else {
                    meta.className = 'record-no-tags'; meta.textContent = 'Без ветки';
                }
            };
            const detachBranch = async event => {
                event.preventDefault(); const form = event.currentTarget;
                try { await requestForm(form); markBranch(form, false); }
                catch (_) { alert('Не удалось изменить ветку. Обновите страницу и попробуйте ещё раз.'); }
            };
            document.querySelectorAll('[data-async-branch-detach]').forEach(form => form.addEventListener('submit', detachBranch));
            document.querySelectorAll('[data-quick-branch]').forEach(form => {
                if (form.querySelector('button[type="submit"]').classList.contains('picker-selected')) addUnlinkButton(form, 'Отвязать от ветки');
                form.addEventListener('submit', async event => {
                    event.preventDefault();
                    try { await requestForm(form); markBranch(form, true); }
                    catch (_) { alert('Не удалось изменить ветку. Обновите страницу и попробуйте ещё раз.'); }
                });
                form.addEventListener('click', event => {
                    if (!event.target.closest('.quick-unlink')) return;
                    event.preventDefault(); event.stopPropagation();
                    form.querySelector('[name="branch_id"]').value = '';
                    form.requestSubmit();
                });
            });
            const markTag = (form, selected) => {
                const record = form.closest('.record-entry'); const tagId = form.dataset.tagId;
                const button = form.querySelector('button[type="submit"]');
                button.classList.toggle('picker-selected', selected);
                form.querySelector('.quick-unlink')?.remove();
                const meta = record.querySelector('.record-summary-meta');
                meta.querySelector(`[data-record-tag-id="${tagId}"]`)?.remove();
                if (selected) {
                    addUnlinkButton(form, 'Убрать тег');
                    const chip = document.createElement('span'); chip.className = 'summary-tag'; chip.dataset.recordTagId = tagId;
                    chip.append(document.createTextNode(form.dataset.tagName));
                    const removeForm = document.createElement('form'); removeForm.method = 'POST'; removeForm.action = form.dataset.detachUrl; removeForm.dataset.asyncTagDetach = ''; removeForm.dataset.tagId = tagId;
                    const token = document.createElement('input'); token.type = 'hidden'; token.name = '_token'; token.value = form.querySelector('[name="_token"]').value; removeForm.append(token);
                    const method = document.createElement('input'); method.type = 'hidden'; method.name = '_method'; method.value = 'DELETE'; removeForm.append(method);
                    const remove = document.createElement('button'); remove.type = 'submit'; remove.className = 'summary-tag-remove'; remove.textContent = '×'; remove.setAttribute('aria-label', 'Убрать тег'); removeForm.append(remove);
                    chip.append(removeForm); meta.append(chip); removeForm.addEventListener('submit', detachTag);
                    meta.querySelector('.record-no-tags')?.remove();
                } else if (!meta.querySelector('[data-record-tag-id]')) {
                    const empty = document.createElement('span'); empty.className = 'record-no-tags'; empty.textContent = 'Без тегов'; meta.append(empty);
                }
            };
            const detachTag = async event => {
                event.preventDefault(); const form = event.currentTarget;
                try {
                    await requestForm(form);
                    const record = form.closest('.record-entry');
                    const quick = record.querySelector(`[data-quick-tag][data-tag-id="${form.dataset.tagId}"]`);
                    if (quick) markTag(quick, false);
                    else {
                        record.querySelector(`[data-record-tag-id="${form.dataset.tagId}"]`)?.remove();
                        const meta = record.querySelector('.record-summary-meta');
                        if (!meta.querySelector('[data-record-tag-id]')) { const empty = document.createElement('span'); empty.className = 'record-no-tags'; empty.textContent = 'Без тегов'; meta.append(empty); }
                    }
                }
                catch (_) { alert('Не удалось убрать тег. Обновите страницу и попробуйте ещё раз.'); }
            };
            document.querySelectorAll('[data-async-tag-detach]').forEach(form => form.addEventListener('submit', detachTag));
            document.querySelectorAll('[data-quick-tag]').forEach(form => {
                if (form.querySelector('button[type="submit"]').classList.contains('picker-selected')) addUnlinkButton(form, 'Убрать тег');
                form.addEventListener('submit', async event => {
                    event.preventDefault();
                    try { await requestForm(form); markTag(form, true); }
                    catch (_) { alert('Не удалось добавить тег. Обновите страницу и попробуйте ещё раз.'); }
                });
                form.addEventListener('click', async event => {
                    if (!event.target.closest('.quick-unlink')) return;
                    event.preventDefault(); event.stopPropagation();
                    try {
                        const response = await fetch(form.dataset.detachUrl, { method:'POST', headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json','Content-Type':'application/x-www-form-urlencoded'}, body:new URLSearchParams({_token:form.querySelector('[name="_token"]').value,_method:'DELETE'}) });
                        if (!response.ok) throw new Error('delete'); markTag(form, false);
                    } catch (_) { alert('Не удалось убрать тег. Обновите страницу и попробуйте ещё раз.'); }
                });
            });
            document.querySelectorAll('[data-record-status]').forEach(form => {
                const button = form.querySelector('button[type="submit"]');
                if (form.dataset.listMode === 'ordinary' && form.dataset.active === 'true') addUnlinkButton(form, 'Вернуть в обычные');
                form.addEventListener('submit', async event => {
                    event.preventDefault();
                    const record = form.closest('.record-entry');
                    const mode = form.dataset.listMode;
                    const nextStatus = form.querySelector('[name="status"]').value || null;
                    try {
                        const response = await fetch(form.action, { method:'POST', body:new FormData(form), headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'} });
                        if (!response.ok) throw new Error('status');
                        if (mode !== 'ordinary') { record.remove(); return; }
                        record.querySelectorAll('[data-record-status][data-list-mode="ordinary"]').forEach(option => {
                            const active = option === form && nextStatus !== null;
                            option.dataset.active = active ? 'true' : 'false';
                            option.querySelector('input[name="status"]').value = active ? option.dataset.status : option.dataset.status;
                            const optionButton = option.querySelector('button[type="submit"]');
                            optionButton.classList.toggle('status-active', active);
                            optionButton.textContent = active
                                ? (option.dataset.status === 'hidden' ? 'Скрыт' : 'В спаме')
                                : (option.dataset.status === 'hidden' ? 'Скрыть' : 'В спам');
                            option.querySelector('.quick-unlink')?.remove();
                            if (active) addUnlinkButton(option, 'Вернуть в обычные');
                        });
                    } catch (_) { alert('Не удалось изменить список записи. Обновите страницу и попробуйте ещё раз.'); }
                });
                form.addEventListener('click', event => {
                    if (!event.target.closest('.quick-unlink')) return;
                    event.preventDefault(); event.stopPropagation();
                    form.querySelector('[name="status"]').value = '';
                    form.requestSubmit();
                });
            });
        });
    </script>
@endpush
