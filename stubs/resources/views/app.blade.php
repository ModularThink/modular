<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- If developing using SSL/HTTPS (uncomment the line below): Enforces loading all resources over HTTPS, upgrading requests from HTTP to HTTPS for enhanced security --}}
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}

    <title data-inertia>{{ config('app.name', 'Laravel') }}</title>

    {{-- used by Tiptap Editor --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="/favicon.svg" />

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @routes
    @vite('resources/js/app.js')
    @inertiaHead
</head>

<body class="h-full font-sans antialiased">
    @inertia

    <x-modular-translations></x-modular-translations>
</body>

</html>
