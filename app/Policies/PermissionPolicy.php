<?php

namespace App\Policies;

use App\Models\ususario;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
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
        return auth()->user()->can('Permisos#ver')
            ? Response::allow()
            : Response::deny(__("You don't can view this page"));
    }
}
