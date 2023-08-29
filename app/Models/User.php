<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Concerns\HasUuid;
use App\Builders\UserBuilder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string $uuid
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string> $fillable
     * @inheritdoc
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string> $hidden
     * @inheritdoc
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string> $casts
     * @inheritdoc
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
        'is_marketing' => 'boolean',
    ];

    public function getAuthIdentifierName(): string
    {
        return 'uuid';
    }

    /**
     * @return \App\Builders\UserBuilder<\App\Models\User>
     */
    public function newEloquentBuilder(\Illuminate\Contracts\Database\Query\Builder $query): UserBuilder
    {
        return new UserBuilder($query);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\JwtToken>
     */
    public function jwtTokens(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(JwtToken::class, 'user_id', 'id');
    }

    public function isAdmin(): bool
    {
        return $this->getAttribute('is_admin');
    }
}
