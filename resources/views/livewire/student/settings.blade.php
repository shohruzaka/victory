<div class="max-w-4xl mx-auto space-y-12 animate-reveal">
    <div class="flex items-center justify-between">
        <h2 class="font-display text-xl font-bold uppercase tracking-widest text-slate-900 dark:text-white">
            Identity <span class="text-cyan-600 dark:text-cyan-400">Configuration</span>
        </h2>
        <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm text-xs font-display uppercase tracking-widest text-slate-500 hover:text-slate-900 dark:hover:text-white">
            Back to Terminal
        </a>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/50 text-emerald-700 dark:text-emerald-400 rounded-none font-mono text-xs">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Avatar Section -->
        <div class="space-y-6">
            <div class="cyber-glass p-8 flex flex-col items-center text-center space-y-6 transition-all duration-300">
                <div class="relative group">
                    <div class="w-32 h-32 rounded-full overflow-hidden border-2 border-cyan-600 dark:border-cyan-500 shadow-sm dark:shadow-[0_0_20px_rgba(6,182,212,0.3)] relative">
                        @if ($avatar)
                            <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover">
                        @else
                            <img src="{{ $currentAvatar }}" class="w-full h-full object-cover">
                        @endif

                        <!-- Uploading Overlay -->
                        <div wire:loading wire:target="avatar" class="absolute inset-0 bg-slate-900/80 flex items-center justify-center">
                            <div class="w-8 h-8 border-2 border-cyan-500 border-t-transparent rounded-full animate-spin"></div>
                        </div>
                    </div>
                    
                    <label class="absolute inset-0 flex items-center justify-center bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer rounded-full">
                        <span class="text-[10px] font-display uppercase tracking-widest text-cyan-400 font-bold" wire:loading.remove wire:target="avatar">Update_Bio</span>
                        <input type="file" wire:model="avatar" class="hidden" accept="image/*">
                    </label>
                </div>
                
                <div>
                    <h3 class="font-display text-sm font-bold text-slate-900 dark:text-white uppercase tracking-tight">{{ $name ?: 'Identity_Undefined' }}</h3>
                    <p class="text-[10px] font-mono text-slate-500 uppercase tracking-widest mt-1">Status: Active_Node</p>
                </div>

                <div class="w-full pt-4 border-t border-slate-100 dark:border-white/5">
                    <p class="text-[9px] font-mono text-slate-400 dark:text-slate-600 leading-relaxed uppercase">
                        Recommended: Square image, max 2MB. Valid formats: JPG, PNG, WEBP.
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Fields -->
        <div class="lg:col-span-2 space-y-8">
            <div class="cyber-glass p-8 space-y-6 transition-all duration-300">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">Full Name (F.I.SH)</span>
                    </label>
                    <input type="text" wire:model="name" class="input input-bordered bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-cyan-700 dark:text-cyan-400 focus:border-cyan-600 dark:focus:border-cyan-500 font-mono">
                    @error('name') <span class="text-red-500 text-[10px] mt-1 font-mono uppercase">{{ $message }}</span> @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">Academic Group (Guruh)</span>
                    </label>
                    <input type="text" wire:model="group_name" class="input input-bordered bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-cyan-700 dark:text-cyan-400 focus:border-cyan-600 dark:focus:border-cyan-500 font-mono" placeholder="Masalan: 211-21">
                    @error('group_name') <span class="text-red-500 text-[10px] mt-1 font-mono uppercase">{{ $message }}</span> @enderror
                </div>

                <div class="pt-6 border-t border-slate-100 dark:border-white/5">
                    <button type="submit" wire:loading.attr="disabled" class="btn btn-primary w-full md:w-auto px-12 rounded-none border-2 border-cyan-600 dark:border-cyan-400 bg-cyan-600 dark:bg-cyan-500 text-white dark:text-slate-950 hover:bg-transparent hover:text-cyan-600 dark:hover:text-cyan-400 hover:border-cyan-600 dark:hover:border-cyan-400 transition-all font-display uppercase tracking-widest text-xs shadow-md dark:shadow-[0_0_20px_rgba(6,182,212,0.3)] group">
                        <span wire:loading.remove wire:target="save">Save_Changes</span>
                        <span wire:loading wire:target="save" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Syncing...
                        </span>
                    </button>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="cyber-glass p-8 border-l-4 border-red-600 dark:border-red-500/50 transition-all duration-300">
                <h4 class="font-display text-xs font-bold text-red-600 dark:text-red-500 uppercase tracking-widest mb-4">Integrity_Control</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-6 font-mono font-medium">Password reset requires external auth link. Current session is encrypted.</p>
                <button type="button" class="btn btn-outline btn-error btn-xs rounded-none font-display text-[9px] uppercase tracking-tighter">Initiate_Termination</button>
            </div>
        </div>
    </form>

    <!-- Password Update Section -->
    <div class="mt-12 space-y-6">
        <h2 class="font-display text-xl font-bold uppercase tracking-widest text-slate-900 dark:text-white">
            Security <span class="text-emerald-600 dark:text-emerald-400">Matrix</span>
        </h2>

        @if (session()->has('password_message'))
            <div class="alert alert-success bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/50 text-emerald-700 dark:text-emerald-400 rounded-none font-mono text-xs">
                {{ session('password_message') }}
            </div>
        @endif

        <form wire:submit.prevent="updatePassword" class="cyber-glass p-8 border-l-4 border-emerald-600 dark:border-emerald-500 transition-all duration-300">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">Current Password (Joriy Parol)</span>
                    </label>
                    <input type="password" wire:model="current_password" class="input input-bordered bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-emerald-700 dark:text-emerald-400 focus:border-emerald-600 dark:focus:border-emerald-500 font-mono">
                    @error('current_password') <span class="text-red-500 text-[10px] mt-1 font-mono uppercase">{{ $message }}</span> @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">New Password (Yangi Parol)</span>
                    </label>
                    <input type="password" wire:model="password" class="input input-bordered bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-emerald-700 dark:text-emerald-400 focus:border-emerald-600 dark:focus:border-emerald-500 font-mono">
                    @error('password') <span class="text-red-500 text-[10px] mt-1 font-mono uppercase">{{ $message }}</span> @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">Confirm Password (Tasdiqlash)</span>
                    </label>
                    <input type="password" wire:model="password_confirmation" class="input input-bordered bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-emerald-700 dark:text-emerald-400 focus:border-emerald-600 dark:focus:border-emerald-500 font-mono">
                </div>
            </div>

            <div class="pt-6 mt-6 border-t border-slate-100 dark:border-white/5">
                <button type="submit" wire:loading.attr="disabled" class="btn w-full md:w-auto px-12 rounded-none border-2 border-emerald-600 dark:border-emerald-500 bg-emerald-600 dark:bg-emerald-500 text-white hover:bg-transparent hover:text-emerald-600 dark:hover:text-emerald-400 hover:border-emerald-600 dark:hover:border-emerald-500 transition-all font-display uppercase tracking-widest text-xs shadow-md dark:shadow-[0_0_20px_rgba(16,185,129,0.3)]">
                    <span wire:loading.remove wire:target="updatePassword">Update_Security_Key</span>
                    <span wire:loading wire:target="updatePassword">Processing...</span>
                </button>
            </div>
        </form>
    </div>
</div>

