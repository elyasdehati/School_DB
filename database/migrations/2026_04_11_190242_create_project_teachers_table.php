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
        Schema::create('project_teachers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')->constrained()->cascadeOnDelete();

            $table->string('serial_number')->nullable();
            $table->string('cbe_list')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->string('village')->nullable();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name')->nullable();

            $table->date('starting_date')->nullable();
            $table->boolean('is_active')->default(true);

            $table->string('tazkira_number')->nullable();
            $table->integer('year_of_birth')->nullable();

            $table->enum('gender', ['Male','Female'])->nullable();
            $table->string('teacher_type')->nullable();
            $table->string('qualification')->nullable();

            $table->string('phone')->nullable();

            $table->boolean('core_training')->default(false);
            $table->boolean('refresher_training')->default(false);

            $table->timestamps();

            $table->foreign('province_id')->references('id')->on('provinces')->nullOnDelete();
            $table->foreign('district_id')->references('id')->on('districts')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_teachers');
    }
};
