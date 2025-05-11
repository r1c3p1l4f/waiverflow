<?php

namespace App\Policies;

use App\Models\SignedWaiver;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SignedWaiverPolicy
{
    use HandlesAuthorization;

    public function view(User $user, SignedWaiver $signedWaiver)
    {
        // Admin and staff can view all waivers
        if ($user->hasRole('admin') || $user->hasRole('staff')) {
            return true;
        }
        
        // Users can only view their own waivers
        return $user->id === $signedWaiver->user_id;
    }
}
