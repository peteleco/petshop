<?php

namespace App\Actions\Admin;

use App\Models\User;
use App\Dtos\Admin\CreateData;

class CreateAction
{
    public function execute(User $user, CreateData $data): void
    {
        $user->fillFromData($data);
        $user->save();
    }
}
