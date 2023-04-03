<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case POSTULANT = 'postulant';

    public function isAdmin(): bool
    {
        return $this->value === self::ADMIN->value;
    }

    public function isApplicant(): bool
    {
        return $this->value === self::POSTULANT->value;
    }
}
