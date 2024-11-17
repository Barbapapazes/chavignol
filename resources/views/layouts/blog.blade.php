<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/blog.css', 'resources/js/blog.ts'])

    <script>
        window.isLoggedIn = @json(auth()->check());
        window.postId = @json(request()->route('post')->id ?? null);
    </script>
</head>
<body>

    <header class="h-16 px-4 flex items-center">
        <div class="mx-auto w-full max-w-screen-lg flex justify-between">
            <a class="flex items-center text-lg font-bold space-x-px" href="{{ route('home') }}">
                <x-application-logo aria-hidden="true" class="size-5"></x-application-logo>
                <span>Chavignol</span>
            </a>

            <div class="space-x-2">
                <a href="{{ route('login') }}" class="px-2 py-1 text-sm tracking-wide transition duration-200 ease-in hover:bg-neutral-100 rounded text-neutral-700 hover:text-neutral-900">
                    Login
                </a>
                <a href="{{ route('register') }}" class="px-2 py-1 border border-neutral-200 hover:border-neutral-400 rounded shadow-sm text-sm tracking-wide transition ease-in duration-200 text-neutral-700 hover:text-neutral-900">
                    Register
                </a>
            </div>
        </div>
    </header>

    <main class="mt-16">
        {{ $slot }}
    </main>

    @if (isset($vue))
        {{ $vue }}
    @endif
</body>
</html>
