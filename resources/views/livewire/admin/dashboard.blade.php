<div class="space-y-8 animate-reveal">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="cyber-glass p-6 border-l-4 border-cyan-600 dark:border-cyan-500 transition-all duration-300">
            <p class="text-[10px] font-mono text-slate-500 uppercase tracking-[0.2em] mb-1">Total_Students</p>
            <div class="flex items-end gap-2">
                <span class="text-3xl font-display font-black text-slate-900 dark:text-white">{{ $this->stats['totalStudents'] }}</span>
                <span class="text-xs text-cyan-600 dark:text-cyan-500 font-mono mb-1">Users</span>
            </div>
        </div>

        <div class="cyber-glass p-6 border-l-4 border-fuchsia-600 dark:border-fuchsia-500 transition-all duration-300">
            <p class="text-[10px] font-mono text-slate-500 uppercase tracking-[0.2em] mb-1">Arena_Games</p>
            <div class="flex items-end gap-2">
                <span class="text-3xl font-display font-black text-slate-900 dark:text-white">{{ $this->stats['totalGames'] }}</span>
                <span class="text-xs text-fuchsia-600 dark:text-fuchsia-500 font-mono mb-1">Total</span>
            </div>
            <p class="text-[9px] font-mono text-slate-400 mt-2">AVG_SCORE: {{ $this->stats['avgScore'] }}</p>
        </div>

        <div class="cyber-glass p-6 border-l-4 border-emerald-600 dark:border-emerald-500 transition-all duration-300">
            <p class="text-[10px] font-mono text-slate-500 uppercase tracking-[0.2em] mb-1">Completed_Duels</p>
            <div class="flex items-end gap-2">
                <span class="text-3xl font-display font-black text-slate-900 dark:text-white">{{ $this->stats['totalDuels'] }}</span>
                <span class="text-xs text-emerald-600 dark:text-emerald-500 font-mono mb-1">PvP</span>
            </div>
        </div>

        <div class="cyber-glass p-6 border-l-4 border-amber-600 dark:border-amber-500 transition-all duration-300">
            <p class="text-[10px] font-mono text-slate-500 uppercase tracking-[0.2em] mb-1">System_Admins</p>
            <div class="flex items-end gap-2">
                <span class="text-3xl font-display font-black text-slate-900 dark:text-white">{{ $this->stats['totalAdmins'] }}</span>
                <span class="text-xs text-amber-600 dark:text-amber-500 font-mono mb-1">Root</span>
            </div>
        </div>
    </div>

    <!-- Recent Activity & System Logs -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="space-y-4">
            <h3 class="font-display text-sm font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Recent <span class="text-cyan-600 dark:text-cyan-400">Activity</span></h3>
            <div class="cyber-glass-light overflow-hidden transition-all duration-300">
                @forelse($this->activities as $activity)
                    <div class="p-4 border-b border-slate-100 dark:border-white/5 flex justify-between items-center hover:bg-slate-50 dark:hover:bg-white/5 transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full {{ $activity['color'] }}"></div>
                            <span class="text-xs text-slate-800 dark:text-white truncate max-w-xs">{!! $activity['message'] !!}</span>
                        </div>
                        <span class="text-[9px] font-mono text-slate-400 dark:text-slate-500 uppercase shrink-0">{{ $activity['time']->diffForHumans(null, true) }} AGO</span>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <p class="text-[10px] font-mono text-slate-500 uppercase tracking-widest">No recent neural activity found</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="font-display text-sm font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">System <span class="text-amber-600 dark:text-amber-400">Status</span></h3>
            <div class="cyber-glass-light p-6 space-y-6 transition-all duration-300">
                <div class="space-y-2">
                    <div class="flex justify-between text-[10px] font-mono uppercase tracking-widest">
                        <span class="text-slate-500">Hard Questions Load</span>
                        <span class="text-red-600 dark:text-red-400 font-bold">{{ $this->systemStatus['hard_percent'] }}%</span>
                    </div>
                    <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-900 rounded-full overflow-hidden">
                        <div class="h-full bg-red-600 dark:bg-red-500 shadow-sm dark:shadow-[0_0_10px_rgba(220,38,38,0.5)]" style="width: {{ $this->systemStatus['hard_percent'] }}%"></div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-[10px] font-mono uppercase tracking-widest">
                        <span class="text-slate-500">Beginner Friendliness</span>
                        <span class="text-emerald-600 dark:text-emerald-400 font-bold">{{ $this->systemStatus['easy_percent'] }}%</span>
                    </div>
                    <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-900 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-600 dark:bg-emerald-500 shadow-sm dark:shadow-[0_0_10px_rgba(16,185,129,0.5)]" style="width: {{ $this->systemStatus['easy_percent'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


