<div class="space-y-12 animate-reveal">
    <!-- Player Profile Header -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 cyber-glass p-8 flex flex-col md:flex-row items-center gap-8 border-l-4 border-cyan-500">
            <div class="relative">
                <div class="w-24 h-24 rounded-full bg-cyan-500/20 border-2 border-cyan-500 flex items-center justify-center shadow-[0_0_20px_rgba(6,182,212,0.4)]">
                    <span class="font-display font-black text-3xl text-cyan-400">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
                <div class="absolute -bottom-2 -right-2 bg-slate-950 border border-cyan-500/50 px-2 py-0.5 rounded text-[10px] font-mono text-cyan-400">
                    LVL {{ auth()->user()->level }}
                </div>
            </div>
            
            <div class="flex-grow text-center md:text-left space-y-2">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <h2 class="font-display text-2xl font-black uppercase tracking-widest text-white">
                        {{ auth()->user()->name }}
                    </h2>
                    <a href="{{ route('settings') }}" class="btn btn-xs btn-outline border-cyan-500/50 text-cyan-400 hover:bg-cyan-500 hover:text-slate-950 rounded-none font-display uppercase tracking-widest text-[9px]">
                        Edit_Profile
                    </a>
                </div>
                <div class="flex items-center justify-center md:justify-start gap-4">
                    <span class="badge badge-outline border-fuchsia-500/50 text-fuchsia-400 font-display text-[10px] uppercase tracking-tighter italic">Rank: {{ auth()->user()->rank }}</span>
                    <span class="text-[10px] font-mono text-slate-500 uppercase tracking-widest">ID: #{{ str_pad(auth()->id(), 5, '0', STR_PAD_LEFT) }}</span>
                    @if(auth()->user()->group_name)
                        <span class="text-[10px] font-mono text-cyan-500/60 uppercase tracking-widest">Node: {{ auth()->user()->group_name }}</span>
                    @endif
                </div>
                
                <!-- XP Bar -->
                <div class="mt-6 space-y-2">
                    <div class="flex justify-between text-[10px] font-mono uppercase tracking-widest">
                        <span class="text-slate-400">Experience Points</span>
                        <span class="text-cyan-400">{{ auth()->user()->xp }} / {{ auth()->user()->level * 1000 }} XP</span>
                    </div>
                    <div class="h-1.5 w-full bg-slate-900 rounded-full overflow-hidden border border-white/5">
                        <div class="h-full bg-gradient-to-r from-cyan-600 to-cyan-400 shadow-[0_0_10px_rgba(6,182,212,0.5)]" style="width: {{ (auth()->user()->xp / (auth()->user()->level * 1000)) * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cyber-glass p-8 flex flex-col justify-center items-center text-center space-y-4 border-t-4 border-fuchsia-500">
            <p class="text-[10px] font-mono text-slate-500 uppercase tracking-[0.2em]">Total_Battles</p>
            <span class="text-4xl font-display font-black text-white">{{ $totalBattles }}</span>
            <p class="text-[10px] font-mono text-fuchsia-400 uppercase tracking-widest">Win Rate: {{ $winRate }}%</p>
        </div>
    </section>

    <!-- Game Modes Selection -->
    <section class="space-y-8">
        <div class="flex items-center gap-4">
            <h3 class="font-display text-sm font-bold uppercase tracking-[0.3em] text-white">Initialize <span class="text-cyan-400">Session</span></h3>
            <div class="h-px flex-grow bg-gradient-to-r from-cyan-500/50 to-transparent"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Classic Mode -->
            <div class="group relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-lg blur opacity-20 group-hover:opacity-60 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative cyber-glass p-6 flex flex-col h-full border border-white/5">
                    <div class="mb-4 text-cyan-400 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    <h4 class="font-display text-base font-bold text-white uppercase tracking-wider mb-2">Classic</h4>
                    <p class="text-[10px] text-slate-400 leading-relaxed mb-6">Vaqt cheklovisiz, mavzular bo'yicha savollar to'plami.</p>
                    <div class="mt-auto">
                        <a href="{{ route('arena.setup', 'classic') }}" class="btn btn-xs btn-primary w-full rounded-none font-display uppercase tracking-widest text-[9px] bg-cyan-500 border-none text-slate-950 hover:bg-cyan-400">Launch_Core</a>
                    </div>
                </div>
            </div>

            <!-- Speed Run -->
            <div class="group relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-fuchsia-500 to-purple-600 rounded-lg blur opacity-20 group-hover:opacity-60 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative cyber-glass p-6 flex flex-col h-full border border-white/5">
                    <div class="mb-4 text-fuchsia-400 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <h4 class="font-display text-base font-bold text-white uppercase tracking-wider mb-2">Speed Run</h4>
                    <p class="text-[10px] text-slate-400 leading-relaxed mb-6">Tezkor qaror qabul qilish! Har bir savol uchun 15s vaqt.</p>
                    <div class="mt-auto">
                        <a href="{{ route('arena.setup', 'speedrun') }}" class="btn btn-xs btn-secondary w-full rounded-none font-display uppercase tracking-widest text-[9px] bg-fuchsia-500 border-none text-slate-950 hover:bg-fuchsia-400">Sync_Velocity</a>
                    </div>
                </div>
            </div>

            <!-- Survival -->
            <div class="group relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-red-500 to-orange-600 rounded-lg blur opacity-20 group-hover:opacity-60 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative cyber-glass p-6 flex flex-col h-full border border-white/5">
                    <div class="mb-4 text-red-500 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                    </div>
                    <h4 class="font-display text-base font-bold text-white uppercase tracking-wider mb-2">Survival</h4>
                    <p class="text-[10px] text-slate-400 leading-relaxed mb-6">Bitta xato — o'yin tugadi. Oxirigacha chidab bera olasizmi?</p>
                    <div class="mt-auto">
                        <a href="{{ route('arena.setup', 'survival') }}" class="btn btn-xs btn-error w-full rounded-none font-display uppercase tracking-widest text-[9px] bg-red-600 border-none text-white hover:bg-red-500">Integrity_Check</a>
                    </div>
                </div>
            </div>

            <!-- PvP Duel -->
            <div class="group relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-amber-500 to-yellow-600 rounded-lg blur opacity-20 group-hover:opacity-60 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative cyber-glass p-6 flex flex-col h-full border border-white/5">
                    <div class="mb-4 text-amber-500 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <h4 class="font-display text-base font-bold text-white uppercase tracking-wider mb-2">PvP Duel</h4>
                    <p class="text-[10px] text-slate-400 leading-relaxed mb-6">Jonli 1v1 jang! Real vaqtda boshqa talabalar bilan bellashing.</p>
                    <div class="mt-auto">
                        <a href="{{ route('arena.duel.lobby') }}" class="btn btn-xs btn-warning w-full rounded-none font-display uppercase tracking-widest text-[9px] bg-amber-500 border-none text-slate-950 hover:bg-amber-400">Join_Queue</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent History Table -->
    <section class="space-y-6">
        <div class="flex items-center justify-between">
            <h3 class="font-display text-sm font-bold uppercase tracking-[0.3em] text-white">Mission <span class="text-fuchsia-500">Logs</span></h3>
            <a href="#" class="text-[10px] font-mono text-cyan-400 hover:underline uppercase">View All Logs</a>
        </div>
        
        <div class="cyber-glass-light overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-white/5 border-b border-white/10 font-display uppercase text-[9px] tracking-[0.2em] text-slate-500">
                    <tr>
                        <th class="p-4">Arena_Mode</th>
                        <th class="p-4">Accuracy</th>
                        <th class="p-4">Result</th>
                        <th class="p-4">XP_Gain</th>
                        <th class="p-4">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="font-sans text-xs">
                    @forelse($recentLogs as $log)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                            <td class="p-4 text-white font-medium uppercase tracking-tighter">{{ $log->mode }}</td>
                            <td class="p-4"><span class="text-cyan-400 font-mono text-[10px]">{{ $log->score }} / {{ $log->total_questions }}</span></td>
                            <td class="p-4 {{ $log->score >= ($log->total_questions / 2) ? 'text-emerald-400' : 'text-red-400' }} font-bold italic uppercase">
                                {{ $log->score >= ($log->total_questions / 2) ? 'Victory' : 'Defeat' }}
                            </td>
                            <td class="p-4 text-cyan-400 font-mono">+{{ $log->xp_earned }}</td>
                            <td class="p-4 text-slate-500 font-mono">{{ $log->created_at->format('Y.m.d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center">
                                <p class="text-[10px] font-mono text-slate-600 uppercase tracking-widest italic">No mission records found in the system</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
