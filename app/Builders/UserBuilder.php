<?php

namespace App\Builders;

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

    public function filterByUUid(string $uuid): static
    {
        return $this->where('uuid', $uuid);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<array-key,\App\Models\User>
     */
    public function findByEmail(string $email): \Illuminate\Database\Eloquent\Collection
    {
        return $this->filterByEmail($email)->get();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Collection<array-key,\App\Models\User>
     */
    public function findAdminByEmail(string $email): \Illuminate\Database\Eloquent\Collection
    {
        return $this->filterByAdmin()->filterByEmail($email)->get();
    }
}
