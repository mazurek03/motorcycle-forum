<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Forum Motocyklowe - Panel Główny') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Dodaj nowy temat</h3>
                    <form action="{{ route('posts.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300">Tytuł</label>
                            <input type="text" name="title" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300">Kategoria</label>
                            <select name="category_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100">
                                @foreach(\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300">Treść</label>
                            <textarea name="content" rows="4" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"></textarea>
                        </div>

                        <x-primary-button>Opublikuj post</x-primary-button>
                    </form>
                </div>

                <hr class="border-gray-200 dark:border-gray-700 my-8">

                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Najnowsze wpisy</h3>
                <div class="space-y-6">
                    @forelse($posts as $post)
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="text-xl font-bold text-indigo-600 dark:text-indigo-400">{{ $post->title }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                        Autor: <strong>{{ $post->user->name }}</strong> | 
                                        Kategoria: <strong>{{ $post->category->name }}</strong> | 
                                        Data: {{ $post->created_at->format('d.m.Y H:i') }}
                                    </p>
                                </div>
                                
                                @if(Auth::user()->role_id === 1 || Auth::id() === $post->user_id)
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć ten post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm bg-red-100 dark:bg-red-900/30 px-3 py-1 rounded">
                                            USUŃ
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <p class="text-gray-800 dark:text-gray-200 mt-2">{{ $post->content }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 italic">Brak postów do wyświetlenia. Bądź pierwszy!</p>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>