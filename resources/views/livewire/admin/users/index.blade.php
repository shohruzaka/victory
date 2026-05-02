<div class="space-y-6 animate-reveal">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-display text-xl font-bold uppercase tracking-widest text-slate-900 dark:text-white">
            Foydalanuvchilar <span class="text-fuchsia-600 dark:text-fuchsia-500">Boshqaruvi</span>
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
                    <th class="p-4">Foydalanuvchi</th>
                    <th class="p-4 text-center">Rol</th>
                    <th class="p-4 text-center">Guruh</th>
                    <th class="p-4 text-center">Daraja</th>
                    <th class="p-4 text-right">XP</th>
                    <th class="p-4 text-right">Amallar</th>
                </tr>
            </thead>
            <tbody class="font-sans text-sm">
                @forelse($users as $user)
                    <tr class="border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors {{ $user->id === auth()->id() ? 'bg-cyan-50/30 dark:bg-cyan-500/5' : '' }}">
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
                            @if($user->isAdmin())
                                <span class="badge badge-error gap-1 rounded-none font-display text-[9px] uppercase tracking-tighter shadow-[0_0_10px_rgba(239,68,68,0.2)]">
                                    <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29L5.21 21L12 18L18.79 21L19.5 20.29L12 2Z"/></svg>
                                    Admin
                                </span>
                            @else
                                <span class="badge badge-ghost gap-1 rounded-none font-display text-[9px] uppercase tracking-tighter text-slate-400">
                                    Talaba
                                </span>
                            @endif
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
                            <div class="flex items-center justify-end gap-2">
                                @if(auth()->id() === 1 && $user->id !== auth()->id())
                                    <button 
                                        wire:click="toggleRole({{ $user->id }})" 
                                        wire:confirm="Ushbu foydalanuvchi rolini o'zgartirishga aminmisiz?"
                                        class="p-1 {{ $user->isAdmin() ? 'text-red-400 hover:text-red-600' : 'text-slate-400 hover:text-emerald-600' }} transition-colors"
                                        title="{{ $user->isAdmin() ? 'Talaba qilish' : 'Admin qilish' }}"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                    </button>
                                @endif

                                <button 
                                    wire:click="openPasswordModal({{ $user->id }})" 
                                    class="p-1 text-slate-400 hover:text-cyan-600 transition-colors"
                                    title="Parolni o'zgartirish"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                                </button>
                                
                                <button 
                                    wire:click="deleteUser({{ $user->id }})" 
                                    wire:confirm="Ushbu foydalanuvchini o'chirishga aminmisiz?"
                                    class="p-1 text-slate-400 hover:text-red-600 transition-colors"
                                    title="O'chirish"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
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

    <!-- Password Reset Modal -->
    @if($isPasswordModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm animate-reveal">
            <div class="cyber-glass max-w-md w-full p-8 space-y-6 border-l-4 border-cyan-600 dark:border-cyan-500 shadow-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="font-display text-lg font-bold uppercase tracking-widest text-slate-900 dark:text-white">
                        Access <span class="text-cyan-600 dark:text-cyan-400">Override</span>
                    </h3>
                    <button wire:click="closePasswordModal" class="text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form wire:submit.prevent="updateUserPassword" class="space-y-6">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500 font-bold">New Security Key</span>
                        </label>
                        <div class="join w-full">
                            <input type="text" wire:model="newPassword" class="input input-bordered join-item w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-cyan-700 dark:text-cyan-400 focus:border-cyan-600 dark:focus:border-cyan-500 font-mono text-sm" placeholder="Yangi parol...">
                            <button type="button" wire:click="generateRandomPassword" class="btn btn-outline join-item border-slate-200 dark:border-white/10 text-cyan-600 dark:text-cyan-400 hover:bg-cyan-600 dark:hover:bg-cyan-400 hover:text-white dark:hover:text-slate-950 font-display text-[10px] uppercase">Generate</button>
                        </div>
                        @error('newPassword') <span class="text-red-500 text-[10px] mt-1 font-mono uppercase">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500 font-bold">Confirm Key</span>
                        </label>
                        <input type="password" wire:model="newPasswordConfirmation" class="input input-bordered w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-cyan-700 dark:text-cyan-400 focus:border-cyan-600 dark:focus:border-cyan-500 font-mono text-sm">
                        @error('newPasswordConfirmation') <span class="text-red-500 text-[10px] mt-1 font-mono uppercase">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="submit" class="btn btn-primary flex-grow rounded-none border-2 border-cyan-600 dark:border-cyan-400 bg-cyan-600 dark:bg-cyan-400 text-white dark:text-slate-950 hover:bg-transparent hover:text-cyan-600 dark:hover:text-cyan-400 hover:border-cyan-600 dark:hover:border-cyan-400 transition-all font-display uppercase tracking-widest text-xs shadow-md dark:shadow-[0_0_20px_rgba(6,182,212,0.3)]">
                            Reset_Password
                        </button>
                        <button type="button" wire:click="closePasswordModal" class="btn btn-ghost rounded-none font-display text-[10px] uppercase tracking-widest text-slate-500">
                            Abort
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
