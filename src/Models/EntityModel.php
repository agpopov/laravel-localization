<?php

namespace agpopov\localization\Models;

use agpopov\localization\Repositories\LanguageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

abstract class EntityModel extends Model
{
    public $rules = [];

    public function __sleep()
    {
        unset($this->rules);
        return parent::__sleep();
    }

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
        $languageId = $this->translation->language_id ?? app(LanguageRepositoryInterface::class)->all()->firstWhere('code', app()->getLocale())->id;
        $this->translation()->updateOrCreate(['language_id' => $languageId], Arr::only($fields, $this->translation()->getModel()->getFillable()));
    }

    public function setRelationships(array $fields): void
    {
    }
}
