<div class="space-y-6 animate-reveal">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-display text-xl font-bold uppercase tracking-widest text-white">
            Savollar <span class="text-cyan-400">Bazasi</span>
        </h2>
        
        <div class="flex gap-3">
            <a href="{{ route('admin.questions.import') }}" class="btn btn-outline rounded-none border-white/10 text-slate-400 hover:text-white hover:bg-white/5 transition-all font-display uppercase tracking-widest text-xs">
                DOCX / Excel Import
            </a>
            <a href="{{ route('admin.questions.create') }}" class="btn btn-primary rounded-none border-2 border-cyan-400 bg-cyan-400 text-slate-950 hover:bg-transparent hover:text-cyan-400 hover:border-cyan-400 transition-all font-display uppercase tracking-widest text-xs">
                Yangi Savol Qo'shish
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="cyber-glass p-4 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="form-control w-full">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Savol bo'yicha qidirish..." class="input input-sm input-bordered bg-slate-900/50 border-white/10 text-cyan-400 focus:border-cyan-500 font-mono">
        </div>
        <div class="form-control w-full">
            <input wire:model.live.debounce.300ms="subject" type="text" placeholder="Fan (Subject)..." class="input input-sm input-bordered bg-slate-900/50 border-white/10 text-cyan-400 focus:border-cyan-500 font-mono">
        </div>
        <div class="form-control w-full">
            <input wire:model.live.debounce.300ms="topic" type="text" placeholder="Mavzu (Topic)..." class="input input-sm input-bordered bg-slate-900/50 border-white/10 text-cyan-400 focus:border-cyan-500 font-mono">
        </div>
        <div class="form-control w-full">
            <select wire:model.live="difficulty" class="select select-sm select-bordered bg-slate-900/50 border-white/10 text-slate-300 focus:border-cyan-500 font-display uppercase tracking-wider text-[10px]">
                <option value="">Barcha Qiyinchiliklar</option>
                <option value="easy">Easy (10 XP)</option>
                <option value="medium">Medium (20 XP)</option>
                <option value="hard">Hard (30 XP)</option>
            </select>
        </div>
    </div>

    <!-- Messages -->
    @if (session()->has('message'))
        <div class="alert alert-success bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 rounded-none font-mono text-xs">
            {{ session('message') }}
        </div>
    @endif

    <!-- Table -->
    <div class="cyber-glass-light overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-white/5 border-b border-white/10 font-display uppercase text-[10px] tracking-[0.2em] text-slate-500">
                <tr>
                    <th class="p-4">Savol Matni</th>
                    <th class="p-4">Fan / Mavzu</th>
                    <th class="p-4">Qiyinchilik / Ball</th>
                    <th class="p-4">Variantlar</th>
                    <th class="p-4 text-right">Amallar</th>
                </tr>
            </thead>
            <tbody class="font-sans text-sm">
                @forelse($questions as $question)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                        <td class="p-4 max-w-xs">
                            <p class="text-white font-medium truncate">{{ $question->text }}</p>
                        </td>
                        <td class="p-4">
                            <div class="flex flex-col">
                                <span class="text-cyan-400 font-mono text-[10px] uppercase tracking-tighter">{{ $question->subject }}</span>
                                <span class="text-slate-500 font-mono text-[9px] uppercase">{{ $question->topic ?: '---' }}</span>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex flex-col gap-1">
                                @if($question->difficulty === 'easy')
                                    <span class="badge badge-outline border-emerald-500/50 text-emerald-500 text-[9px] uppercase">Easy</span>
                                @elseif($question->difficulty === 'medium')
                                    <span class="badge badge-outline border-amber-500/50 text-amber-500 text-[9px] uppercase">Medium</span>
                                @else
                                    <span class="badge badge-outline border-red-500/50 text-red-500 text-[9px] uppercase">Hard</span>
                                @endif
                                <span class="text-[10px] font-mono text-slate-400">{{ $question->points }} XP</span>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="text-cyan-400 font-mono text-xs">{{ $question->options_count }} ta</span>
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.questions.edit', $question) }}" class="p-1 hover:text-cyan-400 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                </a>
                                <button 
                                    wire:click="deleteQuestion({{ $question->id }})" 
                                    wire:confirm="Haqiqatan ham ushbu savolni o'chirmoqchimisiz?"
                                    class="p-1 hover:text-red-500 transition-colors"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center">
                            <p class="text-slate-500 font-display uppercase tracking-widest italic">Savollar topilmadi</p>
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
