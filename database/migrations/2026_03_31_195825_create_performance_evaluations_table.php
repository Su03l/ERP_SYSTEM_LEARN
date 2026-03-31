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
            $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('evaluator_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('overall_rating'); // الأداء العام 1-5
            $table->unsignedTinyInteger('commitment_rating'); // الالتزام 1-5
            $table->unsignedTinyInteger('teamwork_rating'); // العمل الجماعي 1-5
            $table->unsignedTinyInteger('creativity_rating'); // الإبداع 1-5
            $table->unsignedTinyInteger('communication_rating'); // التواصل 1-5
            $table->text('notes')->nullable(); // ملاحظات المشرف
            $table->string('evaluation_period'); // شهري / ربع سنوي / سنوي
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_evaluations');
    }
};
