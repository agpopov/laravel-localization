<?php

namespace agpopov\localization\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * gpopov\localization\Models\Language
 *
 * @property int $id
 * @property string $code
 * @property bool $default
 * @method static Builder|Language newModelQuery()
 * @method static Builder|Language newQuery()
 * @method static Builder|Language query()
 * @method static Builder|Language whereCode($value)
 * @method static Builder|Language whereDefault($value)
 * @method static Builder|Language whereId($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
    protected $casts = [
        'default' => 'boolean'
    ];

    public static function getDefault() : Language
    {
        static $default;

        if(!isset($default)) {
            $default = Language::whereDefault(true)->first();
        }

        return $default;
    }
}
