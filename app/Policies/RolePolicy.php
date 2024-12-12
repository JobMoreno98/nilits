<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Role;

class RolePolicy
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
    public function view($user): Response
    {
        if ($user === null) {
            return  Response::deny(__("You don't can view this page"));
        }
        return auth()->user()->can('Roles#ver')
            ? Response::allow()
            : Response::deny(__("You don't can view this page"));
    }

    public function update($user): Response
    {
        if ($user === null) {
            return  Response::deny(__("You don't can view this page"));
        }
        return auth()->user()->can('Roles#update')
            ? Response::allow()
            : Response::deny(__("You don't can view this page"));
    }
}
