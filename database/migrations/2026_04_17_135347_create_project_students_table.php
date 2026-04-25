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
        Schema::create('project_students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('class_id')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('village')->nullable();
            $table->string('asas_no')->nullable();
            $table->date('enrollment_date')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('tazkira_no')->nullable();
            $table->integer('year_of_birth')->nullable();
            $table->integer('age')->nullable();
            $table->enum('gender', ['Girls', 'Boys'])->nullable();
            $table->string('native_language')->nullable();
            $table->string('residence_type')->nullable();
            $table->boolean('is_disabled')->default(false);
            $table->string('disability_type')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('guardian_relation')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Handed Over', 'Transited'])->default('Active');
            // $table->date('status_change_date')->nullable();
            // $table->text('status_change_reason')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_students');
    }
};
