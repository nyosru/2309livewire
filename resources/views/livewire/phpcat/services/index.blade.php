<div>
    <div class="block bg-blue-200">
        <div class="container mx-auto py-5">
            <h1 class="text-[2rem] font-bold">Помощник, пользуйтесь с удовольствием!</h1>
        </div>
    </div>

{{--    <!-- Dropdown для выбора компонента -->--}}
{{--    <select wire:model.live="selectedComponent" class="border p-2 mb-4">--}}
{{--        <option value="">Выберите нужный (их уже 2)</option>--}}
{{--        <option value="punny-converter">Punny конвертер</option>--}}
{{--        <option value="generator-qr">Генератор Qr код</option>--}}
{{--    </select>--}}
{{--    {{ $selectedComponent ?? 'x' }}--}}

    <!-- Условный рендеринг компонентов -->
{{--    @if ($selectedComponent === 'punny-converter')--}}
{{--        <livewire:phpcat.services.converter-punny />--}}
        <livewire:phpcat.Services.converter-punny />
{{--    @elseif ($selectedComponent === 'generator-qr')--}}
        <livewire:Phpcat.Services.generator-qr />
{{--    @endif--}}
</div>
