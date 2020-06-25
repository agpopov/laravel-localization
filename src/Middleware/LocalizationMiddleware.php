<?php

namespace agpopov\localization\Middleware;

use agpopov\localization\Models\Language;
use agpopov\localization\Repositories\CachingLanguageRepository;
use agpopov\localization\Repositories\LanguageRepository;
use Closure;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $repository = new CachingLanguageRepository(new LanguageRepository(new Language()));
        $local = $request->hasHeader('x-localization') ? $request->header('x-localization') : $repository->default()->code;
        app()->setLocale($local);
        return $next($request);
    }
}
