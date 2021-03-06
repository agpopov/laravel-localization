<?php


namespace agpopov\localization\Repositories;


use agpopov\localization\Models\Language;
use Illuminate\Database\Eloquent\Collection;

class CachingLanguageRepository implements LanguageRepositoryInterface
{
    protected const ttl = 60 * 60 * 24 * 30;
    protected const tag = 'language';

    protected $repository;
    protected $cache;

    public function __construct(LanguageRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->cache = app('cache.store');
    }

    public function default(): Language
    {
        return $this->cache->tags(static::tag)->remember(static::tag . ":default", static::ttl, function () {
            return $this->repository->default();
        });
    }

    public function all(): Collection
    {
        return $this->cache->tags(static::tag)->remember(static::tag . ":all", static::ttl, function () {
            return $this->repository->all();
        });
    }
}
