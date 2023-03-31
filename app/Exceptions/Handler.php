<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Validation\ValidationException;
use App\Traits\ApiResponse;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        return $this->handleException($request, $e);
    }

    public function handleException($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        if ($e instanceof ModelNotFoundException) {
            $model = class_basename($e->getModel());
            return $this->errorResponse("No existe ninguna instancia {$model} con el id especificado", 404);
        }

        if ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }

        if ($e instanceof AuthorizationException) {
            return $this->errorResponse('No posee permisos para ejecutar esta accion', 403);
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->errorResponse('No se encontro la URL especifcada', 404);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse("El metodo especificado en la peticion no es valido", 405);
        }

        if ($e instanceof HttpException) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        if ($e instanceof QueryException) {
            $codigo = $e->errorInfo[1];
            if ($codigo === 1451) {
                return $this->errorResponse('No se puede eliminar de forma permanente el recurso porque esta relacionado con alun otro.', 409);
            }
        }

        if ($e instanceof TokenMismatchException) {
            return redirect()->back()->withInput($request->input());
        }

        if (config('app.debug')) {
            return parent::render($request, $e);
        }

        return $this->errorResponse('Falla inesperada intente luego', 500);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        return $this->errorResponse($errors, 422);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($this->isFrontend($request)) {
            return redirect()->guest('login');
        }
        return $this->errorResponse('No autenticado.', 401);
    }

    private function isFrontend($request): bool
    {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}
