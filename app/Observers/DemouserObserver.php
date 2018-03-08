<?php

namespace App\Observers;

use App\Demouser;

class DemouserObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function creating(Demouser $user)
    {
        $user->subscriptiontoken = intval("0" . rand(1, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) .rand(0, 9));
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleting(Demouser $user)
    {
        //
    }
}
