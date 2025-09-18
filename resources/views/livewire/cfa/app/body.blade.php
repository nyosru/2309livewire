<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Центр Финансовой Аналитики</title>
    <link href="/css/output.css?v={{ filemtime(public_path('/css/output.css')) }}" rel="stylesheet">
    @livewireStyles

</head>
<body>

<livewire:app.navigation/>

{{ $slot }}

<livewire:app.footer/>

@livewireScripts

</body>
</html>
