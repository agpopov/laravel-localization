<?php


namespace agpopov\localization\Repositories;


use agpopov\localization\Models\Language;
use Illuminate\Database\Eloquent\Collection;

class LanguageRepository implements LanguageRepositoryInterface
{
    protected $model;

    public function __construct(Language $model)
    {
        $this->model = $model;
    }

    public function default(): Language
    {
        return $this->model->default()->firstOrFail();
    }

    public function all(): Collection
    {
        return $this->model->get();
    }
}
