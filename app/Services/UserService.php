<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-4-14
 * Time: 下午3:50
 */

namespace App\Services;


use App\Exceptions\Err;
use App\Guards\CustomTokenGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Cookie;

class UserService extends BaseService
{

    const TOKEN_LENGTH = 60;
    const TOKEN_NAME = 'api_token';
    const TOKEN_EXPIRE = 7 * 24 * 60 * 60;


    public function login()
    {
        /** @var CustomTokenGuard $guard */
        $guard = Auth::guard('api');

        if ($guard->user()) {
            return $this->outputError(Err::AUTH_LOGGED_IN);
        }

        $api_token = Str::random(self::TOKEN_LENGTH);

        if ($guard->validate()) {
            $model = $guard->user();
            $model->api_token = $api_token;
            $model->save();

            return $this->outputSuccess($model, 'Login done')
                ->withCookie($this->generateCookie($api_token, self::TOKEN_EXPIRE));
        }

        return $this->outputError(Err::AUTH_UNAUTHORIZED);
    }

    private function generateCookie($cookie_value, $expire)
    {
        return new Cookie(self::TOKEN_NAME, $cookie_value, time() + $expire);
    }

    public function logout()
    {
        /** @var CustomTokenGuard $guard */
        $guard = Auth::guard('api');

        if ($guard->guest()) {
            return $this->outputError(Err::AUTH_NOT_LOGGED);
        }

        $guard->logout();

        return $this->outputSuccess([], 'Logout done')
            ->cookie($this->generateCookie('', 0));
    }

}