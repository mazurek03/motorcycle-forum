<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MotoForum | Społeczność Motocyklowa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style id="accessibility-css"></style>
</head>
<body class="antialiased bg-slate-900 text-slate-200 transition-colors duration-200">

    <nav class="bg-slate-800/50 backdrop-blur-md border-b border-slate-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between h-16 items-center">
            <div class="flex items-center gap-2">
                <span class="text-3xl">🏍️</span>
                <span class="text-2xl font-black tracking-tighter text-white uppercase">Moto<span class="text-orange-500">Forum</span></span>
            </div>

            <div class="flex items-center gap-2 mx-4">
                <button onclick="toggleAccessibility('contrast')" class="bg-white text-black hover:bg-yellow-400 border-2 border-black px-3 py-1 rounded text-[10px] font-black transition shadow-sm">
                    👁️ KONTRAST
                </button>
                <button onclick="toggleAccessibility('font')" class="bg-white text-black hover:bg-blue-400 border-2 border-black px-3 py-1 rounded text-[10px] font-black transition shadow-sm">
                    A+ TEKST
                </button>
            </div>

            <div class="flex gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-bold transition">PANEL GŁÓWNY</a>
                @else
                    <a href="{{ route('login') }}" class="text-slate-300 hover:text-white px-3 py-2 font-medium">Logowanie</a>
                    <a href="{{ route('register') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-bold transition">DOŁĄCZ DO NAS</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="relative py-20 bg-slate-900 overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1558981403-c5f9899a28bc?q=80&w=2070')] bg-cover bg-center opacity-20 shadow-inner"></div>
        <div class="relative max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-6xl font-extrabold text-white mb-6 leading-tight">Pasja, Prędkość, <span class="text-orange-500 underline decoration-orange-500/30">Społeczność.</span></h1>
            <p class="text-xl text-slate-400 max-w-2xl mx-auto mb-10">Wymieniaj się doświadczeniami, pytaj o serwis i planuj wspólne trasy z tysiącami motocyklistów z całej Polski.</p>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-12">
        <div class="flex items-center justify-between mb-8 border-l-4 border-orange-500 pl-4">
            <h2 class="text-3xl font-bold text-white uppercase tracking-tight">Najnowsze dyskusje</h2>
            <span class="text-slate-500 text-sm italic">Ostatnie 5 wpisów</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <article class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden hover:border-orange-500/50 transition-all group flex flex-col h-full">
                    <div class="p-6 flex-1">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-[10px] font-bold uppercase tracking-widest bg-orange-500/10 text-orange-500 border border-orange-500/20 px-2 py-1 rounded">
                                {{ $post->category->name }}
                            </span>
                            <span class="text-xs text-slate-500">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-white group-hover:text-orange-400 transition mb-3">
                            {{ $post->title }}
                        </h3>
                        <p class="text-slate-400 text-sm line-clamp-4 leading-relaxed">
                            {{ $post->content }}
                        </p>
                    </div>
                    <div class="p-6 pt-0 mt-auto border-t border-slate-700/50 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center text-xs font-bold text-orange-500">
                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium text-slate-300">{{ $post->user->name }}</span>
                        </div>
                        <div class="text-slate-500 text-sm flex items-center gap-1">
                            <span>💬</span> {{ $post->comments->count() }}
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-20 bg-slate-800 rounded-2xl border-2 border-dashed border-slate-700">
                    <p class="text-slate-500">Obecnie nie ma żadnych publicznych tematów.</p>
                </div>
            @endforelse
        </div>
    </main>

    <footer class="bg-slate-950 py-12 border-t border-slate-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-slate-500 text-sm">&copy; 2026 MotoForum Project. Wszystkie lewe w górę! ✌️</p>
        </div>
    </footer>

    <script>
        function updateAccessibilityStyles() {
            const isContrast = localStorage.getItem('hc') === 'true';
            const isFont = localStorage.getItem('lt') === 'true';
            const styleTag = document.getElementById('accessibility-css');
            let css = '';

            if (isContrast) {
                css += `
                    html, body, nav, header, main, footer, article, div { 
                        background-color: #000 !important; 
                        color: #ff0 !important; 
                        border-color: #ff0 !important; 
                        background-image: none !important;
                    }
                    h1, h2, h3, span, p, a { color: #ff0 !important; }
                    a, button { border: 2px solid #ff0 !important; text-decoration: underline !important; }
                    .absolute { opacity: 1 !important; } /* Pokazuje tło w headerze w kontrastowym kolorze */
                `;
            }
            if (isFont) {
                css += `
                    html { font-size: 135% !important; }
                    body, p, span, a, div, h3 { line-height: 1.8 !important; }
                `;
            }
            styleTag.innerHTML = css;
        }

        function toggleAccessibility(type) {
            if (type === 'contrast') {
                localStorage.setItem('hc', localStorage.getItem('hc') === 'true' ? 'false' : 'true');
            } else {
                localStorage.setItem('lt', localStorage.getItem('lt') === 'true' ? 'false' : 'true');
            }
            updateAccessibilityStyles();
        }

        // Uruchom przy starcie, aby zapamiętać ustawienia
        document.addEventListener('DOMContentLoaded', updateAccessibilityStyles);
    </script>
</body>
</html>