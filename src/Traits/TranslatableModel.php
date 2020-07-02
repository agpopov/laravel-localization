<?php


namespace agpopov\localization\Traits;


use agpopov\localization\Repositories\LanguageRepositoryInterface;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Arr;

trait TranslatableModel
{
    public function initializeTranslatableModel(): void
    {
        $this->with[] = 'translation';
    }

    public function setTranslation(array $fields): void
    {
        $languageId = $this->translation->language_id ?? app(LanguageRepositoryInterface::class)->all()->firstWhere('code', app()->getLocale())->id;
        $this->translation()->updateOrCreate(['language_id' => $languageId], Arr::only($fields, $this->translation()->getModel()->getFillable()));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    abstract public function translation(): HasOne;
}
