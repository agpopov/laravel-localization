<?php

namespace agpopov\localization\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

abstract class EntityModel extends Model
{
    public function __construct(array $attributes = [])
    {
        $this->with = array_merge((array)$this->with, ['translation']);
        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    abstract public function translation();

    public function setTranslation(array $fields)
    {
        $fields = Arr::only($fields, $this->translation()->getModel()->getFillable());
        $this->translation()->updateOrCreate([], array_merge($fields, [
            'language_id' => Language::whereCode(app()->getLocale())->firstOrFail(['id'])->id
        ]));
    }
}
