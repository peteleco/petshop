<?php

namespace App\Builders;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of \App\Models\User
 *
 * @extends Builder<\App\Models\User>
 */
class UserBuilder extends Builder
{
    public function filterByEmail(string $email): static
    {
        return $this->where('email', $email);
    }

    public function filterByAdmin(): static
    {
        return $this->where('is_admin', true);
    }

    public function findByEmail(string $email): User|null
    {
        return $this->filterByEmail($email)->get()->first();
    }
    public function findAdminByEmail(string $email): User|null
    {
        return $this->filterByAdmin()->filterByEmail($email)->get()->first();
    }
}