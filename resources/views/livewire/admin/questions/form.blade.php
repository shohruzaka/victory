<div class="space-y-6 animate-reveal">
    <div class="flex items-center justify-between mb-8">
        <h2 class="font-display text-xl font-bold uppercase tracking-widest text-white">
            {{ $question ? 'Savolni' : 'Yangi' }} <span class="text-fuchsia-500">{{ $question ? 'Tahrirlash' : 'Savol' }}</span>
        </h2>
        <a href="{{ route('admin.questions.index') }}" class="btn btn-ghost btn-sm text-xs font-display uppercase tracking-widest text-slate-500">
            Back to List
        </a>
    </div>

    <form wire:submit.prevent="save" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Question Details -->
        <div class="lg:col-span-2 space-y-8">
            <div class="cyber-glass p-8">
                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-2">
                        <div class="w-1 h-4 bg-cyan-500 shadow-[0_0_8px_rgba(6,182,212,0.8)]"></div>
                        <label class="font-display uppercase tracking-[0.2em] text-xs text-white font-bold">
                            Savol Matni
                        </label>
                    </div>
                    
                    <div class="relative group">
                        <!-- Neon corner accents for the textarea -->
                        <div class="absolute -top-1 -left-1 w-2 h-2 border-t border-l border-cyan-500/50 group-focus-within:border-cyan-500 transition-colors"></div>
                        <div class="absolute -bottom-1 -right-1 w-2 h-2 border-b border-r border-cyan-500/50 group-focus-within:border-cyan-500 transition-colors"></div>
                        
                        <textarea 
                            wire:model="text" 
                            class="textarea textarea-bordered w-full h-40 bg-slate-900/80 border-white/5 text-cyan-400 focus:border-cyan-500/50 focus:outline-none font-mono text-base p-4 resize-none leading-relaxed transition-all" 
                            placeholder="Tizimga savol matnini kiriting... (Masalan: C++ da 'virtual' kalit so'zi nima uchun ishlatiladi?)"
                        ></textarea>
                    </div>
                    @error('text') <span class="text-red-500 text-[10px] font-mono uppercase tracking-tighter">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8 pt-8 border-t border-white/5">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">Fan (Subject)</span>
                        </label>
                        <input type="text" wire:model="subject" class="input input-bordered bg-slate-900/50 border-white/10 text-cyan-400 focus:border-cyan-500 font-mono" placeholder="Masalan: Python, C++, Tarmoqlar...">
                        @error('subject') <span class="text-red-500 text-[10px] mt-1 font-mono uppercase">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">Mavzu (Topic)</span>
                        </label>
                        <input type="text" wire:model="topic" class="input input-bordered bg-slate-900/50 border-white/10 text-cyan-400 focus:border-cyan-500 font-mono" placeholder="Masalan: Lug'atlar, Virtual funksiyalar...">
                        @error('topic') <span class="text-red-500 text-[10px] mt-1 font-mono uppercase">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8 pt-8 border-t border-white/5">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">Qiyinchilik</span>
                        </label>
                        <div class="flex gap-4">
                            @foreach(['easy', 'medium', 'hard'] as $level)
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" wire:model.live="difficulty" value="{{ $level }}" class="radio radio-xs {{ $level === 'easy' ? 'radio-success' : ($level === 'medium' ? 'radio-warning' : 'radio-error') }}">
                                    <span class="text-xs font-display uppercase tracking-widest group-hover:text-white transition-colors {{ $difficulty === $level ? 'text-white' : 'text-slate-500' }}">
                                        {{ $level }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('difficulty') <span class="text-red-500 text-[10px] mt-1 font-mono uppercase">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">Hisoblanadigan Ball</span>
                        </label>
                        <div class="flex items-center gap-3">
                            <span class="text-3xl font-display font-black text-cyan-400">{{ $points }}</span>
                            <span class="text-[10px] font-mono text-slate-600 uppercase">XP_Points</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Options Section -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-display text-sm font-bold uppercase tracking-widest text-slate-400">Javob <span class="text-cyan-400">Variantlari</span></h3>
                    <button type="button" wire:click="addOption" class="btn btn-xs btn-outline border-cyan-500/50 text-cyan-500 hover:bg-cyan-500 hover:text-slate-950 rounded-none font-display">Add Option</button>
                </div>

                @error('options') <div class="alert alert-error text-xs font-mono uppercase p-2 rounded-none">{{ $message }}</div> @enderror

                <div class="space-y-3">
                    @foreach($options as $index => $option)
                        <div class="cyber-glass-light p-4 flex items-center gap-4 group transition-all {{ $option['is_correct'] ? 'border-l-4 border-emerald-500 bg-emerald-500/5' : 'border-l-4 border-white/5' }}">
                            <div class="flex-grow flex items-center gap-3">
                                <span class="font-mono text-[10px] text-slate-600">0{{ $index + 1 }}</span>
                                <input type="text" wire:model="options.{{ $index }}.text" class="input input-sm w-full bg-transparent border-none focus:ring-0 text-slate-200 placeholder-slate-700 font-sans" placeholder="Variant matnini kiriting...">
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="button" wire:click="setCorrect({{ $index }})" class="btn btn-xs rounded-none {{ $option['is_correct'] ? 'btn-success shadow-[0_0_10px_rgba(16,185,129,0.3)]' : 'btn-ghost text-slate-600' }} font-display uppercase text-[9px] tracking-tighter">
                                    {{ $option['is_correct'] ? 'Correct' : 'Mark Correct' }}
                                </button>
                                
                                @if(count($options) > 2)
                                    <button type="button" wire:click="removeOption({{ $index }})" class="p-1 text-slate-700 hover:text-red-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <div class="cyber-glass p-6 space-y-6 sticky top-24">
                <h3 class="font-display text-xs font-bold uppercase tracking-[0.2em] text-white mb-4">Actions</h3>
                
                <div class="space-y-3">
                    <button type="submit" class="btn btn-primary w-full rounded-none border-2 border-cyan-400 bg-cyan-400 text-slate-950 hover:bg-transparent hover:text-cyan-400 hover:border-cyan-400 transition-all font-display uppercase tracking-widest text-xs shadow-[0_0_20px_rgba(6,182,212,0.3)]">
                        {{ $question ? 'Update' : 'Generate' }} Question
                    </button>
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-outline w-full rounded-none border-white/10 text-slate-400 hover:text-white font-display uppercase tracking-widest text-xs">
                        Cancel
                    </a>
                </div>

                <div class="pt-6 border-t border-white/5 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-mono uppercase text-slate-600 tracking-tighter">Integrity Check</span>
                        <span class="text-[10px] font-mono uppercase text-emerald-500 tracking-tighter">Passed</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-mono uppercase text-slate-600 tracking-tighter">Options Count</span>
                        <span class="text-[10px] font-mono uppercase text-cyan-400 tracking-tighter">{{ count($options) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
