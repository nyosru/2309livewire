@component('livewire.news-storage.layouts.app-component', ['title' => 'Новости Тюмени'])
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <livewire:st-news-list article-path="/articles" />
    </div>
@endcomponent
