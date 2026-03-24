<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('salary', 10, 2)->nullable()->after('phone');       // الراتب
            $table->string('national_id')->nullable()->after('salary');          // رقم الهوية
            $table->date('join_date')->nullable()->after('national_id');         // تاريخ الالتحاق
            $table->string('bank_iban')->nullable()->after('join_date');         // رقم الآيبان
            $table->string('address')->nullable()->after('bank_iban');           // العنوان
            $table->string('emergency_contact')->nullable()->after('address');   // رقم الطوارئ
            $table->string('gender')->nullable()->after('emergency_contact');    // الجنس
            $table->date('birth_date')->nullable()->after('gender');             // تاريخ الميلاد
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'salary', 'national_id', 'join_date', 'bank_iban',
                'address', 'emergency_contact', 'gender', 'birth_date'
            ]);
        });
    }
};
