<x-layouts.app>
    <div class="space-y-24">
        <!-- Hero Section -->
        <section class="relative py-20 overflow-hidden">
            <div class="flex flex-col items-center text-center space-y-8 animate-reveal">
                <div class="inline-block px-4 py-1 rounded-full border border-cyan-200 dark:border-cyan-500/30 bg-cyan-50 dark:bg-cyan-500/5 text-cyan-600 dark:text-cyan-400 font-display text-xs tracking-[0.3em] uppercase">
                    System Online // Version 1.0.0
                </div>
                
                <h1 class="font-display font-black text-6xl md:text-8xl tracking-tighter leading-none">
                    <span class="block text-slate-900 dark:text-white">LEVEL UP YOUR</span>
                    <span class="block text-cyan-600 dark:neon-text-cyan dark:text-cyan-400 italic">KNOWLEDGE</span>
                </h1>
                
                <p class="max-w-2xl text-lg text-slate-600 dark:text-slate-400 font-light leading-relaxed">
                    Enter the ultimate gamified learning arena. Master C++, OOP, and Algorithms through high-stakes duels and survival challenges.
                </p>

                <div class="flex flex-wrap items-center justify-center gap-6 pt-4">
                    <a href="{{ auth()->check() ? route('dashboard') : route('register') }}" class="btn btn-lg px-12 rounded-none border-2 border-cyan-600 dark:border-cyan-400 bg-cyan-600 dark:bg-cyan-400 text-white dark:text-slate-950 hover:bg-transparent hover:text-cyan-600 dark:hover:text-cyan-400 hover:border-cyan-600 dark:hover:border-cyan-400 transition-all duration-300 font-display uppercase tracking-[0.2em] shadow-md dark:shadow-[0_0_30px_rgba(34,211,238,0.4)]">
                        Enter Arena
                    </a>
                    <a href="#modes" class="btn btn-lg px-12 rounded-none border-2 border-slate-200 dark:border-white/20 bg-transparent text-slate-600 dark:text-white hover:border-slate-900 dark:hover:border-white transition-all duration-300 font-display uppercase tracking-[0.2em]">
                        Select Mode
                    </a>
                </div>
            </div>
            
            <!-- Decorative Elements -->
            <div class="absolute top-1/2 left-0 w-64 h-[1px] bg-gradient-to-r from-transparent via-cyan-500/50 to-transparent rotate-45 hidden dark:block"></div>
            <div class="absolute bottom-1/4 right-0 w-96 h-[1px] bg-gradient-to-r from-transparent via-fuchsia-500/50 to-transparent -rotate-12 hidden dark:block"></div>
        </section>

        <!-- Game Modes Grid -->
        <section id="modes">
            <div class="flex flex-col items-center mb-12 space-y-4">
                <h2 class="font-display text-4xl font-bold uppercase tracking-widest text-slate-900 dark:text-white">Select <span class="text-cyan-600 dark:text-cyan-400">Mode</span></h2>
                <div class="h-1 w-24 bg-gradient-to-r from-cyan-600 to-fuchsia-600 dark:from-cyan-500 dark:to-fuchsia-500"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Classic -->
                <a href="{{ route('arena.setup', 'classic') }}" class="bg-white dark:cyber-glass p-6 border border-slate-200 dark:border-white/10 shadow-sm group hover:border-cyan-600 dark:hover:neon-border-cyan transition-all duration-500 cursor-pointer block">
                    <div class="w-12 h-12 mb-6 rounded bg-slate-100 dark:bg-slate-800 flex items-center justify-center border border-slate-200 dark:border-white/10 group-hover:bg-cyan-600 dark:group-hover:bg-cyan-500 group-hover:text-white dark:group-hover:text-slate-950 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-xl mb-2 text-slate-900 dark:text-white uppercase tracking-wider">Classic</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mb-4">Master core concepts at your own pace. No timers, just pure learning.</p>
                    <div class="text-[10px] font-mono text-cyan-600/50 dark:text-cyan-500/50 uppercase">Subsystem: Learning_Base</div>
                </a>

                <!-- Speed Run -->
                <a href="{{ route('arena.setup', 'speedrun') }}" class="bg-white dark:cyber-glass p-6 border border-slate-200 dark:border-white/10 shadow-sm group hover:border-fuchsia-600 dark:hover:neon-border-magenta transition-all duration-500 cursor-pointer block">
                    <div class="w-12 h-12 mb-6 rounded bg-slate-100 dark:bg-slate-800 flex items-center justify-center border border-slate-200 dark:border-white/10 group-hover:bg-fuchsia-600 dark:group-hover:bg-fuchsia-500 group-hover:text-white dark:group-hover:text-slate-950 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-xl mb-2 text-slate-900 dark:text-white uppercase tracking-wider">Speed Run</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mb-4">Race against the clock. Accuracy meets velocity for maximum bonus XP.</p>
                    <div class="text-[10px] font-mono text-fuchsia-600/50 dark:text-fuchsia-500/50 uppercase">Subsystem: Neural_Velocity</div>
                </a>

                <!-- Survival -->
                <a href="{{ route('arena.setup', 'survival') }}" class="bg-white dark:cyber-glass p-6 border border-slate-200 dark:border-red-500/20 shadow-sm group hover:border-red-600 dark:hover:border-red-500 transition-all duration-500 cursor-pointer block">
                    <div class="w-12 h-12 mb-6 rounded bg-slate-100 dark:bg-slate-800 flex items-center justify-center border border-slate-200 dark:border-white/10 group-hover:bg-red-600 dark:group-hover:bg-red-500 group-hover:text-white dark:group-hover:text-slate-950 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-xl mb-2 text-red-600 dark:text-red-400 uppercase tracking-wider">Survival</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mb-4">Zero margin for error. One mistake ends your run. How long can you last?</p>
                    <div class="text-[10px] font-mono text-red-600/50 dark:text-red-500/50 uppercase">Subsystem: Integrity_Check</div>
                </a>

                <!-- Duel -->
                <a href="{{ route('arena.duel.lobby') }}" class="bg-white dark:cyber-glass p-6 border border-slate-200 dark:border-white/10 shadow-sm group hover:border-cyan-600 dark:hover:neon-border-cyan transition-all duration-500 cursor-pointer block">
                    <div class="w-12 h-12 mb-6 rounded bg-slate-100 dark:bg-slate-800 flex items-center justify-center border border-slate-200 dark:border-white/10 group-hover:bg-cyan-600 dark:group-hover:bg-cyan-500 group-hover:text-white dark:group-hover:text-slate-950 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-xl mb-2 text-slate-900 dark:text-white uppercase tracking-wider">Duel (PvP)</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mb-4">Live 1v1 battle. Real-time synchronization. Outsmart your opponent.</p>
                    <div class="text-[10px] font-mono text-cyan-600/50 dark:text-cyan-500/50 uppercase tracking-widest animate-pulse">Status: Real-time_Active</div>
                </a>
            </div>
        </section>

        <!-- Stats/Leaderboard Preview -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-12 pt-12">
            <div class="lg:col-span-2 space-y-8">
                <div class="flex items-center justify-between">
                    <h2 class="font-display text-3xl font-bold uppercase tracking-widest text-slate-900 dark:text-white">Global <span class="text-fuchsia-600 dark:text-fuchsia-500">Leaderboard</span></h2>
                    <a href="{{ route('leaderboard') }}" class="text-xs font-mono text-cyan-600 dark:text-cyan-400 hover:underline uppercase">View Full Rankings</a>
                </div>
                
                <div class="bg-white dark:cyber-glass-light border border-slate-200 dark:border-white/10 shadow-sm overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 dark:bg-white/5 border-b border-slate-200 dark:border-white/10 font-display uppercase text-xs tracking-widest text-slate-500 dark:text-slate-400">
                            <tr>
                                <th class="p-4">Rank</th>
                                <th class="p-4">Talaba</th>
                                <th class="p-4">Level</th>
                                <th class="p-4">XP</th>
                            </tr>
                        </thead>
                        <tbody class="font-sans text-sm">
                            @forelse($topUsers as $index => $user)
                                <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-4 font-display font-black {{ $index === 0 ? 'text-cyan-600 dark:text-cyan-400' : 'text-slate-400' }}">0{{ $index + 1 }}</td>
                                    <td class="p-4">
                                        <a href="{{ route('profile.public', $user->id) }}" class="flex items-center gap-3 group/item">
                                            <div class="w-8 h-8 rounded-full border {{ $index === 0 ? 'border-cyan-600 dark:border-cyan-500' : 'border-slate-200 dark:border-white/10' }} overflow-hidden">
                                                <img src="{{ $user->avatar_url }}" class="w-full h-full object-cover">
                                            </div>
                                            <span class="font-bold text-slate-900 dark:text-white group-hover/item:text-cyan-600 dark:group-hover/item:text-cyan-400 transition-colors uppercase tracking-tight">{{ $user->name }}</span>
                                        </a>
                                    </td>
                                    <td class="p-4"><span class="badge badge-outline border-slate-300 dark:border-white/10 text-slate-500 dark:text-slate-400 text-[10px] uppercase">LVL {{ $user->level }}</span></td>
                                    <td class="p-4 font-mono text-cyan-600 dark:text-cyan-400">{{ number_format($user->xp) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-12 text-center text-slate-500 font-mono uppercase text-xs">No neural links established yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-8">
                <h2 class="font-display text-3xl font-bold uppercase tracking-widest text-slate-900 dark:text-white">Live <span class="text-cyan-600 dark:text-cyan-400">Activity</span></h2>
                <div class="space-y-4">
                    @forelse($activities as $activity)
                        <div class="bg-white dark:cyber-glass-light p-4 flex gap-4 items-start border-l-2 {{ $activity->color }} shadow-sm">
                            <div class="w-2 h-2 rounded-full {{ $activity->color }} mt-1 animate-pulse"></div>
                            <div>
                                <p class="text-sm text-slate-900 dark:text-white font-medium">{{ $activity->user_name }} <span class="text-slate-500 dark:text-slate-400">{{ $activity->message }}</span></p>
                                <p class="text-[10px] font-mono text-slate-400 dark:text-slate-500 uppercase">{{ $activity->time->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center border border-dashed border-slate-200 dark:border-white/10">
                            <p class="text-[10px] font-mono text-slate-500 uppercase">Silence in the grid...</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</x-layouts.app>
