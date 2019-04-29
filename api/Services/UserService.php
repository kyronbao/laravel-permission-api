<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-4-14
 * Time: 下午3:50
 */

namespace Api\Services;


use App\Exceptions\Err;
use App\Guards\CustomTokenGuard;
use App\Traits\StaticServer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Cookie;

class UserService
{
    use StaticServer;

    const TOKEN_LENGTH = 60;
    const TOKEN_NAME = 'api_token';
    const TOKEN_EXPIRE = 7 * 24 * 60 * 60;


    public function login()
    {
        /** @var CustomTokenGuard $guard */
        $guard = Auth::guard('api');

        if ($guard->user()) {
            return responseOk($guard->user(), 'Has logged in');
        }

        $api_token = Str::random(self::TOKEN_LENGTH);

        if ($guard->validate()) {
            $model = $guard->user();
            $model->api_token = $api_token;
            $model->save();

            return responseOk($model, 'Login done')
                ->withCookie($this->generateCookie($api_token, self::TOKEN_EXPIRE));
        }

        return responseError(Err::AUTH_UNAUTHORIZED);
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
            return responseError(Err::AUTH_NOT_LOGGED);
        }

        $guard->logout();

        return responseOk([], 'Logout done')
            ->cookie($this->generateCookie('', 0));
    }

}