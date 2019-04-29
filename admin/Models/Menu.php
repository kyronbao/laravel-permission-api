<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-3-31
 * Time: 下午11:37
 */

namespace Admin\Models;

use App\Helpers\ArrHelper;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Menu extends Model
{

    protected $guarded = [];

    public function getMenuRows()
    {
        /** @var Stuff $stuff */
        $stuff = Auth::guard(Stuff::GUARD)->user();
        if ($stuff->hasRole('super-admin')) {
            return $this->get();
        }

        $role = $stuff->roles->pluck('id');

        if (!isset($role[0])) {
            return new \stdClass;
        }

        // 暂时只支持一个用户一个角色
        return Role::findById($role[0])->menus;

    }

    public function getMenuTree()
    {
        $menuRows = $this->getMenuRows()->toArray();

        if (empty($menuRows)) {
            return [];
        }
        return ArrHelper::array2Tree($menuRows);
    }
}