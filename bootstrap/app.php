<?php

use App\Exceptions\ShortUrlCreationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
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
