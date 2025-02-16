<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Kasir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
</head>
<body class="bg-blue-500">
    <nav class="bg-blue-600 p-4 flex justify-between items-center text-white">
        <h1 class="text-xl font-bold">Phylax Computer - Kasir</h1>
        <a href="{{ route('auth.logout') }}" class="bg-red-500 px-4 py-2 rounded hover:bg-red-700">
            Logout
        </a>
    </nav>

    <div class="container mx-auto mt-10">
        @yield('content')
    </div>
</body>
</html>
