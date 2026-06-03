<div x-data="{ 
        percent: 0,
        updateProgress() {
            let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            this.percent = (winScroll / height) * 100;
        }
    }" 
    x-init="window.addEventListener('scroll', () => updateProgress())"
    class="relative">
    
    <!-- Reading Progress Bar -->
    <div class="fixed top-0 left-0 w-full h-1 z-[60] pointer-events-none">
        <div class="h-full bg-cyan-500 shadow-[0_0_10px_#06b6d4] transition-all duration-150 ease-out" :style="`width: ${percent}%`"></div >
    </div>

    <!-- Immersive Header Background -->
    <div class="absolute top-0 left-0 w-full h-[50vh] bg-gradient-to-b from-cyan-500/5 to-transparent pointer-events-none z-0"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10 animate-reveal">
        <!-- Breadcrumbs -->
        <nav class="mb-12 flex flex-wrap items-center gap-2 font-mono text-[10px] uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">
            <a href="{{ route('subjects.index') }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">Fanlar</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            @if($article->topic)
                <a href="{{ route('subjects.show', $article->topic->subject->slug) }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">{{ $article->topic->subject->name }}</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-slate-400 dark:text-slate-600">{{ $article->topic->name }}</span>
            @else
                <span class="text-slate-400 dark:text-slate-600">Umumiy</span>
            @endif
        </nav>

        <!-- Article Header -->
        <header class="mb-16">
            @if($article->image)
                <div class="mb-12 aspect-video w-full overflow-hidden rounded-2xl border border-slate-200 dark:border-white/10 shadow-2xl relative group">
                    <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 to-transparent"></div>
                </div>
            @endif

            <h1 class="font-display text-4xl md:text-6xl font-black text-slate-900 dark:text-white mb-8 leading-[1.1] tracking-tight dark:neon-text-cyan">
                {{ $article->title }}
            </h1>
            
            <div class="flex flex-wrap items-center justify-between gap-6 py-8 border-y border-slate-200 dark:border-white/10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-slate-100 dark:bg-slate-900/80 rounded-full flex items-center justify-center border border-slate-200 dark:border-white/10 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-600 dark:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-display text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                            {{ $article->user->name }}
                        </p>
                        <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500 dark:text-slate-500">System_Architect</p>
                    </div>
                </div>

                <div class="flex items-center gap-8">
                    <div class="text-right">
                        <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-400 dark:text-slate-600 mb-1">Ko'rishlar</p>
                        <p class="font-display text-sm font-bold text-slate-900 dark:text-cyan-400">{{ number_format($article->views) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-400 dark:text-slate-600 mb-1">Sana</p>
                        <p class="font-display text-sm font-bold text-slate-900 dark:text-slate-300">{{ $article->created_at->format('d.m.Y') }}</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Article Content -->
        <div class="cyber-glass-light dark:cyber-glass p-8 md:p-12 mb-16 relative overflow-hidden group">
            <!-- Content Accent -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/5 blur-3xl pointer-events-none"></div>
            
            <article class="prose prose-slate dark:prose-invert prose-cyan max-w-none 
                prose-headings:font-display prose-headings:uppercase prose-headings:tracking-widest 
                prose-p:text-slate-600 dark:prose-p:text-slate-300 prose-p:text-lg prose-p:leading-relaxed
                prose-pre:bg-slate-950/80 prose-pre:backdrop-blur-sm prose-pre:border prose-pre:border-white/10 prose-pre:rounded-xl
                prose-strong:text-cyan-600 dark:prose-strong:text-cyan-400 prose-strong:font-bold
                prose-a:text-cyan-600 dark:prose-a:text-cyan-400 prose-a:no-underline hover:prose-a:underline
                prose-img:rounded-2xl prose-img:border prose-img:border-slate-200 dark:prose-img:border-white/10">
                {!! $article->content !!}
            </article>
        </div>

        <!-- Footer -->
        <footer class="pt-12 border-t border-slate-200 dark:border-white/10 flex flex-col sm:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-4">
                @if($article->topic)
                    <a href="{{ route('subjects.show', $article->topic->subject->slug) }}" class="group flex items-center gap-2 font-display text-[10px] uppercase tracking-[0.2em] text-cyan-600 dark:text-cyan-500 hover:text-cyan-500 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Mavzuga qaytish
                    </a>
                @else
                    <a href="{{ route('subjects.index') }}" class="group flex items-center gap-2 font-display text-[10px] uppercase tracking-[0.2em] text-cyan-600 dark:text-cyan-500 hover:text-cyan-500 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Fanlar ro'yxati
                    </a>
                @endif
            </div>

            <div class="flex items-center gap-3">
                <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-400">Share_Protocol:</span>
                <div class="flex gap-2">
                    <button class="w-8 h-8 rounded bg-slate-100 dark:bg-slate-800 flex items-center justify-center border border-slate-200 dark:border-white/10 hover:border-cyan-500/50 hover:text-cyan-500 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </button>
                    <button class="w-8 h-8 rounded bg-slate-100 dark:bg-slate-800 flex items-center justify-center border border-slate-200 dark:border-white/10 hover:border-fuchsia-500/50 hover:text-fuchsia-500 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </button>
                </div>
            </div>
        </footer>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" integrity="sha512-VS9TV9S8PToJvD0D6S0n89Fq0p/ZpWc2zB8mCj8oIeW/wN6R4F4W4F/7Z8kRzZzZzZzZzZzZzZzZzZzZzZzZzZ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    /* Custom prose styles to match CyberArena aesthetic */
    .prose pre {
        background-color: rgba(2, 6, 23, 0.9) !important;
        backdrop-filter: blur(12px);
        box-shadow: 0 0 30px rgba(6, 182, 212, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
    }
    .prose code {
        font-family: 'JetBrains Mono', monospace;
        background-color: rgba(6, 182, 212, 0.1);
        color: #06b6d4;
        padding: 0.15rem 0.35rem;
        border-radius: 0.375rem;
        font-weight: 500;
        font-size: 0.875em;
    }
    .prose pre code {
        background-color: transparent;
        color: inherit;
        padding: 0;
        font-size: 0.9em;
    }
    .prose strong {
        color: #06b6d4;
        text-shadow: 0 0 10px rgba(6, 182, 212, 0.2);
    }
    .dark .prose strong {
        color: #22d3ee;
        text-shadow: 0 0 15px rgba(34, 211, 238, 0.3);
    }
    
    /* Animation for initial load */
    .animate-reveal {
        animation: reveal 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes reveal {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-cpp.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup.min.js"></script>
@endpush
