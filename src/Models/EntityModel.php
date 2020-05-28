<?php

namespace agpopov\localization\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class EntityModel extends \Illuminate\Database\Eloquent\Model
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
