<div class="space-y-6 animate-reveal">
    <div class="flex items-center justify-between mb-8">
        <h2 class="font-display text-xl font-bold uppercase tracking-widest text-slate-900 dark:text-white">
            Excel / Word <span class="text-cyan-600 dark:text-cyan-400">Import</span>
        </h2>
        <div class="flex gap-4">
            <button wire:click="downloadTemplate" class="btn btn-outline btn-sm rounded-none border-slate-200 dark:border-white/10 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-600 dark:hover:bg-emerald-500 hover:text-white dark:hover:text-slate-950 font-display text-[10px] uppercase transition-all">
                Download Excel Template
            </button>
            <a href="{{ route('admin.questions.index') }}" class="btn btn-ghost btn-sm text-xs font-display uppercase tracking-widest text-slate-500 hover:text-slate-900 dark:hover:text-white">
                Back to List
            </a>
        </div>
    </div>

    @if($step === 1)
        <!-- Step 1: Upload -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="cyber-glass p-8 space-y-8 transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-4 bg-cyan-600 dark:bg-cyan-500 shadow-sm dark:shadow-[0_0_8px_rgba(6,182,212,0.8)]"></div>
                        <h3 class="font-display uppercase tracking-[0.2em] text-xs text-slate-700 dark:text-white font-bold">
                            Faylni Yuklash
                        </h3>
                    </div>

                    <form wire:submit.prevent="parseImport" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">Fan (Subject)</span>
                                </label>
                                <input type="text" wire:model="subject" class="input input-bordered bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-cyan-700 dark:text-cyan-400 focus:border-cyan-600 dark:focus:border-cyan-500 font-mono" placeholder="Masalan: Python">
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">Mavzu (Topic)</span>
                                </label>
                                <input type="text" wire:model="topic" class="input input-bordered bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-cyan-700 dark:text-cyan-400 focus:border-cyan-600 dark:focus:border-cyan-500 font-mono" placeholder="Masalan: Lug'atlar (Ixtiyoriy)">
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">Qiyinchilik</span>
                            </label>
                            <div class="flex gap-4">
                                @foreach(['easy', 'medium', 'hard'] as $level)
                                    <label class="flex items-center gap-2 cursor-pointer group">
                                        <input type="radio" wire:model="difficulty" value="{{ $level }}" class="radio radio-xs {{ $level === 'easy' ? 'radio-success' : ($level === 'medium' ? 'radio-warning' : 'radio-error') }}">
                                        <span class="text-xs font-display uppercase tracking-widest group-hover:text-slate-900 dark:group-hover:text-white transition-colors {{ $difficulty === $level ? 'text-slate-900 dark:text-white font-bold' : 'text-slate-500' }}">
                                            {{ $level }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500">XLSX, DOCX yoki TXT Fayl</span>
                            </label>
                            <input type="file" wire:model="file" class="file-input file-input-bordered w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-slate-700 dark:text-cyan-400 focus:border-cyan-600 dark:focus:border-cyan-500 font-mono text-sm" accept=".xlsx,.xls,.docx,.txt">
                            @error('file') <span class="text-red-500 text-[10px] mt-1 font-mono uppercase">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="btn btn-primary w-full rounded-none border-2 border-cyan-600 dark:border-cyan-400 bg-cyan-600 dark:bg-cyan-400 text-white dark:text-slate-950 hover:bg-transparent hover:text-cyan-600 dark:hover:text-cyan-400 hover:border-cyan-600 dark:hover:border-cyan-400 transition-all font-display uppercase tracking-widest text-xs shadow-md dark:shadow-[0_0_20px_rgba(6,182,212,0.3)]">
                                <span wire:loading.remove wire:target="parseImport">Preview Questions</span>
                                <span wire:loading wire:target="parseImport" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Parsing...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-6">
                <div class="cyber-glass p-6 space-y-4 transition-all duration-300">
                    <h3 class="font-display text-xs font-bold uppercase tracking-[0.2em] text-slate-700 dark:text-white mb-4">Formatlar</h3>
                    
                    <div class="space-y-6 text-[10px] font-mono leading-relaxed text-slate-500 dark:text-slate-400">
                        <div class="space-y-2">
                            <p class="text-emerald-600 dark:text-emerald-400 border-b border-slate-100 dark:border-white/5 pb-1 uppercase font-bold">Variant 1: Excel</p>
                            <p>Shablonni to'ldirib yuklang.</p>
                        </div>

                        <div class="space-y-2">
                            <p class="text-cyan-600 dark:text-cyan-400 border-b border-slate-100 dark:border-white/5 pb-1 uppercase font-bold">Variant 2: Word / Text</p>
                            <div class="bg-slate-50 dark:bg-black/40 p-3 border border-slate-200 dark:border-white/5 rounded text-[9px] leading-tight">
                                ++++<br>
                                Savol matni?<br>
                                ====<br>
                                <span class="text-emerald-600 dark:text-emerald-400">#To'g'ri javob</span><br>
                                ====<br>
                                Noto'g'ri javob 1
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Step 2: Preview -->
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-display text-sm font-bold uppercase tracking-widest text-slate-900 dark:text-white">Import <span class="text-cyan-600 dark:text-cyan-400">Preview</span></h3>
                    <p class="text-[10px] font-mono text-slate-500 mt-1">
                        Jami: {{ $totalFound }} ta | Yaroqli: <span class="text-emerald-600 dark:text-emerald-500 font-bold">{{ $validCount }}</span> ta
                        @if($totalFound > 50) | <span class="text-amber-600 dark:text-amber-500">Dastlabki 50 tasi ko'rsatilmoqda</span> @endif
                    </p>
                </div>
                <div class="flex gap-4">
                    <button wire:click="resetImport" class="btn btn-ghost btn-sm text-xs font-display uppercase text-slate-500 hover:text-slate-900 dark:hover:text-white">Bekor qilish</button>
                    <button wire:click="save" class="btn btn-primary btn-sm rounded-none border-2 border-cyan-600 dark:border-cyan-400 bg-cyan-600 dark:bg-cyan-400 text-white dark:text-slate-950 font-display uppercase tracking-widest text-xs">
                        Tasdiqlash va Saqlash ({{ $validCount }} ta)
                    </button>
                </div>
            </div>

            <div class="cyber-glass-light overflow-hidden transition-all duration-300">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 dark:bg-white/5 border-b border-slate-200 dark:border-white/10 font-display uppercase text-[10px] tracking-[0.2em] text-slate-500 dark:text-slate-400">
                        <tr>
                            <th class="p-4">Savol</th>
                            <th class="p-4">Variantlar</th>
                            <th class="p-4">To'g'ri</th>
                            <th class="p-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="font-sans text-xs">
                        @foreach($this->previewData as $item)
                            <tr class="border-b border-slate-100 dark:border-white/5 {{ $item['is_valid'] ? 'hover:bg-slate-50 dark:hover:bg-cyan-500/5' : 'bg-red-50 dark:bg-red-500/5' }} transition-colors">
                                <td class="p-4 max-w-md">
                                    <p class="text-slate-900 dark:text-white font-medium">{{ Str::limit($item['text'], 80) }}</p>
                                </td>
                                <td class="p-4">
                                    <div class="grid grid-cols-2 gap-2 text-[10px] font-mono text-slate-500 dark:text-slate-500">
                                        @foreach($item['options'] as $opt)
                                            <span class="{{ $opt['letter'] === $item['correct_letter'] ? 'text-emerald-600 dark:text-emerald-400 font-bold' : '' }}">
                                                {{ $opt['letter'] }}) {{ Str::limit($opt['text'], 20) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="p-4 font-mono font-bold text-cyan-700 dark:text-cyan-400 text-center">{{ $item['correct_letter'] ?? '?' }}</td>
                                <td class="p-4">
                                    @if($item['is_valid'])
                                        <span class="text-emerald-600 dark:text-emerald-500 flex items-center gap-1 font-mono uppercase text-[9px] font-bold">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            Ready
                                        </span>
                                    @else
                                        <div class="text-red-600 dark:text-red-400 space-y-1 font-mono text-[9px] uppercase font-bold">
                                            @foreach($item['errors'] as $error)
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                    {{ $error }}
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

