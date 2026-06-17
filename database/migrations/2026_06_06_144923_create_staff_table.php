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
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        // Foreign keys with cascade delete so records clean up if a staff/cme is removed
        $table->foreignId('cme_id')->constrained('cmes')->onDelete('cascade');
        $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
        $table->enum('status', ['Present', 'Absent'])->default('Absent');
        $table->timestamps();
        
        // Optimizes performance and prevents duplicate records for the same person in one CME
        $table->unique(['cme_id', 'staff_id']); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
