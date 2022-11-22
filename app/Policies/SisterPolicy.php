<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Sister;
use Illuminate\Auth\Access\HandlesAuthorization;

class SisterPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Sister $sister)
    {
        // Update $user authorization to view $sister here.
        return true;
    }

    public function create(User $user, Sister $sister)
    {
        // Update $user authorization to create $sister here.
        return true;
    }

    public function update(User $user, Sister $sister)
    {
        // Update $user authorization to update $sister here.
        return true;
    }

    public function delete(User $user, Sister $sister)
    {
        // Update $user authorization to delete $sister here.
        return true;
    }
}
