@props(['title' => 'Laravel App', 'noSidebar' => false, 'heading' => ''])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <title>{{ $title }}</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

</head>

<body>
    @if (!($noSidebar ?? false))
        <x-side-bar>
            <x-slot:heading>{{ $heading ?? '' }}</x-slot:heading>
            {{ $slot }}
        </x-side-bar>
    @else
        {{ $slot }}
    @endif
    @stack('scripts')
</body>

</html>