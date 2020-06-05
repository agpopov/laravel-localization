<?php

namespace agpopov\localization\Models;


use agpopov\localization\Scopes\LocalizedScope;
use agpopov\localization\Traits\CompositePrimaryModel;
use Illuminate\Database\Eloquent\Model;

abstract class TranslationModel extends Model
{
    use CompositePrimaryModel;

    protected $guarded = [];
    public $timestamps = false;

    public $incrementing = false;

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new LocalizedScope());
    }
}
