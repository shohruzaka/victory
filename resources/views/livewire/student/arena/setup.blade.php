<div class="max-w-2xl mx-auto py-12 animate-reveal">
    <div class="cyber-glass p-10 border-t-4 border-cyan-500 relative overflow-hidden">
        <!-- Background Accents -->
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-cyan-500/10 blur-[80px] rounded-full"></div>
        
        <div class="space-y-8 relative z-10">
            <!-- Header -->
            <div class="text-center space-y-2">
                <h2 class="font-display text-3xl font-black text-white uppercase tracking-tighter">Mission <span class="text-cyan-400">Briefing</span></h2>
                <p class="text-[10px] font-mono text-slate-500 uppercase tracking-[0.3em]">Configure Neural Interface Parameters</p>
            </div>

            <!-- Mode Display -->
            <div class="flex items-center justify-center gap-4 py-4 border-y border-white/5">
                <span class="text-[10px] font-mono text-slate-500 uppercase">Selected_Mode:</span>
                <span class="badge badge-outline border-fuchsia-500 text-fuchsia-400 font-display text-xs uppercase italic px-4">{{ $mode }}</span>
            </div>

            <!-- Selection Form -->
            <div class="space-y-6">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">Select Subject (Fan)</span>
                    </label>
                    <select wire:model.live="selectedSubject" class="select select-bordered bg-slate-900/80 border-white/10 text-cyan-400 focus:border-cyan-500 font-mono">
                        <option value="">-- ALL SUBJECTS (RANDOM) --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject }}">{{ strtoupper($subject) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control w-full {{ empty($topics) ? 'opacity-30' : '' }}">
                    <label class="label">
                        <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">Select Topic (Mavzu)</span>
                    </label>
                    <select wire:model="selectedTopic" class="select select-bordered bg-slate-900/80 border-white/10 text-cyan-400 focus:border-cyan-500 font-mono" {{ empty($topics) ? 'disabled' : '' }}>
                        <option value="">-- ALL TOPICS --</option>
                        @foreach($topics as $topic)
                            <option value="{{ $topic }}">{{ $topic }}</option>
                        @endforeach
                    </select>
                    @if(empty($topics) && $selectedSubject)
                        <span class="text-[9px] font-mono text-amber-500/60 mt-2 italic uppercase">No specific topics indexed for this subject node.</span>
                    @endif
                </div>
            </div>

            <!-- Action -->
            <div class="pt-8">
                <button wire:click="startMission" class="btn btn-primary btn-lg w-full rounded-none border-2 border-cyan-400 bg-cyan-400 text-slate-950 hover:bg-transparent hover:text-cyan-400 hover:border-cyan-400 transition-all font-display uppercase tracking-[0.2em] shadow-[0_0_30px_rgba(6,182,212,0.3)] group">
                    Initialize_Stream
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </button>
            </div>
            
            <div class="text-center">
                <a href="{{ route('dashboard') }}" class="text-[10px] font-display uppercase tracking-widest text-slate-600 hover:text-white transition-colors">Abort_Mission</a>
            </div>
        </div>
    </div>
</div>
