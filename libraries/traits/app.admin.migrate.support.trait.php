<?php

namespace Traits;

use Table\Classes\Users;

trait AdminSupport
{
     public function cozyUser(string $user, string $request)
    {
        return $this->userInfo($user, $request);
    }
}