<?php
/**
 * Created by PhpStorm.
 * User: Kenyon Bao
 * Date: 19-3-25
 * Time: 上午3:00
 */

namespace Admin\Controllers;


use Admin\Services\StuffService;
use Illuminate\Http\Request;

class StuffController
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $params = $request->only('username', 'password');
        return StuffService::server()->login($params);
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:stuffs',
            'email' => 'required|string|email|unique:stuffs',
            'password' => 'required|string',
        ]);
        $params = $request->only('username', 'email', 'password');
        return StuffService::server()->register($params);
    }

    public function getStuff()
    {
        return StuffService::server()->getStuff();
    }

    public function logout()
    {
        return StuffService::server()->logout();
    }

}