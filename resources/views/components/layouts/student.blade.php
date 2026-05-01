<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
    x-data="{ theme: localStorage.getItem('theme') || 'light' }" 
    x-init="$watch('theme', val => localStorage.setItem('theme', val))"
    :data-theme="theme">
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
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-200 font-sans selection:bg-cyan-500/30 selection:text-cyan-200 overflow-x-hidden transition-colors duration-300">
    <!-- Cyber Background -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden opacity-40 hidden dark:block">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-cyan-500/10 blur-[120px]"></div>
        <div class="absolute top-[40%] -right-[10%] w-[50%] h-[50%] rounded-full bg-fuchsia-500/10 blur-[120px]"></div>
        <div class="absolute inset-0 bg-grid-slate-900/[0.04] bg-[bottom_1px_center]"></div>
    </div>

    <div class="relative z-10 flex flex-col min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white/80 dark:bg-slate-900/60 backdrop-blur-md sticky top-0 z-50 px-6 py-4 mb-8 border-b border-slate-200 dark:border-white/10 dark:cyber-glass transition-all duration-300">
            <div class="container mx-auto flex items-center justify-between">
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 bg-cyan-600 dark:bg-cyan-500 rounded flex items-center justify-center shadow-sm dark:shadow-[0_0_15px_rgba(6,182,212,0.5)]">
                        <span class="font-display font-black text-lg text-white dark:text-slate-950">Q</span>
                    </div>
                    <span class="font-display font-bold text-xl tracking-tighter text-slate-900 dark:neon-text-cyan dark:text-white uppercase">Terminal</span>
                </a>

                <div class="hidden md:flex items-center gap-8 font-display font-medium uppercase tracking-widest text-[10px] text-slate-600 dark:text-slate-200">
                    <a href="{{ route('dashboard') }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors {{ request()->routeIs('dashboard') ? 'text-cyan-600 dark:text-cyan-400' : '' }}">Main_Arena</a>
                    <a href="{{ route('leaderboard') }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors {{ request()->routeIs('leaderboard') ? 'text-cyan-600 dark:text-cyan-400' : '' }}">Leaderboard</a>
                    <a href="{{ route('settings') }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors {{ request()->routeIs('settings') ? 'text-cyan-600 dark:text-cyan-400' : '' }}">Settings</a>
                </div>

                <div class="flex items-center gap-6">
                    <!-- Theme Toggle -->
                    <button @click="theme = (theme === 'light' ? 'dark' : 'light')" class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" title="Toggle Theme">
                        <svg x-show="theme === 'dark'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.364 17.636l-.707.707M6.364 6.364l.707.707m11.314 11.314l.707.707M12 5a7 7 0 100 14 7 7 0 000-14z" />
                        </svg>
                        <svg x-show="theme === 'light'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-mono text-slate-400 dark:text-slate-500 uppercase tracking-tighter">Identity_Confirmed</span>
                        <span class="text-xs font-display font-bold text-slate-900 dark:text-white uppercase">{{ auth()->user()->name }}</span>
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

        <!-- Footer -->
        <footer class="mt-auto py-12 border-t border-slate-200 dark:border-white/5 transition-colors duration-300">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="flex flex-col items-center md:items-start gap-2">
                        <div class="flex items-center gap-2 opacity-80">
                            <div class="w-6 h-6 bg-slate-900 dark:bg-cyan-500 rounded flex items-center justify-center">
                                <span class="font-display font-black text-xs text-white dark:text-slate-950">Q</span>
                            </div>
                            <span class="font-display font-bold text-lg tracking-tighter text-slate-900 dark:text-white uppercase tracking-tight">Terminal_Link</span>
                        </div>
                        <p class="text-[10px] font-mono text-slate-400 dark:text-slate-600 uppercase tracking-widest">Neural_Learning_Grid // v1.0.0</p>
                    </div>

                    <div class="flex items-center gap-8 text-[10px] font-display uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">
                        <a href="#" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">Neural_Docs</a>
                        <a href="#" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">Privacy_Shield</a>
                        <a href="#" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">Grid_Status</a>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="h-1 w-12 bg-slate-200 dark:bg-slate-800"></div>
                        <p class="text-[10px] font-mono text-slate-400 dark:text-slate-600 uppercase">
                            &copy; {{ date('Y') }} QuizArena_Systems
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @livewireScripts
</body>
</html>
