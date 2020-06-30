<?php


namespace agpopov\localization\Repositories;


use agpopov\localization\Models\Language;
use Illuminate\Database\Eloquent\Collection;

interface LanguageRepositoryInterface
{
    public function default(): Language;

    public function all(): Collection;
}
