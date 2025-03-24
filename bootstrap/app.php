<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\LegalMiddleware;
use App\Http\Middleware\ComplianceMiddleware;
use App\Http\Middleware\TwoFactorMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\PermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // user middleware
        $middleware->alias([
            // 'user'=> UserMiddleware::class,
            // 'admin'=> AdminMiddleware::class,
            // 'legal'=> LegalMiddleware::class,
            // 'compliance'=> ComplianceMiddleware::class,
            'role' => RoleMiddleware::class,
            'two-factor'=> TwoFactorMiddleware::class,
            // 'permission' => PermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
