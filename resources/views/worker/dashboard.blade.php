<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-orange-500 uppercase tracking-widest flex items-center gap-2">
                🛠️ Centrum Moderacji <span class="text-slate-500 text-sm">| Panel Operacyjny</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-white">
                <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-xl">
                    <p class="text-slate-400 text-xs uppercase font-black tracking-widest mb-1">Społeczność</p>
                    <p class="text-4xl font-black text-white">{{ $totalUsers }}</p>
                </div>
                <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-xl">
                    <p class="text-slate-400 text-xs uppercase font-black tracking-widest mb-1">Baza Wpisów</p>
                    <p class="text-4xl font-black text-orange-500">{{ $totalPosts }}</p>
                </div>
            </div>

            <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden shadow-2xl">
                <div class="p-6 bg-slate-800/50 border-b border-slate-700 flex justify-between items-center">
                    <h3 class="text-white font-bold uppercase text-sm tracking-widest">Posty na forum</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-slate-300">
                        <thead class="bg-slate-900/50 text-slate-500 uppercase text-[10px] font-black">
                            <tr>
                                <th class="p-4">Wpis</th>
                                <th class="p-4">Kategoria</th>
                                <th class="p-4 text-center">Akcja</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @foreach($posts as $post)
                            <tr class="hover:bg-slate-700/30 transition">
                                <td class="p-4">
                                    <div class="font-bold text-slate-100">{{ $post->title }}</div>
                                    <div class="text-[10px] text-slate-500 italic">Autor: {{ $post->user->name }}</div>
                                </td>
                                <td class="p-4">
                                    <span class="text-[10px] font-bold px-2 py-1 bg-slate-900 border border-slate-700 rounded text-slate-400 uppercase">
                                        {{ $post->category->name }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Usunąć?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 bg-slate-900 hover:bg-red-600/20 text-red-500 border border-slate-700 rounded-lg transition">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden shadow-2xl">
                <div class="p-6 bg-slate-800/50 border-b border-slate-700">
                    <h3 class="text-white font-bold uppercase text-sm tracking-widest">🚫 Zarządzanie Użytkownikami</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-slate-300">
                        <thead class="bg-slate-900/50 text-slate-500 uppercase text-[10px] font-black">
                            <tr>
                                <th class="p-4">Użytkownik</th>
                                <th class="p-4">Status blokady</th>
                                <th class="p-4 text-right">Działanie</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @foreach($clients as $client)
                            <tr class="hover:bg-slate-700/30 transition">
                                <td class="p-4">
                                    <div class="font-bold text-slate-100">{{ $client->name }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $client->email }}</div>
                                </td>
                                <td class="p-4 text-xs">
                                    @if($client->banned_until && $client->banned_until > now())
                                        <span class="text-red-500 font-bold uppercase bg-red-500/10 px-2 py-1 rounded">
                                            Zbanowany do: {{ $client->banned_until->format('d.m.Y') }}
                                        </span>
                                    @else
                                        <span class="text-green-500 font-bold uppercase bg-green-500/10 px-2 py-1 rounded">Aktywny</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <form action="{{ route('worker.users.ban', $client) }}" method="POST" class="flex justify-end gap-2">
                                        @csrf
                                        <select name="days" class="bg-slate-900 border-slate-700 text-[10px] rounded-lg text-slate-300 focus:border-orange-500 py-1">
                                            <option value="1">1 Dzień</option>
                                            <option value="7">7 Dni</option>
                                            <option value="30">30 Dni</option>
                                            <option value="365">1 Rok</option>
                                        </select>
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-black px-4 py-1 rounded-lg uppercase transition shadow-lg shadow-red-900/20">
                                            BAN
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>