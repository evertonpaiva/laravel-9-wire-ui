<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session('dark', false) ? 'dark' : '' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'WireUI') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <livewire:styles />
    <link rel="stylesheet" href="{{ mix('dist/app.css') }}">

    <!-- Scripts -->
    <wireui:scripts />
    <script src="{{ mix('dist/alpine.js') }}" defer></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @stack('styles')
</head>

<body class="font-sans overflow-y-scroll min-h-screen bg-slate-100 dark:bg-secondary-800">
<x-notifications />
<x-dialog />

{{ $slot }}

<!-- Scripts -->
<livewire:scripts />
<script src="{{ mix('dist/app.js') }}"></script>
@stack('scripts')
</body>
</html>
