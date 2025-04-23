<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('true_false_questions')) {
            Schema::create('true_false_questions', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('question_id')->constrained()->cascadeOnDelete();
                $table->boolean('correct_answer');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('true_false_questions');
    }
};
