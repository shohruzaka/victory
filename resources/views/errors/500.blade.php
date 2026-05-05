<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Core Meltdown</title>
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
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-orange-600/10 blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-red-500/10 blur-[120px]"></div>
    </div>

    <div class="relative z-10 max-w-lg w-full text-center space-y-8 animate-reveal">
        <div class="space-y-4">
            <h1 class="font-display text-8xl font-black text-white tracking-tighter opacity-10 leading-none absolute -top-12 left-1/2 -translate-x-1/2 select-none">500</h1>
            <div class="cyber-glass p-12 border-t-4 border-orange-600 relative overflow-hidden">
                <div class="space-y-6">
                    <div class="w-16 h-16 mx-auto mb-8 flex items-center justify-center rounded bg-orange-600/10 border border-orange-600/50 text-orange-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    
                    <h2 class="font-display text-2xl font-bold text-white uppercase tracking-widest">Core_Meltdown_Detected</h2>
                    <p class="text-xs text-slate-500 uppercase tracking-[0.2em] font-medium">Critical system failure in the central processing matrix</p>
                    
                    <div class="pt-8 border-t border-white/5 space-y-4">
                        <p class="text-[10px] font-mono text-orange-500/70 uppercase">Error_Code: 0x500_INTERNAL_FAIL</p>
                        <a href="/" class="btn btn-outline border-orange-600/50 text-orange-400 hover:bg-orange-600 hover:text-white rounded-none font-display uppercase tracking-widest text-[10px] px-8 py-3 transition-all inline-block">
                            Emergency_Restart
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
