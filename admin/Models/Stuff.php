<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-3-25
 * Time: 下午11:37
 */

namespace Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Stuff extends Authenticatable
{

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'admin_token'
    ];
}