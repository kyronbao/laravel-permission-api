<?php

use App\Exceptions\Err;

if (!function_exists('responseOk')) {

    /**
     * Return a new successful response from the application.
     *
     * @param  array|null $data
     * @param  string $msg
     * @param  int $status
     * @param  array $headers
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    function responseOk($data = [], $msg = 'ok', $status = 200, array $headers = [])
    {
        return response([
            'code' => Err::CODE_OK,
            'msg' => $msg,
            'data' => $data,
        ], $status, $headers);
    }
}


if (!function_exists('responseError')) {

    /**
     * Return a new logic error response from the application.
     *
     * @param  array|null $error
     * @param  int $status
     * @param  array $headers
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    function responseError(
        $error = ['code' => 11000, 'msg' => 'Logic error'],
        $status = 200,
        array $headers = []
    )
    {
        return response($error, $status, $headers);
    }
}

