<?php

namespace App\Enums;

enum UserRole: string
{
    case JOBSEEKER  = 'jobseeker';
    case EMPLOYER   = 'employer';
    case ADMIN      = 'admin';
}
