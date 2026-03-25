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
        Schema::create('personal_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->enum('gender', ['male', 'female']);
            $table->enum('fitness_level', ['beginner', 'intermediate', 'advanced']);
            $table->enum('training_type', ['in_person', 'online', 'both']);
            $table->enum('training_frequency', ['1-2', '3-4', '5+', 'not_sure']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_information');
    }
};
