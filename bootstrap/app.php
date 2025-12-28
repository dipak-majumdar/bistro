<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \App\Providers\MacroServiceProvider::class,
        \Bistro\Banners\BannerServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->encryptCookies(except: [
            'guest_identifier',
        ]);
        
        // CORS configuration
        $middleware->validateCsrfTokens(except: [
            'api/*',
            'sanctum/csrf-cookie',
            'login',
            'logout',
            'register'
        ]);
        
        $middleware->trustProxies(at: '*');
        $middleware->trustHosts(at: ['*']);
        
        // Trust local network headers for IP detection
        $middleware->trustProxies(
            at: ['127.0.0.1', '192.168.0.0/16', '10.0.0.0/8', '172.16.0.0/12'],
            headers: Request::HEADER_X_FORWARDED_FOR |
                    Request::HEADER_X_FORWARDED_HOST |
                    Request::HEADER_X_FORWARDED_PORT |
                    Request::HEADER_X_FORWARDED_PROTO |
                    Request::HEADER_X_FORWARDED_AWS_ELB
        );
        
        // Enable CORS for all routes
        $middleware->web(\Illuminate\Http\Middleware\HandleCors::class);
        $middleware->api(\Illuminate\Http\Middleware\HandleCors::class);
        
        // Add login activity tracking middleware
        $middleware->web(\App\Http\Middleware\LogLoginActivity::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
