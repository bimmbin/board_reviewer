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
    Schema::create('exam_answers', function (Blueprint $table) {
      $table->id();
      $table->foreignId('exam_id')
        ->constrained('exams')
        ->onDelete('cascade');
      $table->foreignId('choice_id')
        ->constrained('choices')
        ->onDelete('cascade');
      $table->foreignId('lesson_id')
        ->constrained('lessons')
        ->onDelete('cascade');
      $table->string('is_correct'); //to show scores
      $table->string('not_answered'); //to show unanswered
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('exam_answers');
  }
};
