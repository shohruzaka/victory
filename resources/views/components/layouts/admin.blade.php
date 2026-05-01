<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
    x-data="{ theme: localStorage.getItem('theme') || 'light' }" 
    x-init="$watch('theme', val => localStorage.setItem('theme', val))"
    :data-theme="theme">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - {{ config('app.name', 'QuizArena') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Rajdhani:wght@300;400;500;600;700&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-200 font-sans selection:bg-cyan-500/30 selection:text-cyan-200 overflow-x-hidden transition-colors duration-300">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:cyber-glass border-r border-slate-200 dark:border-white/10 flex flex-col fixed inset-y-0 z-50 transition-all duration-300">
            <div class="p-6">
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 bg-cyan-600 dark:bg-cyan-500 rounded flex items-center justify-center shadow-sm dark:shadow-[0_0_15px_rgba(6,182,212,0.5)]">
                        <span class="font-display font-black text-lg text-white dark:text-slate-950">Q</span>
                    </div>
                    <span class="font-display font-bold text-xl tracking-tighter text-slate-900 dark:neon-text-cyan dark:text-white">ADMIN<span class="text-fuchsia-600 dark:text-fuchsia-500 dark:neon-text-fuchsia">CORE</span></span>
                </a>
            </div>

            <nav class="flex-grow px-4 space-y-2 mt-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-3 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-cyan-600/10 dark:bg-cyan-500/10 text-cyan-700 dark:text-cyan-400 border border-cyan-600/20 dark:border-cyan-500/30' : 'hover:bg-slate-100 dark:hover:bg-white/5 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all' }} font-display uppercase tracking-widest text-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.subjects.index') }}" class="flex items-center gap-3 p-3 rounded {{ request()->routeIs('admin.subjects.*') ? 'bg-cyan-600/10 dark:bg-cyan-500/10 text-cyan-700 dark:text-cyan-400 border border-cyan-600/20 dark:border-cyan-500/30' : 'hover:bg-slate-100 dark:hover:bg-white/5 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all' }} font-display uppercase tracking-widest text-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    Fanlar & Mavzular
                </a>
                <a href="{{ route('admin.questions.index') }}" class="flex items-center gap-3 p-3 rounded {{ request()->routeIs('admin.questions.*') ? 'bg-cyan-600/10 dark:bg-cyan-500/10 text-cyan-700 dark:text-cyan-400 border border-cyan-600/20 dark:border-cyan-500/30' : 'hover:bg-slate-100 dark:hover:bg-white/5 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all' }} font-display uppercase tracking-widest text-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    Savollar
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 p-3 rounded {{ request()->routeIs('admin.users.*') ? 'bg-cyan-600/10 dark:bg-cyan-500/10 text-cyan-700 dark:text-cyan-400 border border-cyan-600/20 dark:border-cyan-500/30' : 'hover:bg-slate-100 dark:hover:bg-white/5 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all' }} font-display uppercase tracking-widest text-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    Talabalar
                </a>
            </nav>

            <div class="p-4 border-t border-slate-200 dark:border-white/5">
                <div class="flex items-center gap-3 p-2 bg-slate-50 dark:cyber-glass-light rounded border border-slate-200 dark:border-white/5">
                    <div class="w-8 h-8 rounded bg-fuchsia-600/10 dark:bg-fuchsia-500/20 border border-fuchsia-600/20 dark:border-fuchsia-500 flex items-center justify-center text-[10px] font-bold text-fuchsia-700 dark:text-fuchsia-400">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-500 truncate uppercase tracking-tighter">System Administrator</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Content Area -->
        <main class="flex-grow ml-64 p-8">
            <header class="flex justify-between items-center mb-10">
                <h1 class="font-display text-2xl font-black uppercase tracking-widest text-slate-900 dark:text-white">
                    <span class="text-cyan-600 dark:text-cyan-400 mr-2">//</span> Dashboard
                </h1>

                <div class="flex items-center gap-4">
                    <!-- Theme Toggle -->
                    <button @click="theme = (theme === 'light' ? 'dark' : 'light')" class="p-2 rounded-lg bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors shadow-sm" title="Toggle Theme">
                        <svg x-show="theme === 'dark'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.364 17.636l-.707.707M6.364 6.364l.707.707m11.314 11.314l.707.707M12 5a7 7 0 100 14 7 7 0 000-14z" />
                        </svg>
                        <svg x-show="theme === 'light'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-100 dark:bg-cyan-500/10 border border-cyan-600/20 dark:border-cyan-500/20">
                        <div class="w-2 h-2 rounded-full bg-cyan-600 dark:bg-cyan-500 animate-pulse"></div>
                        <span class="text-[10px] font-mono text-cyan-700 dark:text-cyan-400 uppercase tracking-widest">System Live</span>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm text-xs font-display text-slate-500 hover:text-red-400">Logout</button>
                    </form>
                </div>
            </header>

            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
