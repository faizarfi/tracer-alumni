<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Lupa Password - Tracer Alumni</title>
    <link rel="icon" href="{{ asset('img/uin.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{font-family:Inter, sans-serif}</style>
</head>
<body class="bg-green-50 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-lg p-8">
        <div class="text-center mb-6">
            <img src="{{ asset('img/uin.png') }}" class="mx-auto w-20 h-20" alt="logo">
            <h1 class="mt-4 text-2xl font-bold text-gray-800">Lupa Password</h1>
            <p class="text-sm text-gray-500">Masukkan email untuk menerima tautan reset</p>
        </div>

        @if (session('status'))
            <div class="mb-4 text-sm text-green-700 bg-green-100 p-3 rounded">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-2 focus:ring-2 focus:ring-green-500" placeholder="nama@example.com">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full py-2.5 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">Kirim Tautan Reset</button>

            <p class="text-center text-sm text-gray-500">Ingat password? <a href="{{ route('login') }}" class="text-green-700 font-semibold">Login</a></p>
        </form>
    </div>
</body>
</html>
