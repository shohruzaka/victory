<div class="max-w-4xl mx-auto space-y-8 animate-reveal">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <h2 class="font-display text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tighter">Duel <span class="text-cyan-600 dark:text-cyan-400">Log_Files</span></h2>
            <p class="text-[10px] font-mono text-slate-500 dark:text-slate-400 uppercase tracking-[0.3em] font-bold">Historical combat records decrypted</p>
        </div>
        <a href="{{ route('arena.duel.lobby') }}" class="btn btn-outline border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-400 rounded-none font-display uppercase tracking-widest text-xs px-6 hover:bg-slate-100 dark:hover:bg-white/5 transition-all">
            Return to Lobby
        </a>
    </div>

    <!-- History List -->
    <div class="space-y-4">
        @forelse($duels as $duel)
            @php
                $isPlayer1 = $duel->player1_id === auth()->id();
                $opponent = $isPlayer1 ? $duel->player2 : $duel->player1;
                $userScore = $isPlayer1 ? $duel->p1_score : $duel->p2_score;
                $opponentScore = $isPlayer1 ? $duel->p2_score : $duel->p1_score;
                
                $result = 'draw';
                if ($duel->winner_id === auth()->id()) $result = 'win';
                elseif ($duel->winner_id !== null) $result = 'loss';
                
                $resultColors = [
                    'win' => 'border-emerald-600 dark:border-emerald-500 text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/5',
                    'loss' => 'border-red-600 dark:border-red-500 text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-500/5',
                    'draw' => 'border-amber-600 dark:border-amber-500 text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-500/5'
                ];
            @endphp

            <div class="cyber-glass p-6 flex flex-col md:flex-row items-center justify-between gap-6 transition-all duration-300 hover:border-cyan-600/50">
                <!-- Opponent Info -->
                <div class="flex items-center gap-4 w-full md:w-1/3">
                    <div class="w-10 h-10 rounded-full border border-slate-200 dark:border-white/10 overflow-hidden shrink-0">
                        <img src="{{ $opponent->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($opponent->name) }}" class="w-full h-full object-cover">
                    </div>
                    <div class="min-w-0">
                        <p class="text-[9px] font-mono text-slate-500 uppercase tracking-widest font-bold">Opponent</p>
                        <p class="text-sm font-bold text-slate-900 dark:text-white truncate uppercase">{{ $opponent->name }}</p>
                    </div>
                </div>

                <!-- Score & VS -->
                <div class="flex items-center justify-center gap-6 w-full md:w-1/3 py-4 md:py-0 border-y md:border-y-0 border-slate-100 dark:border-white/5">
                    <div class="text-center">
                        <p class="text-[8px] font-mono text-slate-400 uppercase font-bold">You</p>
                        <p class="text-2xl font-display font-black text-slate-900 dark:text-white">{{ $userScore }}</p>
                    </div>
                    <div class="px-3 py-1 rounded bg-slate-100 dark:bg-slate-800 text-[10px] font-display font-black italic text-slate-400">VS</div>
                    <div class="text-center">
                        <p class="text-[8px] font-mono text-slate-400 uppercase font-bold">Them</p>
                        <p class="text-2xl font-display font-black text-slate-900 dark:text-white">{{ $opponentScore }}</p>
                    </div>
                </div>

                <!-- Status & Date -->
                <div class="flex flex-row md:flex-col items-center md:items-end justify-between md:justify-center gap-2 w-full md:w-1/3">
                    <span class="px-4 py-1 border text-[10px] font-display font-black uppercase tracking-[0.2em] italic {{ $resultColors[$result] }}">
                        {{ strtoupper($result) }}
                    </span>
                    <p class="text-[9px] font-mono text-slate-400 uppercase font-bold">{{ $duel->created_at->format('M d, Y • H:i') }}</p>
                </div>
            </div>
        @empty
            <div class="cyber-glass p-20 text-center space-y-6">
                <div class="w-16 h-16 rounded-full bg-slate-50 dark:bg-slate-900 border border-dashed border-slate-200 dark:border-white/10 flex items-center justify-center mx-auto opacity-50">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="space-y-2">
                    <p class="font-display text-slate-900 dark:text-white uppercase tracking-widest font-bold">No combat data found</p>
                    <p class="text-xs text-slate-500 font-mono uppercase font-medium">Initialize matchmaking to generate your first combat record</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $duels->links() }}
    </div>
</div>
