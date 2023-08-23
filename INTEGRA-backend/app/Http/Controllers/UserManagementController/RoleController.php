<?php

namespace App\Http\Controllers\UserManagementController;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserManagement\PermissionCollection;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Http\Resources\UserManagement\RoleResource;
use App\Http\Resources\UserManagement\RoleCollection;
use App\Http\Resources\UserManagement\UserCollection;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        return new RoleCollection(Role::all());
    }

    public function store(Request $request){

        if( $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'api'
            ])){

            return response()->json(['message' => 'Role is created']);
        }
    }

    public function show($id){
        return new RoleResource(Role::findOrFail($id));
    }

    public function update($id , Request $request){
        $role = Role::findOrFail($id);

         if ($role->name != $request->name){
            $role->name = $request->name;
            $role->save();
            return response()->json(['message' => 'Role does changed']);
        }

         else
         return response()->json(['message' => 'Role does not changed']);
    }

    public function destroy($id){
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(['message' => 'Role Deleted']);
    }

    public function assignRole($id , Request $request){
        $user = User::find($id);
        $user->assignRole($request->role);
        return response()->json(['message' => $request->role . " is assigned to " . $user->fullName]);
    }

    public function unassignRole($id , Request $request) {
        $user = User::find($id);
        $user->removeRole($request->role);
        return response()->json(['message' => $request->role . " is unassigned to " . $user->fullName]);
    }

    public function attach(Request $request , $id) {

        $role = Role::findOrFail($id);

        foreach ($request->permissions as $permission) {
        $role->givePermissionTo($permission);
        }
        return response()->json(['message' => 'Permissions is assign to ' . $role->name . ' role']);

    }

    public function detach(Request $request , $id) {

        $role = Role::findOrFail($id);

        $role->revokePermissionTo($request->permissions);

        return response()->json(['message' => 'Permissions is unassign to ' . $role->name . ' role']);

    }

    public function showRoleUsers($id){
        $role = Role::findOrFail($id);
        $user = User::role($role)->get();
        return new UserCollection($user);
    }

    public function showRolePermissions($id){
        $role = Role::findOrFail($id);
        $permissions = $role->permissions;
        return new PermissionCollection($permissions);
    }
}
