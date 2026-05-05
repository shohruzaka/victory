<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Access Denied</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'JetBrains Mono', monospace; }
        .font-display { font-family: 'Orbitron', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-slate-300 min-h-screen flex items-center justify-center p-6 overflow-hidden relative">
    <!-- Background Accents -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden opacity-30">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-fuchsia-600/10 blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-purple-500/10 blur-[120px]"></div>
    </div>

    <div class="relative z-10 max-w-lg w-full text-center space-y-8 animate-reveal">
        <div class="space-y-4">
            <h1 class="font-display text-8xl font-black text-white tracking-tighter opacity-10 leading-none absolute -top-12 left-1/2 -translate-x-1/2 select-none">403</h1>
            <div class="cyber-glass p-12 border-t-4 border-fuchsia-600 relative overflow-hidden">
                <div class="space-y-6">
                    <div class="w-16 h-16 mx-auto mb-8 flex items-center justify-center rounded bg-fuchsia-600/10 border border-fuchsia-600/50 text-fuchsia-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    
                    <h2 class="font-display text-2xl font-bold text-white uppercase tracking-widest">Access_Denied</h2>
                    <p class="text-xs text-slate-500 uppercase tracking-[0.2em] font-medium">Neural credentials insufficient for this high-security sector</p>
                    
                    <div class="pt-8 border-t border-white/5 space-y-4">
                        <p class="text-[10px] font-mono text-fuchsia-500/70 uppercase">Error_Code: 0x403_FORBIDDEN</p>
                        <a href="/" class="btn btn-outline border-fuchsia-600/50 text-fuchsia-400 hover:bg-fuchsia-600 hover:text-white rounded-none font-display uppercase tracking-widest text-[10px] px-8 py-3 transition-all inline-block">
                            Request_Auth
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .cyber-glass {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
    </style>
</body>
</html>
