<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>{{ $title }}</title>
</head>

<body>
    <div x-data="{ open: false }" class="min-h-screen flex bg-gray-100">
        <x-side-bar></x-side-bar>
        <main class="p-6">
            {{ $slot }}
        </main>
</body>

</html>