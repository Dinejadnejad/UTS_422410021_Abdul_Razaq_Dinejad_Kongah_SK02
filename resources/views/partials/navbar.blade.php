<nav class="bg-slate-900/90 border-b border-indigo-950 sticky top-0 z-30 backdrop-blur">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-indigo-600/20 border border-indigo-500/40 text-indigo-400 font-bold">
                    ✦
                </span>
                <div>
                    <a href="{{ route('observation-sessions.index') }}" class="text-base font-bold tracking-wide text-white">
                        DARK SKY OBSERVATORY
                    </a>
                    <p class="text-[11px] text-indigo-300">Manajemen Sesi Astronomi</p>
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-4 text-sm">
                <a href="{{ route('observation-sessions.index') }}"
                   class="px-3 py-2 rounded-lg transition {{ request()->routeIs('observation-sessions.*') ? 'bg-indigo-600 text-white font-medium' : 'text-slate-300 hover:bg-slate-800' }}">
                    Sesi Pengamatan
                </a>
                <a href="{{ route('target-objects.index') }}"
                   class="px-3 py-2 rounded-lg transition {{ request()->routeIs('target-objects.*') ? 'bg-indigo-600 text-white font-medium' : 'text-slate-300 hover:bg-slate-800' }}">
                    Objek Sasaran
                </a>
                <a href="{{ route('equipments.index') }}"
                   class="px-3 py-2 rounded-lg transition {{ request()->routeIs('equipments.*') ? 'bg-indigo-600 text-white font-medium' : 'text-slate-300 hover:bg-slate-800' }}">
                    Perlengkapan
                </a>
            </div>
        </div>
    </div>
</nav>