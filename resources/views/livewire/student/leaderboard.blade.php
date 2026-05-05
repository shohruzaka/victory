<div class="max-w-4xl mx-auto space-y-8 animate-reveal">
    <div class="text-center space-y-4">
        <h2 class="font-display text-4xl font-black text-slate-900 dark:text-white uppercase tracking-tighter">
            Global <span class="text-cyan-600 dark:text-cyan-400">Leaderboard</span>
        </h2>
        <p class="text-sm text-slate-500 font-mono uppercase tracking-widest font-bold">Top Players in the Neural Grid</p>
    </div>

    <div class="cyber-glass-light overflow-hidden transition-all duration-300">
        <table class="w-full text-left">
            <thead class="bg-slate-50 dark:bg-white/5 border-b border-slate-200 dark:border-white/10 font-display uppercase text-[10px] tracking-[0.2em] text-slate-500 dark:text-slate-400">
                <tr>
                    <th class="p-6">Rank</th>
                    <th class="p-6">Player</th>
                    <th class="p-6 text-center">Level</th>
                    <th class="p-6 text-right">XP_Points</th>
                </tr>
            </thead>
            <tbody class="font-sans text-sm">
                @foreach($topUsers as $index => $user)
                    <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-all group {{ auth()->id() == $user->id ? 'bg-cyan-500/5' : '' }}">
                        <td class="p-6">
                            <span class="font-display font-black {{ $index < 3 ? 'text-cyan-600 dark:text-cyan-400 text-xl' : 'text-slate-400 dark:text-slate-500' }}">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td class="p-6">
                            <a href="{{ route('profile.public', $user->id) }}" class="flex items-center gap-4 group/item">
                                <div class="w-10 h-10 rounded-full border {{ $index < 3 ? 'border-cyan-600 dark:border-cyan-500 shadow-sm dark:shadow-[0_0_10px_rgba(6,182,212,0.4)]' : 'border-slate-200 dark:border-white/10' }} overflow-hidden">
                                    @if($user->avatar_url)
                                        <img src="{{ $user->avatar_url }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-xs font-bold text-slate-400">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-900 dark:text-white group-hover/item:text-cyan-600 dark:group-hover/item:text-cyan-400 transition-colors uppercase tracking-tight">
                                        {{ $user->name }}
                                        @if(auth()->id() == $user->id)
                                            <span class="text-[9px] text-cyan-600 dark:text-cyan-500 ml-2 font-mono font-bold">(YOU)</span>
                                        @endif
                                    </span>
                                    <span class="text-[10px] text-slate-500 font-display italic uppercase tracking-tighter">{{ $user->rank }}</span>
                                </div>
                            </a>
                        </td>
                        <td class="p-6 text-center">
                            <span class="font-mono text-xs text-slate-600 dark:text-slate-300 font-bold">LVL {{ $user->level }}</span>
                        </td>
                        <td class="p-6 text-right">
                            <span class="font-mono font-bold text-cyan-700 dark:text-cyan-400">{{ number_format($user->xp) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bottom Legend -->
    <div class="flex justify-center gap-8 py-8 border-t border-slate-200 dark:border-white/5">
        <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-cyan-600 dark:bg-cyan-500 shadow-sm dark:shadow-[0_0_8px_rgba(6,182,212,0.8)]"></div>
            <span class="text-[9px] font-mono text-slate-500 uppercase">Neural_Elite</span>
        </div>
        <div class="flex items-center gap-2 opacity-50">
            <div class="w-2 h-2 rounded-full bg-fuchsia-600 dark:bg-fuchsia-500"></div>
            <span class="text-[9px] font-mono text-slate-500 uppercase">Active_Nodes</span>
        </div>
    </div>
</div>

