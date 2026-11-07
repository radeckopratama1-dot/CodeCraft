<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'xp',
        'level',
        'streak_days',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'xp' => 'integer',
            'level' => 'integer',
            'streak_days' => 'integer',
        ];
    }

    public function userProgress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Add XP and recalculate level automatically.
     */
    public function addXp(int $amount): void
    {
        $this->xp += $amount;
        // Level calculation: level 1 is 0-300, level 2 is 301-600, etc. (every 300 XP = 1 level up)
        $this->level = max(1, (int) floor($this->xp / 300) + 1);
        $this->save();
    }
}
