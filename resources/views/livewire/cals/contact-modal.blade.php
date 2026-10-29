<div x-data x-on:keydown.escape.window="$wire.close()">
    @if($showModal)
        <div class="modal" aria-hidden="false">
            <button type="button" class="modal-backdrop" aria-label="Закрыть карточку" wire:click="close"></button>
            <section class="modal-dialog" role="dialog" aria-modal="true" aria-labelledby="contact-modal-title">
                <header class="modal-header">
                    <div><span class="eyebrow">Карточка абонента</span><h2 id="contact-modal-title">{{ $name ?: ($phone ?: 'Абонент') }}</h2></div>
                    <button type="button" class="modal-close" aria-label="Закрыть" wire:click="close">×</button>
                </header>
                <div class="modal-content">
                    @if($message)<p class="modal-feedback" role="status">{{ $message }}</p>@endif

                    <form wire:submit="saveContact">
                        <div class="modal-fields">
                            <div class="field">
                                <label for="modal-contact-name">Имя абонента</label>
                                <input id="modal-contact-name" type="text" wire:model="name" maxlength="255" placeholder="Если имя неизвестно — оставьте пустым">
                                @error('name')<small class="field-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="field">
                                <label for="modal-contact-phone">Номер телефона</label>
                                <input id="modal-contact-phone" type="text" wire:model="phone" maxlength="64" placeholder="+7 …">
                                @error('phone')<small class="field-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="field">
                                <label for="modal-contact-company">Компания</label>
                                <input id="modal-contact-company" type="text" wire:model="companyName" maxlength="255" placeholder="Название компании">
                                @error('companyName')<small class="field-error">{{ $message }}</small>@enderror
                            </div>
                            <div class="field">
                                <label for="modal-contact-start-date">Дата начала</label>
                                <input id="modal-contact-start-date" type="date" wire:model="startDate">
                                @error('startDate')<small class="field-error">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="field">
                            <label for="modal-contact-notes">Заметка об абоненте</label>
                            <textarea id="modal-contact-notes" wire:model="notes" rows="3" placeholder="Дополнительные сведения"></textarea>
                            @error('notes')<small class="field-error">{{ $message }}</small>@enderror
                        </div>
                        <div class="modal-actions">
                            <button type="submit" wire:loading.attr="disabled" wire:target="saveContact">Сохранить данные</button>
                            <span class="muted" wire:loading wire:target="saveContact">Сохраняем…</span>
                        </div>
                    </form>

                    <section class="modal-comments" aria-labelledby="contact-comments-title">
                        <div class="modal-section-heading"><h3 id="contact-comments-title">Комментарии</h3><span class="count">{{ count($comments) }}</span></div>
                        <div class="modal-comments-list">
                            @forelse($comments as $comment)
                                <article class="modal-comment" wire:key="contact-comment-{{ $comment['id'] }}">
                                    <time>{{ $comment['created_at'] }}</time>
                                    <p>{{ $comment['body'] }}</p>
                                </article>
                            @empty
                                <p class="muted">Комментариев пока нет.</p>
                            @endforelse
                        </div>
                        <form wire:submit="addComment">
                            <div class="field">
                                <label for="modal-new-comment">Новый комментарий</label>
                                <textarea id="modal-new-comment" wire:model="commentBody" rows="3" maxlength="10000" required placeholder="Добавьте отдельную заметку об этом абоненте"></textarea>
                                @error('commentBody')<small class="field-error">{{ $message }}</small>@enderror
                            </div>
                            <button type="submit" class="secondary-button" wire:loading.attr="disabled" wire:target="addComment">Добавить комментарий</button>
                        </form>
                    </section>
                </div>
            </section>
        </div>
    @endif
</div>
