<?php

namespace agpopov\localization\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

abstract class EntityModel extends Model
{
    public $rules = [];

    public function __construct(array $attributes = [])
    {
        $this->with = array_merge((array)$this->with, ['translation']);
        parent::__construct($attributes);
    }

    public static function page(array $page, array $with = [])
    {
        $request = app('request');
        $query = static::query();
        if (count($with)) {
            $query = $query->with($with);
        }
        return $query->paginate($page['size'], ['*'], 'page[number]', $page['number'])
            ->withPath($request->fullUrlWithQuery($request->except('page.number')));
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
