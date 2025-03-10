<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $title ?? 'Php Cat' }}</title>
{{--    <script src="https://cdn.tailwindcss.com"></script>--}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        header,
        .background-radial-gradient {
            /*min-height: 130px;*/
            background-color: rgb(255, 211, 161);
            background-image: radial-gradient(
                650px circle at 20% 20%,
                rgb(255, 196, 133) 15%,
                    /* hsl(218, 41%, 30%) 35%, */ /* hsl(218, 41%, 20%) 75%, */ rgb(218, 170, 141) 15%,
                    /* hsl(218, 41%, 19%) 80%, */ rgb(146, 223, 223) 40%,
                    /* hsl(218, 41%, 35%) 15%, */ rgb(176, 142, 197) 75%,
                transparent 100%
            ),
            radial-gradient(1250px circle at 80% 80%,
                    /* hsl(218, 41%, 45%) 15%, */ rgb(129, 216, 255) 15%,
                    /* hsl(218, 41%, 30%) 35%, */ rgb(255, 190, 139) 35%,
                    /* hsl(218, 41%, 20%) 75%, */ rgb(240, 250, 255) 65%,
                    /* hsl(218, 41%, 19%) 80%, */ rgb(140, 255, 137) 90%,
                transparent 100%
            );

            background-size: 250% 250%; /* Размер фона */
            animation: animateGradient 30s linear infinite; /* Анимация */
        }


        @keyframes animateGradient {
            0% {
                background-position: 15% 90%;
            }
            50% {
                background-position: 65% 100%;
            }
            100% {
                background-position: 15% 90%;
            }
        }
    </style>

    <link href="/css/output.css?v={{ filemtime(public_path('/css/output.css')) }}" rel="stylesheet" />

</head>
<body
    style="background: linear-gradient(
    180deg,
    rgba(255, 255, 255, 0.75),
    rgba(255,234,205,0.25) ),
        url('/tmn/photo1.jpg') center/cover;"
    class="
{{--    bg-gradient-to-bl--}}
{{--    from-white--}}
{{--    to-gray-100--}}
    min-h-[100vh]
    ">
@include('livewire.phpcatru.layouts.header')
<main class="mt-[30px]">
    {{ $slot }}
</main>
@include('livewire.phpcatru.layouts.footer')
</body>
</html>
