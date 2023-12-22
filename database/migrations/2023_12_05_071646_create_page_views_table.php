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
    Schema::create('page_views', function (Blueprint $table) {
      $table->id();
      $table->foreignId('recent_lesson_id')
        ->constrained('recent_lessons')
        ->onDelete('cascade');
      $table->foreignId('category_id')
        ->constrained('categories')
        ->onDelete('cascade');
      $table->foreignId('lesson_id')
        ->constrained('lessons')
        ->onDelete('cascade');
      $table->string('page_number');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('page_views');
  }
};
