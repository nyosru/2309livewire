<section class="projects section" id="projects">
    <div class="projects-heading reveal">
        <div><span class="eyebrow">/ Текущие проекты</span><h2>Уже в работе</h2></div>
        <p>Не обещания, а&nbsp;конкретные проекты. Наведите на&nbsp;разные части фотографии, чтобы увидеть больше.</p>
    </div>

    @forelse($projects as $project)
        @php
            $images = collect($project->images)->filter()->values();
            if ($images->isEmpty()) {
                $images = collect(['/processmaster/preview_link_for_fb.jpg']);
            }
            $statusClass = match($project->status_color) {
                'orange' => 'status-warm',
                'blue' => 'status-blue',
                default => '',
            };
        @endphp
        <article class="project-card {{ $loop->even ? 'project-card-reverse' : '' }} reveal">
            <div class="project-visual js-project-gallery" data-images="{{ $images->implode('|') }}">
                <img src="{{ $images->first() }}" alt="Проект {{ $project->title }}" loading="lazy">
                <div class="gallery-zones" style="grid-template-columns: repeat({{ $images->count() }}, 1fr)" aria-label="Другие фотографии проекта">
                    @foreach($images as $image)
                        <button type="button" data-image="{{ $loop->index }}" aria-label="Фото {{ $loop->iteration }}"></button>
                    @endforeach
                </div>
                <div class="gallery-progress">
                    @foreach($images as $image)
                        <i class="{{ $loop->first ? 'active' : '' }}"></i>
                    @endforeach
                </div>
                <span class="project-status {{ $statusClass }}">{{ $project->status }}</span>
            </div>
            <div class="project-info">
                <div class="project-meta">
                    <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} / {{ $project->category }}</span>
                    <span>{{ $project->location }}</span>
                </div>
                <h3>{{ $project->title }}</h3>
                <p class="project-description">{{ $project->description }}</p>
                <div class="investment"><span>Возможность для инвестора</span><p>{{ $project->investment_offer }}</p></div>
                <button class="button button-dark js-open-modal" type="button" data-project="{{ $project->title }}">Обсудить участие в&nbsp;проекте <span>↗</span></button>
            </div>
        </article>
    @empty
        <p class="projects-empty">Скоро здесь появятся новые проекты.</p>
    @endforelse
</section>
