<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluator_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('users')->onDelete('cascade');
            $table->string('period'); // e.g. "Q1 2026"
            $table->unsignedTinyInteger('punctuality');   // الانضباط والحضور 1-5
            $table->unsignedTinyInteger('quality');        // جودة العمل 1-5
            $table->unsignedTinyInteger('teamwork');       // روح الفريق 1-5
            $table->unsignedTinyInteger('communication');  // مهارات التواصل 1-5
            $table->unsignedTinyInteger('productivity');   // الإنتاجية والإنجاز 1-5
            $table->decimal('overall_score', 4, 2)->virtualAs('(punctuality + quality + teamwork + communication + productivity) / 5.0');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_evaluations');
    }
};
