<?php

namespace App\Service;

class AdminVoterService
{
    public function isAdmin($roles = []): ?bool
    {        
        $isAdmin = false;
        foreach ( $roles as $role) {
            if ($role == 'ROLE_ADMIN') {
                $isAdmin = true;
            }
        }
        
        return $isAdmin;
    }
}