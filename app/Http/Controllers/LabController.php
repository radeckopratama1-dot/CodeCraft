<?php

namespace App\Http\Controllers;

use App\Models\LabModule;
use App\Models\LearningPath;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LabController extends Controller
{
    /**
     * Display the main CodeCraft landing page with MySQL data.
     */
    public function index(Request $request): View
    {
        // Get authenticated student user if logged in
        $user = Auth::user();

        // Fetch Learning Paths with their Lab Modules
        $learningPaths = LearningPath::with(['labModules' => function ($q) {
            $q->where('is_active', true)->orderBy('order');
        }])->get();

        // Fetch User Progress if user is authenticated
        $userProgress = $user
            ? UserProgress::with('labModule')
                ->where('user_id', $user->id)
                ->latest()
                ->get()
            : collect();

        $openLab = $request->query('open_lab');

        return view('welcome', compact('user', 'learningPaths', 'userProgress', 'openLab'));
    }

    /**
     * Redirect to classes section for authenticated students.
     */
    public function classes(): RedirectResponse
    {
        return redirect('/#classes');
    }

    /**
     * Open interactive lab for authenticated students.
     */
    public function lab(Request $request): RedirectResponse
    {
        $type = $request->query('type', 'network');
        return redirect()->route('home', ['open_lab' => $type]);
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

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu untuk menyimpan XP.',
            ], 401);
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
                'grade_level' => $user->grade_level,
                'streak_days' => $user->streak_days,
            ],
        ]);
    }
}
