<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa — CodeCraft SMP Lab</title>

    <!-- Google Fonts: Plus Jakarta Sans & Space Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (v3 CDN with brand configuration) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-bg': '#F4F3EF',
                        'brand-blue': '#312ECB',
                        'brand-lime': '#D4FF33',
                        'brand-dark': '#1E1E1E',
                        'brand-surface': '#ECEAE4',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Space Grotesk"', 'sans-serif'],
                    },
                    boxShadow: {
                        'glow-lime': '0 0 25px -5px rgba(212, 255, 51, 0.5)',
                        'glow-blue': '0 10px 30px -10px rgba(49, 46, 203, 0.4)',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            background-color: #F4F3EF;
            color: #1E1E1E;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .bg-editorial-grain {
            background-image: radial-gradient(rgba(30, 30, 30, 0.05) 1px, transparent 1px);
            background-size: 24px 24px;
        }
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 22s linear infinite;
        }
    </style>
</head>

<body class="bg-brand-bg min-h-screen text-brand-dark flex flex-col justify-between selection:bg-brand-lime selection:text-brand-dark bg-editorial-grain">

    <!-- Simple Top Bar -->
    <nav class="max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-5 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <div class="w-8 h-8 rounded-lg bg-brand-blue flex items-center justify-center text-brand-lime font-black font-display text-sm shadow-md group-hover:scale-105 transition-transform">
                C²
            </div>
            <span class="font-display font-extrabold text-lg tracking-tight">CodeCraft</span>
        </a>

        <a href="{{ route('home') }}" class="text-xs font-bold font-mono tracking-wider text-gray-500 hover:text-brand-blue flex items-center gap-1 transition-colors">
            <span>← KEMBALI KE BERANDA</span>
        </a>
    </nav>

    <!-- Main Bento Split-Screen Container -->
    <main class="max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8 flex-1 flex items-center justify-center">
        <div class="w-full bg-white border border-black/10 rounded-[32px] p-4 sm:p-6 lg:p-8 shadow-sm grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            
            <!-- SISI KIRI: Visual Showcase Bento Card (5 Cols) -->
            <div class="lg:col-span-5 bg-brand-blue rounded-3xl p-6 sm:p-8 text-white flex flex-col justify-between relative overflow-hidden shadow-glow-blue border border-blue-400/20 min-h-[460px]">
                
                <!-- Glowing Aura Background -->
                <div class="absolute -top-16 -right-16 w-48 h-48 bg-brand-lime/25 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Header Visual Card: Rotating Asterisk & Badge -->
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 bg-brand-lime text-brand-dark px-3 py-1 rounded-full text-[11px] font-extrabold tracking-wider font-mono">
                            <span class="w-2 h-2 rounded-full bg-brand-dark animate-ping"></span>
                            STUDENT PORTAL
                        </span>

                        <!-- Rotating Blue/White Asterisk -->
                        <svg class="w-8 h-8 text-brand-lime fill-current animate-spin-slow" viewBox="0 0 100 100">
                            <g transform="translate(50,50)">
                                <rect x="-6" y="-45" width="12" height="90" rx="6" />
                                <rect x="-6" y="-45" width="12" height="90" rx="6" transform="rotate(45)" />
                                <rect x="-6" y="-45" width="12" height="90" rx="6" transform="rotate(90)" />
                                <rect x="-6" y="-45" width="12" height="90" rx="6" transform="rotate(135)" />
                            </g>
                        </svg>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black font-display tracking-tight uppercase mt-6 leading-tight">
                        WELCOME BACK <br>
                        <span class="text-brand-lime">YOUNG CODER!</span>
                    </h2>
                    <p class="text-xs text-white/80 mt-2 leading-relaxed">
                        Lanjutkan eksperimen simulasi paket jaringan komputer dan susun blok kode logika algoritma kamu.
                    </p>
                </div>

                <!-- Center Graphic: Gamification Preview Badge -->
                <div class="relative z-10 my-6 bg-black/35 backdrop-blur-md rounded-2xl p-4 border border-white/10 space-y-3">
                    <div class="flex items-center justify-between border-b border-white/10 pb-2.5">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-brand-lime text-brand-dark flex items-center justify-center font-bold text-xs">
                                🤖
                            </div>
                            <div>
                                <p class="text-xs font-bold leading-none text-white">Rafi Pratama</p>
                                <span class="text-[10px] text-brand-lime font-mono">Siswa SMP • Kelas 8</span>
                            </div>
                        </div>
                        <span class="bg-brand-lime/20 text-brand-lime text-[10px] font-mono font-bold px-2 py-0.5 rounded-full">
                            LVL 4
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-2 text-center text-xs font-mono">
                        <div class="bg-white/5 rounded-xl p-2 border border-white/5">
                            <span class="text-[10px] text-gray-300 block">TOTAL XP</span>
                            <span class="text-brand-lime font-bold text-sm">1,250 XP</span>
                        </div>
                        <div class="bg-white/5 rounded-xl p-2 border border-white/5">
                            <span class="text-[10px] text-gray-300 block">DAILY STREAK</span>
                            <span class="text-orange-400 font-bold text-sm">🔥 7 Hari</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Visual Card: Quick Stats -->
                <div class="relative z-10 pt-4 border-t border-white/15 flex items-center justify-between text-[11px] font-mono text-white/75">
                    <span>2.4K+ SISWA TERDAFTAR</span>
                    <span class="text-brand-lime">500+ SIMULASI</span>
                </div>

            </div>

            <!-- SISI KANAN: Form Interaktif Login (7 Cols) -->
            <div class="lg:col-span-7 flex flex-col justify-center px-2 sm:px-6 py-4">
                
                <div class="mb-6">
                    <span class="text-xs font-bold font-mono tracking-wider text-brand-blue uppercase">AUTENTIKASI SISWA</span>
                    <h1 class="text-2xl sm:text-3xl font-black font-display text-brand-dark tracking-tight mt-1">
                        Masuk ke Akun Lab
                    </h1>
                    <p class="text-xs text-gray-500 mt-1">
                        Gunakan email atau username siswa SMP kamu yang sudah terdaftar.
                    </p>
                </div>

                <!-- Flash Alert Messages -->
                @if(session('warning'))
                    <div class="mb-5 p-3.5 bg-yellow-50 border border-yellow-200 rounded-2xl flex items-start gap-2.5 text-xs text-yellow-800">
                        <span class="text-base leading-none">⚠️</span>
                        <div>
                            <span class="font-bold">Akses Terbatas:</span> {{ session('warning') }}
                        </div>
                    </div>
                @endif

                @if(session('info'))
                    <div class="mb-5 p-3.5 bg-blue-50 border border-blue-200 rounded-2xl text-xs text-blue-800 flex items-center gap-2">
                        <span>ℹ️</span> {{ session('info') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-5 p-3.5 bg-red-50 border border-red-200 rounded-2xl text-xs text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <div class="flex items-center gap-1.5">
                                <span>•</span>
                                <span>{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Form Login -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="login" class="block text-xs font-bold font-mono text-brand-dark mb-1">
                            EMAIL ATAU USERNAME SISWA
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   id="login" 
                                   name="login" 
                                   value="{{ old('login') }}" 
                                   required 
                                   autofocus
                                   placeholder="misal: siswa_demo atau siswa@codecraft.test"
                                   class="w-full px-4 py-3 rounded-2xl border border-black/15 bg-brand-surface/30 focus:bg-white focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 text-sm font-medium transition-all">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-xs font-bold font-mono text-brand-dark">
                                PASSWORD
                            </label>
                            <span class="text-[11px] text-gray-400 font-mono">Min. 6 Karakter</span>
                        </div>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required 
                               placeholder="••••••••"
                               class="w-full px-4 py-3 rounded-2xl border border-black/15 bg-brand-surface/30 focus:bg-white focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 text-sm font-medium transition-all">
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 text-xs text-gray-600 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="rounded accent-brand-blue w-4 h-4">
                            <span>Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full mt-2 py-3.5 px-6 rounded-2xl bg-brand-dark text-white font-display font-bold text-sm tracking-wide hover:bg-brand-lime hover:text-brand-dark hover:shadow-glow-lime transition-all duration-300 flex items-center justify-center gap-2 group">
                        <span>MASUK KE LAB KODING</span>
                        <span class="w-5 h-5 rounded-full bg-white/20 group-hover:bg-brand-dark group-hover:text-brand-lime flex items-center justify-center text-xs font-bold transition-colors">↗</span>
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-6 relative flex items-center justify-center">
                    <div class="border-t border-black/10 w-full"></div>
                    <span class="bg-white px-3 text-[11px] font-mono text-gray-400 uppercase tracking-widest relative z-10">ATAU</span>
                </div>

                <!-- Quick 1-Click Demo Login Button -->
                <form action="{{ route('login.demo') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="w-full py-3 px-5 rounded-2xl bg-[#EBE9FE] text-brand-blue border border-brand-blue/20 font-display font-bold text-xs tracking-wide hover:bg-brand-blue hover:text-white transition-all duration-200 flex items-center justify-center gap-2">
                        <span>⚡ QUICK DEMO LOGIN (Siswa SMP Tester)</span>
                    </button>
                </form>

                <!-- Switch to Register -->
                <p class="text-center text-xs text-gray-500 mt-6">
                    Belum punya akun siswa? 
                    <a href="{{ route('register') }}" class="font-bold text-brand-blue hover:underline">
                        Daftar Akun Baru (+50 XP) ➔
                    </a>
                </p>

            </div>

        </div>
    </main>

    <!-- Simple Footer -->
    <footer class="max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center text-xs text-gray-400 font-medium">
        CodeCraft • Inovasi Mahasiswa STT WASTUKANCANA · 2024 - 2026
    </footer>

</body>
</html>

