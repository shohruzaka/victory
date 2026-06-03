<div class="relative min-h-screen">
    <!-- Immersive Background -->
    <div class="absolute top-0 left-0 w-full h-[50vh] bg-gradient-to-b from-cyan-500/5 to-transparent pointer-events-none z-0"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10 animate-reveal">
        <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <a href="{{ route('subjects.index') }}" class="group flex items-center gap-2 font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-600 dark:text-cyan-500 hover:text-cyan-500 transition-colors mb-4 inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Barcha fanlar
                </a>
                <h1 class="font-display text-4xl md:text-5xl font-black uppercase tracking-tight text-slate-900 dark:text-white mb-2 dark:neon-text-cyan">
                    {{ $subject->name }}
                </h1>
                <p class="font-mono text-xs text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em]">
                    Neural_Learning_Grid // Subjects // {{ $subject->slug }}
                </p>
            </div>
            
            <div class="hidden md:block">
                <div class="px-8 py-4 cyber-glass-light dark:cyber-glass border border-slate-200 dark:border-white/10 shadow-xl">
                    <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 block mb-1">Mavzular_Soni</span>
                    <span class="font-display font-black text-3xl text-cyan-600 dark:text-cyan-400">{{ $subject->topics->count() }}</span>
                </div>
            </div>
        </div>

        <div class="space-y-16">
            @foreach($subject->topics as $topic)
                <div class="relative">
                    <!-- Topic Header -->
                    <div class="flex items-center gap-6 mb-8 group">
                        <div class="w-12 h-12 bg-slate-900 dark:bg-cyan-500/10 rounded-lg flex items-center justify-center border border-slate-700 dark:border-cyan-500/30 group-hover:border-cyan-500 transition-all duration-300 shadow-lg">
                            <span class="font-display font-black text-lg text-white dark:text-cyan-400">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div>
                            <h2 class="font-display text-2xl font-bold text-slate-900 dark:text-white uppercase tracking-widest group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                                {{ $topic->name }}
                            </h2>
                            <div class="w-12 h-1 bg-cyan-600 dark:bg-cyan-500 mt-1 transform origin-left transition-transform group-hover:scale-x-150"></div>
                        </div>
                    </div>

                    <!-- Articles Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-0 md:pl-20">
                        @forelse($topic->articles as $article)
                            <a href="{{ route('articles.show', $article->slug) }}" class="group relative flex items-center gap-6 p-6 cyber-glass-light dark:cyber-glass border border-slate-200 dark:border-white/10 hover:border-cyan-500/50 transition-all duration-500 hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(6,182,212,0.1)]">
                                <!-- Accent -->
                                <div class="absolute top-0 left-0 w-1 h-0 bg-cyan-500 group-hover:h-full transition-all duration-500"></div>
                                
                                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800/50 flex items-center justify-center border border-slate-200 dark:border-white/5 text-slate-400 group-hover:text-cyan-500 group-hover:bg-cyan-500/10 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                
                                <div class="flex-grow">
                                    <h4 class="font-display text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors mb-2">
                                        {{ $article->title }}
                                    </h4>
                                    <div class="flex items-center gap-4 font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500 dark:text-slate-500">
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            {{ number_format($article->views) }}
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $article->created_at->format('d.m.Y') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-shrink-0 opacity-0 group-hover:opacity-100 transform translate-x-4 group-hover:translate-x-0 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full py-8 px-6 bg-slate-50/50 dark:bg-white/5 border border-dashed border-slate-200 dark:border-white/10 rounded-xl">
                                <p class="font-mono text-[10px] uppercase tracking-[0.3em] text-slate-400 text-center italic">
                                    Hozircha nazariy materiallar yuklanmagan
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
