<?php

namespace App\Enum;

enum JobApplicationStatusEnum: string
{
    case PENDING = 'pending';
    case REVIEWED = 'reviewed';
    case SHORTLISTED = 'shortlisted';
    case REJECTED = 'rejected';
    case HIRED = 'hired';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::REVIEWED => 'Reviewed',
            self::SHORTLISTED => 'Shortlisted',
            self::REJECTED => 'Rejected',
            self::HIRED => 'Hired',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::PENDING => 'bg-warning text-dark',
            self::REVIEWED => 'bg-info text-dark',
            self::SHORTLISTED => 'bg-primary',
            self::REJECTED => 'bg-danger',
            self::HIRED => 'bg-success',
        };
    }
}
