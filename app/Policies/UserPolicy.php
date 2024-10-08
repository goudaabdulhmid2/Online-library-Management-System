<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    public function __construct()
    {
        //
    }

    public function manager(User $user)
    {
        return $user->role === 'manager';
    }
    
    public function admin(User $user)
    {
        return $user->role === 'admin'; 
    }
    


    
}
