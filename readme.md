# Laravel Localization

[![Total Downloads](https://poser.pugx.org/agpopov/laravel-localization/d/total.svg)](https://packagist.org/packages/agpopov/laravel-localization)
[![Latest Stable Version](https://poser.pugx.org/agpopov/laravel-localization/v/stable.svg)](https://packagist.org/packages/agpopov/laravel-localization)
[![Latest Unstable Version](https://poser.pugx.org/agpopov/laravel-localization/v/unstable.svg)](https://packagist.org/packages/agpopov/laravel-localization)
[![License](https://poser.pugx.org/agpopov/laravel-localization/license.svg)](https://packagist.org/packages/agpopov/laravel-localization)

## Установка

```sh
composer require agpopov/laravel-localization
```

Для Lumen нужно зарегистрировать провайдер в bootstrap/app.php

```php
$app->register(\agpopov\localization\LocalizationServiceProvider::class);
```

## Описание

Модуль добавляет таблицу для храниения списка доступных языков и указанием на используемый язык по умолчанию. Также присутствуют два абстрактных класса, унаслежлванных от Illuminate\Database\Eloquent\Model. 

Класс EntityModel содержит абстрактный метод translation, в котором нужно задать связь с таблицей переводов, например
```php
return $this->hasOne(Translations\Product::class);
```

Класс TranslationModel содержит scope для получения нужного перевода. Таблица переводов, к которой относится наследуемая модель, должна иметь поле UNSIGNED TINYINT language_id с привязкой к таблице языков. Также для наследуемой модели необходимо указать составной primary key.
