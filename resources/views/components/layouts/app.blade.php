<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
    x-data="{ theme: localStorage.getItem('theme') || 'light' }" 
    x-init="$watch('theme', val => localStorage.setItem('theme', val))"
    :data-theme="theme">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'QuizArena') }} - Gamified Learning</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Rajdhani:wght@300;400;500;600;700&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-200 font-sans selection:bg-cyan-500/30 selection:text-cyan-200 overflow-x-hidden transition-colors duration-300">
    <!-- Cyber Background Elements -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden hidden dark:block">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-cyan-500/10 blur-[120px]"></div>
        <div class="absolute top-[40%] -right-[10%] w-[50%] h-[50%] rounded-full bg-fuchsia-500/10 blur-[120px]"></div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay"></div>
        <div class="absolute inset-0 bg-grid-slate-900/[0.04] bg-[bottom_1px_center] [mask-image:linear-gradient(to_bottom,transparent,black)]"></div>
    </div>

    <div class="relative z-10 flex flex-col min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white/80 dark:bg-slate-900/60 backdrop-blur-md sticky top-0 z-50 px-4 py-3 mb-8 border-b border-slate-200 dark:border-white/10 dark:cyber-glass transition-all duration-300">
            <div class="container mx-auto flex items-center justify-between">
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-cyan-600 dark:bg-cyan-500 rounded-lg flex items-center justify-center shadow-sm dark:shadow-[0_0_15px_rgba(6,182,212,0.5)] group-hover:shadow-md dark:group-hover:shadow-[0_0_25px_rgba(6,182,212,0.8)] transition-all duration-300">
                        <span class="font-display font-black text-xl text-white dark:text-slate-950">Q</span>
                    </div>
                    <span class="font-display font-bold text-2xl tracking-tighter text-slate-900 dark:neon-text-cyan dark:text-white">QUIZ<span class="text-fuchsia-600 dark:text-fuchsia-500 dark:neon-text-fuchsia">ARENA</span></span>
                </a>

                <div class="hidden md:flex items-center gap-8 font-display font-medium uppercase tracking-widest text-sm text-slate-600 dark:text-slate-200">
                    <a href="{{ auth()->check() ? route('dashboard') : '#modes' }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">Games</a>
                    <a href="{{ route('leaderboard') }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors {{ request()->routeIs('leaderboard') ? 'text-cyan-600 dark:text-cyan-400' : '' }}">Leaderboard</a>
                    <a href="{{ route('dashboard') }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors {{ request()->routeIs('dashboard') ? 'text-cyan-600 dark:text-cyan-400' : '' }}">Arena</a>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Theme Toggle -->
                    <button @click="theme = (theme === 'light' ? 'dark' : 'light')" class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" title="Toggle Theme">
                        <svg x-show="theme === 'dark'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.364 17.636l-.707.707M6.364 6.364l.707.707m11.314 11.314l.707.707M12 5a7 7 0 100 14 7 7 0 000-14z" />
                        </svg>
                        <svg x-show="theme === 'light'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost btn-sm font-display text-cyan-600 dark:text-cyan-400">Admin_Panel</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm font-display text-cyan-600 dark:text-cyan-400">Terminal</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost btn-sm font-display text-slate-600 dark:text-slate-200">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm font-display shadow-sm dark:shadow-[0_0_15px_rgba(6,182,212,0.5)] border-none bg-cyan-600 dark:bg-cyan-500 text-white dark:text-slate-950 hover:bg-cyan-500 dark:hover:bg-cyan-400">Join Arena</a>
                    @endauth
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
                            <span class="font-display font-bold text-lg tracking-tighter text-slate-900 dark:text-white uppercase">QuizArena</span>
                        </div>
                        <p class="text-[10px] font-mono text-slate-400 dark:text-slate-600 uppercase tracking-widest">Neural_Learning_Grid // v1.0.0</p>
                    </div>

                    <div class="flex items-center gap-8 text-[10px] font-display uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">
                        <a href="#" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">Documentation</a>
                        <a href="#" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">Privacy_Protocol</a>
                        <a href="#" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">System_Status</a>
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
