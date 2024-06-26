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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id')
                ->constrained('majors')
                ->onDelete('cascade');
            $table->foreignId('staff_profile_id')
                ->constrained('staff_profiles')
                ->onDelete('cascade');
            $table->string('category_name');
            $table->string('status');
            $table->string('pdf')->nullable();
            $table->text('embed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
