<div class="max-w-4xl mx-auto space-y-8 animate-reveal">
    <div class="text-center space-y-4">
        <h2 class="font-display text-4xl font-black text-white uppercase tracking-tighter">
            Global <span class="text-cyan-400">Leaderboard</span>
        </h2>
        <p class="text-sm text-slate-500 font-mono uppercase tracking-widest">Top Players in the Neural Grid</p>
    </div>

    <div class="cyber-glass-light overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-white/5 border-b border-white/10 font-display uppercase text-[10px] tracking-[0.2em] text-slate-500">
                <tr>
                    <th class="p-6">Rank</th>
                    <th class="p-6">Player</th>
                    <th class="p-6 text-center">Level</th>
                    <th class="p-6 text-right">XP_Points</th>
                </tr>
            </thead>
            <tbody class="font-sans text-sm">
                @foreach($topUsers as $index => $user)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition-all group {{ auth()->id() == $user->id ? 'bg-cyan-500/5' : '' }}">
                        <td class="p-6">
                            <span class="font-display font-black {{ $index < 3 ? 'text-cyan-400 text-xl' : 'text-slate-500' }}">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full border {{ $index < 3 ? 'border-cyan-500 shadow-[0_0_10px_rgba(6,182,212,0.4)]' : 'border-white/10' }} overflow-hidden">
                                    <img src="{{ $user->avatar_url }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-white group-hover:text-cyan-400 transition-colors uppercase tracking-tight">
                                        {{ $user->name }}
                                        @if(auth()->id() == $user->id)
                                            <span class="text-[9px] text-cyan-500 ml-2 font-mono">(YOU)</span>
                                        @endif
                                    </span>
                                    <span class="text-[10px] text-slate-500 font-display italic uppercase tracking-tighter">{{ $user->rank }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-6 text-center">
                            <span class="font-mono text-xs text-slate-300">LVL {{ $user->level }}</span>
                        </td>
                        <td class="p-6 text-right">
                            <span class="font-mono font-bold text-cyan-400">{{ number_format($user->xp) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bottom Legend -->
    <div class="flex justify-center gap-8 py-8 border-t border-white/5">
        <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-cyan-500 shadow-[0_0_8px_rgba(6,182,212,0.8)]"></div>
            <span class="text-[9px] font-mono text-slate-500 uppercase">Neural_Elite</span>
        </div>
        <div class="flex items-center gap-2 opacity-50">
            <div class="w-2 h-2 rounded-full bg-fuchsia-500"></div>
            <span class="text-[9px] font-mono text-slate-500 uppercase">Active_Nodes</span>
        </div>
    </div>
</div>
