<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-3-25
 * Time: 下午11:15
 */

namespace Admin\Services;


use App\Models\Menu;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionService extends BaseService
{
    public $menu;
    public $role;
    public $permission;

    public function __construct()
    {
        $this->menu = new Menu();
        $this->role = new Role(['guard_name' => 'admin']);
        $this->permission = new Permission(['guard_name' => 'admin']);
    }

    public function postRoles(Request $request)
    {
        return $this->batchSync($this->role, $request->all(), 'name');
    }

    public function batchSync($model, $params, $index)
    {
        $keys = array_keys($params[0]);
        $params_value = Arr::pluck($params, $index);

        $olds = $model->get($keys)->toArray();
        $olds_value = Arr::pluck($olds, $index);

        $delete = [];

        foreach ($olds as $item) {
            if (!in_array($item[$index], $params_value)) {
                array_push($delete, $item);
            }
        }

        $model->whereIn($index, Arr::pluck($delete, $index))->delete();


        foreach ($params as $item) {
            if (in_array($item[$index], $olds_value)) {

                $update_model = $model->where($index, $item[$index])->first();
                foreach ($item as $key => $value) {
                    $update_model->$key = $value;
                }
                $update_model->update();
            } else {
                $model->create($item);
            }
        }

        return $this->outputSuccess([], 'Batch post done');
    }

    public function getRoles()
    {
        return $this->outputSuccess($this->role->get());
    }

    public function postMenus(Request $request)
    {
        return $this->batchSync($this->menu, $request->all(), 'key');
    }

    public function getMenus()
    {
        return $this->outputSuccess($this->menu->get());
    }

    public function postRolesViaUser(Request $request)
    {
        $stuff = Auth::guard('admin')->user();
        $roles = $request->input('roles');

        return $stuff->syncRoles($roles);
    }

    public function postRoutesViaRole(Request $request)
    {
        $role_name = $request->input('role');
        $routes = $request->input('routes');
        $role = Role::findByName($role_name);

        return $role->syncPermissions($routes);
    }

}