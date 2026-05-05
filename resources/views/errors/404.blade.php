<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Neural Link Severed</title>
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
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-red-600/10 blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-cyan-500/10 blur-[120px]"></div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay"></div>
    </div>

    <div class="relative z-10 max-w-lg w-full text-center space-y-8 animate-reveal">
        <div class="space-y-4">
            <h1 class="font-display text-8xl font-black text-white tracking-tighter opacity-10 leading-none absolute -top-12 left-1/2 -translate-x-1/2 select-none">404</h1>
            <div class="cyber-glass p-12 border-t-4 border-red-600 relative overflow-hidden">
                <!-- Glitch Effect Container -->
                <div class="space-y-6">
                    <div class="w-16 h-16 mx-auto mb-8 flex items-center justify-center rounded bg-red-600/10 border border-red-600/50 text-red-500 animate-pulse">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    
                    <h2 class="font-display text-2xl font-bold text-white uppercase tracking-widest">Neural_Link_Severed</h2>
                    <p class="text-xs text-slate-500 uppercase tracking-[0.2em] font-medium">The requested node does not exist in the current grid</p>
                    
                    <div class="pt-8 border-t border-white/5 space-y-4">
                        <p class="text-[10px] font-mono text-red-500/70 uppercase">Error_Code: 0x404_NOT_FOUND</p>
                        <a href="/" class="btn btn-outline border-cyan-600/50 text-cyan-400 hover:bg-cyan-600 hover:text-white rounded-none font-display uppercase tracking-widest text-[10px] px-8 py-3 transition-all inline-block">
                            Reboot_System
                        </a>
                    </div>
                </div>

                <!-- Decorative scanner line -->
                <div class="absolute inset-0 pointer-events-none">
                    <div class="w-full h-[1px] bg-red-600/20 absolute top-0 animate-[scan_4s_linear_infinite]"></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes scan {
            0% { top: 0; }
            100% { top: 100%; }
        }
        .cyber-glass {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
    </style>
</body>
</html>
