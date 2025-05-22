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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            // $table->foreignId('assigned_to')->constrained('users')->onDelete('cascade');
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['En cours', 'En progression', 'Achevé'])->default('En cours');
            $table->enum('priority', ['Faible', 'Moyen', 'Elevé', 'Urgent'])->default('Moyen');
            $table->integer('estimated_hours')->nullable();
            $table->integer('actual_hours')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->date('due_date')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
