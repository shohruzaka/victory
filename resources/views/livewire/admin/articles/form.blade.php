<div class="space-y-6 animate-reveal">
    <div class="flex items-center justify-between">
        <h2 class="font-display text-xl font-bold uppercase tracking-widest text-slate-900 dark:text-white">
            {{ $article ? 'Maqolani Tahrirlash' : 'Yangi Maqola Qo\'shish' }}
        </h2>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-ghost text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white font-mono text-xs uppercase tracking-widest">
            ← Ortga
        </a>
    </div>

    <div class="cyber-glass-light p-6 md:p-8 relative overflow-hidden transition-all duration-300">
        <form wire:submit="save" class="space-y-6 relative z-10">
            
            <!-- Sarlavha -->
            <div class="form-control w-full space-y-2">
                <label class="label p-0">
                    <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500 dark:text-slate-400 font-bold">Maqola sarlavhasi <span class="text-red-500">*</span></span>
                </label>
                <input wire:model.live.debounce.300ms="title" type="text" placeholder="Maqola sarlavhasini kiriting..." class="input input-bordered w-full bg-white dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-slate-900 dark:text-white focus:border-cyan-600 dark:focus:border-cyan-500 @error('title') border-red-500 dark:border-red-500 focus:border-red-500 dark:focus:border-red-500 @enderror" />
                @error('title') <span class="text-red-500 text-[10px] font-mono uppercase">{{ $message }}</span> @enderror
            </div>

            <!-- Slug -->
            <div class="form-control w-full space-y-2">
                <label class="label p-0">
                    <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500 dark:text-slate-400 font-bold">URL qismi (Slug) <span class="text-red-500">*</span></span>
                </label>
                <input wire:model="slug" type="text" placeholder="maqola-sarlavhasi" class="input input-bordered w-full bg-slate-50 dark:bg-slate-900/30 border-slate-200 dark:border-white/10 text-slate-500 dark:text-slate-400 font-mono text-sm focus:border-cyan-600 dark:focus:border-cyan-500 @error('slug') border-red-500 dark:border-red-500 focus:border-red-500 dark:focus:border-red-500 @enderror" />
                @error('slug') <span class="text-red-500 text-[10px] font-mono uppercase">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Holati -->
                <div class="form-control w-full space-y-2">
                    <label class="label p-0">
                        <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500 dark:text-slate-400 font-bold">Holati <span class="text-red-500">*</span></span>
                    </label>
                    <select wire:model="status" class="select select-bordered w-full bg-white dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-slate-900 dark:text-white focus:border-cyan-600 dark:focus:border-cyan-500 @error('status') border-red-500 dark:border-red-500 @enderror font-display uppercase tracking-wider text-[11px]">
                        <option value="draft">Qoralama</option>
                        <option value="published">Chop etilgan</option>
                    </select>
                    @error('status') <span class="text-red-500 text-[10px] font-mono uppercase">{{ $message }}</span> @enderror
                </div>

                <!-- Muqova rasmi -->
                <div class="form-control w-full space-y-2">
                    <label class="label p-0">
                        <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500 dark:text-slate-400 font-bold">Muqova rasmi (Ixtiyoriy)</span>
                    </label>
                    <input wire:model="image" type="file" class="file-input file-input-bordered w-full bg-white dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-slate-900 dark:text-white focus:border-cyan-600 dark:focus:border-cyan-500 text-sm @error('image') border-red-500 dark:border-red-500 @enderror" accept="image/*" />
                    @error('image') <span class="text-red-500 text-[10px] font-mono uppercase">{{ $message }}</span> @enderror
                    
                    @if ($image)
                        <div class="mt-2 text-[10px] font-mono text-emerald-500 uppercase">Yangi rasm tanlandi</div>
                    @elseif ($existing_image)
                        <div class="mt-2 text-[10px] font-mono text-slate-500">Joriy rasm: <a href="{{ Storage::url($existing_image) }}" target="_blank" class="text-cyan-500 hover:underline">Ko'rish</a></div>
                    @endif
                </div>
            </div>

            <!-- Matn -->
            <div class="form-control w-full space-y-2" wire:ignore>
                <label class="label p-0">
                    <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500 dark:text-slate-400 font-bold">Maqola matni <span class="text-red-500">*</span></span>
                </label>
                <textarea id="article-content" rows="15" placeholder="Maqola matnini bu yerga yozing..." class="textarea textarea-bordered w-full bg-white dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-slate-900 dark:text-white focus:border-cyan-600 dark:focus:border-cyan-500 text-base leading-relaxed @error('content') border-red-500 dark:border-red-500 focus:border-red-500 dark:focus:border-red-500 @enderror">{{ $content }}</textarea>
                @error('content') <span class="text-red-500 text-[10px] font-mono uppercase">{{ $message }}</span> @enderror
            </div>

            <div class="pt-8 border-t border-slate-200 dark:border-white/10 flex justify-end gap-3">
                <a href="{{ route('admin.articles.index') }}" class="btn btn-outline rounded-none border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white font-display uppercase tracking-widest text-xs transition-all">
                    Bekor qilish
                </a>
                <button type="submit" class="btn btn-primary rounded-none border-2 border-cyan-600 dark:border-cyan-400 bg-cyan-600 dark:bg-cyan-400 text-white dark:text-slate-950 hover:bg-transparent hover:text-cyan-600 dark:hover:text-cyan-400 hover:border-cyan-600 dark:hover:border-cyan-400 transition-all font-display uppercase tracking-widest text-xs shadow-sm dark:shadow-[0_0_15px_rgba(6,182,212,0.3)]">
                    Saqlash
                </button>
            </div>
            </form>
            </div>

            @push('scripts')
            <script src="https://cdn.tiny.cloud/1/9188oi4nsr86nfp7v03t5g4owu8g6wlkfh8eq6clm4zlr6cp/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
            <script>
            document.addEventListener('livewire:navigated', () => {
                const initTinyMCE = () => {
                    if (document.getElementById('article-content')) {
                        tinymce.init({
                            selector: '#article-content',
                            height: 600,
                            menubar: false,
                            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code codesample fullscreen insertdatetime media table wordcount',
                            toolbar: 'undo redo | blocks | bold italic codesample | bullist numlist | link image table | removeformat | fullscreen code',
                            skin: document.documentElement.dataset.theme === 'dark' ? 'oxide-dark' : 'oxide',
                            content_css: document.documentElement.dataset.theme === 'dark' ? 'dark' : 'default',
                            codesample_languages: [
                                { text: 'HTML/XML', value: 'markup' },
                                { text: 'JavaScript', value: 'javascript' },
                                { text: 'CSS', value: 'css' },
                                { text: 'PHP', value: 'php' },
                                { text: 'Python', value: 'python' },
                                { text: 'SQL', value: 'sql' },
                                { text: 'Bash', value: 'bash' }
                            ],
                            setup: function (editor) {
                                editor.on('init change', function () {
                                    editor.save();
                                });
                                editor.on('change', function (e) {
                                    @this.set('content', editor.getContent());
                                });
                            }
                        });
                    }
                };

                initTinyMCE();

                // Re-init on Livewire refresh if needed
                document.addEventListener('livewire:load', initTinyMCE);
            }, { once: true });

            // Handle cleanup before navigation
            document.addEventListener('livewire:navigating', () => {
                if (tinymce.get('article-content')) {
                    tinymce.get('article-content').remove();
                }
            });
            </script>
            @endpush
            </div>
