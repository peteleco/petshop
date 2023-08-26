<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

trait HasUuid
{
    protected static function bootHasUuid(): void
    {
        static::creating(fn (Model $model) => $model->setAttribute('uuid', (string) Uuid::uuid4()));
    }
}
