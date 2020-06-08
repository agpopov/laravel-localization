<?php

namespace agpopov\localization\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * agpopov\localization\Models\Language
 *
 * @property int $id
 * @property string $code
 * @property string $language
 * @property bool $default
 * @method static Builder|Language newModelQuery()
 * @method static Builder|Language newQuery()
 * @method static Builder|Language query()
 * @method static Builder|Language whereLanguage($value)
 * @method static Builder|Language whereDefault($value)
 * @method static Builder|Language whereId($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
    protected $casts = [
        'default' => 'boolean'
    ];
    public $timestamps = false;

    public function scopeDefault(Builder $query): Builder
    {
        return $query->whereDefault(true)->limit(1);
    }

    public static function getDefault(): Language
    {
        static $default;

        if (! isset($default)) {
            $default = Language::default()->firstOrFail();
        }

        return $default;
    }
}
