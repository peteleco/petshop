<?php

namespace App\Models\Traits;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

trait HasUuid
{
    protected static function bootHasUuid(): void
    {
        static::creating(fn (Model $model) => $model->setAttribute('uuid', (string) Uuid::uuid4()));
    }
}
