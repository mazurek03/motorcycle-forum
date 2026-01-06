<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Forum Motocyklowe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('posts.store') }}" method="POST" class="mb-8">
                    @csrf
                    <div class="mb-4">
                        <input type="text" name="title" placeholder="Tytuł tematu" required class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-gray-100">
                    </div>
                    <div class="mb-4">
                        <select name="category_id" required class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-gray-100">
                            @foreach(\App\Models\Category::all() as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <textarea name="content" placeholder="Treść posta..." required class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-gray-100"></textarea>
                    </div>
                    <x-primary-button>Opublikuj post</x-primary-button>
                </form>

                <hr class="border-gray-700 my-6">

                @foreach($posts as $post)
                    <div class="mb-8 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow border border-gray-200 dark:border-gray-600">
                        <div class="flex justify-between">
                            <h3 class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $post->title }}</h3>
                            @if(Auth::user()->role_id === 1 || Auth::id() === $post->user_id)
                                <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 font-bold">USUŃ POST</button>
                                </form>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mb-4 italic text-gray-400">
                            Autor: {{ $post->user->name }} | Kategoria: {{ $post->category->name }}
                        </p>
                        <p class="text-gray-800 dark:text-gray-200 text-lg mb-6">{{ $post->content }}</p>

                        <div class="mt-6 bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-300 dark:border-gray-600">
                            <h5 class="font-bold mb-4 dark:text-gray-200">Komentarze:</h5>
                            
                            @foreach($post->comments as $comment)
                                <div class="mb-2 p-2 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                                    <p class="text-sm dark:text-gray-300">
                                        <span class="font-bold text-indigo-400">{{ $comment->user->name }}:</span> 
                                        {{ $comment->content }}
                                    </p>
                                    @if(Auth::user()->role_id === 1 || Auth::id() === $comment->user_id)
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="text-xs text-red-400 hover:underline">Usuń</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach

                            <form action="{{ route('comments.store') }}" method="POST" class="mt-4 flex gap-2">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <input type="text" name="content" placeholder="Skomentuj..." required 
                                       class="flex-1 text-sm rounded-md border-gray-300 dark:bg-gray-900 dark:text-gray-200">
                                <x-primary-button class="py-1">OK</x-primary-button>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>