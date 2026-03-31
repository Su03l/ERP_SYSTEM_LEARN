<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('performance_evaluations', function (Blueprint $table) {
            // حذف أعمدة التقييم القديمة
            $table->dropColumn([
                'overall_rating',
                'commitment_rating',
                'teamwork_rating',
                'creativity_rating',
                'communication_rating',
            ]);

            // إضافة عمود JSON لتخزين كل التقييمات التفصيلية
            $table->json('ratings')->after('evaluator_id');
        });
    }

    public function down(): void
    {
        Schema::table('performance_evaluations', function (Blueprint $table) {
            $table->dropColumn('ratings');
            $table->unsignedTinyInteger('overall_rating');
            $table->unsignedTinyInteger('commitment_rating');
            $table->unsignedTinyInteger('teamwork_rating');
            $table->unsignedTinyInteger('creativity_rating');
            $table->unsignedTinyInteger('communication_rating');
        });
    }
};
