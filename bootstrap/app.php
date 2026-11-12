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
        $isDbConnectionDown = static function (\Throwable $e): bool {
            $needles = [
                'Connection refused',
                'No connection could be made',
                'target machine actively refused it',
                'Server gone away',
                'MySQL server has gone away',
                'Connection timed out',
                'php_network_getaddresses',
                'Unknown database',
                'SQLSTATE[HY000] [2002]',
                'SQLSTATE[HY000] [2003]',
                'SQLSTATE[HY000] [2006]',
                'SQLSTATE[HY000] [1049]',
            ];

            for ($current = $e; $current !== null; $current = $current->getPrevious()) {
                if (! $current instanceof \PDOException) {
                    continue;
                }

                $code = (string) $current->getCode();
                if (in_array($code, ['2002', '2003', '2006', '1049'], true)) {
                    return true;
                }

                $message = $current->getMessage();
                foreach ($needles as $needle) {
                    if (str_contains($message, $needle)) {
                        return true;
                    }
                }
            }

            return false;
        };

        $exceptions->render(function (\Throwable $e, $request) use ($isDbConnectionDown) {
            if (! $isDbConnectionDown($e)) {
                return null;
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Dapur Toon Burger sedang gangguan teknis. Silakan coba beberapa saat lagi.',
                ], 500);
            }

            return response()->view('errors.500', [], 500);
        });
    })->create();
