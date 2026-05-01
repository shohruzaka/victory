<div class="space-y-6 animate-reveal">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-display text-xl font-bold uppercase tracking-widest text-slate-900 dark:text-white">
            Talabalar <span class="text-fuchsia-600 dark:text-fuchsia-500">Boshqaruvi</span>
        </h2>
    </div>

    <!-- Filters -->
    <div class="cyber-glass p-4 shadow-sm transition-all duration-300">
        <div class="form-control w-full max-w-md">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Ism, email yoki guruh bo'yicha qidirish..." class="input input-sm input-bordered bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-fuchsia-700 dark:text-fuchsia-400 focus:border-fuchsia-600 dark:focus:border-fuchsia-500 font-mono">
        </div>
    </div>

    <!-- Messages -->
    @if (session()->has('message'))
        <div class="alert alert-success bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/50 text-emerald-700 dark:text-emerald-400 rounded-none font-mono text-xs">
            {{ session('message') }}
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="alert alert-error bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/50 text-red-700 dark:text-red-400 rounded-none font-mono text-xs">
            {{ session('error') }}
        </div>
    @endif

    <!-- Table -->
    <div class="cyber-glass-light overflow-hidden transition-all duration-300">
        <table class="w-full text-left">
            <thead class="bg-slate-50 dark:bg-white/5 border-b border-slate-200 dark:border-white/10 font-display uppercase text-[10px] tracking-[0.2em] text-slate-500 dark:text-slate-400">
                <tr>
                    <th class="p-4">Talaba</th>
                    <th class="p-4 text-center">Guruh</th>
                    <th class="p-4 text-center">Daraja</th>
                    <th class="p-4 text-right">XP</th>
                    <th class="p-4 text-right">Amallar</th>
                </tr>
            </thead>
            <tbody class="font-sans text-sm">
                @forelse($users as $user)
                    <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full border border-slate-200 dark:border-white/10 overflow-hidden shadow-sm">
                                    <img src="{{ $user->avatar_url }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-slate-900 dark:text-white font-bold uppercase tracking-tight">{{ $user->name }}</span>
                                    <span class="text-[10px] text-slate-500 font-mono">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            <span class="badge badge-outline border-cyan-500/50 text-cyan-600 dark:text-cyan-400 text-[10px] font-mono uppercase font-bold">{{ $user->group_name ?: '---' }}</span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-slate-900 dark:text-white font-display font-black text-xs">LVL {{ $user->level }}</span>
                                <span class="text-[9px] text-slate-500 uppercase font-mono tracking-tighter">{{ $user->rank }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-right">
                            <span class="font-mono font-bold text-cyan-700 dark:text-cyan-400">{{ number_format($user->xp) }}</span>
                        </td>
                        <td class="p-4 text-right">
                            <button 
                                wire:click="deleteUser({{ $user->id }})" 
                                wire:confirm="Ushbu talabani o'chirishga aminmisiz? Barcha natijalar ham o'chib ketadi!"
                                class="p-1 text-slate-400 hover:text-red-600 transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center">
                            <p class="text-slate-400 dark:text-slate-500 font-display uppercase tracking-widest italic">Talabalar topilmadi</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
