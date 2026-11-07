<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LearningPath extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'description',
        'level_tag',
        'icon',
        'badge_color',
        'is_featured',
        'total_modules',
        'xp_reward',
        'preview_type',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'total_modules' => 'integer',
            'xp_reward' => 'integer',
        ];
    }

    public function labModules(): HasMany
    {
        return $this->hasMany(LabModule::class)->orderBy('order');
    }
}

