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
            $table->string('project_contract_no')->nullable();
            $table->string('name')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('donor')->nullable();
            $table->string('partner')->nullable();
            $table->string('thematic_area')->nullable();
            $table->enum('status', ['Completed', 'Ongoing', 'Pipeline', 'Change', 'Suspend', 'Cancel'])->nullable();
            $table->json('province')->nullable();
            $table->json('district')->nullable();
            $table->text('description')->nullable();

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
