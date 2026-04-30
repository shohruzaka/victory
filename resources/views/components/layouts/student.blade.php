<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'QuizArena') }} - Student Terminal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Rajdhani:wght@300;400;500;600;700&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-950 text-slate-200 font-sans selection:bg-cyan-500/30 selection:text-cyan-200 overflow-x-hidden">
    <!-- Cyber Background -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden opacity-40">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-cyan-500/10 blur-[120px]"></div>
        <div class="absolute top-[40%] -right-[10%] w-[50%] h-[50%] rounded-full bg-fuchsia-500/10 blur-[120px]"></div>
        <div class="absolute inset-0 bg-grid-slate-900/[0.04] bg-[bottom_1px_center]"></div>
    </div>

    <div class="relative z-10 flex flex-col min-h-screen">
        <!-- Navigation -->
        <nav class="cyber-glass sticky top-0 z-50 px-6 py-4 mb-8 border-b border-white/10">
            <div class="container mx-auto flex items-center justify-between">
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 bg-cyan-500 rounded flex items-center justify-center shadow-[0_0_15px_rgba(6,182,212,0.5)]">
                        <span class="font-display font-black text-lg text-slate-950">Q</span>
                    </div>
                    <span class="font-display font-bold text-xl tracking-tighter neon-text-cyan uppercase">Terminal</span>
                </a>

                <div class="hidden md:flex items-center gap-8 font-display font-medium uppercase tracking-widest text-[10px]">
                    <a href="{{ route('dashboard') }}" class="hover:text-cyan-400 transition-colors">Main_Arena</a>
                    <a href="#" class="hover:text-cyan-400 transition-colors">History</a>
                    <a href="{{ route('leaderboard') }}" class="hover:text-cyan-400 transition-colors {{ request()->routeIs('leaderboard') ? 'text-cyan-400' : '' }}">Leaderboard</a>
                </div>

                <div class="flex items-center gap-6">
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-mono text-slate-500 uppercase tracking-tighter">Identity_Confirmed</span>
                        <span class="text-xs font-display font-bold text-white uppercase">{{ auth()->user()->name }}</span>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-2 rounded border border-white/5 hover:border-red-500/50 hover:text-red-500 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 pb-20">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
