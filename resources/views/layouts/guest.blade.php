<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/art_icon.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-image: url('/images/dcmtrd-bg.png');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="font-sans antialiased text-white bg-gradient-to-br from-indigo-600 to-purple-700">
    <div
        class="relative z-10 flex flex-col items-center min-h-screen pt-6 sm:justify-center sm:pt-0 backdrop-blur-md bg-white/10">
        <div class="mb-6">
            <a href="/">
                <x-application-logo class="h-20 text-white fill-current drop-shadow-md" />
            </a>
        </div>

        <div class="w-full px-6 py-6 text-gray-900 bg-white border border-gray-300 shadow-xl sm:max-w-md rounded-2xl">
            {{ $slot }}
        </div>

    </div>
</body>

</html>
