<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Bootstrap the HasUuid trait for a model.
     */
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string)Str::uuid();
            }
        });
    }

    /**
     * The "booted" method of the model (Laravel 11+ safe).
     */
    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string)Str::uuid();
            }
        });
    }

    /**
     * The model does not have an incrementing ID.
     */
    public $incrementing = false;

    /**
     * The model's primary key type.
     */
    protected $keyType = 'string';
}
