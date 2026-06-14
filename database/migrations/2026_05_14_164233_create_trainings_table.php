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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            // $table->integer('sno')->nullable();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('province_id')->nullable()->constrained('provinces')->nullOnDelete();
            $table->string('village')->nullable();
            $table->string('training_venue')->nullable();
            $table->foreignId('training_type_id')->nullable()->constrained('training_types')->nullOnDelete();
            $table->string('training_topic')->nullable();
            $table->date('training_start_date')->nullable();
            $table->date('training_end_date')->nullable();
            $table->string('facilitator_name')->nullable();
            $table->string('facilitator_position')->nullable();
            $table->integer('male_participants')->nullable();
            $table->integer('female_participants')->nullable();
            $table->integer('gov_participants')->nullable();
            $table->foreignId('status_id')->nullable()->constrained('statuses')->nullOnDelete();
            $table->float('avg_pre_test')->nullable();
            $table->float('avg_post_test')->nullable();
            $table->text('objective')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
