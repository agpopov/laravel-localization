<?php

namespace agpopov\localization\Models;

use Illuminate\Database\Eloquent\Model;

abstract class EntityModel extends Model
{
    public function __construct(array $attributes = [])
    {
        $this->with = array_merge((array)$this->with, ['translation']);
        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    abstract public function translation();
}
