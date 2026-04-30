<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
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
<body class="bg-slate-950 text-slate-200 font-sans selection:bg-cyan-500/30 selection:text-cyan-200 overflow-x-hidden">
    <!-- Cyber Background Elements -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-cyan-500/10 blur-[120px]"></div>
        <div class="absolute top-[40%] -right-[10%] w-[50%] h-[50%] rounded-full bg-fuchsia-500/10 blur-[120px]"></div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay"></div>
        <div class="absolute inset-0 bg-grid-slate-900/[0.04] bg-[bottom_1px_center] [mask-image:linear-gradient(to_bottom,transparent,black)]"></div>
    </div>

    <div class="relative z-10 flex flex-col min-h-screen">
        <!-- Navigation -->
        <nav class="cyber-glass sticky top-0 z-50 px-4 py-3 mb-8 border-b border-white/10">
            <div class="container mx-auto flex items-center justify-between">
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-cyan-500 rounded-lg flex items-center justify-center shadow-[0_0_15px_rgba(6,182,212,0.5)] group-hover:shadow-[0_0_25px_rgba(6,182,212,0.8)] transition-all duration-300">
                        <span class="font-display font-black text-xl text-slate-950">Q</span>
                    </div>
                    <span class="font-display font-bold text-2xl tracking-tighter neon-text-cyan">QUIZ<span class="text-fuchsia-500 neon-text-fuchsia">ARENA</span></span>
                </a>

                <div class="hidden md:flex items-center gap-8 font-display font-medium uppercase tracking-widest text-sm">
                    <a href="#" class="hover:text-cyan-400 transition-colors">Games</a>
                    <a href="#" class="hover:text-cyan-400 transition-colors">Leaderboard</a>
                    <a href="#" class="hover:text-cyan-400 transition-colors">Arena</a>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost btn-sm font-display text-cyan-400">Admin_Panel</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm font-display text-cyan-400">Terminal</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost btn-sm font-display">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm font-display shadow-[0_0_15px_rgba(6,182,212,0.5)] border-none bg-cyan-500 text-slate-950 hover:bg-cyan-400">Join Arena</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 pb-20">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="py-12 border-t border-white/5 bg-slate-950/50">
            <div class="container mx-auto px-4 text-center">
                <p class="font-display text-sm text-slate-500 tracking-widest uppercase">
                    &copy; {{ date('Y') }} QuizArena System. All rights reserved.
                </p>
            </div>
        </footer>
    </div>

    @livewireScripts
</body>
</html>
