<?php

namespace App\APP_NAME\Traits;

use App\APP_NAME\Table\Classes\Users;

trait AdminSupport
{
     public function cozyUser(string $user, string $request)
    {
        return $this->userInfo($user, $request);
    }
}