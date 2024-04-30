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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id')
                ->constrained('majors')
                ->onDelete('cascade');
            $table->foreignId('assessment_id')
                ->nullable()
                ->constrained('assessments')
                ->onDelete('cascade');
            $table->unsignedTinyInteger('is_exam')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
