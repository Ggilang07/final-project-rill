<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <h1 class="text-2xl font-bold mb-4">{{ $heading }}</h1>
    <form action="" method="POST">
        @csrf
        <input type="text" name="judul" placeholder="Judul Template" required>
        <textarea name="isi_template" id="editor"></textarea>
        <button type="submit">Simpan</button>
    </form>

    <!-- CKEditor CDN -->
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor'); // Aktifkan CKEditor di textarea
    </script>

</x-layout>