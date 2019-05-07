<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-4-19
 * Time: 上午5:50
 */

namespace App\Models;


use Admin\Models\Menu;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends \Spatie\Permission\Models\Role
{

    protected $fillable = ['name', 'name_cn', 'guard_name'];


    public function syncMenus($current_menus)
    {
        return $this->menus()->sync($current_menus);
    }

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(
            Menu::class,
            'role_has_menus',
            'role_id',
            'menu_id'
        );
    }

    public function getMenusViaRole()
    {
        if ($this->isSuperAdmin()) {
            return Menu::get();
        }
        return $this->menus()->get();
    }

    public function isSuperAdmin()
    {
        return $this->name === 'super-admin';
    }
}