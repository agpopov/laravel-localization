<?php

namespace agpopov\localization\Scopes;


use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LocalizedScope implements Scope
{
    /**
     * Получает запись из таблицы переводов на запрошенном языке (или языке по умолчанию)
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $locale = app()->getLocale();
        $defaultLang = Language::getDefault();
        $builder->join($defaultLang->getTable(), $defaultLang->getTable() . '.id', '=', $model->getTable() . '.language_id');
        $builder->where('languages.code', app()->getLocale());

        if ($locale !== $defaultLang->code) {
            $builder->orWhere($defaultLang->getTable() . '.code', $defaultLang->code)->orderBy($defaultLang->getTable() . '.default', 'asc');
        }
    }
}
