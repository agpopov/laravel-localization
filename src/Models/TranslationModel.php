<?php


namespace agpopov\localization\Models;


use agpopov\localization\Scopes\LocalizedScope;
use Illuminate\Database\Eloquent\Builder;

abstract class TranslationModel extends \Illuminate\Database\Eloquent\Model
{
    protected $guarded = [];
    public $timestamps = false;

    public $incrementing = false;

    protected static function boot() : void
    {
        parent::boot();
        static::addGlobalScope(new LocalizedScope());
    }

    /**
     * Set the keys for a save update query.
     *
     * @param  Builder  $query
     * @return Builder
     */
    protected function setKeysForSaveQuery(Builder $query) : Builder
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param string $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery(string $keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}