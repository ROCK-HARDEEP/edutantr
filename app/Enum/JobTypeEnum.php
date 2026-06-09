<?php

namespace App\Enum;

enum JobTypeEnum: string
{
    case FULL_TIME = 'full_time';
    case INTERNSHIP = 'internship';
    case PART_TIME = 'part_time';
    case CONTRACT = 'contract';

    public function label(): string
    {
        return match ($this) {
            self::FULL_TIME => 'Full-Time',
            self::INTERNSHIP => 'Internship',
            self::PART_TIME => 'Part-Time',
            self::CONTRACT => 'Contract',
        };
    }
}
