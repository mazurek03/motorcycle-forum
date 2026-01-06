<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Motorcycle Forum</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 dark:bg-gray-900">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        
        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 text-lg">Zaloguj się</a>
                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 text-lg">Rejestracja</a>
                @endauth
            </div>
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8 w-full">
            <div class="text-center py-10">
                <h1 class="text-5xl font-extrabold text-indigo-600 dark:text-indigo-400 mb-4">🏍️ Motorcycle Forum</h1>
                <p class="text-xl text-gray-600 dark:text-gray-400">Najlepsza społeczność pasjonatów dwóch kółek!</p>
            </div>

            <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($posts as $post)
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg border-l-4 border-indigo-500">
                        <div class="flex items-center mb-2">
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-indigo-900 dark:text-indigo-300">
                                {{ $post->category->name }}
                            </span>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $post->title }}</h2>
                        <p class="text-gray-600 dark:text-gray-400 line-clamp-3 mb-4 italic">
                            "{{ Str::limit($post->content, 150) }}"
                        </p>
                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <span>Autor: {{ $post->user->name }}</span>
                            <span>💬 {{ $post->comments->count() }} komentarzy</span>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($posts->isEmpty())
                <p class="text-center text-gray-500 mt-10">Brak postów do wyświetlenia. Zaloguj się i dodaj pierwszy!</p>
            @endif
        </div>
    </div>
</body>
</html>