<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('options')) {
            Schema::create('options', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('multiple_choice_question_id')->constrained()->cascadeOnDelete();
                $table->text('content');
                $table->boolean('is_correct')->default(false);
                $table->unsignedTinyInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
