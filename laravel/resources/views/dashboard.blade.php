<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:heading>{{ $heading }}</x-slot:heading>
    @auth
    <p>Selamat datang, {{ Auth::user()->name }}</p>
@endauth
</x-layout>
