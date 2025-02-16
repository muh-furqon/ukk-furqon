<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="w-full max-w-sm bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Login</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-600 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('auth.login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" class="w-full p-2 border rounded focus:ring focus:ring-blue-200" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="w-full p-2 border rounded focus:ring focus:ring-blue-200" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                Login
            </button>
        </form>
    </div>
</body>
</html>
