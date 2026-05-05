<div class="max-w-7xl mx-auto space-y-8 animate-reveal">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <h2 class="font-display text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tighter">Savollar <span class="text-cyan-600 dark:text-cyan-400">Statistikasi</span></h2>
            <p class="text-[10px] font-mono text-slate-500 dark:text-slate-400 uppercase tracking-[0.3em] font-bold">Analitika: Eng ko'p xato topilayotgan tugunlar</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.questions.index') }}" class="btn btn-outline border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-400 rounded-none font-display uppercase tracking-widest text-xs px-6 hover:bg-slate-100 dark:hover:bg-white/5 transition-all">
                Orqaga
            </a>
        </div>
    </div>

    <!-- Stats Overview (Optional) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="cyber-glass p-6 border-l-4 border-cyan-600 dark:border-cyan-500">
            <p class="text-[10px] font-mono text-slate-500 uppercase tracking-[0.2em] mb-2 font-bold">Jami Urinishlar</p>
            <div class="text-3xl font-display font-black text-slate-900 dark:text-white">
                {{ \App\Models\Question::sum('total_attempts') }}
            </div>
        </div>
        <div class="cyber-glass p-6 border-l-4 border-emerald-600 dark:border-emerald-500">
            <p class="text-[10px] font-mono text-slate-500 uppercase tracking-[0.2em] mb-2 font-bold">To'g'ri Javoblar</p>
            <div class="text-3xl font-display font-black text-slate-900 dark:text-white">
                {{ \App\Models\Question::sum('correct_attempts') }}
            </div>
        </div>
    </div>

    <!-- Questions Table -->
    <div class="cyber-glass overflow-hidden border-t-2 border-slate-900 dark:border-white/10 transition-all duration-300">
        <div class="overflow-x-auto">
            <table class="table w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 dark:text-slate-400 border-b border-slate-100 dark:border-white/5 font-mono text-[10px] uppercase tracking-widest font-bold">
                        <th class="p-4 text-left">Savol Matni</th>
                        <th class="p-4 text-center">Urinishlar</th>
                        <th class="p-4 text-center">To'g'ri</th>
                        <th class="p-4 text-center">Xato</th>
                        <th class="p-4 text-center">Xatolik (%)</th>
                        <th class="p-4 text-right">Amallar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    @forelse($questions as $question)
                        <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors group">
                            <td class="p-4">
                                <div class="space-y-1">
                                    <div class="text-sm font-medium text-slate-900 dark:text-white line-clamp-2 font-mono">
                                        {{ $question->text }}
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[9px] font-mono text-cyan-600 dark:text-cyan-400 uppercase font-bold">{{ $question->topic->name ?? "Noma'lum Mavzu" }}</span>
                                        <span class="text-[9px] font-mono text-slate-400 uppercase">/</span>
                                        <span class="text-[9px] font-mono text-slate-400 uppercase">{{ $question->difficulty }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-center font-mono text-sm font-bold text-slate-700 dark:text-slate-300">
                                {{ $question->total_attempts }}
                            </td>
                            <td class="p-4 text-center font-mono text-sm font-bold text-emerald-600 dark:text-emerald-400">
                                {{ $question->correct_attempts }}
                            </td>
                            <td class="p-4 text-center font-mono text-sm font-bold text-red-600 dark:text-red-400">
                                {{ $question->total_attempts - $question->correct_attempts }}
                            </td>
                            <td class="p-4">
                                <div class="flex flex-col items-center space-y-2">
                                    <div class="w-full h-1.5 bg-slate-100 dark:bg-slate-900 rounded-full overflow-hidden border border-slate-200 dark:border-white/5">
                                        <div class="h-full {{ $question->fail_rate > 70 ? 'bg-red-600 dark:bg-red-500' : ($question->fail_rate > 40 ? 'bg-amber-600 dark:bg-amber-500' : 'bg-emerald-600 dark:bg-emerald-500') }} transition-all duration-500" style="width: {{ $question->fail_rate }}%"></div>
                                    </div>
                                    <span class="text-xs font-mono font-black {{ $question->fail_rate > 70 ? 'text-red-600 dark:text-red-400' : ($question->fail_rate > 40 ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400') }}">
                                        {{ number_format($question->fail_rate, 1) }}%
                                    </span>
                                </div>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.questions.edit', $question) }}" class="text-cyan-600 dark:text-cyan-400 hover:text-cyan-800 dark:hover:text-cyan-300 font-mono text-[10px] uppercase font-bold transition-colors">
                                    Tahrirlash
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center">
                                <div class="space-y-2">
                                    <p class="text-slate-400 dark:text-slate-500 font-mono text-xs uppercase font-bold tracking-widest">Hozircha ma'lumotlar mavjud emas</p>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-600 uppercase font-bold">Talabalar test yechishni boshlagandan so'ng statistika bu yerda paydo bo'ladi.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($questions->hasPages())
            <div class="p-4 border-t border-slate-100 dark:border-white/5 bg-slate-50/50 dark:bg-slate-900/30">
                {{ $questions->links() }}
            </div>
        @endif
    </div>
</div>
