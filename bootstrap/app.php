<?php

use App\Exceptions\ShortUrlCreationException;
use App\Http\Middleware\HSTS;
use App\Http\Middleware\SetLocaleFromHeader;
use Illuminate\Foundation\Application;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function ($middleware) {
        $middleware->web(append: [
            // I18N
            SetLocaleFromHeader::class,
            // HSTS
            HSTS::class,
        ]);
    })

    ->withExceptions(function ($exceptions) {
        $exceptions->render(function (ShortUrlCreationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => $e->getMessage()
                ], 400);
            }

            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput();
        });
    })   ->create();
