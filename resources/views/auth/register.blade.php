<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa Baru — CodeCraft SMP Lab</title>

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

<body class="bg-brand-bg min-h-screen text-brand-dark flex flex-col justify-between selection:bg-brand-lime selection:text-brand-dark bg-editorial-grain"
      x-data="{
          selectedAvatar: 'cyber-bot',
          avatars: [
              { id: 'cyber-bot', name: 'Cyber Bot', emoji: '🤖', desc: 'Ahli Protokol & Jaringan' },
              { id: 'code-wizard', name: 'Code Wizard', emoji: '🧙‍♂️', desc: 'Master Algoritma & Loop' },
              { id: 'network-ninja', name: 'Network Ninja', emoji: '🥷', desc: 'Cepat & Tangkas Routing' },
              { id: 'pixel-hero', name: 'Pixel Hero', emoji: '👾', desc: 'Kreator Game & Logika' }
          ]
      }">

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
            <div class="lg:col-span-5 bg-brand-blue rounded-3xl p-6 sm:p-8 text-white flex flex-col justify-between relative overflow-hidden shadow-glow-blue border border-blue-400/20 min-h-[500px]">
                
                <!-- Glowing Aura Background -->
                <div class="absolute -top-16 -right-16 w-48 h-48 bg-brand-lime/25 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Header Visual Card: Rotating Asterisk & Badge -->
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 bg-brand-lime text-brand-dark px-3 py-1 rounded-full text-[11px] font-extrabold tracking-wider font-mono">
                            <span class="w-2 h-2 rounded-full bg-brand-dark animate-ping"></span>
                            +50 XP WELCOME BONUS
                        </span>

                        <!-- Rotating Asterisk -->
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
                        JOIN THE <br>
                        <span class="text-brand-lime">NEXT GEN LAB!</span>
                    </h2>
                    <p class="text-xs text-white/80 mt-2 leading-relaxed">
                        Daftar sekarang untuk membuka akses penuh simulasi paket data jaringan komputer, puzzle algoritma, dan sertifikat digital.
                    </p>
                </div>

                <!-- Interactive Selected Avatar Live Preview -->
                <div class="relative z-10 my-6 bg-black/35 backdrop-blur-md rounded-2xl p-4 border border-white/10 text-center">
                    <span class="text-[10px] text-gray-300 font-mono block mb-1">AVATAR KARAKTER PILIHANMU:</span>
                    <div class="w-16 h-16 mx-auto rounded-2xl bg-brand-lime text-brand-dark flex items-center justify-center text-3xl shadow-glow-lime transform transition-transform duration-300 hover:scale-110">
                        <template x-for="a in avatars" :key="a.id">
                            <span x-show="selectedAvatar === a.id" x-text="a.emoji"></span>
                        </template>
                    </div>
                    <div class="mt-2 font-display font-bold text-sm text-white">
                        <template x-for="a in avatars" :key="a.id">
                            <span x-show="selectedAvatar === a.id" x-text="a.name"></span>
                        </template>
                    </div>
                    <div class="text-[11px] text-brand-lime font-mono">
                        <template x-for="a in avatars" :key="a.id">
                            <span x-show="selectedAvatar === a.id" x-text="a.desc"></span>
                        </template>
                    </div>
                </div>

                <!-- Footer Visual Card: Quick Perks -->
                <div class="relative z-10 pt-4 border-t border-white/15 space-y-1.5 text-xs text-white/85">
                    <div class="flex items-center gap-2">
                        <span class="text-brand-lime">✔</span>
                        <span>Simulasi ICMP Ping & Router Live</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-brand-lime">✔</span>
                        <span>Sistem Gamifikasi Level & Real-Time XP</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-brand-lime">✔</span>
                        <span>100% Gratis untuk Siswa SMP Indonesia</span>
                    </div>
                </div>

            </div>

            <!-- SISI KANAN: Form Interaktif Register (7 Cols) -->
            <div class="lg:col-span-7 flex flex-col justify-center px-2 sm:px-6 py-2">
                
                <div class="mb-4">
                    <span class="text-xs font-bold font-mono tracking-wider text-brand-blue uppercase">REGISTRASI SISWA BARU</span>
                    <h1 class="text-2xl sm:text-3xl font-black font-display text-brand-dark tracking-tight mt-1">
                        Buat Akun CodeCraft
                    </h1>
                    <p class="text-xs text-gray-500 mt-1">
                        Lengkapi profil siswa kamu untuk langsung mendapatkan <span class="font-bold text-brand-blue">+50 XP</span>.
                    </p>
                </div>

                @if($errors->any())
                    <div class="mb-4 p-3.5 bg-red-50 border border-red-200 rounded-2xl text-xs text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <div class="flex items-center gap-1.5">
                                <span>•</span>
                                <span>{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Form Register -->
                <form action="{{ route('register.post') }}" method="POST" class="space-y-3.5">
                    @csrf

                    <!-- Hidden Input for Selected Avatar -->
                    <input type="hidden" name="avatar" :value="selectedAvatar">

                    <!-- Interactive Avatar Picker Cards -->
                    <div>
                        <label class="block text-xs font-bold font-mono text-brand-dark mb-1.5">
                            PILIH AVATAR SISWA
                        </label>
                        <div class="grid grid-cols-4 gap-2">
                            <template x-for="a in avatars" :key="a.id">
                                <button type="button" 
                                        @click="selectedAvatar = a.id"
                                        class="p-2 rounded-2xl border transition-all duration-200 flex flex-col items-center justify-center gap-1 text-center"
                                        :class="selectedAvatar === a.id 
                                            ? 'bg-brand-blue text-white border-brand-blue ring-2 ring-brand-lime shadow-md scale-105' 
                                            : 'bg-brand-surface/40 hover:bg-brand-surface border-black/10 text-brand-dark'">
                                    <span class="text-xl" x-text="a.emoji"></span>
                                    <span class="text-[10px] font-bold font-display truncate max-w-full" x-text="a.name"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Row: Nama & Username -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="name" class="block text-xs font-bold font-mono text-brand-dark mb-1">
                                NAMA LENGKAP
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   placeholder="misal: Siti Nurhaliza"
                                   class="w-full px-3.5 py-2.5 rounded-2xl border border-black/15 bg-brand-surface/30 focus:bg-white focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 text-sm font-medium transition-all">
                        </div>

                        <div>
                            <label for="username" class="block text-xs font-bold font-mono text-brand-dark mb-1">
                                USERNAME (LOGIN)
                            </label>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username') }}" 
                                   required 
                                   placeholder="misal: siticoder"
                                   class="w-full px-3.5 py-2.5 rounded-2xl border border-black/15 bg-brand-surface/30 focus:bg-white focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 text-sm font-medium transition-all">
                        </div>
                    </div>

                    <!-- Row: Email & Pilihan Kelas -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="email" class="block text-xs font-bold font-mono text-brand-dark mb-1">
                                EMAIL SISWA
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   placeholder="siti@sekolah.sch.id"
                                   class="w-full px-3.5 py-2.5 rounded-2xl border border-black/15 bg-brand-surface/30 focus:bg-white focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 text-sm font-medium transition-all">
                        </div>

                        <div>
                            <label for="grade_level" class="block text-xs font-bold font-mono text-brand-dark mb-1">
                                TINGKAT KELAS SMP
                            </label>
                            <select id="grade_level" 
                                    name="grade_level" 
                                    required 
                                    class="w-full px-3.5 py-2.5 rounded-2xl border border-black/15 bg-brand-surface/30 focus:bg-white focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 text-sm font-medium transition-all">
                                <option value="Kelas 7" {{ old('grade_level') == 'Kelas 7' ? 'selected' : '' }}>Kelas 7 (Fase D Awal)</option>
                                <option value="Kelas 8" {{ old('grade_level', 'Kelas 8') == 'Kelas 8' ? 'selected' : '' }}>Kelas 8 (Fase D Tengah)</option>
                                <option value="Kelas 9" {{ old('grade_level') == 'Kelas 9' ? 'selected' : '' }}>Kelas 9 (Fase D Lanjutan)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Row: Password & Konfirmasi -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="password" class="block text-xs font-bold font-mono text-brand-dark mb-1">
                                PASSWORD (MIN. 6)
                            </label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   placeholder="••••••••"
                                   class="w-full px-3.5 py-2.5 rounded-2xl border border-black/15 bg-brand-surface/30 focus:bg-white focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 text-sm font-medium transition-all">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold font-mono text-brand-dark mb-1">
                                ULANGI PASSWORD
                            </label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required 
                                   placeholder="••••••••"
                                   class="w-full px-3.5 py-2.5 rounded-2xl border border-black/15 bg-brand-surface/30 focus:bg-white focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 text-sm font-medium transition-all">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full mt-3 py-3.5 px-6 rounded-2xl bg-brand-dark text-white font-display font-bold text-sm tracking-wide hover:bg-brand-lime hover:text-brand-dark hover:shadow-glow-lime transition-all duration-300 flex items-center justify-center gap-2 group">
                        <span>DAFTAR SEKARANG & KLAIM +50 XP 🚀</span>
                        <span class="w-5 h-5 rounded-full bg-white/20 group-hover:bg-brand-dark group-hover:text-brand-lime flex items-center justify-center text-xs font-bold transition-colors">↗</span>
                    </button>
                </form>

                <!-- Switch to Login -->
                <p class="text-center text-xs text-gray-500 mt-4">
                    Sudah memiliki akun siswa? 
                    <a href="{{ route('login') }}" class="font-bold text-brand-blue hover:underline">
                        Masuk ke Akun ➔
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

