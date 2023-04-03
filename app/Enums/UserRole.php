<?php

namespace App\Enums;

enum UserRole: string
{
    case Administrator = 'administrator';
    case Applicant = 'applicant';

    public function isAdmin(): bool
    {
        return $this->value === self::Administrator->value;
    }

    public function isApplicant(): bool
    {
        return $this->value === self::Applicant->value;
    }
}
