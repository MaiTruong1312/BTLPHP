<?php

namespace App\Enums;

enum UserRole: string
{
    case CANDIDATE = 'candidate';
    case EMPLOYER = 'employer';
    case ADMIN = 'admin';
}

