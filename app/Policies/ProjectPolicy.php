<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function user_operator(User $user)
    {
        return true;
        // $boolean = true;
        // dd($users);
        // foreach ($users as $user) {
        //     if ($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 4 || $user->role_id == 5) {
        //         $boolean = false;
        //     } else if ($user->role_id == 3) {
        //         $boolean = true;
        //     }
        // }
        // if ($boolean) {
        //     return true;
        // } else {
        //     return false;
        // }
    }
}
