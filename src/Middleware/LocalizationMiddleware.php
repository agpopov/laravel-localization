<?php

namespace agpopov\localization\Middleware;

use App\Models\Language;
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
        $local = $request->hasHeader('x-localization') ? $request->header('x-localization') : Language::getDefault()->code;
        app()->setLocale($local);
        return $next($request);
    }
}
