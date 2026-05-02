<div class="max-w-5xl mx-auto space-y-8 animate-reveal">
    <!-- Players VS Header -->
    <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-8 md:gap-0">
        <!-- Player 1 (You) -->
        <div class="cyber-glass p-6 border-l-4 border-cyan-600 dark:border-cyan-500 flex items-center gap-4 transition-all duration-300">
            <div class="w-12 h-12 rounded-full border-2 border-cyan-600 dark:border-cyan-500 overflow-hidden shadow-sm">
                <img src="{{ auth()->user()->avatar_url }}" class="w-full h-full object-cover">
            </div>
            <div>
                <p class="text-[10px] font-mono text-cyan-700 dark:text-cyan-500 uppercase tracking-widest font-bold">You</p>
                <p class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-tight">{{ auth()->user()->name }}</p>
                <p class="text-lg font-display font-black text-cyan-700 dark:text-cyan-400">{{ $score }} <span class="text-[10px] text-slate-500 font-normal">PTS</span></p>
            </div>
        </div>

        <!-- VS Badge -->
        <div class="flex flex-col items-center justify-center space-y-2">
            <div class="w-16 h-16 rounded-full bg-slate-50 dark:bg-slate-900 border-2 border-slate-200 dark:border-white/10 flex items-center justify-center shadow-sm">
                <span class="font-display font-black text-2xl text-slate-900 dark:text-white italic">VS</span>
            </div>
            <div class="px-3 py-1 rounded bg-fuchsia-100 dark:bg-fuchsia-500/10 border border-fuchsia-200 dark:border-fuchsia-500/20">
                <span class="text-[9px] font-mono text-fuchsia-700 dark:text-fuchsia-400 uppercase tracking-[0.3em] font-bold animate-pulse">Neural_Sync: Active</span>
            </div>
        </div>

        <!-- Player 2 (Opponent) -->
        <div class="cyber-glass p-6 border-r-4 border-fuchsia-600 dark:border-fuchsia-500 flex items-center justify-end gap-4 text-right transition-all duration-300">
            <div>
                <p class="text-[10px] font-mono text-fuchsia-700 dark:text-fuchsia-500 uppercase tracking-widest font-bold">Opponent</p>
                <p class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-tight">{{ $opponent ? $opponent->name : 'Disconnected' }}</p>
                <p class="text-lg font-display font-black text-fuchsia-700 dark:text-fuchsia-400">{{ $opponentScore }} <span class="text-[10px] text-slate-500 font-normal">PTS</span></p>
            </div>
            <div class="w-12 h-12 rounded-full border-2 border-fuchsia-600 dark:border-fuchsia-500 overflow-hidden shadow-sm">
                <img src="{{ $opponent ? $opponent->avatar_url : 'https://ui-avatars.com/api/?name=?' }}" class="w-full h-full object-cover">
            </div>
        </div>
    </div>

    <!-- Progress Synchronization Bar -->
    <div class="cyber-glass p-4 space-y-4 transition-all duration-300">
        <div class="flex justify-between text-[9px] font-mono uppercase tracking-widest font-bold">
            <span class="text-cyan-700 dark:text-cyan-400">Your Progress: {{ $currentIndex }}/10</span>
            <span class="text-fuchsia-700 dark:text-fuchsia-400">Opponent Progress: {{ $opponentIndex }}/10</span>
        </div>
        <div class="relative h-2 w-full bg-slate-100 dark:bg-slate-900 rounded-full overflow-hidden border border-slate-200 dark:border-white/5">
            <!-- P1 Progress -->
            <div class="absolute h-full bg-cyan-600 dark:bg-cyan-500 shadow-sm dark:shadow-[0_0_10px_rgba(6,182,212,0.8)] transition-all duration-500 z-10" style="width: {{ ($currentIndex / 10) * 100 }}%"></div>
            <!-- P2 Progress (lower opacity) -->
            <div class="absolute h-full bg-fuchsia-600/30 dark:bg-fuchsia-500/30 transition-all duration-500 z-0" style="width: {{ ($opponentIndex / 10) * 100 }}%"></div>
        </div>
    </div>

    @if($isFinished)
        <!-- End Result -->
        <div class="cyber-glass p-12 text-center space-y-8 animate-reveal transition-all duration-300">
            @if($duel->winner_id == auth()->id())
                <h2 class="font-display text-5xl font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-tighter italic">Victory <span class="text-slate-900 dark:text-white">Confirmed</span></h2>
                <p class="text-slate-500 dark:text-slate-400 font-mono text-sm uppercase font-bold">You dominated the neural grid. +200 XP gained.</p>
            @elseif($duel->winner_id == null && $duel->status == 'finished')
                <h2 class="font-display text-5xl font-black text-amber-600 dark:text-amber-400 uppercase tracking-tighter italic">Draw <span class="text-slate-900 dark:text-white">Detected</span></h2>
                <p class="text-slate-500 dark:text-slate-400 font-mono text-sm uppercase font-bold">Perfect symmetry. No XP gained.</p>
            @else
                <h2 class="font-display text-5xl font-black text-red-600 dark:text-red-500 uppercase tracking-tighter italic">Defeat <span class="text-slate-900 dark:text-white">Acknowledged</span></h2>
                <p class="text-slate-500 dark:text-slate-400 font-mono text-sm uppercase font-bold">System override failed. Retrain and return.</p>
            @endif

            <div class="pt-8 border-t border-slate-100 dark:border-white/5">
                <a href="{{ route('dashboard') }}" class="btn btn-primary px-12 rounded-none border-2 border-cyan-600 dark:border-cyan-400 bg-cyan-600 dark:bg-cyan-400 text-white dark:text-slate-950 font-display uppercase tracking-widest text-xs shadow-md">Return to Terminal</a>
            </div>
        </div>
    @else
        <!-- Question Area -->
        @if($currentQuestion)
            <div class="cyber-glass p-8 md:p-12 space-y-12 animate-reveal transition-all duration-300" wire:key="question-{{ $currentIndex }}">
                <div class="space-y-4">
                    <span class="badge badge-outline border-cyan-600/50 dark:border-cyan-500/50 text-cyan-700 dark:text-cyan-400 font-display text-[10px] uppercase tracking-tighter italic font-bold">Category: {{ $currentQuestion['category'] ?? 'Neural_Matrix' }}</span>
                    <div class="text-lg md:text-xl font-medium text-slate-900 dark:text-white leading-relaxed whitespace-pre-wrap font-mono bg-slate-50 dark:bg-slate-900/50 p-4 rounded border border-slate-100 dark:border-white/5 shadow-inner">{{ $currentQuestion['text'] }}</div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($currentOptions as $index => $option)
                        @php
                            $btnClass = 'border-slate-200 dark:border-white/10 hover:border-cyan-600 dark:hover:border-cyan-500 hover:bg-cyan-50 dark:hover:bg-cyan-500/5 text-slate-700 dark:text-slate-300';
                            if ($showResult) {
                                if ($option['id'] == $correctOptionId) $btnClass = 'border-emerald-500 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-white font-bold shadow-sm';
                                elseif ($option['id'] == $selectedOptionId && !$isCorrect) $btnClass = 'border-red-500 bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-white font-bold shadow-sm';
                                else $btnClass = 'border-slate-100 dark:border-white/5 opacity-50 text-slate-400 dark:text-slate-500';
                            }
                        @endphp
                        <button 
                            wire:key="option-{{ $option['id'] }}-{{ $currentIndex }}"
                            @if(!$showResult) wire:click="answer({{ $option['id'] }})" @endif
                            class="w-full text-left p-4 rounded-lg border-2 {{ $btnClass }} transition-all duration-300 flex items-center gap-4 group"
                            {{ $showResult ? 'disabled' : '' }}
                        >
                            <span class="font-mono text-xs opacity-40">{{ chr(65 + $index) }}.</span>
                            <span class="font-mono text-xs md:text-sm">{{ $option['text'] }}</span>
                        </button>
                    @endforeach
                </div>

                @if($showResult)
                    <div class="pt-8 border-t border-slate-100 dark:border-white/5 flex justify-end">
                        <button wire:click="nextQuestion" class="btn btn-outline border-cyan-600 dark:border-cyan-500 text-cyan-700 dark:text-cyan-400 hover:bg-cyan-600 hover:text-white dark:hover:bg-cyan-500 dark:hover:text-slate-950 rounded-none font-display uppercase tracking-widest text-xs px-8 transition-all">
                            {{ $currentIndex + 1 >= 10 ? 'Awaiting Opponent' : 'Next Node' }}
                        </button>
                    </div>
                @endif
            </div>
        @else
            <div class="cyber-glass p-20 text-center space-y-6 transition-all duration-300">
                <div class="w-12 h-12 border-4 border-cyan-600 dark:border-cyan-500 border-t-transparent rounded-full animate-spin mx-auto"></div>
                <p class="font-display text-slate-900 dark:text-white uppercase tracking-widest font-bold">Awaiting Neural Link...</p>
                <p class="text-xs text-slate-500 font-mono uppercase font-medium">Wait for opponent to complete current node</p>
            </div>
        @endif
    @endif
</div>

