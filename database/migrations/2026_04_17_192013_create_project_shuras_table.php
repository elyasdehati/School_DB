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
        Schema::create('project_shuras', function (Blueprint $table) {
           $table->id();
           $table->string('sno')->nullable();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('province_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('district_id')->nullable()->constrained()->nullOnDelete();
            $table->string('village')->nullable();
            $table->string('shura_name')->nullable();
            $table->date('shura_establishment_date')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->date('status_change_date')->nullable();
            $table->string('status_change_reason')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_shuras');
    }
};
