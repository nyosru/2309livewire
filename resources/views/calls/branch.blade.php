<li class="branch" id="branch-{{ $branch->id }}">
    @if(isset($children[$branch->id]))
        <ul class="tree">
            @foreach($children[$branch->id] as $child)
                @include('calls.branch', ['branch' => $child])
            @endforeach
        </ul>
    @endif
    @if(!empty($byBranch[$branch->id]))
        <div class="branch-recordings">
            @foreach($byBranch[$branch->id] as $item)
                <x-calls.recording :item="$item" :branches="$branches" :recent-branches="$recentBranches" :recent-tags="$recentTags" :all-tags="$allTags" :list-mode="$listMode" />
            @endforeach
        </div>
    @endif
    <div class="branch-heading">
        <div class="branch-name"><span class="branch-dot" aria-hidden="true"></span>{{ $branch->name }}</div>
        <div class="branch-info"><span>{{ $branch->type }}</span><span>Проект: {{ $branch->project }}</span><span>Записей: {{ count($byBranch[$branch->id] ?? []) }}</span></div>
        <div class="branch-actions">
            <details><summary>+ Новая ветка</summary>@include('calls.branch-form', ['editing' => false])</details>
            <details><summary>Изменить</summary>@include('calls.branch-form', ['editing' => true])</details>
        </div>
    </div>

</li>
