<?php

namespace agpopov\localization\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Validator;

abstract class EntityModel extends Model
{
    public $rules = [];

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
        $this->translation()->updateOrCreate([], Arr::only($fields, $this->translation()->getModel()->getFillable()));
    }

    public function setRelationships(array $fields)
    {
    }

    public static function store(array $fields)
    {
        $fields = Validator::make($fields, (new static())->rules['store'])->validate();

        return DB::transaction(function () use ($fields) {
            $model = new static();
            $model->setRawAttributes(Arr::only($fields, $model->getFillable()), true);
            $model->save();
            $model->setTranslation($fields);
            $model->setRelationships($fields);
            return $model;
        });
    }

    public static function change($id, array $fields)
    {
        $fields = Validator::make($fields, (new static())->rules['update'])->validate();

        return DB::transaction(function () use ($id, $fields) {
            $model = static::whereKey($id)->without('translation')->firstOrFail();
            $model->update(Arr::only($fields, $model->getFillable()));
            $model->setTranslation($fields);
            $model->setRelationships($fields);
            return $model;
        });
    }

    public static function destroy($id)
    {
        return static::whereKey($id)->without(['translation'])->firstOrFail()->delete();
    }
}
