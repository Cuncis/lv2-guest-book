<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <header class="bg-white shadow-sm">
        <div class="max-w-2xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('messages.index') }}" class="text-xl font-bold text-amber-600">
                Guest Book
            </a>
        </div>
    </header>

    <main class="flex-1 max-w-2xl mx-auto w-full px-4 py-10">
        @yield('content')
    </main>

    <footer class="text-center text-sm text-gray-400 py-6">
        &copy; {{ date('Y') }} Guest Book — Laravel 12 + SQLite
    </footer>
</body>

</html>