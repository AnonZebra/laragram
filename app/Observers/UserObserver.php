<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserProfile;

class UserObserver
{
    private $userProfile;

    public function __construct(UserProfile $userProfile)
    {
        $this->userProfile = $userProfile;
    }

    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $this->userProfile->create([
            'user_id' => $user->id
        ]);
    }
}
