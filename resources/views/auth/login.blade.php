<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In | Study Greater Masaka</title>
    <link rel="icon" type="image/png" href="{{ asset('images/sgm-logo.png') }}">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-[#eef4fb] text-[#111827] antialiased">
    <main class="mx-auto flex min-h-screen w-full max-w-sm flex-col justify-center gap-5 px-4 py-8">
        <img src="{{ asset('images/sgm-logo.png') }}" alt="Study Greater Masaka" class="mx-auto h-auto w-40 object-contain">
        <form method="POST" action="{{ route('login') }}" class="grid gap-4 rounded-none border border-[#c7d7ea] bg-white p-5">
            @csrf
            <h1 class="text-xl font-bold text-[#082c56]">Sign in</h1>
            @if ($errors->any())<p role="alert" class="rounded-none bg-red-50 p-2 text-xs text-red-700">{{ $errors->first() }}</p>@endif
            <label for="email" class="grid gap-1.5 text-xs font-semibold">Email
                <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" class="w-full rounded-none border border-[#9dbbe0] px-3 py-2 text-sm font-normal focus:outline-2 focus:outline-[#1d72b8]" required autofocus>
            </label>
            <label for="password" class="grid gap-1.5 text-xs font-semibold">Password
                <input id="password" name="password" type="password" autocomplete="current-password" class="w-full rounded-none border border-[#9dbbe0] px-3 py-2 text-sm font-normal focus:outline-2 focus:outline-[#1d72b8]" required>
            </label>
            <label class="flex items-center gap-2 text-xs"><input type="checkbox" name="remember" value="1" @checked(old('remember'))> Remember me</label>
            <button class="rounded-none bg-[#1d72b8] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#082c56]">Sign in</button>
        </form>
    </main>
</body>
</html>
