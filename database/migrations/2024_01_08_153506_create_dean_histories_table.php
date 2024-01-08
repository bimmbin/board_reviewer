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
    Schema::create('dean_histories', function (Blueprint $table) {
      $table->id();
      $table->foreignId('staff_profile_id')
        ->constrained('staff_profiles')
        ->onDelete('cascade');
      $table->foreignId('category_id')
        ->constrained('categories')
        ->onDelete('cascade');
      $table->string('status'); 
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('dean_histories');
  }
};
