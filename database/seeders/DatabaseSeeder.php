<?php

namespace Database\Seeders;

use App\Models\LabModule;
use App\Models\LearningPath;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Demo Siswa SMP
        $demoUser = User::updateOrCreate(
            ['email' => 'siswa@codecraft.test'],
            [
                'name' => 'Rafi Pratama (Siswa SMP)',
                'username' => 'siswa_demo',
                'grade_level' => 'Kelas 8',
                'password' => Hash::make('password123'),
                'xp' => 1250,
                'level' => 4,
                'streak_days' => 7,
                'avatar' => 'cyber-bot',
            ]
        );

        // 2. Tiga Kelas Utama (Bento Cards)
        $beginner = LearningPath::updateOrCreate(
            ['slug' => 'beginner-class'],
            [
                'title' => 'Beginner Class',
                'subtitle' => 'Logic & Basic Coding',
                'description' => 'For those of you who are just learning logic, block coding & programming fundamentals.',
                'level_tag' => 'Beginner',
                'icon' => 'code',
                'badge_color' => '#312ECB',
                'is_featured' => false,
                'total_modules' => 6,
                'xp_reward' => 150,
                'preview_type' => 'logic',
            ]
        );

        $expert = LearningPath::updateOrCreate(
            ['slug' => 'expert-class'],
            [
                'title' => 'Expert Class',
                'subtitle' => 'Network & Packet Routing',
                'description' => 'For those of you who want to master computer networks, TCP/IP packets & routing.',
                'level_tag' => 'Expert',
                'icon' => 'network',
                'badge_color' => '#312ECB',
                'is_featured' => true,
                'total_modules' => 8,
                'xp_reward' => 250,
                'preview_type' => 'network',
            ]
        );

        $pro = LearningPath::updateOrCreate(
            ['slug' => 'pro-class'],
            [
                'title' => 'Pro Class',
                'subtitle' => 'Cyber & Algorithm Lab',
                'description' => 'For those of you who want advanced coding puzzles, basic cybersecurity & cipher labs.',
                'level_tag' => 'Pro',
                'icon' => 'shield',
                'badge_color' => '#312ECB',
                'is_featured' => false,
                'total_modules' => 10,
                'xp_reward' => 350,
                'preview_type' => 'cyber',
            ]
        );

        // 3. Modul Simulasi
        $logicMod = LabModule::updateOrCreate(
            ['slug' => 'logic-block-puzzle'],
            [
                'learning_path_id' => $beginner->id,
                'title' => 'Logic Block Sequence: Robot Pathfinding',
                'type' => 'logic_puzzle',
                'difficulty' => 'Easy',
                'description' => 'Susun urutan blok kode (Maju, Putar Kanan, Periksa Sensor, Ulangi) agar robot mencapai server tujuan tanpa menabrak firewall.',
                'instructions' => 'Tarik blok logika ke urutan eksekusi yang tepat: [START] -> [REPEAT 3x] -> [MOVE_FORWARD] -> [SEND_DATA].',
                'initial_config' => [
                    'blocks' => ['REPEAT_3X', 'MOVE_FORWARD', 'TURN_LEFT', 'SEND_DATA'],
                    'target_sequence' => ['REPEAT_3X', 'MOVE_FORWARD', 'SEND_DATA'],
                ],
                'solution_key' => ['REPEAT_3X', 'MOVE_FORWARD', 'SEND_DATA'],
                'xp_reward' => 50,
                'order' => 1,
                'is_active' => true,
            ]
        );

        $networkMod = LabModule::updateOrCreate(
            ['slug' => 'network-packet-simulator'],
            [
                'learning_path_id' => $expert->id,
                'title' => 'Packet Route Simulation: PC to Cloud Server',
                'type' => 'network_simulator',
                'difficulty' => 'Medium',
                'description' => 'Simulasikan pengiriman paket data ICMP (Ping) dari PC Siswa melewati Switch Lokal dan Edge Router hingga mencapai Cloud Server.',
                'instructions' => 'Klik tombol "Send Ping ⚡" untuk meluncurkan paket data, periksa latensi round-trip (RTT), dan pastikan 0% packet loss.',
                'initial_config' => [
                    'nodes' => [
                        ['id' => 'pc', 'name' => 'PC Siswa', 'ip' => '192.168.1.10', 'role' => 'client'],
                        ['id' => 'switch', 'name' => 'Switch Lab SMP', 'ip' => '192.168.1.1', 'role' => 'bridge'],
                        ['id' => 'router', 'name' => 'Gateway Router', 'ip' => '10.0.0.1', 'role' => 'gateway'],
                        ['id' => 'server', 'name' => 'Cloud Server', 'ip' => '104.21.55.2', 'role' => 'server'],
                    ],
                ],
                'xp_reward' => 25,
                'order' => 1,
                'is_active' => true,
            ]
        );

        $cyberMod = LabModule::updateOrCreate(
            ['slug' => 'caesar-cipher-decoder'],
            [
                'learning_path_id' => $pro->id,
                'title' => 'Cyber Security: Caesar Cipher Decoder',
                'type' => 'cyber_lab',
                'difficulty' => 'Medium',
                'description' => 'Pecahkan kode rahasia terenkripsi dari server dengan mencari pergeseran kunci (Key Shift) yang sesuai.',
                'instructions' => 'Geser slider kunci enkripsi hingga teks sandi terbaca menjadi instruksi rahasia.',
                'initial_config' => [
                    'ciphertext' => 'FRGHFUDIW',
                    'correct_shift' => 3,
                    'plaintext' => 'CODECRAFT',
                ],
                'xp_reward' => 40,
                'order' => 1,
                'is_active' => true,
            ]
        );

        // 4. Progress Awal Demo User
        UserProgress::updateOrCreate(
            [
                'user_id' => $demoUser->id,
                'lab_module_id' => $networkMod->id,
            ],
            [
                'status' => 'completed',
                'score' => 100,
                'xp_earned' => 25,
                'metadata' => [
                    'latency_ms' => 14,
                    'hops' => 3,
                    'protocol' => 'ICMP Ping',
                ],
                'completed_at' => now(),
            ]
        );
    }
}
