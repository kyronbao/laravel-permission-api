<?php

namespace App\Exceptions;

class Err
{
    const CODE_OK = 20000;
    const OUTPUT_OK = ['code' => self::CODE_OK];

    const AUTH_LOGGED_IN = ['code' => 10100, 'msg' => 'Has logged in'];
    const AUTH_NOT_LOGGED = ['code' => 10401, 'msg' => 'Not logged'];
    const AUTH_UNAUTHORIZED = ['code' => 11401, 'msg' => 'Unauthorized, username or password error'];
    const AUTH_FORBIDDEN = ['code' => 10403, 'msg' => 'Forbidden'];

    const VALIDATE_CODE = 30100;

    const DATA_NOT_FOUND = ['code' => 30200, 'msg' => 'Data not found'];
}
