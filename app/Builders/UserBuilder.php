<?php

namespace App\Builders;

use Carbon\Carbon;

/**
 * @template TModelClass of \App\Models\User
 * @extends \App\Builders\FilterBuilder<TModelClass>
 */
class UserBuilder extends FilterBuilder
{
    /**
     * @return \App\Builders\UserBuilder<TModelClass>
     */
    public function filterByFirstName(string $firstName): self
    {
        $this->where('first_name', 'like', '%' . $firstName . '%');

        return $this;
    }

    /**
     * @return \App\Builders\UserBuilder<TModelClass>
     */
    public function filterByPhoneNumber(string $phone): self
    {
        $this->where('phone_number', 'like', '%' . $phone . '%');

        return $this;
    }

    /**
     * @return \App\Builders\UserBuilder<TModelClass>
     */
    public function filterByAddress(string $address): self
    {
        $this->where('address', 'like', '%' . $address . '%');

        return $this;
    }

    /**
     * @return \App\Builders\UserBuilder<TModelClass>
     */
    public function filterByMarketing(bool $marketing): self
    {
        return $this->where('is_marketing', $marketing);
    }

    /**
     * @param \Carbon\Carbon $createdAt
     *
     * @return \App\Builders\UserBuilder<TModelClass>
     */
    public function filterByCreatedAt(Carbon $createdAt): self
    {
        $this->whereBetween('created_at', [
            $createdAt->copy()->startOfDay(),
            $createdAt->copy()->endOfDay(),
        ]);

        return $this;
    }

    /**
     * @return \App\Builders\UserBuilder<TModelClass>
     */
    public function filterByEmail(string $email): self
    {
        $this->where('email', 'like', '%' . $email . '%');

        return $this;
    }

    /**
     * @return \App\Builders\UserBuilder<TModelClass>
     */
    public function findByEmail(string $email): self
    {
        $this->where('email', $email);

        return $this;
    }

    /**
     * @return \App\Builders\UserBuilder<TModelClass>
     */
    public function filterByAdmin(): self
    {
        $this->where('is_admin', true);

        return $this;
    }

    /**
     * @return \App\Builders\UserBuilder<TModelClass>
     */
    public function filterByNotAdmin(): self
    {
        $this->where('is_admin', false);

        return $this;
    }

    /**
     * @return \App\Builders\UserBuilder<TModelClass>
     */
    public function findByUUid(string $uuid): self
    {
        $this->where('uuid', $uuid);

        return $this;
    }

    /**
     * @return \App\Builders\UserBuilder<TModelClass>
     */
    public function filterByUUid(string $uuid): self
    {
        return $this->findByUUid($uuid);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<array-key,TModelClass>
     */
    public function searchByEmail(string $email): \Illuminate\Database\Eloquent\Collection
    {
        return $this->findByEmail($email)->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<array-key,TModelClass>
     */
    public function searchAdminByEmail(string $email): \Illuminate\Database\Eloquent\Collection
    {
        return $this->filterByAdmin()->findByEmail($email)->get();
    }
}
