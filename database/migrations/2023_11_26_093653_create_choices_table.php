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
    Schema::create('choices', function (Blueprint $table) {
      $table->id();
      $table->foreignId('lesson_id')
        ->constrained('lessons')
        ->onDelete('cascade');
      $table->string('choice_index');
      $table->text('choice_description');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('choices');
  }
};