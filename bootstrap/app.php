<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 🔴 Error de validación
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Los datos proporcionados no son válidos.',
                    'errors' => $e->errors(),
                ], 422);
            }
        });

        // 🔴 Ruta no encontrada
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recurso no encontrado',
                    'errors' => app()->isProduction() ? null : $e->getMessage(),
                ], 404);
            }
        });

        // 🔴 Modelo Eloquent no encontrado
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recurso no encontrado',
                    'errors' => app()->isProduction() ? null : [
                        'model' => $e->getModel(),
                        'id' => $e->getIds(),
                    ]
                ], 404);
            }
        });

        // 🔴 Usuario no autenticado
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No autorizado',
                    'errors' => app()->isProduction() ? null : $e->getMessage(),
                ], Response::HTTP_UNAUTHORIZED);
            }
        });

        // 🔴 Usuario autenticado pero no autorizado
        $exceptions->render(function (AuthorizationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permiso para realizar esta acción',
                    'errors' => app()->isProduction() ? null : $e->getMessage(),
                ], Response::HTTP_FORBIDDEN);
            }
        });

        // 🔴 Excepciones HTTP (403, 404, 500, etc.)
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($request->is('api/*')) {
                if ($e->getMessage() === 'This action is unauthorized.') {
                    return response()->json([
                        'success' => false,
                        'message' => 'No tienes permiso para realizar esta acción',
                        'errors' => [
                            'code' => 403,
                            'detail' => app()->isProduction() ? null : $e->getMessage(),
                        ],
                    ], Response::HTTP_FORBIDDEN);
                }
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?: 'Error del servidor',
                    'errors' => app()->isProduction() ? null : [
                        'code' => $e->getStatusCode()
                    ]
                ], $e->getStatusCode());
            }
        });

        // 🔴 Cualquier otra excepción no controlada
        $exceptions->render(function (\Exception $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => app()->isProduction() ? 'Error interno del servidor' : $e->getMessage(),
                    'errors' => app()->isProduction() ? null : ['trace' => $e->getTrace()],
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    })->create();
