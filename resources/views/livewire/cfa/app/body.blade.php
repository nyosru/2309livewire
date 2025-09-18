<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
