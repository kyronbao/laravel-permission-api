<?php

namespace App\Exceptions;

use App\Exceptions\Auth\AuthAdminRouteException;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

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
        if ($e instanceof ValidationException) {
            return response(['code' => Err::VALIDATE_CODE, 'msg' => $e->errors()]);
        } elseif ($e instanceof AuthenticationException) {
            return response(Err::AUTH_NOT_LOGGED);
        } elseif ($e instanceof AuthAdminRouteException) {
            return response(Err::AUTH_FORBIDDEN);
        }

        return $e;
    }
}
