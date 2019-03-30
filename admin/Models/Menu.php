<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-3-31
 * Time: 下午11:37
 */

namespace Admin\Models;

use Spatie\Permission\Models\Permission;


class Menu extends Permission
{
    const IS_MENU = 1;

    public function getMenuRows()
    {
        return static::where('is_menu', self::IS_MENU)->get();
    }
}