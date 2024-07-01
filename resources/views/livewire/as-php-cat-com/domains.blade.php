<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Yes!!</title>

    @if(1==2)
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>


        <link
            href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap"
            rel="stylesheet" />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/tw-elements/css/tw-elements.min.css" />

        @livewireStyles
    @endif
</head>

<body class="antialiased">

<div>

<pre style="font-size: 10px;">
    $history_whois: {{ print_r($history_whois,true) }}
</pre>

    {{--    {{ $domains }}--}}
    <table class="table-auto border-collapse border border-slate-500">
        <caption class="caption-top">
            домены и всё такое
        </caption>
        <thead style="position: sticky; top: 0;">
        <tr>
            <th class="bg-green-300 p-1" >домен</th>
            <th class="bg-green-200 p-1" >рус</th>
            <th class="bg-green-300 p-1" >действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $domains as $d )
            @if( !empty($d[0]) )
            <tr>
                <td class="text-xl">{{ $d[0] }}</td>
                <td>{{ $d[1] ?? '' }}</td>
                <td><livewire:as_php-cat_com.whois :domain="$d[1] ?? $d[0]"/></td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>

@livewireScripts

</body>
</html>
