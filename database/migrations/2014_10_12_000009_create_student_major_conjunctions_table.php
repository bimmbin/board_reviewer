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
    Schema::create('student_major_conjunctions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('student_major_id')
        ->constrained('student_majors')
        ->onDelete('cascade');
      $table->foreignId('major_id')
        ->constrained('majors')
        ->onDelete('cascade');
        $table->foreignId('major_coverage_id')
        ->constrained('major_coverages')
        ->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('student_major_conjunctions');
  }
};
