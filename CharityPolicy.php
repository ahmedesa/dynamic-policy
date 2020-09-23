<?php

namespace App\Policies;

class CharityPolicy extends BasePolicy
{
    protected $type = 'charities';

    public function checkPermission($current_user, $charity, $permission)
    {
        return $current_user->hasCharity($charity->id)
               && $current_user->can($this->type . '.' . $permission);
    }
}
