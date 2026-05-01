<div class="max-w-2xl mx-auto py-12 animate-reveal">
    <div class="cyber-glass p-10 border-t-4 border-cyan-600 dark:border-cyan-500 relative overflow-hidden transition-all duration-300">
        <!-- Background Accents -->
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-cyan-600/10 dark:bg-cyan-500/10 blur-[80px] rounded-full"></div>
        
        <div class="space-y-8 relative z-10">
            <!-- Header -->
            <div class="text-center space-y-2">
                <h2 class="font-display text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tighter">Mission <span class="text-cyan-600 dark:text-cyan-400">Briefing</span></h2>
                <p class="text-[10px] font-mono text-slate-500 dark:text-slate-400 uppercase tracking-[0.3em] font-bold">Configure Neural Interface Parameters</p>
            </div>

            <!-- Mode Display -->
            <div class="flex items-center justify-center gap-4 py-4 border-y border-slate-100 dark:border-white/5">
                <span class="text-[10px] font-mono text-slate-400 dark:text-slate-500 uppercase font-bold">Selected_Mode:</span>
                <span class="badge badge-outline border-fuchsia-600 dark:border-fuchsia-500 text-fuchsia-700 dark:text-fuchsia-400 font-display text-xs uppercase italic px-4 font-bold">{{ $mode }}</span>
            </div>

            <!-- Selection Form -->
            <div class="space-y-6">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500 font-bold">Select Subject (Fan)</span>
                    </label>
                    <select wire:model.live="selectedSubject" class="select select-bordered bg-white dark:bg-slate-900/80 border-slate-200 dark:border-white/10 text-cyan-700 dark:text-cyan-400 focus:border-cyan-600 dark:focus:border-cyan-500 font-mono">
                        <option value="">-- ALL SUBJECTS (RANDOM) --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ strtoupper($subject->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control w-full {{ count($topics) === 0 ? 'opacity-30' : '' }}">
                    <label class="label">
                        <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500 font-bold">Select Topic (Mavzu)</span>
                    </label>
                    <select wire:model="selectedTopic" class="select select-bordered bg-white dark:bg-slate-900/80 border-slate-200 dark:border-white/10 text-cyan-700 dark:text-cyan-400 focus:border-cyan-600 dark:focus:border-cyan-500 font-mono" {{ count($topics) === 0 ? 'disabled' : '' }}>
                        <option value="">-- ALL TOPICS --</option>
                        @foreach($topics as $topic)
                            <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                        @endforeach
                    </select>
                    @if(count($topics) === 0 && $selectedSubject)
                        <span class="text-[9px] font-mono text-amber-600 dark:text-amber-500/60 mt-2 italic uppercase font-bold">No specific topics indexed for this subject node.</span>
                    @endif
                </div>
            </div>

            <!-- Action -->
            <div class="pt-8">
                <button wire:click="startMission" class="btn btn-primary btn-lg w-full rounded-none border-2 border-cyan-600 dark:border-cyan-400 bg-cyan-600 dark:bg-cyan-400 text-white dark:text-slate-950 hover:bg-transparent hover:text-cyan-600 dark:hover:text-cyan-400 hover:border-cyan-600 dark:hover:border-cyan-400 transition-all font-display uppercase tracking-[0.2em] shadow-md dark:shadow-[0_0_30px_rgba(6,182,212,0.3)] group">
                    Initialize_Stream
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </button>
            </div>
            
            <div class="text-center">
                <a href="{{ route('dashboard') }}" class="text-[10px] font-display uppercase tracking-widest text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors font-bold">Abort_Mission</a>
            </div>
        </div>
    </div>
</div>
