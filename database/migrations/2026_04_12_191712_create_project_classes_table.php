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
        Schema::create('project_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->date('registration_date')->nullable();
            $table->string('class_id')->nullable();
            $table->string('class_name')->nullable();
            $table->string('grades')->nullable();
            $table->string('class_type')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('village')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('climate')->nullable();
            $table->string('infrastructure')->nullable();
            $table->integer('boys_enrolled')->nullable();
            $table->integer('girls_enrolled')->nullable();
            $table->integer('total_enrolled')->nullable();
            $table->string('demographic')->nullable();
            $table->string('language')->nullable();
            $table->boolean('class_status')->nullable();
            $table->date('establishment_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('shift')->nullable();
            $table->boolean('is_cluster')->default(false);
            $table->integer('female_teachers')->nullable();
            $table->integer('male_teachers')->nullable();
            $table->text('cbe_teachers')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->date('closure_date')->nullable();
            $table->text('closure_reason')->nullable();
            $table->integer('female_sms_members')->nullable();
            $table->integer('male_sms_members')->nullable();
            $table->text('sms_members')->nullable();
            $table->boolean('has_hub_school')->default(false);
            $table->string('hub_school_name')->nullable();
            $table->decimal('hub_distance_km', 8, 2)->nullable();
            $table->boolean('sip_completed')->default(false);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_classes');
    }
};
