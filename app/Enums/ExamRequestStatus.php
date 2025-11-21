<?php

namespace App\Enums;

enum ExamRequestStatus: string
{
    case PENDING   = 'pending';
    case UPDATED   = 'updated';
    case APPROVED  = 'approved';
    case REJECTED  = 'rejected';

    public function label(): string
    {
        return match($this) {
            self::PENDING   => 'Pending',
            self::UPDATED   => 'Updated',
            self::APPROVED  => 'Approved',
            self::REJECTED  => 'Rejected',
        };
    }

    public function badgeColor(): string
    {
        return match($this) {
            self::PENDING   => 'warning',
            self::UPDATED   => 'success',
            self::APPROVED  => 'success',
            self::REJECTED  => 'danger',
        };
    }
}
