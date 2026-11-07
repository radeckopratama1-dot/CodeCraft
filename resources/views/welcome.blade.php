<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CodeCraft — Web Lab Coding & Jaringan Komputer SMP</title>

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
                        'brand-card-light': '#FFFFFF',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Space Grotesk"', 'sans-serif'],
                    },
                    boxShadow: {
                        'glow-lime': '0 0 25px -5px rgba(212, 255, 51, 0.5)',
                        'glow-blue': '0 10px 30px -10px rgba(49, 46, 203, 0.4)',
                        'card-lift': '0 20px 40px -15px rgba(30, 30, 30, 0.15)',
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
            overflow-x: hidden;
        }

        /* Subtle grid & grain effect */
        .bg-editorial-grain {
            background-image: radial-gradient(rgba(30, 30, 30, 0.05) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 20s linear infinite;
        }

        @keyframes pulse-gentle {
            0%, 100% { transform: scale(1); opacity: 0.9; }
            50% { transform: scale(1.08); opacity: 1; }
        }
        .animate-pulse-gentle {
            animation: pulse-gentle 3s ease-in-out infinite;
        }

        @keyframes float-packet {
            0% { transform: translateX(0); }
            50% { transform: translateX(180px); }
            100% { transform: translateX(360px); }
        }
    </style>
</head>

@php
    $currentUser = $user ?? \App\Models\User::first();
    $paths = $learningPaths ?? \App\Models\LearningPath::with('labModules')->get();
@endphp

<body class="bg-brand-bg min-h-screen text-brand-dark selection:bg-brand-lime selection:text-brand-dark" 
      x-data="codecraftApp({
          initialXp: {{ $currentUser->xp ?? 1250 }},
          initialLevel: {{ $currentUser->level ?? 4 }},
          initialStreak: {{ $currentUser->streak_days ?? 7 }}
      })">



    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 bg-editorial-grain">

        <!-- ========================================== -->
        <!-- NAVBAR MINIMALIS PERSIS GAMBAR REFERENSI -->
        <!-- ========================================== -->
        <header class="border-b border-black/10 pb-5 mb-8 sm:mb-12">
            <nav class="flex items-center justify-between">
                <!-- Left Nav Links -->
                <div class="flex items-center space-x-6 sm:space-x-10 text-[13px] font-semibold tracking-wider text-brand-dark">
                    <a href="#home" class="hover:text-brand-blue transition-colors uppercase">HOME</a>
                    <a href="#labs" class="hover:text-brand-blue transition-colors uppercase flex items-center gap-1.5">
                        STORE/LABS
                        <span class="text-[9px] bg-brand-lime text-brand-dark font-extrabold px-1.5 py-0.5 rounded-full">NEW</span>
                    </a>
                    <a href="#about" class="hover:text-brand-blue transition-colors uppercase hidden md:inline-block">ABOUT US</a>
                </div>

                <!-- Center Logo (Subtle) -->
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-brand-blue flex items-center justify-center text-brand-lime font-black font-display text-sm shadow-md">
                        C²
                    </div>
                    <span class="font-display font-extrabold text-base tracking-tight hidden sm:inline-block">CodeCraft</span>
                </div>

                <!-- Right Nav Links & Floating User XP Pill -->
                <div class="flex items-center space-x-3 sm:space-x-6">
                    <a href="#classes" class="hover:text-brand-blue transition-colors uppercase text-[13px] font-semibold tracking-wider hidden sm:inline-block">CLASS</a>
                    
                    <!-- Dynamic Live MySQL XP & Level Badge -->
                    <div class="flex items-center gap-2 bg-white/90 backdrop-blur-sm border border-black/10 rounded-full py-1.5 px-3.5 shadow-sm text-xs font-semibold">
                        <div class="w-6 h-6 rounded-full bg-brand-blue text-brand-lime flex items-center justify-center font-bold text-[11px]">
                            L<span x-text="level"></span>
                        </div>
                        <div class="flex flex-col text-left leading-tight">
                            <span class="text-[10px] text-gray-500 font-medium">Siswa SMP</span>
                            <span class="font-bold text-brand-dark font-mono text-[12px]">
                                <span x-text="xp.toLocaleString()"></span> XP
                            </span>
                        </div>
                        <span class="text-orange-500 text-xs ml-0.5" title="Daily Streak">🔥 <span x-text="streak"></span>d</span>
                    </div>

                    <!-- Contact Us / Join Pill Button -->
                    <button @click="openModal('contact')" 
                            class="inline-flex items-center gap-1.5 border border-black/25 rounded-full px-4 sm:px-5 py-2 text-[12px] sm:text-[13px] font-bold tracking-wide hover:bg-brand-dark hover:text-white transition-all duration-200">
                        <span>CONTACT US</span>
                        <span class="text-sm">↗</span>
                    </button>
                </div>
            </nav>
        </header>


        <!-- ========================================== -->
        <!-- HERO SECTION PERSIS GAMBAR REFERENSI -->
        <!-- ========================================== -->
        <section id="home" class="relative pt-2 pb-10 sm:pb-16 text-center">
            
            <!-- Left Blue Asterisk Ornament (Spinning) -->
            <div class="absolute left-0 sm:left-4 top-0 select-none pointer-events-none">
                <svg class="w-10 h-10 sm:w-16 sm:h-16 text-brand-blue animate-spin-slow fill-current" viewBox="0 0 100 100">
                    <!-- 8-arm asterisk -->
                    <g transform="translate(50,50)">
                        <rect x="-6" y="-45" width="12" height="90" rx="6" />
                        <rect x="-6" y="-45" width="12" height="90" rx="6" transform="rotate(45)" />
                        <rect x="-6" y="-45" width="12" height="90" rx="6" transform="rotate(90)" />
                        <rect x="-6" y="-45" width="12" height="90" rx="6" transform="rotate(135)" />
                    </g>
                </svg>
            </div>

            <!-- Right Lime Sparkle Ornament -->
            <div class="absolute right-2 sm:right-8 top-2 select-none pointer-events-none">
                <svg class="w-8 h-8 sm:w-12 sm:h-12 text-[#B9F517] animate-pulse-gentle fill-current drop-shadow-sm" viewBox="0 0 100 100">
                    <!-- 4-point sparkle star -->
                    <path d="M50 0 C50 30 70 50 100 50 C70 50 50 70 50 100 C50 70 30 50 0 50 C30 50 50 30 50 0 Z" />
                </svg>
            </div>

            <!-- Main Hero Typography -->
            <div class="max-w-4xl mx-auto px-2">
                <h1 class="text-3xl sm:text-5xl lg:text-[62px] font-black tracking-tight leading-[1.1] text-brand-dark uppercase font-display">
                    LEVEL UP YOUR<br>
                    <span class="inline-flex items-center flex-wrap justify-center gap-2 sm:gap-4 my-1">
                        <span>DESIGN / LOGIC</span>
                        <!-- Neon Lime Arrow Pill -->
                        <span class="inline-flex items-center justify-center bg-brand-lime text-brand-dark px-5 sm:px-8 py-1 sm:py-2 rounded-full shadow-sm hover:scale-105 transition-transform cursor-pointer"
                              title="Start Learning Now">
                            <span class="text-2xl sm:text-4xl font-extrabold leading-none">→</span>
                        </span>
                        <span>WITH OUR</span>
                    </span><br>
                    <span>CODECRAFT CLASS</span>
                </h1>
            </div>

            <!-- Subheader Bar: Statistics (Left) & Join Us Button (Right) -->
            <div class="mt-8 sm:mt-12 flex flex-col sm:flex-row items-center justify-between max-w-4xl mx-auto px-4 gap-6">
                <!-- Left: With more than 2K+ MEMBERS 500+ TUTORIALS -->
                <div class="text-left" x-data="{ members: 0, tutorials: 0 }" x-init="
                    let mTarget = 2400; let tTarget = 520;
                    let mTimer = setInterval(() => { if (members < mTarget) members += 40; else { members = mTarget; clearInterval(mTimer); } }, 20);
                    let tTimer = setInterval(() => { if (tutorials < tTarget) tutorials += 10; else { tutorials = tTarget; clearInterval(tTimer); } }, 25);
                ">
                    <p class="text-[13px] text-gray-500 font-medium leading-tight">With more than</p>
                    <div class="mt-0.5 font-display font-extrabold text-[15px] sm:text-base tracking-tight text-brand-dark flex flex-col sm:flex-row sm:gap-4">
                        <span><span x-text="(members/1000).toFixed(1)">2.4</span>K+ MEMBERS</span>
                        <span class="hidden sm:inline text-gray-300">•</span>
                        <span><span x-text="tutorials">500</span>+ LAB SIMULATIONS</span>
                    </div>
                </div>

                <!-- Right: Join Us Pill Button -->
                <div>
                    <a href="#classes" 
                       class="inline-flex items-center gap-2 bg-brand-lime text-brand-dark font-display font-bold text-sm sm:text-base px-6 py-3 rounded-full hover:bg-[#c3f01f] hover:shadow-glow-lime transition-all duration-300 hover:-translate-y-0.5">
                        <span>Join us</span>
                        <span class="w-6 h-6 rounded-full bg-brand-dark text-brand-lime flex items-center justify-center text-xs font-bold">↗</span>
                    </a>
                </div>
            </div>


            <!-- ========================================== -->
            <!-- 5-CARD VERTICAL STAGGERED SHOWCASE         -->
            <!-- (Sesuai gambar referensi: Blue-Black-Blue-Black-Blue) -->
            <!-- ========================================== -->
            <div class="mt-12 sm:mt-16 max-w-5xl mx-auto px-2">
                <div class="grid grid-cols-5 gap-2 sm:gap-4 lg:gap-6 items-center justify-items-center">
                    
                    <!-- CARD 1 (Far Left, Blue, Medium Height) -->
                    <div class="w-full bg-brand-blue rounded-2xl sm:rounded-3xl p-3 sm:p-5 h-40 sm:h-52 flex flex-col justify-between text-white shadow-lg hover:-translate-y-2 transition-all duration-300 group cursor-pointer border border-blue-400/20"
                         @click="startLab('logic')">
                        <div class="flex items-center justify-between">
                            <span class="w-2.5 h-2.5 rounded-full bg-brand-lime"></span>
                            <span class="text-[10px] font-mono tracking-wider opacity-75">#01 BLOCK</span>
                        </div>
                        
                        <!-- 3D-styled logic blocks visual -->
                        <div class="my-auto flex flex-col items-center">
                            <div class="flex items-center gap-1.5 bg-black/30 backdrop-blur-sm p-2 rounded-xl border border-white/10 group-hover:scale-105 transition-transform">
                                <span class="w-4 h-4 rounded bg-[#FF5964] flex items-center justify-center text-[9px] font-bold">IF</span>
                                <span class="w-4 h-4 rounded bg-[#FFB800] flex items-center justify-center text-[9px] font-bold">DO</span>
                                <span class="w-4 h-4 rounded bg-brand-lime text-brand-dark flex items-center justify-center text-[9px] font-bold">GO</span>
                            </div>
                            <span class="text-[11px] font-semibold mt-2 text-white/90">Logic Palette</span>
                        </div>

                        <div class="text-[10px] text-brand-lime font-mono text-center opacity-80 group-hover:opacity-100">
                            TAP TO SOLVE ↗
                        </div>
                    </div>

                    <!-- CARD 2 (Inner Left, Charcoal/Black, Tall Height) -->
                    <div class="w-full bg-brand-dark rounded-2xl sm:rounded-3xl p-3 sm:p-5 h-56 sm:h-72 flex flex-col justify-between text-white shadow-xl hover:-translate-y-2 transition-all duration-300 group cursor-pointer border border-white/10"
                         @click="startLab('network')">
                        <div class="flex items-center justify-between">
                            <span class="w-2.5 h-2.5 rounded-full bg-cyan-400"></span>
                            <span class="text-[10px] font-mono tracking-wider text-gray-400">#02 ROUTE</span>
                        </div>

                        <!-- 3D Vector Pen / Network Wire Stylus Graphic -->
                        <div class="my-auto flex flex-col items-center">
                            <div class="relative w-16 h-28 flex items-center justify-center">
                                <!-- Stylus Pen / Network Probe SVG -->
                                <svg class="w-14 h-24 drop-shadow-[0_10px_10px_rgba(49,46,203,0.5)] transform -rotate-12 group-hover:rotate-0 transition-transform duration-300" viewBox="0 0 60 120">
                                    <path d="M30 0 L45 35 L38 38 L30 110 L22 38 L15 35 Z" fill="#312ECB" />
                                    <path d="M30 110 L26 120 L34 120 Z" fill="#D4FF33" />
                                    <circle cx="30" cy="20" r="5" fill="#FFFFFF" />
                                    <!-- Anchor lines -->
                                    <line x1="5" y1="35" x2="55" y2="35" stroke="#00F0FF" stroke-width="2" stroke-dasharray="3 3"/>
                                    <circle cx="5" cy="35" r="3" fill="#00F0FF"/>
                                    <circle cx="55" cy="35" r="3" fill="#00F0FF"/>
                                </svg>
                            </div>
                            <span class="text-[11px] font-semibold mt-2 text-gray-200">Packet Tracer</span>
                        </div>

                        <div class="text-[10px] text-cyan-300 font-mono text-center opacity-80 group-hover:opacity-100">
                            PING TEST ↗
                        </div>
                    </div>

                    <!-- CARD 3 (Center, Vibrant Blue, Tallest Centerpiece) -->
                    <div class="w-full bg-brand-blue rounded-3xl sm:rounded-[32px] p-4 sm:p-6 h-72 sm:h-96 flex flex-col justify-between text-white shadow-2xl hover:-translate-y-3 transition-all duration-300 group cursor-pointer border-2 border-brand-lime/40 ring-4 ring-brand-blue/20 relative overflow-hidden"
                         @click="startLab('network')">
                        
                        <!-- Glow highlight in background -->
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-brand-lime/20 rounded-full blur-2xl pointer-events-none"></div>

                        <div class="flex items-center justify-between relative z-10">
                            <span class="bg-brand-lime text-brand-dark text-[9px] font-extrabold px-2 py-0.5 rounded-full">ACTIVE LAB</span>
                            <span class="text-[10px] font-mono tracking-wider text-brand-lime font-bold">#03 SMP HERO</span>
                        </div>

                        <!-- 3D Student Coder Avatar with Laptop & Idea Lightbulb -->
                        <div class="my-auto flex flex-col items-center relative z-10">
                            <!-- Floating Idea Elements -->
                            <div class="flex items-center gap-2 mb-2">
                                <span class="bg-white/20 backdrop-blur-sm px-2 py-0.5 rounded-full text-[10px] text-yellow-300 font-mono animate-bounce">💡 Idea</span>
                                <span class="bg-black/30 px-2 py-0.5 rounded-full text-[10px] text-brand-lime font-mono">&lt;/code&gt;</span>
                            </div>

                            <!-- 3D Boy Programmer Illustration (SVG) -->
                            <div class="w-24 sm:w-32 h-24 sm:h-32 relative group-hover:scale-105 transition-transform duration-300">
                                <svg viewBox="0 0 160 160" class="w-full h-full drop-shadow-2xl">
                                    <!-- Head -->
                                    <circle cx="80" cy="55" r="26" fill="#FCD5B5" />
                                    <!-- Hair -->
                                    <path d="M54 50 C54 28 106 28 106 50 C106 40 95 34 80 34 C65 34 54 42 54 50 Z" fill="#2D2D2D" />
                                    <!-- Glasses -->
                                    <rect x="62" y="48" width="14" height="10" rx="3" fill="none" stroke="#1E1E1E" stroke-width="2.5" />
                                    <rect x="84" y="48" width="14" height="10" rx="3" fill="none" stroke="#1E1E1E" stroke-width="2.5" />
                                    <line x1="76" y1="53" x2="84" y2="53" stroke="#1E1E1E" stroke-width="2" />
                                    <!-- Smile -->
                                    <path d="M74 66 Q80 72 86 66" stroke="#C86A4B" stroke-width="2" fill="none" stroke-linecap="round" />
                                    <!-- Body (Blue Shirt) -->
                                    <path d="M50 90 C50 78 110 78 110 90 L115 130 L45 130 Z" fill="#1C1A99" />
                                    <!-- Arms Holding Laptop -->
                                    <path d="M48 95 L65 115 L60 120" stroke="#FCD5B5" stroke-width="8" stroke-linecap="round" fill="none"/>
                                    <path d="M112 95 L95 115 L100 120" stroke="#FCD5B5" stroke-width="8" stroke-linecap="round" fill="none"/>
                                    <!-- Laptop -->
                                    <path d="M58 112 L102 112 L108 124 L52 124 Z" fill="#2E2E2E" />
                                    <rect x="62" y="98" width="36" height="18" rx="2" fill="#D4FF33" />
                                    <!-- Code symbols on screen -->
                                    <text x="80" y="110" font-size="8" font-family="monospace" font-weight="bold" fill="#1E1E1E" text-anchor="middle">&gt; PING OK</text>
                                </svg>
                            </div>

                            <span class="text-xs sm:text-sm font-bold mt-2 text-white font-display">Student Networker</span>
                            <span class="text-[10px] text-white/70">Routing & Logic Master</span>
                        </div>

                        <div class="relative z-10 bg-brand-lime text-brand-dark py-1.5 px-3 rounded-full text-[11px] font-extrabold text-center tracking-wide group-hover:scale-105 transition-transform">
                            RUN SIMULATOR ⚡
                        </div>
                    </div>

                    <!-- CARD 4 (Inner Right, Charcoal/Black, Tall Height) -->
                    <div class="w-full bg-brand-dark rounded-2xl sm:rounded-3xl p-3 sm:p-5 h-56 sm:h-72 flex flex-col justify-between text-white shadow-xl hover:-translate-y-2 transition-all duration-300 group cursor-pointer border border-white/10"
                         @click="startLab('cyber')">
                        <div class="flex items-center justify-between">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-400"></span>
                            <span class="text-[10px] font-mono tracking-wider text-gray-400">#04 TOOLBAR</span>
                        </div>

                        <!-- 3D Toolbar Pill Graphic -->
                        <div class="my-auto flex flex-col items-center">
                            <div class="bg-brand-blue/90 p-2.5 rounded-2xl flex flex-col items-center gap-2.5 shadow-lg border border-white/20 group-hover:scale-105 transition-transform">
                                <span class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center text-xs font-mono font-bold text-brand-lime">T</span>
                                <span class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center text-xs">🌐</span>
                                <span class="w-6 h-6 rounded-lg bg-brand-lime text-brand-dark flex items-center justify-center text-xs font-bold">⚡</span>
                                <span class="w-6 h-6 rounded-lg bg-white/20 flex items-center justify-center text-xs">🔒</span>
                            </div>
                            <span class="text-[11px] font-semibold mt-2 text-gray-200">Lab Toolset</span>
                        </div>

                        <div class="text-[10px] text-purple-300 font-mono text-center opacity-80 group-hover:opacity-100">
                            CIPHER LAB ↗
                        </div>
                    </div>

                    <!-- CARD 5 (Far Right, Blue, Medium Height) -->
                    <div class="w-full bg-brand-blue rounded-2xl sm:rounded-3xl p-3 sm:p-5 h-40 sm:h-52 flex flex-col justify-between text-white shadow-lg hover:-translate-y-2 transition-all duration-300 group cursor-pointer border border-blue-400/20"
                         @click="startLab('logic')">
                        <div class="flex items-center justify-between">
                            <span class="w-2.5 h-2.5 rounded-full bg-brand-lime"></span>
                            <span class="text-[10px] font-mono tracking-wider opacity-75">#05 SYNTAX</span>
                        </div>

                        <!-- 3D Dashed Typography Box with "Aa" / Code -->
                        <div class="my-auto flex flex-col items-center">
                            <div class="border-2 border-dashed border-white/50 rounded-xl p-3 group-hover:scale-105 transition-transform bg-black/20">
                                <span class="text-2xl font-black font-display tracking-tight text-brand-lime drop-shadow-md">Aa</span>
                            </div>
                            <span class="text-[11px] font-semibold mt-2 text-white/90">Code Grammar</span>
                        </div>

                        <div class="text-[10px] text-brand-lime font-mono text-center opacity-80 group-hover:opacity-100">
                            VIEW RULES ↗
                        </div>
                    </div>

                </div>
            </div>

        </section>


        <!-- ========================================== -->
        <!-- PLACEHOLDER UNTUK FASE 3: BENTO CLASSES,   -->
        <!-- QUOTE & FOOTER (AKAN DIHUBUNGKAN KE MYSQL) -->
        <!-- ========================================== -->
        <section id="classes" class="mt-8 mb-16">
            <div class="bg-brand-surface/70 border border-black/10 rounded-[32px] p-6 sm:p-10 lg:p-12 shadow-sm relative overflow-hidden"
                 x-data="{ activeClass: 'expert-class' }">
                
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-8 border-b border-black/10">
                    <div>
                        <h2 class="text-3xl sm:text-4xl font-black font-display tracking-tight text-brand-dark">Our Classes</h2>
                        <p class="text-xs text-gray-500 font-mono mt-1">MySQL-POWERED SYLLABUS FOR JUNIOR HIGH SCHOOL</p>
                    </div>
                    <p class="text-sm text-gray-600 max-w-md md:text-right leading-relaxed">
                        Here's our types of coding & network classes that will accompany you in mastering modern computer technology from SMP level.
                    </p>
                </div>

                <!-- 3 Bento Cards from MySQL -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                    @forelse($paths as $index => $path)
                        @php
                            $isCenterDefault = ($path->slug === 'expert-class' || $index === 1);
                        @endphp
                        <div class="rounded-3xl p-6 transition-all duration-300 cursor-pointer flex flex-col justify-between h-96 relative border"
                             :class="activeClass === '{{ $path->slug }}' 
                                 ? 'bg-brand-blue text-white border-brand-blue shadow-glow-blue scale-[1.02]' 
                                 : 'bg-white text-brand-dark border-black/10 hover:border-brand-blue/40 hover:shadow-md'"
                             @mouseenter="activeClass = '{{ $path->slug }}'"
                             @click="startLab('{{ $path->preview_type }}')">
                            
                            <!-- Card Header -->
                            <div>
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="text-xl font-black font-display" 
                                            :class="activeClass === '{{ $path->slug }}' ? 'text-white' : 'text-brand-dark'">
                                            {{ $path->title }}
                                        </h3>
                                        <span class="text-xs font-mono font-medium block mt-0.5"
                                              :class="activeClass === '{{ $path->slug }}' ? 'text-brand-lime' : 'text-brand-blue'">
                                            {{ $path->subtitle }}
                                        </span>
                                    </div>

                                    <!-- Top Right Arrow Pill -->
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center transition-all duration-300"
                                         :class="activeClass === '{{ $path->slug }}' ? 'bg-brand-lime text-brand-dark' : 'bg-brand-blue text-white'">
                                        <span class="font-bold text-sm">↗</span>
                                    </div>
                                </div>

                                <p class="text-xs mt-3 leading-relaxed"
                                   :class="activeClass === '{{ $path->slug }}' ? 'text-white/80' : 'text-gray-500'">
                                    {{ $path->description }}
                                </p>
                            </div>

                            <!-- Interactive Dashboard Graphic Inside Bento Card -->
                            <div class="mt-4 rounded-2xl p-4 overflow-hidden relative"
                                 :class="activeClass === '{{ $path->slug }}' ? 'bg-black/30 border border-white/10' : 'bg-[#F4F3EF] border border-black/5'">
                                
                                @if($path->preview_type === 'logic')
                                    <!-- Visual for Beginner: Logic & Code Blocks -->
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between text-[11px] font-mono font-bold">
                                            <span>LOOP: 4 ITERATIONS</span>
                                            <span class="text-green-500">READY</span>
                                        </div>
                                        <div class="flex gap-1.5">
                                            <span class="px-2 py-1 bg-red-500/80 text-white rounded text-[10px] font-mono">REPEAT 3X</span>
                                            <span class="px-2 py-1 bg-blue-500/80 text-white rounded text-[10px] font-mono">STEP_FWD()</span>
                                            <span class="px-2 py-1 bg-brand-lime text-brand-dark rounded text-[10px] font-mono font-bold">SEND()</span>
                                        </div>
                                        <div class="w-full bg-gray-200 h-1.5 rounded-full overflow-hidden mt-2">
                                            <div class="bg-brand-blue h-full w-2/3"></div>
                                        </div>
                                    </div>
                                @elseif($path->preview_type === 'network')
                                    <!-- Visual for Expert: Packet Flow & Ping -->
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between text-[11px] font-mono font-bold">
                                            <span>ICMP ECHO ROUTING</span>
                                            <span class="text-brand-lime">RTT: 14ms</span>
                                        </div>
                                        <div class="flex items-center justify-between px-2 py-1 bg-black/40 rounded-lg text-[10px] font-mono text-brand-lime">
                                            <span>PC: 192.168.1.10</span>
                                            <span>➔</span>
                                            <span>GW: 10.0.0.1</span>
                                            <span>➔</span>
                                            <span>SERVER</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <span class="w-2 h-2 rounded-full bg-brand-lime animate-ping"></span>
                                            <span class="text-[10px] text-white/90">0% Packet Loss • 64 Bytes</span>
                                        </div>
                                    </div>
                                @else
                                    <!-- Visual for Pro: Cyber & Encryption -->
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between text-[11px] font-mono font-bold">
                                            <span>CAESAR CIPHER LAB</span>
                                            <span class="text-purple-400">SHIFT +3</span>
                                        </div>
                                        <div class="p-1.5 bg-black/40 rounded-lg text-[11px] font-mono text-center tracking-widest text-brand-lime">
                                            FRGHFUDIW ➔ CODECRAFT
                                        </div>
                                        <div class="text-[10px] text-gray-400 text-center font-mono">
                                            PORT 8080: FIREWALL SECURE
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Card Footer: Modules & XP -->
                            <div class="flex items-center justify-between pt-3 text-xs font-mono">
                                <span :class="activeClass === '{{ $path->slug }}' ? 'text-white/80' : 'text-gray-500'">
                                    {{ $path->total_modules }} Interactive Labs
                                </span>
                                <span class="font-bold"
                                      :class="activeClass === '{{ $path->slug }}' ? 'text-brand-lime' : 'text-brand-blue'">
                                    +{{ $path->xp_reward }} XP REWARD
                                </span>
                            </div>

                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12 text-gray-500">
                            Sedang memuat data kelas dari MySQL XAMPP...
                        </div>
                    @endforelse
                </div>

                <!-- Quote Section Sesuai Gambar Referensi -->
                <div class="mt-16 sm:mt-24 pt-12 border-t border-black/10 text-center relative">
                    <!-- Left Asterisk -->
                    <div class="absolute left-4 top-14 select-none">
                        <svg class="w-8 h-8 text-brand-blue fill-current animate-spin-slow" viewBox="0 0 100 100">
                            <g transform="translate(50,50)">
                                <rect x="-5" y="-40" width="10" height="80" rx="5" />
                                <rect x="-5" y="-40" width="10" height="80" rx="5" transform="rotate(45)" />
                                <rect x="-5" y="-40" width="10" height="80" rx="5" transform="rotate(90)" />
                                <rect x="-5" y="-40" width="10" height="80" rx="5" transform="rotate(135)" />
                            </g>
                        </svg>
                    </div>

                    <!-- Right Asterisk -->
                    <div class="absolute right-4 bottom-4 select-none">
                        <svg class="w-10 h-10 text-brand-blue fill-current animate-spin-slow" viewBox="0 0 100 100">
                            <g transform="translate(50,50)">
                                <rect x="-5" y="-40" width="10" height="80" rx="5" />
                                <rect x="-5" y="-40" width="10" height="80" rx="5" transform="rotate(45)" />
                                <rect x="-5" y="-40" width="10" height="80" rx="5" transform="rotate(90)" />
                                <rect x="-5" y="-40" width="10" height="80" rx="5" transform="rotate(135)" />
                            </g>
                        </svg>
                    </div>

                    <!-- Quote Headline -->
                    <h3 class="text-xl sm:text-3xl lg:text-4xl font-black font-display tracking-tight text-brand-dark uppercase max-w-2xl mx-auto leading-snug">
                        KEEP 
                        <span class="inline-block border-2 border-black/20 px-3 py-0.5 rounded-full bg-white text-brand-blue mx-1 shadow-sm">
                            CREATING
                        </span> 
                        UNTIL YOU FIND YOUR OWN <span class="text-brand-blue">AUDIENCE.</span>
                    </h3>

                    <!-- Quote Author / Attribution -->
                    <div class="mt-4">
                        <p class="font-bold text-sm text-brand-dark">Inovasi Mahasiswa STT WASTUKANCANA</p>
                        <p class="text-xs text-gray-500 font-medium">Laboratorium Interaktif Koding & Jaringan Komputer SMP</p>
                    </div>

                    <!-- Footer Divider -->
                    <div class="mt-16 pt-6 border-t border-black/10 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 font-medium gap-2">
                        <div>Copyright &copy; CodeCraft • Inovasi Mahasiswa STT WASTUKANCANA</div>
                        <div>STT WASTUKANCANA · 2024 - 2026</div>
                    </div>

                </div>

            </div>
        </section>

    </div>

    <!-- ========================================== -->
    <!-- INTERACTIVE MINI-LAB MODAL (NETWORK & LOGIC) -->
    <!-- ========================================== -->
    <div x-show="modalOpen" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div class="bg-brand-bg border border-black/15 rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto"
             @click.away="modalOpen = false">
            
            <!-- Close Button -->
            <button @click="modalOpen = false" 
                    class="absolute top-5 right-5 w-8 h-8 rounded-full bg-brand-surface hover:bg-brand-dark hover:text-white transition-colors flex items-center justify-center font-bold text-sm">
                ✕
            </button>

            <!-- Modal Content: Contact Us -->
            <template x-if="activeLabType === 'contact'">
                <div>
                    <h3 class="text-2xl font-black font-display text-brand-dark">Contact CodeCraft Lab</h3>
                    <p class="text-xs text-gray-500 mt-1">Hubungi tim pengajar lab koding & jaringan komputer SMP.</p>
                    <div class="mt-6 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-brand-dark mb-1">Nama Siswa / Sekolah</label>
                            <input type="text" value="SMP Negeri Lab Komputer" class="w-full px-4 py-2.5 rounded-xl border border-black/15 bg-white text-sm" readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-brand-dark mb-1">Email / WhatsApp Guru Pembina</label>
                            <input type="text" value="guru-tik@codecraft.id" class="w-full px-4 py-2.5 rounded-xl border border-black/15 bg-white text-sm" readonly>
                        </div>
                        <div class="p-4 bg-brand-blue/10 rounded-xl border border-brand-blue/20 text-xs text-brand-blue leading-relaxed">
                            💡 Lab interaktif ini dikembangkan sebagai karya inovasi mahasiswa STT WASTUKANCANA untuk mendukung praktikum TIK / Informatika Kurikulum Merdeka tingkat SMP.
                        </div>
                    </div>
                </div>
            </template>

            <!-- Modal Content: Network Packet Simulator -->
            <template x-if="activeLabType === 'network'">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-brand-lime"></span>
                        <h3 class="text-xl sm:text-2xl font-black font-display text-brand-dark">Interactive Network Packet Simulator</h3>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Simulasi transmisi paket ICMP Ping dari PC Siswa melalui Switch & Router ke Cloud Server.</p>

                    <!-- Network Topology Diagram -->
                    <div class="mt-6 p-4 sm:p-6 bg-brand-dark rounded-2xl text-white relative overflow-hidden">
                        
                        <!-- Nodes Row -->
                        <div class="grid grid-cols-4 gap-2 sm:gap-4 items-center text-center relative z-10">
                            <!-- Node 1: PC -->
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-xl bg-brand-blue flex items-center justify-center text-xl shadow-md"
                                     :class="pingStep >= 1 ? 'ring-2 ring-brand-lime scale-105' : ''">
                                    💻
                                </div>
                                <span class="text-[11px] font-bold mt-1 text-white">PC Siswa</span>
                                <span class="text-[9px] font-mono text-gray-400">192.168.1.10</span>
                            </div>

                            <!-- Node 2: Switch -->
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-xl bg-gray-800 border border-white/20 flex items-center justify-center text-xl shadow-md"
                                     :class="pingStep >= 2 ? 'ring-2 ring-brand-lime scale-105' : ''">
                                    🔀
                                </div>
                                <span class="text-[11px] font-bold mt-1 text-white">Switch Lab</span>
                                <span class="text-[9px] font-mono text-gray-400">Layer 2 LAN</span>
                            </div>

                            <!-- Node 3: Router -->
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-xl bg-gray-800 border border-white/20 flex items-center justify-center text-xl shadow-md"
                                     :class="pingStep >= 3 ? 'ring-2 ring-brand-lime scale-105' : ''">
                                    📡
                                </div>
                                <span class="text-[11px] font-bold mt-1 text-white">Gateway Router</span>
                                <span class="text-[9px] font-mono text-gray-400">10.0.0.1</span>
                            </div>

                            <!-- Node 4: Server -->
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-xl bg-brand-blue flex items-center justify-center text-xl shadow-md"
                                     :class="pingStep >= 4 ? 'ring-2 ring-brand-lime scale-105' : ''">
                                    ☁️
                                </div>
                                <span class="text-[11px] font-bold mt-1 text-white">Cloud Server</span>
                                <span class="text-[9px] font-mono text-gray-400">104.21.55.2</span>
                            </div>
                        </div>

                        <!-- Progress Bar / Cable Connection -->
                        <div class="w-full bg-white/10 h-1.5 rounded-full my-4 overflow-hidden">
                            <div class="bg-brand-lime h-full transition-all duration-300"
                                 :style="'width: ' + (pingStep * 25) + '%'"></div>
                        </div>

                        <!-- Terminal Output Log -->
                        <div class="bg-black/80 rounded-xl p-3 font-mono text-[11px] leading-relaxed text-left text-green-400 h-28 overflow-y-auto">
                            <div>$ ping -c 4 104.21.55.2</div>
                            <template x-for="log in pingLogs" :key="log">
                                <div x-text="log"></div>
                            </template>
                        </div>
                    </div>

                    <!-- Simulator Controls -->
                    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-xs text-gray-600">
                            Status Hadiah: <span class="font-bold text-brand-blue">+25 XP ke Akun MySQL</span>
                        </div>
                        <button @click="runNetworkPing()" 
                                :disabled="isSimulating"
                                class="w-full sm:w-auto px-6 py-2.5 rounded-full bg-brand-blue text-white font-display font-bold text-sm hover:bg-blue-700 transition-all flex items-center justify-center gap-2 disabled:opacity-50">
                            <span x-text="isSimulating ? 'Transmitting Packet...' : 'Send Ping ⚡'"></span>
                        </button>
                    </div>
                </div>
            </template>

            <!-- Modal Content: Logic Block Puzzle -->
            <template x-if="activeLabType === 'logic'">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-brand-blue"></span>
                        <h3 class="text-xl sm:text-2xl font-black font-display text-brand-dark">Logic Block Sequence Puzzle</h3>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Urutkan 3 blok logika berikut agar robot koding dapat mengirim paket data ke server tujuan.</p>

                    <!-- Puzzle Builder Area -->
                    <div class="mt-6 p-4 sm:p-6 bg-brand-surface rounded-2xl border border-black/10">
                        <p class="text-xs font-bold text-gray-600 mb-2">Pilih urutan blok eksekusi (Klik untuk menyusun):</p>
                        
                        <!-- Available Blocks -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            <button @click="addLogicBlock('REPEAT_3X')" class="px-3 py-1.5 rounded-lg bg-red-500 text-white font-mono text-xs font-bold hover:scale-105 transition-transform">
                                + [REPEAT 3X]
                            </button>
                            <button @click="addLogicBlock('MOVE_FORWARD')" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-mono text-xs font-bold hover:scale-105 transition-transform">
                                + [MOVE_FORWARD]
                            </button>
                            <button @click="addLogicBlock('SEND_DATA')" class="px-3 py-1.5 rounded-lg bg-brand-lime text-brand-dark font-mono text-xs font-bold hover:scale-105 transition-transform">
                                + [SEND_DATA]
                            </button>
                        </div>

                        <!-- User Selected Slot Sequence -->
                        <div class="p-3 bg-white rounded-xl border-2 border-dashed border-black/20 min-h-[56px] flex items-center gap-2 flex-wrap">
                            <span x-show="selectedBlocks.length === 0" class="text-xs text-gray-400 font-mono">
                                [Slot Kosong: Silakan klik blok logika di atas]
                            </span>
                            <template x-for="(b, idx) in selectedBlocks" :key="idx">
                                <span class="px-3 py-1 rounded bg-brand-dark text-white font-mono text-xs flex items-center gap-2">
                                    <span x-text="(idx + 1) + '. ' + b"></span>
                                    <button @click="removeLogicBlock(idx)" class="text-red-400 font-bold hover:text-red-300">×</button>
                                </span>
                            </template>
                        </div>

                        <!-- Feedback Message -->
                        <div x-show="logicFeedback" class="mt-3 text-xs font-bold"
                             :class="logicSuccess ? 'text-green-600' : 'text-red-600'"
                             x-text="logicFeedback">
                        </div>
                    </div>

                    <!-- Puzzle Controls -->
                    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <button @click="selectedBlocks = []; logicFeedback = ''" class="text-xs text-gray-500 hover:text-black underline">
                            Reset Blok
                        </button>
                        <button @click="submitLogicPuzzle()" 
                                class="w-full sm:w-auto px-6 py-2.5 rounded-full bg-brand-lime text-brand-dark font-display font-bold text-sm hover:bg-[#c3f01f] transition-all flex items-center justify-center gap-2">
                            <span>Jalankan Program Robot & Kirim (+50 XP) 🚀</span>
                        </button>
                    </div>
                </div>
            </template>

            <!-- Modal Content: Cyber Security Lab -->
            <template x-if="activeLabType === 'cyber'">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-purple-500"></span>
                        <h3 class="text-xl sm:text-2xl font-black font-display text-brand-dark">Cyber Security: Caesar Cipher Decoder</h3>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Pecahkan ciphertext <span class="font-mono font-bold text-brand-blue">FRGHFUDIW</span> dengan mencari rotasi kunci yang tepat.</p>

                    <div class="mt-6 p-4 sm:p-6 bg-brand-dark rounded-2xl text-white">
                        <div class="text-center">
                            <span class="text-xs text-gray-400 font-mono">ENCRYPTED MESSAGE</span>
                            <div class="text-3xl font-mono font-black text-brand-lime tracking-widest mt-1">
                                FRGHFUDIW
                            </div>
                        </div>

                        <!-- Shift Slider -->
                        <div class="mt-6">
                            <div class="flex justify-between text-xs font-mono mb-1">
                                <span>Key Shift (Pergeseran Huruf):</span>
                                <span class="font-bold text-brand-lime" x-text="cipherShift"></span>
                            </div>
                            <input type="range" min="0" max="10" x-model.number="cipherShift" 
                                   @input="decodeCipher()"
                                   class="w-full accent-brand-lime cursor-pointer">
                        </div>

                        <!-- Decoded Output -->
                        <div class="mt-6 p-3 bg-black/60 rounded-xl text-center">
                            <span class="text-[10px] text-gray-400 block font-mono">DECRYPTED RESULT:</span>
                            <span class="text-2xl font-mono font-black tracking-widest text-cyan-300" x-text="decodedText"></span>
                        </div>
                    </div>

                    <!-- Cyber Controls -->
                    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-xs text-gray-600">
                            Hadiah Lab: <span class="font-bold text-purple-600">+40 XP</span>
                        </div>
                        <button @click="submitCipherLab()" 
                                class="w-full sm:w-auto px-6 py-2.5 rounded-full bg-purple-600 text-white font-display font-bold text-sm hover:bg-purple-700 transition-all">
                            Verifikasi Kunci Rahasia 🔑
                        </button>
                    </div>
                </div>
            </template>

        </div>
    </div>


    <!-- Alpine.js Main Store & Logic -->
    <script>
        function codecraftApp(config) {
            return {
                xp: config.initialXp || 1250,
                level: config.initialLevel || 4,
                streak: config.initialStreak || 7,
                modalOpen: false,
                activeLabType: 'network',
                
                // Network Simulator State
                pingStep: 0,
                isSimulating: false,
                pingLogs: [],

                // Logic Puzzle State
                selectedBlocks: [],
                logicFeedback: '',
                logicSuccess: false,

                // Cyber Lab State
                cipherShift: 0,
                decodedText: 'FRGHFUDIW',

                openModal(type) {
                    this.activeLabType = type;
                    this.modalOpen = true;
                },

                startLab(type) {
                    this.openModal(type);
                },

                // Network Ping Simulation
                runNetworkPing() {
                    if (this.isSimulating) return;
                    this.isSimulating = true;
                    this.pingStep = 1;
                    this.pingLogs = ['[192.168.1.10] Mengirim frame ARP & SYN packet...'];

                    setTimeout(() => {
                        this.pingStep = 2;
                        this.pingLogs.push('[Switch Lab SMP] Meneruskan frame MAC Address 00:1A:2B:3C:4D:5E...');
                    }, 500);

                    setTimeout(() => {
                        this.pingStep = 3;
                        this.pingLogs.push('[Gateway 10.0.0.1] IP Route match: NAT translate ke Public WAN...');
                    }, 1000);

                    setTimeout(() => {
                        this.pingStep = 4;
                        let latency = Math.floor(Math.random() * 8) + 12; // 12-19ms
                        this.pingLogs.push(`Reply from 104.21.55.2: bytes=64 time=${latency}ms TTL=58`);
                        this.pingLogs.push('--- Ping Statistic: 4 packets transmitted, 4 received, 0% packet loss ---');
                        
                        // Sync XP to MySQL via AJAX
                        this.syncXpToDatabase('network-packet-simulator', 25, { latency_ms: latency });
                        this.isSimulating = false;
                    }, 1600);
                },

                // Logic Puzzle Methods
                addLogicBlock(name) {
                    if (this.selectedBlocks.length < 3) {
                        this.selectedBlocks.push(name);
                    }
                },
                removeLogicBlock(idx) {
                    this.selectedBlocks.splice(idx, 1);
                },
                submitLogicPuzzle() {
                    const expected = ['REPEAT_3X', 'MOVE_FORWARD', 'SEND_DATA'];
                    if (JSON.stringify(this.selectedBlocks) === JSON.stringify(expected)) {
                        this.logicSuccess = true;
                        this.logicFeedback = '🎉 BENAR SEKALI! Robot berhasil melewati firewall dan mentransmisikan data. +50 XP ditambahkan ke database!';
                        this.syncXpToDatabase('logic-block-puzzle', 50, { solved_sequence: this.selectedBlocks });
                    } else {
                        this.logicSuccess = false;
                        this.logicFeedback = '❌ Urutan belum tepat. Hint: Ulangi langkah maju terlebih dahulu sebelum mengirim data [REPEAT 3X -> MOVE_FORWARD -> SEND_DATA].';
                    }
                },

                // Caesar Cipher Decoder
                decodeCipher() {
                    const raw = 'FRGHFUDIW';
                    let res = '';
                    for (let i = 0; i < raw.length; i++) {
                        let c = raw.charCodeAt(i) - 65;
                        let shifted = (c - this.cipherShift + 26) % 26;
                        res += String.fromCharCode(shifted + 65);
                    }
                    this.decodedText = res;
                },
                submitCipherLab() {
                    if (this.decodedText === 'CODECRAFT') {
                        alert('🎉 KUNCI TEPAT! Pesan rahasia terpecahkan: CODECRAFT (+40 XP ditambahkan ke MySQL).');
                        this.syncXpToDatabase('caesar-cipher-decoder', 40, { shift: this.cipherShift });
                    } else {
                        alert('Kunci belum tepat. Geser slider ke pergeseran yang menghasilkan kata rahasia yang bermakna!');
                    }
                },

                // Asynchronous XP Sync to MySQL endpoint
                async syncXpToDatabase(moduleSlug, xpReward, metadata) {
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        const response = await fetch('/lab/complete', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                module_slug: moduleSlug,
                                xp_reward: xpReward,
                                metadata: metadata
                            })
                        });

                        if (response.ok) {
                            const data = await response.json();
                            if (data.success) {
                                this.xp = data.new_xp;
                                this.level = data.new_level;
                            }
                        } else {
                            // Fallback local update if offline
                            this.xp += xpReward;
                            this.level = Math.max(1, Math.floor(this.xp / 300) + 1);
                        }
                    } catch (e) {
                        this.xp += xpReward;
                        this.level = Math.max(1, Math.floor(this.xp / 300) + 1);
                    }
                }
            }
        }
    </script>
</body>
</html>
