<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $title ?? 'Php Cat' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        header,
        .background-radial-gradient {
            min-height: 130px;
            background-color: rgb(255, 255, 240);
            background-image: radial-gradient(
                650px circle at 0% 0%,
                rgb(255, 255, 240) 15%,
                    /* hsl(218, 41%, 35%) 15%, */ rgb(255, 255, 120) 25%,
                    /* hsl(218, 41%, 30%) 35%, */ /* hsl(218, 41%, 20%) 75%, */ rgb(205, 255, 180) 35%,
                    /* hsl(218, 41%, 19%) 80%, */ rgb(240, 255, 150) 90%,
                transparent 100%
            ),
            radial-gradient(1250px circle at 100% 100%,
                    /* hsl(218, 41%, 45%) 15%, */ rgb(240, 250, 255) 15%,
                    /* hsl(218, 41%, 30%) 35%, */ rgb(240, 220, 255) 25%,
                    /* hsl(218, 41%, 20%) 75%, */ rgb(240, 250, 255) 45%,
                    /* hsl(218, 41%, 19%) 80%, */ rgb(220, 250, 255) 60%,
                transparent 100%);

            background-size: 150% 150%; /* Размер фона */
            animation: animateGradient 30s linear infinite; /* Анимация */
        }


        @keyframes animateGradient {
            0% {
                background-position: 10% 20%;
            }
            50% {
                background-position: 100% 80%;
            }
            100% {
                background-position: 10% 20%;
            }
        }
    </style>


</head>
<body class="bg-gradient-to-b
    from-[rgba(0,0,255,0.1)]
    to-[rgba(0,255,255,0.1)]
    min-h-[100vh]
    ">
@include('livewire.phpcatru.layouts.header')
<main class="mt-[30px]">
    {{ $slot }}
</main>
@include('livewire.phpcatru.layouts.footer')
</body>
</html>
