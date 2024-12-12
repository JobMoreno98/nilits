<?php

namespace App\Policies;

use App\Models\ususario;
use Illuminate\Auth\Access\HandlesAuthorization;

class TutoresPolicy
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
}
