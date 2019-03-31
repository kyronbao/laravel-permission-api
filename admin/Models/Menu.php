<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-3-31
 * Time: 下午11:37
 */

namespace Admin\Models;

use App\Helpers\ArrHelper;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;


class Menu extends Permission
{
    const IS_MENU = 1;

    public function getMenuRows()
    {
        /** @var Stuff $stuff */
        $stuff = Auth::guard(Stuff::GUARD)->user();
        if ($stuff->hasRole('super-admin')) {
            return $this->get();
        }
        return $stuff->getAllPermissions();
    }

    public function getMenuTree()
    {
        return ArrHelper::array2Tree($this->getMenuRows()->toArray());
    }
}