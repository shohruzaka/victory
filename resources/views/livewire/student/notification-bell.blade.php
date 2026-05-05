<div class="relative" x-data="{ open: false }">
    <!-- Bell Icon -->
    <button @click="open = !open; if(open) $wire.markAsRead()" class="relative p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-600 dark:bg-red-500 ring-2 ring-white dark:ring-slate-800 animate-pulse"></span>
        @endif
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="absolute right-0 mt-2 w-80 cyber-glass-light overflow-hidden z-[60] shadow-xl border border-slate-200 dark:border-white/10"
         style="display: none;">
        
        <div class="p-4 border-b border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-slate-900/50 flex justify-between items-center">
            <h4 class="text-[10px] font-mono text-slate-500 uppercase tracking-widest font-bold">Neural_Notifications</h4>
            @if($unreadCount > 0)
                <span class="text-[9px] bg-cyan-600/10 text-cyan-600 dark:text-cyan-400 px-2 py-0.5 rounded font-bold">{{ $unreadCount }} NEW</span>
            @endif
        </div>

        <div class="max-h-96 overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="p-4 border-b border-slate-50 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                    <div class="flex gap-3">
                        <div class="shrink-0 w-8 h-8 rounded bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-cyan-600 dark:text-cyan-400">
                            @if(($notification->data['icon'] ?? '') === 'heroicon-o-fire')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.99 7.99 0 0121 13a8.003 8.003 0 01-3.343 5.657z" /></svg>
                            @elseif(($notification->data['icon'] ?? '') === 'heroicon-o-trophy')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            @elseif(($notification->data['icon'] ?? '') === 'heroicon-o-swords')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                            @endif
                        </div>
                        <div class="min-w-0 flex-grow">
                            <p class="text-[10px] font-bold text-slate-900 dark:text-white uppercase truncate">{{ $notification->data['title'] }}</p>
                            <p class="text-[9px] text-slate-500 dark:text-slate-400 leading-tight mt-1">{{ $notification->data['message'] }}</p>
                            
                            @if(($notification->data['type'] ?? '') === 'duel_challenge')
                                <div class="mt-3 flex gap-2">
                                    <button 
                                        wire:click="$dispatchTo('student.challenge-action', 'accept', { duelUuid: '{{ $notification->data['duel_uuid'] }}' })" 
                                        wire:loading.attr="disabled"
                                        class="px-3 py-1 bg-emerald-600/10 border border-emerald-600/30 text-emerald-600 text-[8px] font-mono font-bold uppercase hover:bg-emerald-600 hover:text-white transition-all flex items-center gap-2"
                                    >
                                        <span wire:loading.remove wire:target="$dispatchTo('student.challenge-action', 'accept', { duelUuid: '{{ $notification->data['duel_uuid'] }}' })">Accept_Duel</span>
                                        <span wire:loading wire:target="$dispatchTo('student.challenge-action', 'accept', { duelUuid: '{{ $notification->data['duel_uuid'] }}' })">
                                            <svg class="animate-spin h-2 w-2" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    <button 
                                        wire:click="$dispatchTo('student.challenge-action', 'decline', { duelUuid: '{{ $notification->data['duel_uuid'] }}' })" 
                                        wire:loading.attr="disabled"
                                        class="px-3 py-1 bg-red-600/10 border border-red-600/30 text-red-600 text-[8px] font-mono font-bold uppercase hover:bg-red-600 hover:text-white transition-all flex items-center gap-2"
                                    >
                                        <span wire:loading.remove wire:target="$dispatchTo('student.challenge-action', 'decline', { duelUuid: '{{ $notification->data['duel_uuid'] }}' })">Decline</span>
                                        <span wire:loading wire:target="$dispatchTo('student.challenge-action', 'decline', { duelUuid: '{{ $notification->data['duel_uuid'] }}' })">
                                            <svg class="animate-spin h-2 w-2" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            @endif

                            <p class="text-[8px] font-mono text-slate-400 mt-2 uppercase">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <p class="text-[10px] font-mono text-slate-400 uppercase tracking-widest italic">No neural pings found</p>
                </div>
            @endforelse
        </div>

        @if(count($notifications) > 0)
            <div class="p-3 bg-slate-50/50 dark:bg-slate-900/30 text-center border-t border-slate-100 dark:border-white/5">
                <button 
                    wire:click="clearAll" 
                    wire:loading.attr="disabled"
                    class="text-[9px] font-mono text-cyan-600 dark:text-cyan-400 hover:underline uppercase font-bold tracking-widest flex items-center justify-center mx-auto gap-2 group"
                >
                    <span wire:loading.remove wire:target="clearAll">Clear_All_Logs</span>
                    <span wire:loading wire:target="clearAll">Purging...</span>
                    <svg wire:loading.remove wire:target="clearAll" class="w-3 h-3 text-slate-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
            </div>
        @endif
    </div>
</div>
