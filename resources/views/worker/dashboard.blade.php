<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-orange-500 uppercase tracking-widest flex items-center gap-2">
                🛠️ Centrum Moderacji <span class="text-slate-500 text-sm">| System Zarządzania</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-white">
                <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-xl border-l-4 border-l-orange-500">
                    <p class="text-slate-400 text-xs uppercase font-black tracking-widest mb-1">Społeczność</p>
                    <p class="text-4xl font-black text-white">{{ $totalUsers }}</p>
                </div>
                <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-xl border-l-4 border-l-blue-500">
                    <p class="text-slate-400 text-xs uppercase font-black tracking-widest mb-1">Baza Wpisów</p>
                    <p class="text-4xl font-black text-white">{{ $totalPosts }}</p>
                </div>
            </div>

            <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden shadow-2xl">
                <div class="p-6 bg-slate-800/50 border-b border-slate-700">
                    <h3 class="text-white font-bold uppercase text-sm tracking-widest text-center md:text-left">Moderacja Postów</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-slate-300">
                        <thead class="bg-slate-900/50 text-slate-500 uppercase text-[10px] font-black">
                            <tr>
                                <th class="p-4">Wpis</th>
                                <th class="p-4 text-right">Akcja</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @foreach($posts as $post)
                            <tr class="hover:bg-slate-700/30 transition">
                                <td class="p-4">
                                    <div class="font-bold text-slate-100">{{ $post->title }}</div>
                                    <div class="text-[10px] text-slate-500 italic">Autor: {{ $post->user->name }}</div>
                                </td>
                                <td class="p-4 text-right">
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Usunąć?')">
                                        @csrf @method('DELETE')
                                        <button class="bg-red-600/10 text-red-500 border border-red-600/20 px-3 py-1 rounded text-[10px] font-black uppercase hover:bg-red-600 hover:text-white transition">Usuń</button>
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
                    <h3 class="text-white font-bold uppercase text-sm tracking-widest text-center md:text-left">Zarządzanie Użytkownikami</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-slate-300 table-fixed min-w-[800px]">
                        <thead class="bg-slate-900/50 text-slate-500 uppercase text-[10px] font-black">
                            <tr>
                                <th class="p-4 w-1/3 text-center md:text-left">Użytkownik</th>
                                <th class="p-4 w-1/6 text-center">Rola</th>
                                <th class="p-4 w-1/4 text-center">Status blokady</th>
                                <th class="p-4 w-1/4 text-right">Działania</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @foreach($clients as $client)
                            <tr class="hover:bg-slate-700/30 transition">
                                <td class="p-4 overflow-hidden">
                                    <div class="font-bold text-slate-100 truncate">{{ $client->name }}</div>
                                    <div class="text-[10px] text-slate-500 truncate">{{ $client->email }}</div>
                                </td>
                                <td class="p-4 text-center">
                                    @if($client->role_id == 1)
                                        <span class="text-purple-400 bg-purple-500/10 px-2 py-0.5 rounded border border-purple-500/20 text-[9px] font-black uppercase tracking-tighter">Admin</span>
                                    @elseif($client->role_id == 2)
                                        <span class="text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded border border-blue-500/20 text-[9px] font-black uppercase tracking-tighter">Worker</span>
                                    @else
                                        <span class="text-slate-400 bg-slate-500/10 px-2 py-0.5 rounded border border-slate-500/20 text-[9px] font-black uppercase tracking-tighter">Klient</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    @if($client->banned_until && $client->banned_until->isFuture())
                                        <div class="flex flex-col items-center">
                                            <span class="text-red-500 text-[9px] font-black uppercase">Zablokowany</span>
                                            <span class="text-slate-500 text-[8px]">{{ $client->banned_until->format('d.m.Y') }}</span>
                                        </div>
                                    @else
                                        <span class="text-green-500 text-[9px] font-black uppercase bg-green-500/10 px-2 py-0.5 rounded border border-green-500/20">Aktywny</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex flex-col gap-2 items-end">
                                        {{-- ZMIANA ROLI: TYLKO DLA ADMINA I TYLKO NA ROLE 2 LUB 3 --}}
                                        @if(Auth::user()->role_id == 1)
                                        <form action="{{ route('worker.users.role', $client) }}" method="POST" class="flex items-center gap-1">
                                            @csrf
                                            <select name="role_id" class="bg-slate-900 border-slate-700 text-[9px] rounded px-1 py-0.5 text-slate-400 focus:ring-0">
                                                <option value="3" {{ $client->role_id == 3 ? 'selected' : '' }}>Klient</option>
                                                <option value="2" {{ $client->role_id == 2 ? 'selected' : '' }}>Worker</option>
                                            </select>
                                            <button type="submit" class="bg-blue-600 text-white text-[9px] font-black px-2 py-0.5 rounded uppercase hover:bg-blue-700 transition">Rola</button>
                                        </form>
                                        @endif

                                        {{-- BANOWANIE --}}
                                        <form action="{{ route('worker.users.ban', $client) }}" method="POST" class="flex items-center gap-1">
                                            @csrf
                                            <select name="days" class="bg-slate-900 border-slate-700 text-[9px] rounded px-1 py-0.5 text-slate-400 focus:ring-0">
                                                <option value="1">1D</option>
                                                <option value="7">7D</option>
                                                <option value="30">30D</option>
                                            </select>
                                            <button type="submit" class="bg-red-600 text-white text-[9px] font-black px-2 py-0.5 rounded uppercase hover:bg-red-700 transition">Ban</button>
                                        </form>
                                    </div>
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