<div class="max-w-4xl mx-auto space-y-12 animate-reveal">
    <div class="flex items-center justify-between">
        <h2 class="font-display text-xl font-bold uppercase tracking-widest text-white">
            Identity <span class="text-cyan-400">Configuration</span>
        </h2>
        <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm text-xs font-display uppercase tracking-widest text-slate-500">
            Back to Terminal
        </a>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 rounded-none font-mono text-xs">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Avatar Section -->
        <div class="space-y-6">
            <div class="cyber-glass p-8 flex flex-col items-center text-center space-y-6">
                <div class="relative group">
                    <div class="w-32 h-32 rounded-full overflow-hidden border-2 border-cyan-500 shadow-[0_0_20px_rgba(6,182,212,0.3)]">
                        @if ($avatar)
                            <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover">
                        @else
                            <img src="{{ $currentAvatar }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    
                    <label class="absolute inset-0 flex items-center justify-center bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer rounded-full">
                        <span class="text-[10px] font-display uppercase tracking-widest text-cyan-400">Update_Bio</span>
                        <input type="file" wire:model="avatar" class="hidden" accept="image/*">
                    </label>
                </div>
                
                <div>
                    <h3 class="font-display text-sm font-bold text-white uppercase">{{ $name ?: 'Identity_Undefined' }}</h3>
                    <p class="text-[10px] font-mono text-slate-500 uppercase tracking-widest mt-1">Status: Active_Node</p>
                </div>

                <div class="w-full pt-4 border-t border-white/5">
                    <p class="text-[9px] font-mono text-slate-600 leading-relaxed uppercase">
                        Recommended: Square image, max 2MB. Valid formats: JPG, PNG, WEBP.
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Fields -->
        <div class="lg:col-span-2 space-y-8">
            <div class="cyber-glass p-8 space-y-6">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">Full Name (F.I.SH)</span>
                    </label>
                    <input type="text" wire:model="name" class="input input-bordered bg-slate-900/50 border-white/10 text-cyan-400 focus:border-cyan-500 font-mono">
                    @error('name') <span class="text-red-500 text-[10px] mt-1 font-mono uppercase">{{ $message }}</span> @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">Academic Group (Guruh)</span>
                    </label>
                    <input type="text" wire:model="group_name" class="input input-bordered bg-slate-900/50 border-white/10 text-cyan-400 focus:border-cyan-500 font-mono" placeholder="Masalan: 211-21">
                    @error('group_name') <span class="text-red-500 text-[10px] mt-1 font-mono uppercase">{{ $message }}</span> @enderror
                </div>

                <div class="pt-6 border-t border-white/5">
                    <button type="submit" class="btn btn-primary w-full md:w-auto px-12 rounded-none border-2 border-cyan-400 bg-cyan-400 text-slate-950 hover:bg-transparent hover:text-cyan-400 hover:border-cyan-400 transition-all font-display uppercase tracking-widest text-xs shadow-[0_0_20px_rgba(6,182,212,0.3)]">
                        Save_Changes
                    </button>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="cyber-glass p-8 border-l-4 border-red-500/50">
                <h4 class="font-display text-xs font-bold text-red-500 uppercase tracking-widest mb-4">Integrity_Control</h4>
                <p class="text-xs text-slate-400 mb-6 font-mono">Password reset requires external auth link. Current session is encrypted.</p>
                <button type="button" class="btn btn-outline btn-error btn-xs rounded-none font-display text-[9px] uppercase tracking-tighter">Initiate_Termination</button>
            </div>
        </div>
    </form>
</div>
