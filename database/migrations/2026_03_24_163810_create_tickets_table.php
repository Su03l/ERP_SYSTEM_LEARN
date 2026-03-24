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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique(); // رقم التذكرة المميز REQ-001
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // صاحب التذكرة
            $table->string('subject');
            $table->text('description');
            $table->string('status')->default(\App\Enums\TicketStatus::OPEN->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
