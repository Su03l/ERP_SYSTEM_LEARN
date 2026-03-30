<?php

namespace App\Enums;

enum TicketStatus: string {
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case CLOSED = 'closed';

    public function getLabel(): string
    {
        return match($this) {
            self::OPEN => 'مفتوحة 🟢',
            self::IN_PROGRESS => 'قيد المعالجة 🟡',
            self::CLOSED => 'مغلقة 🔴',
        };
    }

    public function getLabel(): string
    {
        return match($this) {
            self::OPEN => 'مفتوحة 🟢',
            self::IN_PROGRESS => 'قيد المعالجة 🟡',
            self::CLOSED => 'مغلقة 🔴',
        };
    }
}
