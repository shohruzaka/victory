<div class="max-w-7xl mx-auto space-y-12 animate-reveal">
    <!-- Back Button -->
    <div>
        <a href="{{ route('leaderboard') }}" class="inline-flex items-center gap-2 text-[10px] font-mono text-slate-500 hover:text-cyan-600 transition-colors uppercase tracking-widest font-bold">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Return_to_Leaderboard
        </a>
    </div>

    <!-- Player Profile Header -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 cyber-glass p-8 flex flex-col md:flex-row items-center gap-8 border-l-4 border-cyan-600 dark:border-cyan-500 transition-all duration-300">
            <div class="relative">
                <div class="w-24 h-24 rounded-full border-2 border-cyan-600 dark:border-cyan-500 overflow-hidden shadow-sm dark:shadow-[0_0_20px_rgba(6,182,212,0.4)]">
                    <img src="{{ $user->avatar_url }}" class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-2 -right-2 bg-white dark:bg-slate-950 border border-cyan-600/30 dark:border-cyan-500/50 px-2 py-0.5 rounded text-[10px] font-mono text-cyan-700 dark:text-cyan-400 shadow-sm">
                    LVL {{ $user->level }}
                </div>
            </div>
            
            <div class="flex-grow text-center md:text-left space-y-2">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <h2 class="font-display text-2xl font-black uppercase tracking-widest text-slate-900 dark:text-white">
                        {{ $user->name }}
                    </h2>
                    @if(auth()->id() == $user->id)
                        <span class="text-[9px] font-mono bg-cyan-600/10 text-cyan-600 dark:text-cyan-400 px-3 py-1 border border-cyan-600/20 uppercase font-bold tracking-widest italic">Identity_Verified</span>
                    @endif
                </div>
                <div class="flex items-center justify-center md:justify-start gap-4">
                    <span class="badge badge-outline border-fuchsia-600/50 dark:border-fuchsia-500/50 text-fuchsia-700 dark:text-fuchsia-400 font-display text-[10px] uppercase tracking-tighter italic">Rank: {{ $user->rank }}</span>
                    <span class="text-[10px] font-mono text-slate-500 uppercase tracking-widest">ID: #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                    @if($user->group_name)
                        <span class="text-[10px] font-mono text-cyan-700/60 dark:text-cyan-500/60 uppercase tracking-widest">Node: {{ $user->group_name }}</span>
                    @endif
                </div>
                
                <!-- XP Bar -->
                <div class="mt-6 space-y-2">
                    <div class="flex justify-between text-[10px] font-mono uppercase tracking-widest">
                        <span class="text-slate-500 dark:text-slate-400">Experience Points</span>
                        <span class="text-cyan-700 dark:text-cyan-400 font-bold">{{ $user->xp }} / {{ $user->level * 1000 }} XP</span>
                    </div>
                    <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-900 rounded-full overflow-hidden border border-slate-200 dark:border-white/5">
                        <div class="h-full bg-gradient-to-r from-cyan-600 to-cyan-500 dark:from-cyan-600 dark:to-cyan-400 shadow-sm dark:shadow-[0_0_10px_rgba(6,182,212,0.5)]" style="width: {{ ($user->xp / ($user->level * 1000)) * 100 }}%"></div>
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
                </div>
            @endforeach
        </div>
    </section>

    <!-- Recent History Table -->
    <section class="space-y-6">
        <div class="flex items-center justify-between">
            <h3 class="font-display text-sm font-bold uppercase tracking-[0.3em] text-slate-800 dark:text-white">Neural <span class="text-fuchsia-600 dark:text-fuchsia-500">History</span></h3>
        </div>
        
        <div class="cyber-glass-light overflow-hidden transition-all duration-300">
            <table class="w-full text-left">
                <thead class="bg-slate-50 dark:bg-white/5 border-b border-slate-200 dark:border-white/10 font-display uppercase text-[9px] tracking-[0.2em] text-slate-500 dark:text-slate-400">
                    <tr>
                        <th class="p-4">Arena_Mode</th>
                        <th class="p-4">Accuracy / Opponent</th>
                        <th class="p-4">Result</th>
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
                            <td class="p-4 font-bold italic uppercase">
                                @if($log->is_draw)
                                    <span class="text-amber-600 dark:text-amber-400">Draw</span>
                                @elseif($log->is_victory)
                                    <span class="text-emerald-600 dark:text-emerald-400">Victory</span>
                                @else
                                    <span class="text-red-600 dark:text-red-400">Defeat</span>
                                @endif
                            </td>
                            <td class="p-4 text-slate-500 font-mono">{{ $log->created_at->format('Y.m.d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-12 text-center">
                                <p class="text-[10px] font-mono text-slate-500 dark:text-slate-600 uppercase tracking-widest italic">No neural records found for this entity</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
