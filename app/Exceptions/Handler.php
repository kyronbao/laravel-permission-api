<?php

namespace App\Exceptions;

use App\Exceptions\Auth\AuthAdminRouteException;
use App\Helpers\Env;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $e = $this->prepareException($e);

        if ($e instanceof ValidationException) {
            return responseError(['code' => Err::VALIDATE_CODE, 'msg' => $e->errors()]);
        } elseif ($e instanceof AuthenticationException) {
            return responseError(Err::AUTH_NOT_LOGGED);
        } elseif ($e instanceof AuthAdminRouteException) {
            return responseError(Err::AUTH_FORBIDDEN);
        }

        if ($e instanceof NotFoundHttpException) {
            if (config('app.env') === Env::PROD) {
                return responseError(Err::DATA_NOT_FOUND);
            }
            return responseError(['code' => Err::DATA_NOT_FOUND['code'],
                'msg' => $e->getMessage() ?: [NotFoundHttpException::class, $e->getFile()]]);
        }

        return $this->prepareJsonResponse($request, $e);
    }
}
