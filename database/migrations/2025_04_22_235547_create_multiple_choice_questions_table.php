<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('multiple_choice_questions')) {
            Schema::create('multiple_choice_questions', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('question_id')->constrained()->cascadeOnDelete();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('multiple_choice_questions');
    }
};
