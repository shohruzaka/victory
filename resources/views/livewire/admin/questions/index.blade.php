<div class="space-y-6 animate-reveal">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-display text-xl font-bold uppercase tracking-widest text-slate-900 dark:text-white">
            Savollar <span class="text-cyan-600 dark:text-cyan-400">Bazasi</span>
        </h2>
        
        <div class="flex gap-3">
            <a href="{{ route('admin.questions.import') }}" class="btn btn-outline rounded-none border-slate-200 dark:border-white/10 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/5 transition-all font-display uppercase tracking-widest text-xs">
                DOCX / Excel Import
            </a>
            <a href="{{ route('admin.questions.create') }}" class="btn btn-primary rounded-none border-2 border-cyan-600 dark:border-cyan-400 bg-cyan-600 dark:bg-cyan-400 text-white dark:text-slate-950 hover:bg-transparent hover:text-cyan-600 dark:hover:text-cyan-400 hover:border-cyan-600 dark:hover:border-cyan-400 transition-all font-display uppercase tracking-widest text-xs shadow-sm dark:shadow-none">
                Yangi Savol Qo'shish
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="cyber-glass p-4 grid grid-cols-1 md:grid-cols-4 gap-4 shadow-sm transition-all duration-300">
        <div class="form-control w-full">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Savol bo'yicha qidirish..." class="input input-sm input-bordered bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-cyan-700 dark:text-cyan-400 focus:border-cyan-600 dark:focus:border-cyan-500 font-mono">
        </div>
        <div class="form-control w-full">
            <input wire:model.live.debounce.300ms="subject" type="text" placeholder="Fan (Subject)..." class="input input-sm input-bordered bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-cyan-700 dark:text-cyan-400 focus:border-cyan-600 dark:focus:border-cyan-500 font-mono">
        </div>
        <div class="form-control w-full">
            <input wire:model.live.debounce.300ms="topic" type="text" placeholder="Mavzu (Topic)..." class="input input-sm input-bordered bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-cyan-700 dark:text-cyan-400 focus:border-cyan-600 dark:focus:border-cyan-500 font-mono">
        </div>
        <div class="form-control w-full">
            <select wire:model.live="difficulty" class="select select-sm select-bordered bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-slate-700 dark:text-slate-300 focus:border-cyan-600 dark:focus:border-cyan-500 font-display uppercase tracking-wider text-[10px]">
                <option value="">Barcha Qiyinchiliklar</option>
                <option value="easy">Easy (10 XP)</option>
                <option value="medium">Medium (20 XP)</option>
                <option value="hard">Hard (30 XP)</option>
            </select>
        </div>
    </div>

    <!-- Messages -->
    @if (session()->has('message'))
        <div class="alert alert-success bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/50 text-emerald-700 dark:text-emerald-400 rounded-none font-mono text-xs">
            {{ session('message') }}
        </div>
    @endif

    <!-- Table -->
    <div class="cyber-glass-light overflow-hidden transition-all duration-300">
        <table class="w-full text-left">
            <thead class="bg-slate-50 dark:bg-white/5 border-b border-slate-200 dark:border-white/10 font-display uppercase text-[10px] tracking-[0.2em] text-slate-500 dark:text-slate-400">
                <tr>
                    <th class="p-4">Savol Matni</th>
                    <th class="p-4">Fan</th>
                    <th class="p-4">Qiyinchilik</th>
                    <th class="p-4 text-right">Amallar</th>
                </tr>
            </thead>
            <tbody class="font-sans text-sm">
                @forelse($questions as $question)
                    <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                        <td class="p-4 max-w-xs">
                            <p class="text-slate-900 dark:text-white font-medium truncate">{{ $question->text }}</p>
                        </td>
                        <td class="p-4">
                            <span class="text-cyan-700 dark:text-cyan-400 font-mono text-[10px] uppercase tracking-tighter font-bold">{{ $question->topic->subject->name ?? 'N/A' }}</span>
                        </td>
                        <td class="p-4">
                            @if($question->difficulty === 'easy')
                                <span class="badge badge-outline border-emerald-500/50 text-emerald-600 dark:text-emerald-500 text-[9px] uppercase font-bold">Easy</span>
                            @elseif($question->difficulty === 'medium')
                                <span class="badge badge-outline border-amber-500/50 text-amber-600 dark:text-amber-500 text-[9px] uppercase font-bold">Medium</span>
                            @else
                                <span class="badge badge-outline border-red-500/50 text-red-600 dark:text-red-400 text-[9px] uppercase font-bold">Hard</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.questions.edit', $question) }}" class="p-1 text-slate-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                </a>
                                <button 
                                    wire:click="deleteQuestion({{ $question->id }})" 
                                    wire:confirm="Haqiqatan ham ushbu savolni o'chirmoqchimisiz?"
                                    class="p-1 text-slate-400 hover:text-red-600 transition-colors"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center">
                            <p class="text-slate-400 dark:text-slate-500 font-display uppercase tracking-widest italic">Savollar topilmadi</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $questions->links() }}
    </div>
</div>

