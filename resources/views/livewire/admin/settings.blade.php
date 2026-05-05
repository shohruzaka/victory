<div class="max-w-4xl mx-auto space-y-8 animate-reveal">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <h2 class="font-display text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tighter">System <span class="text-fuchsia-600 dark:text-fuchsia-400">Parameters</span></h2>
            <p class="text-[10px] font-mono text-slate-500 dark:text-slate-400 uppercase tracking-[0.3em] font-bold">Configure Arena default nodes and sync velocity</p>
        </div>
    </div>

    <div class="cyber-glass p-8 md:p-12 transition-all duration-300">
        <form wire:submit.prevent="save" class="space-y-10">
            <!-- Classic Mode Settings -->
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-4 bg-cyan-600 dark:bg-cyan-500 shadow-sm dark:shadow-[0_0_8px_rgba(6,182,212,0.8)]"></div>
                    <h3 class="font-display text-sm font-bold uppercase tracking-widest text-slate-800 dark:text-white">Classic_Arena</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-mono uppercase text-[10px] text-slate-500 font-bold tracking-widest">Questions Limit</span>
                        </label>
                        <input type="number" wire:model="classicQuestionsLimit" class="input input-bordered bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/5 text-slate-900 dark:text-cyan-400 font-mono text-sm focus:border-cyan-600 dark:focus:border-cyan-500 focus:outline-none transition-all duration-300">
                        @error('classicQuestionsLimit') <span class="text-red-500 text-[9px] mt-1 font-mono uppercase tracking-tighter">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Speed Run Settings -->
            <div class="space-y-6 pt-10 border-t border-slate-100 dark:border-white/5">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-4 bg-fuchsia-600 dark:bg-fuchsia-500 shadow-sm dark:shadow-[0_0_8px_rgba(217,70,239,0.8)]"></div>
                    <h3 class="font-display text-sm font-bold uppercase tracking-widest text-slate-800 dark:text-white">Speed_Run_Sync</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-mono uppercase text-[10px] text-slate-500 font-bold tracking-widest">Questions Limit</span>
                        </label>
                        <input type="number" wire:model="speedrunQuestionsLimit" class="input input-bordered bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/5 text-slate-900 dark:text-fuchsia-400 font-mono text-sm focus:border-fuchsia-600 dark:focus:border-fuchsia-500 focus:outline-none transition-all duration-300">
                        @error('speedrunQuestionsLimit') <span class="text-red-500 text-[9px] mt-1 font-mono uppercase tracking-tighter">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-mono uppercase text-[10px] text-slate-500 font-bold tracking-widest">Time Limit (Seconds)</span>
                        </label>
                        <input type="number" wire:model="speedrunTimeLimit" class="input input-bordered bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/5 text-slate-900 dark:text-fuchsia-400 font-mono text-sm focus:border-fuchsia-600 dark:focus:border-fuchsia-500 focus:outline-none transition-all duration-300">
                        @error('speedrunTimeLimit') <span class="text-red-500 text-[9px] mt-1 font-mono uppercase tracking-tighter">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Action -->
            <div class="pt-10 flex justify-end">
                <button type="submit" wire:loading.attr="disabled" class="btn btn-primary rounded-none border-2 border-cyan-600 dark:border-cyan-400 bg-cyan-600 dark:bg-cyan-400 text-white dark:text-slate-950 hover:bg-transparent hover:text-cyan-600 dark:hover:text-cyan-400 hover:border-cyan-600 dark:hover:border-cyan-400 transition-all font-display uppercase tracking-widest text-xs px-12 py-3 shadow-md dark:shadow-[0_0_20px_rgba(6,182,212,0.3)] min-w-[200px] flex items-center justify-center gap-3">
                    <span wire:loading.remove wire:target="save">Update_Parameters</span>
                    <span wire:loading wire:target="save" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Syncing...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
