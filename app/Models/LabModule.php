<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LabModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'learning_path_id',
        'title',
        'slug',
        'type',
        'difficulty',
        'description',
        'instructions',
        'initial_config',
        'solution_key',
        'xp_reward',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'initial_config' => 'array',
            'solution_key' => 'array',
            'xp_reward' => 'integer',
            'order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function learningPath(): BelongsTo
    {
        return $this->belongsTo(LearningPath::class);
    }

    public function userProgress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }
}

