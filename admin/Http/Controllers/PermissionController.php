<?php
/**
 * Created by PhpStorm.
 * User: Kenyon Bao
 * Date: 19-3-25
 * Time: 上午3:00
 */

namespace Admin\Http\Controllers;


use Admin\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController
{
    public function postRoles(Request $request)
    {
        return PermissionService::server()->postRoles($request);
    }

    public function getRoles()
    {
        return PermissionService::server()->getRoles();
    }

    public function postRoutes(Request $request)
    {
        return PermissionService::server()->postRoutes($request);
    }

    public function getMenus()
    {
        return PermissionService::server()->getMenus();
    }

    public function postRolesViaUser(Request $request)
    {
        return PermissionService::server()->postRolesViaUser($request);
    }

    public function postRoutesViaRole(Request $request)
    {
        return PermissionService::server()->postRoutesViaRole($request);
    }

}