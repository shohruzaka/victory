<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 animate-reveal">
    <div class="mb-12">
        <h1 class="font-display text-4xl font-black uppercase tracking-widest text-slate-900 dark:text-white mb-2">
            Fanlar <span class="text-cyan-600 dark:text-cyan-500">Bo'limi</span>
        </h1>
        <p class="font-mono text-sm text-slate-500 dark:text-slate-400 uppercase tracking-widest">
            O'zingizga kerakli fanni tanlang va nazariy ma'lumotlar bilan tanishing
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($subjects as $subject)
            <a href="{{ route('subjects.show', $subject->slug) }}" class="group relative block cyber-glass-light dark:cyber-glass p-8 overflow-hidden transition-all duration-500 hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(6,182,212,0.2)]">
                <!-- Background Accent -->
                <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-cyan-500/5 rounded-full blur-3xl group-hover:bg-cyan-500/10 transition-all duration-500"></div>
                
                <div class="relative z-10 flex flex-col h-full">
                    <div class="mb-6">
                        <div class="w-12 h-12 bg-slate-900 dark:bg-cyan-500/20 rounded-lg flex items-center justify-center border border-slate-700 dark:border-cyan-500/30 group-hover:border-cyan-500 transition-colors">
                            <span class="font-display font-black text-xl text-white dark:text-cyan-400">{{ substr($subject->name, 0, 1) }}</span>
                        </div>
                    </div>

                    <h3 class="font-display text-2xl font-bold text-slate-900 dark:text-white mb-2 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                        {{ $subject->name }}
                    </h3>

                    <div class="mt-auto pt-6 flex items-center justify-between border-t border-slate-200 dark:border-white/5">
                        <span class="font-mono text-[10px] uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            {{ $subject->topics_count }} ta mavzu
                        </span>
                        
                        <div class="flex items-center gap-2 text-cyan-600 dark:text-cyan-400">
                            <span class="font-display font-bold text-[10px] uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-2 group-hover:translate-x-0">O'tish</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
