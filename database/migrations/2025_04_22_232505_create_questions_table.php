<?php

use App\Enums\QuestionDifficulty;
use App\Enums\QuestionType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('questions')) {
            Schema::create('questions', function (Blueprint $table): void {
                $table->id();
                $table->text('content');
                $table->enum('type', array_column(QuestionType::cases(), 'value'));
                $table->foreignId('quiz_id')->constrained()->cascadeOnDelete();
                $table->unsignedSmallInteger('points')->default(1);
                $table->unsignedSmallInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
