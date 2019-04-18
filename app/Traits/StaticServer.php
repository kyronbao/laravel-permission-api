<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-4-18
 * Time: 下午11:11
 */

namespace App\Traits;


Trait StaticServer
{

    public static $_classServer;

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