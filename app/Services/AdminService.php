<?php

namespace App\Services;

use App\Models\User;

class AdminService
{
    public function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }
}