<?php

use App\Classes\ApiResponseClass;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (NotFoundHttpException $exception){
            return ApiResponseClass::errorResponse('NotFoundHttpException',$exception->getMessage(),404);
        });

        $exceptions->render(function (MethodNotAllowedHttpException $exception){
            return ApiResponseClass::errorResponse('MethodNotAllowedHttpException',$exception->getMessage(),405);
        });


    })->create();
