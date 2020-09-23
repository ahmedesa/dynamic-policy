<?php

namespace App\Policies;

use Illuminate\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class BasePolicy
{
    use HandlesAuthorization;

    protected $type;

    public function before($current_user)
    {
        if ($current_user->hasRole('super-admin')) {
            return true;
        }
    }

    /**
     * Handle all requested permission
     * @param $permission [ is the method name that refers permission [update , delete , etc ....] ]
     * @param $arguments  [first argument is always the current registered user other arguments is set in policy call]
     * @return boolean
     */

    public function __call($permission, $arguments)
    {
        $permission = Str::snake($permission, '-');

        $current_user = $arguments[0];

        if (!isset($arguments[1])) {
            return $current_user->can($this->type . '.' . $permission);
        }

        $model = $arguments[1];

        return $this->checkPermission($current_user, $model, $permission);
    }

    /**
     * implemented in child policy
     * @param $current_user
     * @param $model
     * @param $permission
     * @return mixed
     */
    abstract public function checkPermission($current_user, $model, $permission);
}
