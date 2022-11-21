<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Mother;
use Illuminate\Auth\Access\HandlesAuthorization;

class MotherPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Mother $mother)
    {
        // Update $user authorization to view $mother here.
        return true;
    }

    public function create(User $user, Mother $mother)
    {
        // Update $user authorization to create $mother here.
        return true;
    }

    public function update(User $user, Mother $mother)
    {
        // Update $user authorization to update $mother here.
        return true;
    }

    public function delete(User $user, Mother $mother)
    {
        // Update $user authorization to delete $mother here.
        return true;
    }
}
