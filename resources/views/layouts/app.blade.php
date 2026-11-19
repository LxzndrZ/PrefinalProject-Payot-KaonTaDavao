<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kaon Ta! Davao – Payot's Food Guide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen">
    <header class="bg-orange-600 text-white">
        <div class="max-w-6xl mx-auto px-4 py-4">
            <a href="{{ route('home') }}" class="text-xl font-bold">Kaon Ta! Davao – Payot's Food Guide</a>
            @include('partials.nav')
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-6">
        @include('partials.flash')
        @yield('content')
    </main>
</body>
</html>