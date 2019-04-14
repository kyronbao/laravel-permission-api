<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-3-29
 * Time: 上午2:17
 */

namespace App\Guards;


use App\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomTokenGuard implements Guard
{
    protected $request;
    protected $provider;
    protected $user;

    /**
     * Create a new authentication guard.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider $provider
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(UserProvider $provider, Request $request)
    {
        $this->request = $request;
        $this->provider = $provider;
        $this->user = NULL;
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return !is_null($this->user());
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        /** If validated user or else, return directly **/
        if (!is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $api_token = $this->request->cookie('api_token');

        if (isset($api_token) && !empty($api_token)) {
            $user = User::where(['api_token' => $api_token])->first();
        }

        return $this->user = $user;

    }


    /**
     * Get the ID for the currently authenticated user.
     *
     * @return string|null
     */
    public function id()
    {
        if ($user = $this->user()) {
            return $this->user()->getAuthIdentifier();
        }
    }

    /**
     * Validate a user's credentials.
     *
     * @return bool
     */
    public function validate(Array $credentials = [])
    {

        $username = $this->request->input('username');
        $password = $this->request->input('password');

        $user = User::where(['username' => $username])->first();
        if (is_null($user)) {
            return false;
        }

        $checked = Hash::check($password, $user->password);

        if (!is_null($user) && $checked) {
            $this->setUser($user);

            return true;
        }

        return false;

    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @return void
     */
    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }

    public function logout()
    {
        $user = $this->user;
        $user->api_token = '';
        $user->save();
        $this->user = null;
    }


}