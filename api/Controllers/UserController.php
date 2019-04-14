<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-4-14
 * Time: 下午4:00
 */

namespace Api\Controllers;

use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

class UserController
{

    public function getUser()
    {
        $user = Auth::guard('api')->user();
        return BaseService::server()->outputSuccess($user);
    }
}