<?php


namespace agpopov\localization\Repositories;


use agpopov\localization\Models\Language;

class LanguageRepository implements LanguageRepositoryInterface
{
    protected $model;

    public function __construct(Language $model)
    {
        $this->model = $model;
    }

    public function default()
    {
        return $this->model->default()->firstOrFail();
    }
}
