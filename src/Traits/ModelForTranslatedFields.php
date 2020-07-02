<?php


namespace agpopov\localization\Traits;


use agpopov\localization\Scopes\TranslatedFieldsScope;

trait ModelForTranslatedFields
{
    use CompositePrimaryModel;

    public static function bootModelForTranslatedFields(): void
    {
        static::addGlobalScope(new TranslatedFieldsScope);
    }

    public function initializeModelForTranslatedFields(): void
    {
        $this->timestamps = false;
        $this->incrementing = false;
        $this->guarded = [];
    }
}
