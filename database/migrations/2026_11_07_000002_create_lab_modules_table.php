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
        Schema::create('lab_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_path_id')->constrained('learning_paths')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('type'); // network_simulator, logic_puzzle, quiz, cyber_lab
            $table->string('difficulty')->default('Easy');
            $table->text('description');
            $table->text('instructions')->nullable();
            $table->json('initial_config')->nullable();
            $table->json('solution_key')->nullable();
            $table->unsignedInteger('xp_reward')->default(25);
            $table->unsignedInteger('order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_modules');
    }
};

