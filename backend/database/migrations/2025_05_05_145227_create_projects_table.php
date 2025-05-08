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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['En cours', 'En progression', 'Achevé'])->default('En cours');
            $table->enum('priority', ['Faible', 'Moyen', 'Elevé', 'Urgent'])->default('Moyen');
            $table->string('client_name')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->foreignId('manager_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
