<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
        $middleware->redirectGuestsTo(function () {
            session()->flash('warning', 'Wajib login terlebih dahulu.');
            return route('login');
        });
        $middleware->web(append: [
            \App\Http\Middleware\PreventBackHistory::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'logout',
            'logout/*',
        ]);
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'prevent-back-history' => \App\Http\Middleware\PreventBackHistory::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\PDOException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Dapur Toon Burger sedang beres-beres. Silakan coba beberapa saat lagi.',
                ], 500);
            }
            return response()->view('errors.500', [
                'message' => 'Sepertinya ada saus keju yang tumpah di ruang mesin dapur kami. Tim chef Toon Burger sedang beres-beres, yuk coba beberapa saat lagi!',
            ], 500);
        });

        $exceptions->render(function (\Illuminate\Database\QueryException $e, $request) {
            if (str_contains($e->getMessage(), 'Connection refused') || str_contains($e->getMessage(), '2002') || str_contains($e->getMessage(), 'Server gone away') || str_contains($e->getMessage(), 'target machine actively refused it')) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Dapur Toon Burger sedang beres-beres. Silakan coba beberapa saat lagi.',
                    ], 500);
                }
                return response()->view('errors.500', [
                    'message' => 'Sepertinya ada saus keju yang tumpah di ruang mesin dapur kami. Tim chef Toon Burger sedang beres-beres, yuk coba beberapa saat lagi!',
                ], 500);
            }
        });
    })->create();
