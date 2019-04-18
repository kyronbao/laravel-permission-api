<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-3-31
 * Time: 下午11:37
 */

namespace Admin\Models;

use App\Helpers\ArrHelper;
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
        return $stuff->getAllPermissions();
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