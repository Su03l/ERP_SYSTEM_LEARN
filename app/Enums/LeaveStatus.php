<?php

namespace App\Enums;

enum LeaveStatus: string {
    case PENDING = 'pending'; // الحالة معلفة
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
