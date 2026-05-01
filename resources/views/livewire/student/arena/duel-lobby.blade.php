<div class="max-w-xl mx-auto py-20 animate-reveal">
    <div class="cyber-glass p-12 text-center space-y-12 border-t-4 border-cyan-600 dark:border-cyan-500 relative overflow-hidden transition-all duration-300">
        <!-- Background Glow -->
        <div class="absolute -top-24 -left-24 w-48 h-48 bg-cyan-600/10 dark:bg-cyan-500/10 blur-[80px] rounded-full"></div>

        <div class="space-y-4">
            <h2 class="font-display text-4xl font-black text-slate-900 dark:text-white uppercase tracking-tighter">PvP <span class="text-cyan-600 dark:text-cyan-400">Duel Arena</span></h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-mono uppercase tracking-widest font-bold">Real-time Neural Combat</p>
        </div>

        @if(!$isSearching)
            <div class="space-y-8">
                <div class="p-6 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/5 rounded text-left space-y-4 shadow-sm dark:shadow-none">
                    <h4 class="text-[10px] font-mono text-cyan-700 dark:text-cyan-500 uppercase tracking-widest font-bold">Mission_Parameters:</h4>
                    <ul class="text-xs text-slate-600 dark:text-slate-400 space-y-2 font-sans font-medium">
                        <li class="flex items-center gap-2">
                            <div class="w-1 h-1 bg-cyan-600 dark:bg-cyan-500"></div> 10 Synchronized Questions
                        </li>
                        <li class="flex items-center gap-2">
                            <div class="w-1 h-1 bg-cyan-600 dark:bg-cyan-500"></div> Real-time Opponent Tracking
                        </li>
                        <li class="flex items-center gap-2">
                            <div class="w-1 h-1 bg-cyan-600 dark:bg-cyan-500"></div> Winner takes double XP
                        </li>
                    </ul>
                </div>

                <button wire:click="findMatch" class="btn btn-primary btn-lg w-full rounded-none border-2 border-cyan-600 dark:border-cyan-400 bg-cyan-600 dark:bg-cyan-400 text-white dark:text-slate-950 hover:bg-transparent hover:text-cyan-600 dark:hover:text-cyan-400 hover:border-cyan-600 dark:hover:border-cyan-400 transition-all font-display uppercase tracking-[0.2em] shadow-md dark:shadow-[0_0_30px_rgba(6,182,212,0.4)]">
                    Initiate_Matchmaking
                </button>
            </div>
        @else
            <div class="space-y-12 py-8">
                <!-- Searching Animation -->
                <div class="relative flex justify-center">
                    <div class="w-32 h-32 rounded-full border-2 border-cyan-600/20 dark:border-cyan-500/20 flex items-center justify-center animate-pulse">
                        <div class="w-24 h-24 rounded-full border-2 border-cyan-600/40 dark:border-cyan-500/40 flex items-center justify-center animate-spin-slow">
                            <div class="w-2 h-2 bg-cyan-600 dark:bg-cyan-400 rounded-full shadow-sm dark:shadow-[0_0_15px_rgba(34,211,238,1)]"></div>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <h3 class="text-cyan-700 dark:text-cyan-400 font-display font-bold uppercase tracking-widest animate-pulse">Searching for Opponent...</h3>
                    <p class="text-[10px] font-mono text-slate-400 dark:text-slate-600 uppercase">Scanning Neural Network Layers</p>
                </div>

                <div class="pt-6">
                    <button wire:click="$set('isSearching', false)" class="text-[10px] font-display uppercase tracking-widest text-slate-500 hover:text-red-600 transition-colors font-bold">Abort_Search</button>
                </div>
            </div>
        @endif
    </div>
</div>
