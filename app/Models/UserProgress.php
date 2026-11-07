<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProgress extends Model
{
    use HasFactory;

    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'lab_module_id',
        'status',
        'score',
        'xp_earned',
        'metadata',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'integer',
            'xp_earned' => 'integer',
            'metadata' => 'array',
            'completed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function labModule(): BelongsTo
    {
        return $this->belongsTo(LabModule::class);
    }
}
