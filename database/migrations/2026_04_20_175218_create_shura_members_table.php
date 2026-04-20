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
        Schema::create('shura_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shura_id')->constrained('project_shuras')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('tazkira_no')->nullable();
            $table->integer('year_of_birth')->nullable();
            $table->integer('age')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->string('education_level')->nullable();
            $table->string('language')->nullable();
            $table->string('residence_type')->nullable();
            $table->boolean('is_disabled')->default(false);
            $table->string('disability_type')->nullable();
            $table->string('role')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('status')->default(1);
            $table->text('remarks')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shura_members');
    }
};
