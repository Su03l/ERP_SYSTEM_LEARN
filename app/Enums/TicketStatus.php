<?php

namespace App\Enums;

enum TicketStatus: string {
    case OPEN = 'open'; // مفتوحة
    case IN_PROGRESS = 'in_progress'; // قيد المعالجة
    case CLOSED = 'closed'; // مغلقة

    public function getLabel(): string
    {
        return match($this) {
            self::OPEN => 'مفتوحة',
            self::IN_PROGRESS => 'قيد المعالجة',
            self::CLOSED => 'مغلقة',
        };
    }
}
