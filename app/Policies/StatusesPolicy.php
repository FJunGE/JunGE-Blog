<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Status;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusesPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $currentUser, Status $status){
        return $currentUser->id === $status->user_id;
    }

    public function destroy(User $currentUser, Status $status){
        return $currentUser->id === $status->user_id;
    }
}
