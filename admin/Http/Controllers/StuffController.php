<?php
/**
 * Created by PhpStorm.
 * User: Kenyon Bao
 * Date: 19-3-25
 * Time: 上午3:00
 */

namespace Admin\Http\Controllers;


use Admin\Services\StuffService;
use Illuminate\Http\Request;

class StuffController
{
    public function login(Request $request)
    {
        $params = $request->only('username', 'password');
        return StuffService::server()->login($params);
    }

    public function getStuff(Request $request)
    {

        return StuffService::server()->getStuff($request);
    }

}