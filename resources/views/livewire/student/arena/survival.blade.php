<div class="max-w-3xl mx-auto space-y-8 animate-reveal">
    @if(empty($questionIds))
        <div class="cyber-glass p-12 text-center space-y-6 border-t-4 border-red-600 dark:border-red-500 transition-all duration-300">
            <h2 class="font-display text-2xl font-black text-slate-900 dark:text-white uppercase tracking-widest">No Questions <span class="text-red-600 dark:text-red-500">Available</span></h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-mono font-bold">Bazada yetarlicha savollar mavjud emas.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-outline border-cyan-600/50 dark:border-cyan-500/50 text-cyan-700 dark:text-cyan-400 rounded-none font-display uppercase tracking-widest text-xs hover:bg-cyan-600 dark:hover:bg-cyan-500 hover:text-white dark:hover:text-slate-950">Return to Terminal</a>
        </div>
    @elseif($isFinished)
        <!-- Game Over Screen -->
        <div class="cyber-glass p-12 text-center space-y-12 border-t-4 border-red-600 dark:border-red-500 transition-all duration-300">
            <div class="space-y-4">
                <h2 class="font-display text-4xl font-black text-slate-900 dark:text-white uppercase tracking-tighter">Mission <span class="text-red-600 dark:text-red-500">Terminated</span></h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-mono uppercase tracking-widest font-bold">
                    {{ $reasonForFinish === 'mistake' ? 'Neural Integrity Compromised' : 'All Matrix Nodes Cleared' }}
                </p>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div class="cyber-glass-light p-6 border-l-2 border-red-600 dark:border-red-500">
                    <p class="text-[10px] font-mono text-slate-500 uppercase tracking-[0.2em] mb-2 font-bold">Survived</p>
                    <div class="text-4xl font-display font-black text-slate-900 dark:text-white">
                        {{ $score }} <span class="text-lg text-red-600 dark:text-red-400">Nodes</span>
                    </div>
                </div>

                <div class="cyber-glass-light p-6 border-l-2 border-cyan-600 dark:border-cyan-500">
                    <p class="text-[10px] font-mono text-slate-500 uppercase tracking-[0.2em] mb-2 font-bold">XP Earned</p>
                    <div class="text-4xl font-display font-black text-slate-900 dark:text-white">
                        +{{ $xpEarned }} <span class="text-lg text-cyan-600 dark:text-cyan-400">XP</span>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 dark:border-white/5">
                <a href="{{ route('dashboard') }}" class="btn btn-primary px-12 rounded-none border-2 border-red-600 dark:border-red-500 bg-red-600 dark:bg-red-500 text-white dark:text-slate-950 hover:bg-transparent hover:text-red-600 dark:hover:text-red-400 hover:border-red-600 dark:hover:border-red-500 transition-all font-display uppercase tracking-widest text-xs shadow-md dark:shadow-[0_0_20px_rgba(239,68,68,0.3)]">
                    Return to Terminal
                </a>
            </div>
        </div>
    @else
        <!-- Active Game Screen -->
        <div class="space-y-6">
            <!-- Header Info -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-3 h-3 rounded-full bg-red-600 dark:bg-red-500 animate-pulse"></div>
                    <span class="font-mono text-xs uppercase tracking-[0.3em] text-red-600 dark:text-red-500 font-bold">Survival Mode // No Mistakes Allowed</span>
                </div>
                
                <div class="flex items-center gap-3 cyber-glass-light px-4 py-2 border border-red-600/20 transition-all duration-300">
                    <svg class="w-4 h-4 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span class="font-mono text-sm font-black text-slate-900 dark:text-white uppercase tracking-widest">Active</span>
                </div>

                <span class="font-display font-bold text-slate-900 dark:text-white text-lg">Node_{{ $currentIndex + 1 }}</span>
            </div>

            @if($currentQuestion)
                <div class="cyber-glass p-8 md:p-12 space-y-12 relative overflow-hidden transition-all duration-300">
                    <!-- Background Glow -->
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-red-600/5 dark:bg-red-500/5 blur-[80px] rounded-full pointer-events-none"></div>

                    <!-- Question Text -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="badge badge-outline border-cyan-600/50 dark:border-cyan-500/50 text-cyan-700 dark:text-cyan-400 font-display text-[10px] uppercase tracking-tighter italic font-bold">Subject: {{ $currentQuestion['topic']['subject']['name'] ?? 'N/A' }}</span>
                            <span class="text-[10px] font-mono text-red-600 dark:text-red-400 font-bold">Risk Level: HIGH // +{{ $currentQuestion['points'] }} XP</span>
                        </div>
                        <div class="text-lg md:text-xl font-medium text-slate-900 dark:text-white leading-relaxed whitespace-pre-wrap font-mono bg-slate-50 dark:bg-slate-900/50 p-4 rounded border border-slate-100 dark:border-white/5 shadow-inner">{{ $currentQuestion['text'] }}</div>
                    </div>

                    <!-- Options -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($currentOptions as $index => $option)
                            @php
                                $btnClass = 'border-slate-200 dark:border-white/10 hover:border-red-600 dark:hover:border-red-500 hover:bg-red-50 dark:hover:bg-red-500/5 text-slate-700 dark:text-slate-300';
                                $icon = '';
                                
                                if ($showResult) {
                                    if ($option['id'] == $correctOptionId) {
                                        $btnClass = 'border-emerald-500 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-white shadow-sm dark:shadow-[0_0_15px_rgba(16,185,129,0.2)] font-bold';
                                        $icon = '<svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                                    } elseif ($option['id'] == $selectedOptionId && !$isCorrect) {
                                        $btnClass = 'border-red-600 bg-red-600 dark:bg-red-600 text-white shadow-md dark:shadow-[0_0_20px_rgba(239,68,68,0.4)] font-bold';
                                        $icon = '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                                    } else {
                                        $btnClass = 'border-slate-100 dark:border-white/5 opacity-50 text-slate-400 dark:text-slate-500';
                                    }
                                }
                            @endphp

                            <button 
                                wire:key="option-{{ $option['id'] }}-{{ $currentIndex }}"
                                @if(!$showResult) wire:click="answer({{ $option['id'] }})" @endif
                                class="w-full text-left p-5 rounded-lg border-2 {{ $btnClass }} transition-all duration-300 flex items-center justify-between group relative overflow-hidden"
                                {{ $showResult ? 'disabled' : '' }}
                            >
                                <span class="relative z-10 font-mono text-xs md:text-sm">{{ $option['text'] }}</span>
                                {!! $icon !!}
                            </button>
                        @endforeach
                    </div>

                    <!-- Next/Result Button -->
                    @if($showResult)
                        <div class="pt-8 border-t border-slate-100 dark:border-white/5 flex items-center justify-between animate-reveal">
                            <div>
                                @if($isCorrect)
                                    <span class="font-display font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest text-lg italic">Integrity Verified</span>
                                @else
                                    <span class="font-display font-black text-red-600 dark:text-red-500 uppercase tracking-widest text-lg italic">Critical Failure</span>
                                @endif
                            </div>
                            <button wire:click="proceed" class="btn btn-outline {{ $isCorrect ? 'border-emerald-600 text-emerald-700 dark:border-emerald-500 dark:text-emerald-400 hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-500' : 'border-red-600 text-red-700 dark:border-red-500 dark:text-red-400 hover:bg-red-600 hover:text-white dark:hover:bg-red-500' }} rounded-none font-display uppercase tracking-widest text-xs px-8 transition-all">
                                {{ $isCorrect ? 'Advance' : 'Finalize_Log' }}
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </button>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>
