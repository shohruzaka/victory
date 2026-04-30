<div class="max-w-3xl mx-auto space-y-8 animate-reveal">
    @if($isFinished)
        <!-- Game Over Screen -->
        <div class="cyber-glass p-12 text-center space-y-12 border-t-4 border-red-500">
            <div class="space-y-4">
                <h2 class="font-display text-4xl font-black text-white uppercase tracking-tighter">System <span class="text-red-500">Terminated</span></h2>
                <p class="text-sm text-slate-400 font-mono uppercase tracking-widest">
                    {{ $reasonForFinish === 'mistake' ? 'Integrity Check Failed: Fatal Error' : 'All Neural Nodes Processed' }}
                </p>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div class="cyber-glass-light p-6 border-l-2 border-red-500">
                    <p class="text-[10px] font-mono text-slate-500 uppercase tracking-[0.2em] mb-2">Streaks</p>
                    <div class="text-4xl font-display font-black text-white">
                        {{ $score }} <span class="text-lg text-red-500">SOLVED</span>
                    </div>
                </div>

                <div class="cyber-glass-light p-6 border-l-2 border-cyan-500">
                    <p class="text-[10px] font-mono text-slate-500 uppercase tracking-[0.2em] mb-2">XP Gained</p>
                    <div class="text-4xl font-display font-black text-white">
                        +{{ $xpEarned }} <span class="text-lg text-cyan-400">XP</span>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-white/5">
                <a href="{{ route('dashboard') }}" class="btn btn-primary px-12 rounded-none border-2 border-red-500 bg-red-500 text-slate-950 hover:bg-transparent hover:text-red-500 hover:border-red-500 transition-all font-display uppercase tracking-widest text-xs shadow-[0_0_20px_rgba(239,68,68,0.3)]">
                    Back to Terminal
                </a>
            </div>
        </div>
    @else
        <!-- Active Survival Screen -->
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-3 h-3 rounded-full bg-red-600 animate-pulse shadow-[0_0_15px_rgba(220,38,38,0.8)]"></div>
                    <span class="font-mono text-xs uppercase tracking-[0.4em] text-red-500 font-bold italic">Integrity_Check: Survival_Mode</span>
                </div>
                <div class="flex items-center gap-3 cyber-glass-light px-4 py-2 border border-red-500/20">
                    <span class="text-[10px] font-mono text-slate-500 uppercase tracking-widest">Current_Streak:</span>
                    <span class="font-display font-black text-xl text-white">{{ $score }}</span>
                </div>
            </div>

            @if($this->question)
                <div class="cyber-glass p-8 md:p-12 space-y-12 relative overflow-hidden">
                    <!-- Danger Scan Line -->
                    <div class="absolute inset-0 pointer-events-none bg-gradient-to-b from-red-500/5 via-transparent to-transparent h-1 w-full animate-scan"></div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="badge badge-outline border-red-500/50 text-red-500 font-display text-[10px] uppercase tracking-tighter italic">Danger: No Margin for Error</span>
                            <span class="text-[10px] font-mono text-cyan-400">+{{ $this->question->points }} XP per node</span>
                        </div>
                        <h3 class="text-xl md:text-2xl font-medium text-white leading-relaxed">
                            {{ $this->question->text }}
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($this->question->options->shuffle() as $index => $option)
                            @php
                                $btnClass = 'border-white/10 hover:border-red-500 hover:bg-red-500/5 text-slate-300';
                                $icon = '';
                                
                                if ($showResult) {
                                    if ($option->id == $correctOptionId) {
                                        $btnClass = 'border-emerald-500 bg-emerald-500/10 text-white';
                                        $icon = '<svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                                    } elseif ($option->id == $selectedOptionId && !$isCorrect) {
                                        $btnClass = 'border-red-600 bg-red-600/20 text-white';
                                        $icon = '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
                                    } else {
                                        $btnClass = 'border-white/5 opacity-40 text-slate-500';
                                    }
                                }
                            @endphp

                            <button 
                                @if(!$showResult) wire:click="answer({{ $option->id }})" @endif
                                class="w-full text-left p-5 rounded-lg border-2 {{ $btnClass }} transition-all duration-300 flex items-center justify-between group relative overflow-hidden"
                                {{ $showResult ? 'disabled' : '' }}
                            >
                                <span class="relative z-10">{{ $option->text }}</span>
                                {!! $icon !!}
                            </button>
                        @endforeach
                    </div>

                    @if($showResult)
                        <div class="pt-8 border-t border-white/5 flex items-center justify-between animate-reveal">
                            <div>
                                @if($isCorrect)
                                    <span class="font-display font-black text-emerald-400 uppercase tracking-widest text-lg">Identity <span class="text-white">Validated</span></span>
                                @else
                                    <span class="font-display font-black text-red-500 uppercase tracking-widest text-lg">System <span class="text-white">Corrupted</span></span>
                                @endif
                            </div>
                            <button wire:click="proceed" class="btn btn-outline {{ $isCorrect ? 'border-emerald-500 text-emerald-400 hover:bg-emerald-500 hover:text-slate-950' : 'border-red-500 text-red-500 hover:bg-red-500 hover:text-slate-950' }} rounded-none font-display uppercase tracking-widest text-xs px-8">
                                {{ $isCorrect ? 'Next Node' : 'Terminate Run' }}
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </button>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>
