<?php

namespace App\Http\Controllers;

use App\Models\LabModule;
use App\Models\LearningPath;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LabController extends Controller
{
    /**
     * Display the main CodeCraft landing page with MySQL data.
     */
    public function index(): View
    {
        // 1. Fetch Demo Student User
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Rafi Pratama (Siswa SMP)',
                'email' => 'siswa@codecraft.test',
                'password' => bcrypt('password123'),
                'xp' => 1250,
                'level' => 4,
                'streak_days' => 7,
            ]);
        }

        // 2. Fetch Learning Paths with their Lab Modules
        $learningPaths = LearningPath::with(['labModules' => function ($q) {
            $q->where('is_active', true)->orderBy('order');
        }])->get();

        // 3. Fetch User Progresses
        $userProgress = UserProgress::with('labModule')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('welcome', compact('user', 'learningPaths', 'userProgress'));
    }

    /**
     * Endpoint to record completed lab module and sync XP to MySQL.
     */
    public function completeModule(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'module_slug' => 'required|string',
            'xp_reward' => 'nullable|integer|min:1',
            'metadata' => 'nullable|array',
        ]);

        $user = User::first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'No active user found'], 404);
        }

        $module = LabModule::where('slug', $validated['module_slug'])->first();
        $xpReward = $validated['xp_reward'] ?? ($module ? $module->xp_reward : 25);

        // Update user XP & Level in MySQL
        $user->addXp($xpReward);

        // Record progress in MySQL
        if ($module) {
            UserProgress::create([
                'user_id' => $user->id,
                'lab_module_id' => $module->id,
                'status' => 'completed',
                'score' => 100,
                'xp_earned' => $xpReward,
                'metadata' => $validated['metadata'] ?? [],
                'completed_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "Selamat! +{$xpReward} XP berhasil disimpan ke database MySQL.",
            'new_xp' => $user->xp,
            'new_level' => $user->level,
            'user' => [
                'name' => $user->name,
                'streak_days' => $user->streak_days,
            ],
        ]);
    }
}
