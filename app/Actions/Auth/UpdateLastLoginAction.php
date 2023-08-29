<?php

namespace App\Actions\Auth;

use Carbon\Carbon;
use App\Models\User;

class UpdateLastLoginAction
{
    public function execute(User $admin): void
    {
        $admin->setAttribute('last_login_at', Carbon::now());
        $admin->save();
    }
}
