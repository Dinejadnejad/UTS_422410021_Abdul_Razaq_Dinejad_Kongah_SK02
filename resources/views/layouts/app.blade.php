<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Observatorium Langit Gelap')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col font-sans antialiased">

    {{-- Memanggil Partial Navbar --}}
    @include('partials.navbar')

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Memanggil Partial Notifikasi Sukses/Error --}}
        @include('partials.flash-message')

        {{-- Area Konten Dinamis Halaman --}}
        @yield('content')
    </main>

    <footer class="border-t border-slate-800 bg-slate-900/60 py-4 text-center text-xs text-slate-400">
        Sistem Administrasi Observatorium Langit Gelap
    </footer>

</body>
</html>