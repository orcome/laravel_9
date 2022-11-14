<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Master;
use Illuminate\Auth\Access\HandlesAuthorization;

class MasterPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Master $master)
    {
        // Update $user authorization to view $master here.
        return true;
    }

    public function create(User $user, Master $master)
    {
        // Update $user authorization to create $master here.
        return true;
    }

    public function update(User $user, Master $master)
    {
        // Update $user authorization to update $master here.
        return true;
    }

    public function delete(User $user, Master $master)
    {
        // Update $user authorization to delete $master here.
        return true;
    }
}
