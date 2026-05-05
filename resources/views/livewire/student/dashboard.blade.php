<div class="space-y-12 animate-reveal">
    <!-- Player Profile Header -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 cyber-glass p-8 flex flex-col md:flex-row items-center gap-8 border-l-4 border-cyan-600 dark:border-cyan-500 transition-all duration-300">
            <div class="relative">
                <div class="w-24 h-24 rounded-full border-2 border-cyan-600 dark:border-cyan-500 overflow-hidden shadow-sm dark:shadow-[0_0_20px_rgba(6,182,212,0.4)]">
                    <img src="{{ auth()->user()->avatar_url }}" class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-2 -right-2 bg-white dark:bg-slate-950 border border-cyan-600/30 dark:border-cyan-500/50 px-2 py-0.5 rounded text-[10px] font-mono text-cyan-700 dark:text-cyan-400 shadow-sm">
                    LVL {{ auth()->user()->level }}
                </div>
            </div>
            
            <div class="flex-grow text-center md:text-left space-y-2">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <h2 class="font-display text-2xl font-black uppercase tracking-widest text-slate-900 dark:text-white">
                        {{ auth()->user()->name }}
                    </h2>
                    <a href="{{ route('settings') }}" class="btn btn-xs btn-outline border-cyan-600/50 dark:border-cyan-500/50 text-cyan-700 dark:text-cyan-400 hover:bg-cyan-600 dark:hover:bg-cyan-500 hover:text-white dark:hover:text-slate-950 rounded-none font-display uppercase tracking-widest text-[9px]">
                        Edit_Profile
                    </a>
                </div>
                <div class="flex items-center justify-center md:justify-start gap-4">
                    <span class="badge badge-outline border-fuchsia-600/50 dark:border-fuchsia-500/50 text-fuchsia-700 dark:text-fuchsia-400 font-display text-[10px] uppercase tracking-tighter italic">Rank: {{ auth()->user()->rank }}</span>
                    <span class="text-[10px] font-mono text-slate-500 uppercase tracking-widest">ID: #{{ str_pad(auth()->id(), 5, '0', STR_PAD_LEFT) }}</span>
                    @if(auth()->user()->group_name)
                        <span class="text-[10px] font-mono text-cyan-700/60 dark:text-cyan-500/60 uppercase tracking-widest">Node: {{ auth()->user()->group_name }}</span>
                    @endif
                </div>
                
                <!-- XP Bar -->
                <div class="mt-6 space-y-2">
                    <div class="flex justify-between text-[10px] font-mono uppercase tracking-widest">
                        <span class="text-slate-500 dark:text-slate-400">Experience Points</span>
                        <span class="text-cyan-700 dark:text-cyan-400 font-bold">{{ auth()->user()->xp }} / {{ auth()->user()->level * 1000 }} XP</span>
                    </div>
                    <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-900 rounded-full overflow-hidden border border-slate-200 dark:border-white/5">
                        <div class="h-full bg-gradient-to-r from-cyan-600 to-cyan-500 dark:from-cyan-600 dark:to-cyan-400 shadow-sm dark:shadow-[0_0_10px_rgba(6,182,212,0.5)]" style="width: {{ (auth()->user()->xp / (auth()->user()->level * 1000)) * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cyber-glass p-8 flex flex-col justify-center items-center text-center space-y-4 border-t-4 border-fuchsia-600 dark:border-fuchsia-500 transition-all duration-300">
            <p class="text-[10px] font-mono text-slate-500 uppercase tracking-[0.2em]">Total_Battles</p>
            <span class="text-4xl font-display font-black text-slate-900 dark:text-white">{{ $totalBattles }}</span>
            <p class="text-[10px] font-mono text-fuchsia-600 dark:text-fuchsia-400 font-bold uppercase tracking-widest">Win Rate: {{ $winRate }}%</p>
        </div>
    </section>

    <!-- Achievements Section -->
    <section class="space-y-6">
        <div class="flex items-center gap-4">
            <h3 class="font-display text-sm font-bold uppercase tracking-[0.3em] text-slate-800 dark:text-white">Neural <span class="text-amber-600 dark:text-amber-400">Achievements</span></h3>
            <div class="h-px flex-grow bg-gradient-to-r from-amber-600/30 dark:from-amber-500/50 to-transparent"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($allAchievements as $achievement)
                @php
                    $isUnlocked = in_array($achievement->id, $userAchievements);
                @endphp
                <div class="cyber-glass p-4 text-center group transition-all duration-500 {{ $isUnlocked ? 'border-amber-600/50 dark:border-amber-500/50 shadow-[0_0_15px_rgba(245,158,11,0.1)]' : 'opacity-40 grayscale sepia-[.5]' }}">
                    <div class="w-12 h-12 mx-auto mb-3 flex items-center justify-center rounded-full border-2 {{ $isUnlocked ? 'border-amber-600 dark:border-amber-400 text-amber-600 dark:text-amber-400 animate-pulse' : 'border-slate-300 dark:border-white/10 text-slate-400' }}">
                        @if($achievement->icon === 'heroicon-o-fire')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.99 7.99 0 0121 13a8.003 8.003 0 01-3.343 5.657z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" /></svg>
                        @elseif($achievement->icon === 'heroicon-o-trophy')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        @elseif($achievement->icon === 'heroicon-o-shield-check')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        @elseif($achievement->icon === 'heroicon-o-bolt')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        @elseif($achievement->icon === 'heroicon-o-academic-cap')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.02 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" /></svg>
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z" /></svg>
                        @endif
                    </div>
                    <p class="text-[10px] font-display font-bold uppercase tracking-widest text-slate-900 dark:text-white mb-1">{{ $achievement->name }}</p>
                    <p class="text-[8px] font-mono text-slate-500 leading-tight">{{ $achievement->description }}</p>
                    @if($isUnlocked)
                        <div class="mt-2 inline-block px-2 py-0.5 rounded bg-amber-600/10 border border-amber-600/30 text-[7px] font-mono text-amber-700 dark:text-amber-400 uppercase font-bold tracking-tighter">Unlocked</div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <!-- Game Modes Selection -->
    <section class="space-y-8">
        <div class="flex items-center gap-4">
            <h3 class="font-display text-sm font-bold uppercase tracking-[0.3em] text-slate-800 dark:text-white">Initialize <span class="text-cyan-600 dark:text-cyan-400">Session</span></h3>
            <div class="h-px flex-grow bg-gradient-to-r from-cyan-600/30 dark:from-cyan-500/50 to-transparent"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Classic Mode -->
            <div class="group relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-500 dark:to-blue-500 rounded-lg blur opacity-10 dark:opacity-20 group-hover:opacity-30 dark:group-hover:opacity-60 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative cyber-glass p-6 flex flex-col h-full border border-slate-200 dark:border-white/5">
                    <div class="mb-4 text-cyan-600 dark:text-cyan-400 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    <h4 class="font-display text-base font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-2">Classic</h4>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-relaxed mb-6 font-medium">Vaqt cheklovisiz, mavzular bo'yicha savollar to'plami.</p>
                    <div class="mt-auto">
                        <a href="{{ route('arena.setup', 'classic') }}" class="btn btn-xs btn-primary w-full rounded-none font-display uppercase tracking-widest text-[9px] bg-cyan-600 dark:bg-cyan-500 border-none text-white dark:text-slate-950 hover:bg-cyan-500 dark:hover:bg-cyan-400">Launch_Core</a>
                    </div>
                </div>
            </div>

            <!-- Speed Run -->
            <div class="group relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-fuchsia-600 to-purple-600 dark:from-fuchsia-500 dark:to-purple-600 rounded-lg blur opacity-10 dark:opacity-20 group-hover:opacity-30 dark:group-hover:opacity-60 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative cyber-glass p-6 flex flex-col h-full border border-slate-200 dark:border-white/5">
                    <div class="mb-4 text-fuchsia-600 dark:text-fuchsia-400 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <h4 class="font-display text-base font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-2">Speed Run</h4>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-relaxed mb-6 font-medium">Tezkor qaror qabul qilish! Har bir savol uchun 15s vaqt.</p>
                    <div class="mt-auto">
                        <a href="{{ route('arena.setup', 'speedrun') }}" class="btn btn-xs btn-secondary w-full rounded-none font-display uppercase tracking-widest text-[9px] bg-fuchsia-600 dark:bg-fuchsia-500 border-none text-white dark:text-slate-950 hover:bg-fuchsia-500 dark:hover:bg-fuchsia-400">Sync_Velocity</a>
                    </div>
                </div>
            </div>

            <!-- Survival -->
            <div class="group relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-red-600 to-orange-600 dark:from-red-500 dark:to-orange-600 rounded-lg blur opacity-10 dark:opacity-20 group-hover:opacity-30 dark:group-hover:opacity-60 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative cyber-glass p-6 flex flex-col h-full border border-slate-200 dark:border-white/5">
                    <div class="mb-4 text-red-600 dark:text-red-500 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                    </div>
                    <h4 class="font-display text-base font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-2">Survival</h4>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-relaxed mb-6 font-medium">Bitta xato — o'yin tugadi. Oxirigacha chidab bera olasizmi?</p>
                    <div class="mt-auto">
                        <a href="{{ route('arena.setup', 'survival') }}" class="btn btn-xs btn-error w-full rounded-none font-display uppercase tracking-widest text-[9px] bg-red-600 border-none text-white hover:bg-red-500">Integrity_Check</a>
                    </div>
                </div>
            </div>

            <!-- PvP Duel -->
            <div class="group relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-amber-600 to-yellow-600 dark:from-amber-500 dark:to-yellow-600 rounded-lg blur opacity-10 dark:opacity-20 group-hover:opacity-30 dark:group-hover:opacity-60 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative cyber-glass p-6 flex flex-col h-full border border-slate-200 dark:border-white/5">
                    <div class="mb-4 text-amber-600 dark:text-amber-500 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <h4 class="font-display text-base font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-2">PvP Duel</h4>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-relaxed mb-6 font-medium">Jonli 1v1 jang! Real vaqtda boshqa talabalar bilan bellashing.</p>
                    <div class="mt-auto">
                        <a href="{{ route('arena.duel.lobby') }}" class="btn btn-xs btn-warning w-full rounded-none font-display uppercase tracking-widest text-[9px] bg-amber-600 dark:bg-amber-500 border-none text-white dark:text-slate-950 hover:bg-amber-500 dark:hover:bg-amber-400">Join_Queue</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent History Table -->
    <section class="space-y-6">
        <div class="flex items-center justify-between">
            <h3 class="font-display text-sm font-bold uppercase tracking-[0.3em] text-slate-800 dark:text-white">Mission <span class="text-fuchsia-600 dark:text-fuchsia-500">Logs</span></h3>
            <a href="{{ route('arena.duel.history') }}" class="text-[10px] font-mono text-cyan-700 dark:text-cyan-400 hover:underline uppercase font-bold">View All History</a>
        </div>
        
        <div class="cyber-glass-light overflow-hidden transition-all duration-300">
            <table class="w-full text-left">
                <thead class="bg-slate-50 dark:bg-white/5 border-b border-slate-200 dark:border-white/10 font-display uppercase text-[9px] tracking-[0.2em] text-slate-500 dark:text-slate-400">
                    <tr>
                        <th class="p-4">Arena_Mode</th>
                        <th class="p-4">Accuracy / Opponent</th>
                        <th class="p-4">Result / XP</th>
                        <th class="p-4">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="font-sans text-xs">
                    @forelse($recentLogs as $log)
                        <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                            <td class="p-4 text-slate-900 dark:text-white font-medium uppercase tracking-tighter">
                                @if($log->type === 'duel')
                                    <span class="text-amber-600 dark:text-amber-500">PvP Duel</span>
                                @else
                                    {{ $log->mode }}
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <span class="text-cyan-700 dark:text-cyan-400 font-mono text-[10px] font-bold">{{ $log->score }} / {{ $log->total_questions }}</span>
                                    @if($log->opponent_name)
                                        <span class="text-[8px] text-slate-400 uppercase tracking-tighter">VS {{ $log->opponent_name }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <span class="font-bold italic uppercase">
                                        @if($log->is_draw)
                                            <span class="text-amber-600 dark:text-amber-400">Draw</span>
                                        @elseif($log->is_victory)
                                            <span class="text-emerald-600 dark:text-emerald-400">Victory</span>
                                        @else
                                            <span class="text-red-600 dark:text-red-400">Defeat</span>
                                        @endif
                                    </span>
                                    <span class="text-[10px] font-mono text-cyan-700 dark:text-cyan-400 font-bold">
                                        {{ $log->xp_earned > 0 ? '+' . $log->xp_earned : '0' }} XP
                                    </span>
                                </div>
                            </td>
                            <td class="p-4 text-slate-500 font-mono">{{ $log->created_at->format('m.d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-12 text-center">
                                <p class="text-[10px] font-mono text-slate-500 dark:text-slate-600 uppercase tracking-widest italic">No mission records found in the system</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

