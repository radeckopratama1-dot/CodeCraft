<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('learning_paths', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('subtitle');
            $table->text('description');
            $table->string('level_tag'); // Beginner, Expert, Pro
            $table->string('icon')->nullable();
            $table->string('badge_color')->default('#312ECB');
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('total_modules')->default(8);
            $table->unsignedInteger('xp_reward')->default(100);
            $table->string('preview_type')->default('logic'); // logic, network, cyber
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_paths');
    }
};
