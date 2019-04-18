<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-3-25
 * Time: 下午11:05
 */

namespace App\Services;


class BaseService
{

    protected static $_classServer;

    /**
     * return static server
     *
     * @return static
     */
    public static function server()
    {
        $params = func_get_args();
        if ($params) {
            return new static(...$params);
        }

        return new static();
    }


}