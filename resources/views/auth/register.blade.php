<x-layouts.app>
    <div class="min-h-[80vh] flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 cyber-glass p-8 border-t-2 border-fuchsia-600 dark:border-fuchsia-500 animate-reveal transition-all duration-300">
            <!-- Header -->
            <div class="text-center">
                <h2 class="font-display text-3xl font-black tracking-tighter text-slate-900 dark:text-white uppercase">
                    Create <span class="text-fuchsia-600 dark:text-fuchsia-500">Identity</span>
                </h2>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 font-mono uppercase tracking-widest font-bold">
                    Register your neural signature
                </p>
            </div>

            <!-- Errors -->
            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/50 p-3 text-red-600 dark:text-red-400 text-xs font-mono">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <!-- Honeypot: Hidden from humans, tempting for bots -->
                    <div class="hidden" aria-hidden="true">
                        <label for="neural_link_validation">Neural Link Validation</label>
                        <input type="text" name="neural_link_validation" id="neural_link_validation" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500 font-bold">Alias (Full Name)</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="input input-bordered w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-fuchsia-700 dark:text-fuchsia-400 focus:border-fuchsia-600 dark:focus:border-fuchsia-500 focus:ring-1 focus:ring-fuchsia-600 dark:focus:ring-fuchsia-500 transition-all font-mono"
                            placeholder="John Doe">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500 font-bold">Neural Address (Email)</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="input input-bordered w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-fuchsia-700 dark:text-fuchsia-400 focus:border-fuchsia-600 dark:focus:border-fuchsia-500 focus:ring-1 focus:ring-fuchsia-600 dark:focus:ring-fuchsia-500 transition-all font-mono"
                            placeholder="user@neural.link">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500 font-bold">Security Key (Password)</span>
                        </label>
                        <input type="password" name="password" required
                            class="input input-bordered w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-fuchsia-700 dark:text-fuchsia-400 focus:border-fuchsia-600 dark:focus:border-fuchsia-500 focus:ring-1 focus:ring-fuchsia-600 dark:focus:ring-fuchsia-500 transition-all font-mono"
                            placeholder="••••••••">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-display uppercase tracking-widest text-[10px] text-slate-500 font-bold">Confirm Security Key</span>
                        </label>
                        <input type="password" name="password_confirmation" required
                            class="input input-bordered w-full bg-slate-50 dark:bg-slate-900/50 border-slate-200 dark:border-white/10 text-fuchsia-700 dark:text-fuchsia-400 focus:border-fuchsia-600 dark:focus:border-fuchsia-500 focus:ring-1 focus:ring-fuchsia-600 dark:focus:ring-fuchsia-500 transition-all font-mono"
                            placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn btn-secondary w-full rounded-none border-2 border-fuchsia-600 dark:border-fuchsia-500 bg-fuchsia-600 dark:bg-fuchsia-500 text-white dark:text-slate-950 hover:bg-transparent hover:text-fuchsia-600 dark:hover:text-fuchsia-500 hover:border-fuchsia-600 dark:hover:border-fuchsia-500 transition-all duration-300 font-display uppercase tracking-[0.2em] shadow-md dark:shadow-[0_0_15px_rgba(217,70,239,0.3)]">
                        Register Identity
                    </button>
                </div>
            </form>

            <div class="relative py-4">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200 dark:border-white/5"></div></div>
                <div class="relative flex justify-center text-[10px] uppercase font-display tracking-widest text-slate-400 dark:text-slate-600 font-bold">
                    <span class="bg-white dark:bg-slate-950 px-2">External Link</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('social.redirect', 'google') }}" class="btn btn-outline rounded-none border-slate-200 dark:border-white/10 text-slate-600 dark:text-white hover:bg-slate-50 dark:hover:bg-white/5 hover:border-slate-300 dark:hover:border-white/20 font-display flex items-center gap-2 text-[10px] uppercase tracking-widest">
                    <svg class="h-4 w-4" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M21.35,11.1H12.18V13.83H18.69C18.36,17.64 15.19,19.27 12.19,19.27C8.36,19.27 5.05,16.25 5.05,12C5.05,7.74 8.36,4.73 12.19,4.73C15.19,4.73 17.05,6.7 17.05,6.7L19,4.72C19,4.72 16.56,2 12.1,2C6.42,2 2.03,6.8 2.03,12C2.03,17.05 6.16,22 12.25,22C17.6,22 21.5,18.33 21.5,12.91C21.5,11.76 21.35,11.1 21.35,11.1V11.1Z" />
                    </svg>
                    Google
                </a>

                <a href="{{ route('social.redirect', 'github') }}" class="btn btn-outline rounded-none border-slate-200 dark:border-white/10 text-slate-600 dark:text-white hover:bg-slate-50 dark:hover:bg-white/5 hover:border-slate-300 dark:hover:border-white/20 font-display flex items-center gap-2 text-[10px] uppercase tracking-widest">
                    <svg class="h-4 w-4" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M12,2A10,10 0 0,0 2,12C2,16.42 4.87,20.17 8.84,21.5C9.34,21.58 9.5,21.27 9.5,21C9.5,20.77 9.5,20.14 9.5,19.31C6.73,19.91 6.14,17.97 6.14,17.97C5.68,16.81 5.03,16.5 5.03,16.5C4.12,15.88 5.1,15.9 5.1,15.9C6.1,15.97 6.63,16.93 6.63,16.93C7.5,18.45 8.97,18 9.54,17.76C9.63,17.11 9.89,16.67 10.17,16.42C7.95,16.17 5.62,15.31 5.62,11.5C5.62,10.39 6,9.5 6.65,8.79C6.55,8.54 6.2,7.5 6.75,6.15C6.75,6.15 7.59,5.88 9.5,7.17C10.29,6.95 11.15,6.84 12,6.84C12.85,6.84 13.71,6.95 14.5,7.17C16.41,5.88 17.25,6.15 17.25,6.15C17.8,7.5 17.45,8.54 17.35,8.79C18,9.5 18.38,10.39 18.38,11.5C18.38,15.32 16.04,16.16 13.81,16.41C14.17,16.72 14.5,17.33 14.5,18.26C14.5,19.6 14.5,20.68 14.5,21C14.5,21.27 14.66,21.59 15.17,21.5C19.14,20.16 22,16.42 22,12A10,10 0 0,0 12,2Z" />
                    </svg>
                    GitHub
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
