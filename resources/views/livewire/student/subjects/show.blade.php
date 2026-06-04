<div class="relative min-h-screen bg-slate-50 dark:bg-slate-950">
    <!-- Immersive Header -->
    <div class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-white/5 pb-16 pt-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="mb-8">
                <a href="{{ route('subjects.index') }}" class="group inline-flex items-center gap-2 font-mono text-[10px] uppercase tracking-[0.3em] text-cyan-600 dark:text-cyan-500 hover:text-cyan-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Barcha fanlar
                </a>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="space-y-4">
                    <h1 class="font-display text-4xl md:text-5xl font-black uppercase tracking-tight text-slate-900 dark:text-white leading-none">
                        {{ $subject->name }}
                    </h1>
                    <p class="max-w-2xl text-slate-500 dark:text-slate-400 font-medium leading-relaxed">
                        Ushbu kurs davomida siz {{ strtolower($subject->name) }} fanining barcha asosiy va mukammal tushunchalarini o'rganasiz.
                    </p>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="text-center px-6 border-r border-slate-200 dark:border-white/10">
                        <span class="block font-display font-black text-2xl text-slate-900 dark:text-white">{{ $subject->topics->count() }}</span>
                        <span class="font-mono text-[9px] uppercase tracking-widest text-slate-400">Mavzular</span>
                    </div>
                    <div class="text-center px-6">
                        <span class="block font-display font-black text-2xl text-cyan-600 dark:text-cyan-400">{{ $subject->articles()->count() }}</span>
                        <span class="font-mono text-[9px] uppercase tracking-widest text-slate-400">Maqolalar</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Curriculum List (Matching mavzular.png) -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="space-y-4">
            @forelse($subject->topics as $index => $topic)
                <div x-data="{ expanded: false }" class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/5 rounded-2xl transition-all duration-300 hover:shadow-xl hover:shadow-cyan-500/5 hover:border-cyan-500/30">
                    <div @click="expanded = !expanded" class="p-6 flex items-center gap-6 cursor-pointer">
                        <!-- Step Number or Icon -->
                        <div class="flex-shrink-0 w-14 h-14 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center border border-slate-100 dark:border-white/10 group-hover:bg-cyan-500/10 group-hover:border-cyan-500/20 transition-all duration-500">
                            <span class="font-display font-black text-xl text-slate-300 dark:text-slate-700 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        <!-- Topic Details -->
                        <div class="flex-grow min-w-0">
                            <h3 class="font-display text-xl font-bold text-slate-900 dark:text-white truncate group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors mb-1">
                                {{ $topic->name }}
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-500 line-clamp-1">
                                {{ $topic->description ?? "Ushbu bo'limda " . strtolower($topic->name) . " mavzusining asosiy tamoyillari va amaliy misollari o'rganiladi." }}
                            </p>
                        </div>

                        <!-- Action Button -->
                        <div class="flex-shrink-0">
                            <button class="flex items-center justify-center w-10 h-10 rounded-xl bg-slate-50 dark:bg-white/5 text-slate-400 hover:bg-cyan-600 dark:hover:bg-cyan-500 hover:text-white transition-all duration-300">
                                <svg x-show="!expanded" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                                <svg x-show="expanded" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Articles List -->
                    <div x-show="expanded" x-collapse style="display: none;">
                        <div class="px-6 pb-6 pt-2 border-t border-slate-100 dark:border-white/5">
                            <div class="space-y-2 md:pl-[5rem]">
                                @foreach($topic->articles as $article)
                                    <a href="{{ route('articles.show', $article->slug) }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-white/5 transition-colors group/article">
                                        <div class="flex items-center gap-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-hover/article:text-cyan-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span class="text-slate-700 dark:text-slate-300 font-medium group-hover/article:text-cyan-600 dark:group-hover/article:text-cyan-400 transition-colors">{{ $article->title }}</span>
                                        </div>
                                        <span class="text-xs font-mono text-slate-400 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            {{ number_format($article->views) }}
                                        </span>
                                    </a>
                                @endforeach
                                
                                @if($topic->articles->isEmpty())
                                    <div class="flex items-center gap-3 p-3 text-slate-500 dark:text-slate-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        <span class="text-sm">Ushbu mavzuga oid maqolalar hali yuklanmagan.</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-24 text-center">
                    <div class="inline-block p-12 bg-white dark:bg-slate-900 border-2 border-dashed border-slate-200 dark:border-white/10 rounded-[3rem]">
                        <p class="font-display text-xl font-bold text-slate-400 dark:text-slate-600 uppercase tracking-widest">
                            Ushbu fanda hali mavzular yaratilmagan
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
