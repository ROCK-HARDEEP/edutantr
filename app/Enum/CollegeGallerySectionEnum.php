<?php

namespace App\Enum;

enum CollegeGallerySectionEnum: string
{
    case MOU = 'mou';
    case ACADEMIC_PARTNERSHIP = 'academic_partnership';
    case WORKSHOP = 'workshop';
    case SEMINAR = 'seminar';
    case INTERNSHIP_DRIVE = 'internship_drive';
    case EVENT_HIGHLIGHT = 'event_highlight';

    public function label(): string
    {
        return match ($this) {
            self::MOU => 'MOU Signed Colleges',
            self::ACADEMIC_PARTNERSHIP => 'Academic Partnerships',
            self::WORKSHOP => 'Workshop Photos',
            self::SEMINAR => 'Seminar Photos',
            self::INTERNSHIP_DRIVE => 'Internship Drive Photos',
            self::EVENT_HIGHLIGHT => 'Event Highlights',
        };
    }
}
