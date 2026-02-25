<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocaleFromHeader
{
    public function handle(Request $request, Closure $next)
    {
        $supportedLocales = ['en', 'de'];

        $locale = $request->getPreferredLanguage($supportedLocales);

        App::setLocale($locale ?? config('app.fallback_locale'));

        return $next($request);
    }
}
