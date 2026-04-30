<div class="max-w-3xl mx-auto space-y-8 animate-reveal" 
    x-data="{ 
        timeLeft: {{ $timePerQuestion }}, 
        timerInterval: null,
        paused: false,
        startTimer() {
            this.timeLeft = {{ $timePerQuestion }};
            this.paused = false;
            if (this.timerInterval) clearInterval(this.timerInterval);
            this.timerInterval = setInterval(() => {
                if (!this.paused && this.timeLeft > 0) {
                    this.timeLeft--;
                    if (this.timeLeft <= 0) {
                        clearInterval(this.timerInterval);
                        $wire.timeout();
                    }
                }
            }, 1000);
        }
    }" 
    x-init="startTimer()"
    x-on:reset-timer.window="startTimer()"
    x-on:start-next-timer.window="paused = true"
>
    @if(empty($questionIds))
        <div class="cyber-glass p-12 text-center space-y-6 border-t-4 border-red-500">
            <h2 class="font-display text-2xl font-black text-white uppercase tracking-widest">No Questions <span class="text-red-500">Available</span></h2>
            <p class="text-sm text-slate-400 font-mono">Bazada yetarlicha savollar mavjud emas.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-outline border-cyan-500/50 text-cyan-400 rounded-none font-display uppercase tracking-widest text-xs hover:bg-cyan-500 hover:text-slate-950">Return to Terminal</a>
        </div>
    @elseif($isFinished)
        <!-- Game Over Screen -->
        <div class="cyber-glass p-12 text-center space-y-12 border-t-4 border-fuchsia-500">
            <div class="space-y-4">
                <h2 class="font-display text-4xl font-black text-white uppercase tracking-tighter">Speed <span class="text-fuchsia-500">Sync Complete</span></h2>
                <p class="text-sm text-slate-400 font-mono uppercase tracking-widest">Velocity Metrics Optimized</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="cyber-glass-light p-6 border-l-2 border-emerald-500">
                    <p class="text-[10px] font-mono text-slate-500 uppercase tracking-[0.2em] mb-2">Accuracy</p>
                    <div class="text-3xl font-display font-black text-white">
                        {{ $score }} <span class="text-sm text-emerald-500">/ {{ count($questionIds) }}</span>
                    </div>
                </div>

                <div class="cyber-glass-light p-6 border-l-2 border-cyan-500">
                    <p class="text-[10px] font-mono text-slate-500 uppercase tracking-[0.2em] mb-2">Total XP</p>
                    <div class="text-3xl font-display font-black text-white">
                        +{{ $xpEarned }}
                    </div>
                </div>

                <div class="cyber-glass-light p-6 border-l-2 border-amber-500">
                    <p class="text-[10px] font-mono text-slate-500 uppercase tracking-[0.2em] mb-2">Speed Bonus</p>
                    <div class="text-3xl font-display font-black text-amber-400">
                        +{{ $bonusXp }}
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-white/5">
                <a href="{{ route('dashboard') }}" class="btn btn-primary px-12 rounded-none border-2 border-fuchsia-500 bg-fuchsia-500 text-slate-950 hover:bg-transparent hover:text-fuchsia-400 hover:border-fuchsia-500 transition-all font-display uppercase tracking-widest text-xs shadow-[0_0_20px_rgba(217,70,239,0.3)]">
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
                    <div class="w-3 h-3 rounded-full bg-fuchsia-500 animate-ping"></div>
                    <span class="font-mono text-xs uppercase tracking-[0.3em] text-fuchsia-500 font-bold">Speed Run Mode</span>
                </div>
                
                <!-- Digital Clock -->
                <div class="flex items-center gap-3 cyber-glass-light px-4 py-2 border border-white/5">
                    <svg class="w-4 h-4 text-fuchsia-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-mono text-xl font-black tabular-nums" :class="timeLeft <= 5 ? 'text-red-500 animate-pulse' : 'text-white'" x-text="timeLeft + 's'"></span>
                </div>

                <span class="font-display font-bold text-white text-lg">{{ $currentIndex + 1 }} <span class="text-slate-500 text-sm">/ {{ count($questionIds) }}</span></span>
            </div>

            <!-- Timer Bar -->
            <div class="h-2 w-full bg-slate-900 rounded-full overflow-hidden border border-white/5">
                <div 
                    class="h-full bg-gradient-to-r from-fuchsia-600 to-fuchsia-400 shadow-[0_0_15px_rgba(217,70,239,0.6)] transition-all duration-1000 ease-linear" 
                    :style="'width: ' + (timeLeft / {{ $timePerQuestion }} * 100) + '%'"
                ></div>
            </div>

            @if($this->question)
                <div class="cyber-glass p-8 md:p-12 space-y-12 relative overflow-hidden">
                    <!-- Background Glow -->
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-fuchsia-500/5 blur-[80px] rounded-full pointer-events-none"></div>

                    <!-- Question Text -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="badge badge-outline border-cyan-500/50 text-cyan-400 font-display text-[10px] uppercase tracking-tighter italic">{{ $this->question->category }}</span>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] font-mono text-slate-500">Base: {{ $this->question->points }} XP</span>
                                <span class="text-[10px] font-mono text-fuchsia-400" x-show="!paused">Potential Bonus: +<span x-text="timeLeft"></span> XP</span>
                            </div>
                        </div>
                        <h3 class="text-xl md:text-2xl font-medium text-white leading-relaxed">
                            {{ $this->question->text }}
                        </h3>
                    </div>

                    <!-- Options -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($this->question->options as $index => $option)
                            @php
                                $btnClass = 'border-white/10 hover:border-fuchsia-500 hover:bg-fuchsia-500/5 text-slate-300';
                                $icon = '';
                                
                                if ($showResult) {
                                    if ($option->id == $correctOptionId) {
                                        $btnClass = 'border-emerald-500 bg-emerald-500/10 text-white shadow-[0_0_15px_rgba(16,185,129,0.2)]';
                                        $icon = '<svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                                    } elseif ($option->id == $selectedOptionId && !$isCorrect) {
                                        $btnClass = 'border-red-500 bg-red-500/10 text-white shadow-[0_0_15px_rgba(239,68,68,0.2)] opacity-70';
                                        $icon = '<svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                                    } else {
                                        $btnClass = 'border-white/5 opacity-50 text-slate-500';
                                    }
                                }
                            @endphp

                            <button 
                                @if(!$showResult) x-on:click="$wire.answer({{ $option->id }}, timeLeft)" @endif
                                class="w-full text-left p-5 rounded-lg border-2 {{ $btnClass }} transition-all duration-300 flex items-center justify-between group relative overflow-hidden"
                                {{ $showResult ? 'disabled' : '' }}
                            >
                                <span class="relative z-10 flex items-center gap-4">
                                    <span class="font-mono text-xs opacity-40">{{ chr(65 + $index) }}.</span>
                                    {{ $option->text }}
                                </span>
                                {!! $icon !!}
                            </button>
                        @endforeach
                    </div>

                    <!-- Next Button Area -->
                    @if($showResult)
                        <div class="pt-8 border-t border-white/5 flex items-center justify-between animate-reveal">
                            <div>
                                @if($isCorrect)
                                    <div class="flex flex-col">
                                        <span class="font-display font-black text-emerald-400 uppercase tracking-widest text-lg">System Optimized</span>
                                        <span class="text-[10px] font-mono text-cyan-400">Bonus XP Captured: +<span x-text="timeLeft"></span></span>
                                    </div>
                                @else
                                    <span class="font-display font-black text-red-400 uppercase tracking-widest text-lg">Sync Error</span>
                                @endif
                            </div>
                            <button wire:click="nextQuestion" class="btn btn-outline border-fuchsia-500 text-fuchsia-400 hover:bg-fuchsia-500 hover:text-slate-950 rounded-none font-display uppercase tracking-widest text-xs px-8">
                                {{ $currentIndex + 1 >= count($questionIds) ? 'Terminate Stream' : 'Next Node' }}
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </button>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>
