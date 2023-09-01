<?php

namespace App\Builders;

use Carbon\Carbon;

/**
 * @template TModelClass of \App\Models\User
 *
 * @extends FilterBuilder<\App\Models\User>
 */
class UserBuilder extends FilterBuilder
{
    public function filterByFirstName(string $firstName): static
    {
        return $this->where('first_name', 'like', '%' . $firstName . '%');
    }

    public function filterByPhoneNumber(string $phone): static
    {
        return $this->where('phone_number', 'like', '%' . $phone . '%');
    }

    public function filterByAddress(string $address): static
    {
        return $this->where('address', 'like', '%' . $address . '%');
    }

    public function filterByMarketing(bool $marketing): static
    {
        return $this->where('is_marketing', $marketing);
    }

    public function filterByCreatedAt(Carbon $createdAt): static
    {
        return $this->whereBetween('created_at', [
            $createdAt->copy()->startOfDay(),
            $createdAt->copy()->endOfDay(),
        ]);
    }

    public function filterByEmail(string $email): static
    {
        return $this->where('email', 'like', '%' . $email . '%');
    }

    public function findByEmail(string $email): static
    {
        return $this->where('email', $email);
    }

    public function filterByAdmin(): static
    {
        return $this->where('is_admin', true);
    }

    public function filterByNotAdmin(): static
    {
        return $this->where('is_admin', false);
    }

    public function findByUUid(string $uuid): static
    {
        return $this->where('uuid', $uuid);
    }

    public function filterByUUid(string $uuid): static
    {
        return $this->findByUUid($uuid);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<array-key,\App\Models\User>
     */
    public function searchByEmail(string $email): \Illuminate\Database\Eloquent\Collection
    {
        return $this->findByEmail($email)->get();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Collection<array-key,\App\Models\User>
     */
    public function searchAdminByEmail(string $email): \Illuminate\Database\Eloquent\Collection
    {
        return $this->filterByAdmin()->findByEmail($email)->get();
    }
}
