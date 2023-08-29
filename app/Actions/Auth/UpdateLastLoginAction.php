<?php

namespace App\Actions\Auth;

use App\Models\User;
use Carbon\Carbon;

class UpdateLastLoginAction
{
    public function execute(User $admin): void
    {
        $admin->setAttribute('last_login_at', Carbon::now());
        $admin->save();
    }
}
