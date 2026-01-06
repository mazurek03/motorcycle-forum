<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-slate-100 uppercase tracking-tighter">
                🏁 <span class="text-orange-500">Moto</span>Dashboard
            </h2>
            <span class="text-slate-400 text-sm italic underline decoration-orange-500">Zalogowany: {{ Auth::user()->name }}</span>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-slate-800 border border-slate-700 p-6 rounded-2xl shadow-xl flex items-center justify-between group hover:border-orange-500/50 transition">
                    <div>
                        <p class="text-slate-400 text-xs uppercase font-black tracking-widest">Fanów na trasie</p>
                        <p class="text-4xl font-black text-white">{{ $totalUsers }}</p>
                    </div>
                    <span class="text-4xl opacity-20 group-hover:opacity-100 transition">🏍️</span>
                </div>
                <div class="bg-slate-800 border border-slate-700 p-6 rounded-2xl shadow-xl flex items-center justify-between group hover:border-orange-500/50 transition">
                    <div>
                        <p class="text-slate-400 text-xs uppercase font-black tracking-widest">Wszystkich tematów</p>
                        <p class="text-4xl font-black text-white">{{ $totalPosts }}</p>
                    </div>
                    <span class="text-4xl opacity-20 group-hover:opacity-100 transition">🔥</span>
                </div>
            </div>

            <div class="bg-slate-800 border border-slate-700 p-6 rounded-2xl shadow-xl">
                <form action="{{ route('dashboard') }}" method="GET" class="flex flex-wrap gap-4 items-center">
                    <div class="flex-1 min-w-[300px]">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Szukaj tematów..." 
                               class="w-full rounded-xl border-slate-600 bg-slate-900 text-slate-200 focus:border-orange-500 focus:ring-orange-500">
                    </div>
                    <div class="w-full md:w-64">
                        <select name="category" class="w-full rounded-xl border-slate-600 bg-slate-900 text-slate-200 focus:border-orange-500 focus:ring-orange-500">
                            <option value="">Wszystkie kategorie</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-8 py-2.5 rounded-xl font-bold transition-all">
                        FILTRUJ
                    </button>
                    @if(request()->anyFilled(['search', 'category']))
                        <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-white transition text-sm">Wyczyść</a>
                    @endif
                </form>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <div class="bg-slate-800 border border-slate-700 p-6 rounded-2xl shadow-xl sticky top-24">
                        <h3 class="text-xl font-bold text-white mb-6 uppercase tracking-tight text-orange-500">Nowy temat</h3>
                        <form action="{{ route('posts.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="text" name="title" placeholder="Tytuł" required class="w-full rounded-xl border-slate-600 bg-slate-900 text-slate-200 focus:border-orange-500">
                            <select name="category_id" required class="w-full rounded-xl border-slate-600 bg-slate-900 text-slate-200 focus:border-orange-500">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <textarea name="content" rows="4" placeholder="Co tam na trasie?" required class="w-full rounded-xl border-slate-600 bg-slate-900 text-slate-200 focus:border-orange-500"></textarea>
                            <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-black py-3 rounded-xl transition-all uppercase tracking-widest shadow-lg">
                                Opublikuj post
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    @forelse($posts as $post)
                        <article class="bg-slate-800 border border-slate-700 rounded-2xl shadow-xl overflow-hidden transition hover:border-slate-500">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-slate-700 rounded-full flex items-center justify-center text-orange-500 font-bold">
                                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 class="text-white font-bold">{{ $post->user->name }}</h4>
                                            <span class="text-xs text-slate-500">{{ $post->created_at->diffForHumans() }} • {{ $post->category->name }}</span>
                                        </div>
                                    </div>
                                    @if(Auth::user()->role_id === 1 || Auth::id() === $post->user_id)
                                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="text-slate-500 hover:text-red-500 transition text-xs font-bold uppercase">USUŃ</button>
                                        </form>
                                    @endif
                                </div>
                                <h3 class="text-2xl font-black text-white mb-3">{{ $post->title }}</h3>
                                <p class="text-slate-300 mb-6">{{ $post->content }}</p>

                                <div class="border-t border-slate-700 pt-4">
                                    <div class="space-y-2 mb-4">
                                        @foreach($post->comments as $comment)
                                            <div class="bg-slate-900/50 p-2 rounded-lg text-sm border border-slate-700/50 flex justify-between">
                                                <p class="text-slate-300">
                                                    <span class="text-orange-500 font-bold">{{ $comment->user->name }}:</span> {{ $comment->content }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                    <form action="{{ route('comments.store') }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <input type="text" name="content" placeholder="Skomentuj..." required class="flex-1 bg-slate-900 border-slate-700 rounded-xl text-xs text-slate-200 focus:border-orange-500">
                                        <button class="bg-slate-700 px-4 py-1 rounded-xl text-xs font-bold hover:bg-slate-600 transition text-white">OK</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="text-center py-20 bg-slate-800 rounded-2xl border-2 border-dashed border-slate-700 text-slate-500">
                            Brak postów do wyświetlenia.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>