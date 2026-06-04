<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 animate-reveal">
    <div class="mb-16">
        <h1 class="font-display text-4xl font-black uppercase tracking-widest text-slate-900 dark:text-white mb-2">
            Nazariy <span class="text-cyan-600 dark:text-cyan-500">ma'lumotlar</span>
        </h1>
        <p class="font-mono text-xs text-slate-500 dark:text-slate-400 uppercase tracking-widest">
            Barcha mavjud nazariy materiallar va qo'llanmalar ro'yxati
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($articles as $article)
            <article class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/5 rounded-3xl overflow-hidden transition-all duration-500 hover:border-cyan-500/30 hover:shadow-2xl hover:shadow-cyan-500/5 flex flex-col">
                <!-- Thumbnail -->
                @if($article->image)
                    <div class="aspect-video w-full overflow-hidden relative">
                        <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/20 to-transparent"></div>
                    </div>
                @else
                    <div class="aspect-video w-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center border-b border-slate-200 dark:border-white/5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 2v4a2 2 0 002 2h4" />
                        </svg>
                    </div>
                @endif

                <div class="p-8 flex flex-col flex-grow">
                    <!-- Meta -->
                    <div class="flex items-center gap-3 mb-4">
                        @if($article->topic)
                            <span class="px-2 py-0.5 rounded bg-cyan-600/10 text-cyan-600 dark:text-cyan-400 font-mono text-[8px] uppercase tracking-widest border border-cyan-600/20">
                                {{ $article->topic->subject->name }}
                            </span>
                        @endif
                        <span class="font-mono text-[8px] uppercase tracking-widest text-slate-400">
                            {{ $article->created_at->format('d.m.Y') }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h2 class="font-display text-2xl font-bold text-slate-900 dark:text-white leading-tight mb-4 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                        <a href="{{ route('articles.show', $article->slug) }}">
                            {{ $article->title }}
                        </a>
                    </h2>

                    <!-- Excerpt (simulated) -->
                    <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-3 mb-8 flex-grow">
                        {{ Str::limit(strip_tags($article->content), 150) }}
                    </p>

                    <!-- Footer Action -->
                    <div class="pt-6 border-t border-slate-100 dark:border-white/5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span class="font-mono text-[9px] text-slate-400">{{ number_format($article->views) }}</span>
                        </div>

                        <a href="{{ route('articles.show', $article->slug) }}" class="inline-flex items-center gap-2 font-display text-[10px] font-black uppercase tracking-[0.2em] text-cyan-600 dark:text-cyan-400">
                            O'qish <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-16">
        {{ $articles->links() }}
    </div>
</div>
