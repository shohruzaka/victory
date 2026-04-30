<div class="space-y-8 animate-reveal">
    <div class="flex items-center justify-between">
        <h2 class="font-display text-xl font-bold uppercase tracking-widest text-white">
            Fanlar va <span class="text-cyan-400">Mavzular</span>
        </h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Subjects Panel -->
        <div class="space-y-6">
            <div class="cyber-glass p-6">
                <h3 class="font-display text-xs font-bold uppercase tracking-[0.2em] text-white mb-6 flex items-center gap-2">
                    <div class="w-1 h-3 bg-cyan-500"></div> Fan Qo'shish
                </h3>
                
                <form wire:submit.prevent="addSubject" class="flex gap-4">
                    <input type="text" wire:model="newSubjectName" class="input input-bordered flex-grow bg-slate-900/50 border-white/10 text-cyan-400 focus:border-cyan-500 font-mono text-sm" placeholder="Yangi fan nomi (masalan: C++)">
                    <button type="submit" class="btn btn-primary rounded-none border-2 border-cyan-400 bg-cyan-400 text-slate-950 font-display uppercase tracking-widest text-[10px]">Add</button>
                </form>
                @error('newSubjectName') <span class="text-red-500 text-[10px] mt-1 font-mono uppercase">{{ $message }}</span> @enderror
            </div>

            <div class="cyber-glass-light overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-white/5 border-b border-white/10 font-display uppercase text-[10px] tracking-widest text-slate-500">
                        <tr>
                            <th class="p-4">Fan Nomi</th>
                            <th class="p-4 text-center">Mavzular</th>
                            <th class="p-4 text-right">Amallar</th>
                        </tr>
                    </thead>
                    <tbody class="font-sans text-sm">
                        @foreach($subjects as $subject)
                            <tr class="border-b border-white/5 hover:bg-white/5 transition-all cursor-pointer {{ $selectedSubjectId == $subject->id ? 'bg-cyan-500/10' : '' }}" wire:click="selectSubject({{ $subject->id }})">
                                <td class="p-4">
                                    <span class="text-white font-bold uppercase tracking-tight">{{ $subject->name }}</span>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="badge badge-outline border-white/20 text-slate-400 text-[10px]">{{ $subject->topics_count }} ta</span>
                                </td>
                                <td class="p-4 text-right">
                                    <button wire:click.stop="deleteSubject({{ $subject->id }})" wire:confirm="Ushbu fanni o'chirsangiz barcha savollar ham o'chib ketishi mumkin. Rozimisiz?" class="p-1 text-slate-600 hover:text-red-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Topics Panel -->
        <div class="space-y-6">
            @if($selectedSubject)
                <div class="cyber-glass p-6 border-l-4 border-fuchsia-500 animate-reveal">
                    <h3 class="font-display text-xs font-bold uppercase tracking-[0.2em] text-white mb-6 flex items-center gap-2">
                        <div class="w-1 h-3 bg-fuchsia-500"></div> [{{ $selectedSubject->name }}] Mavzulari
                    </h3>
                    
                    <form wire:submit.prevent="addTopic" class="flex gap-4">
                        <input type="text" wire:model="newTopicName" class="input input-bordered flex-grow bg-slate-900/50 border-white/10 text-fuchsia-400 focus:border-fuchsia-500 font-mono text-sm" placeholder="Yangi mavzu nomi">
                        <button type="submit" class="btn btn-secondary rounded-none border-2 border-fuchsia-500 bg-fuchsia-500 text-slate-950 font-display uppercase tracking-widest text-[10px]">Add</button>
                    </form>
                    @error('newTopicName') <span class="text-red-500 text-[10px] mt-1 font-mono uppercase">{{ $message }}</span> @enderror
                </div>

                <div class="cyber-glass-light overflow-hidden animate-reveal">
                    <table class="w-full text-left">
                        <thead class="bg-white/5 border-b border-white/10 font-display uppercase text-[10px] tracking-widest text-slate-500">
                            <tr>
                                <th class="p-4">Mavzu Nomi</th>
                                <th class="p-4 text-right">Amallar</th>
                            </tr>
                        </thead>
                        <tbody class="font-sans text-xs">
                            @forelse($selectedSubject->topics as $topic)
                                <tr class="border-b border-white/5 hover:bg-white/5 transition-all">
                                    <td class="p-4">
                                        <span class="text-slate-200">{{ $topic->name }}</span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <button wire:click="deleteTopic({{ $topic->id }})" class="p-1 text-slate-700 hover:text-red-500 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="p-8 text-center text-slate-600 italic">Mavzular qo'shilmagan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <div class="h-full flex flex-col items-center justify-center border border-dashed border-white/5 rounded-lg p-12 text-slate-600">
                    <svg class="w-12 h-12 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="font-display uppercase tracking-widest text-xs">Mavzularni ko'rish uchun fanni tanlang</p>
                </div>
            @endif
        </div>
    </div>
</div>
