<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JwtToken extends Model
{
    use HasFactory;

    /**
     * @var array<string, string> $casts
     * @inheritdoc
     */
    protected $casts = [
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
        'refreshed_at' => 'datetime',
    ];
}
