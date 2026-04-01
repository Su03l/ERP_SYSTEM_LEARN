<?php

namespace App\Enums;

enum LeaveStatus: string {
    case PENDING = 'pending'; // الحالة معلفة
    case APPROVED = 'approved'; // الحالة مقبولة
    case REJECTED = 'rejected'; // الحالة مرفوضة
}
