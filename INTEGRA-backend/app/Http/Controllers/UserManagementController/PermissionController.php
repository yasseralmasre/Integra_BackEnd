<?php

namespace App\Http\Controllers\UserManagementController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\UserManagement\PermissionResource;
use App\Http\Resources\UserManagement\PermissionCollection;
use App\Http\Resources\UserManagement\RoleCollection;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PermissionCollection(Permission::all());
    }

    public function showPermissionRoles($id)
    {
        $permission = Permission::findOrFail($id);
        $roles = $permission->roles;

        return new RoleCollection($roles);

    }

}
