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
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->longText('question_text')->nullable();
            $table->foreignUuid('question_upload_id')->nullable()->constrained('uploads', 'id')->onDelete('cascade');
            $table->foreignUuid('answer_upload_id')->nullable()->constrained('uploads', 'id')->onDelete('cascade');
            $table->string('course_code');
            $table->string('session');
            $table->string('semester');
            $table->string('level');
            $table->string('difficulty');
            $table->integer('max_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
