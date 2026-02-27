<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HSTS
{
    /**
     * Handle an incoming request.
     *
     * This method ensures that the application enforces HTTP Strict Transport Security (HSTS)
     * in production environments for secure requests. If the application environment is set to
     * 'production' and the request is conducted over HTTPS, the response headers will include
     * the `Strict-Transport-Security` directive with a max-age of 1 year, along with subdomain
     * and preload policies.
     *
     * @param Request $request Incoming HTTP request instance.
     * @param Closure $next The next middleware to be executed.
     * @return Response        The processed HTTP response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (app()->environment('production') && $request->secure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload'
            );
        }

        return $response;
    }
}
