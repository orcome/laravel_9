<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Brother;
use Illuminate\Auth\Access\HandlesAuthorization;

class BrotherPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Brother $brother)
    {
        // Update $user authorization to view $brother here.
        return true;
    }

    public function create(User $user, Brother $brother)
    {
        // Update $user authorization to create $brother here.
        return true;
    }

    public function update(User $user, Brother $brother)
    {
        // Update $user authorization to update $brother here.
        return true;
    }

    public function delete(User $user, Brother $brother)
    {
        // Update $user authorization to delete $brother here.
        return true;
    }
}
