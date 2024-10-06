<?php

namespace App\Http\Controllers\admin;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Exception;

class RolePermissionController extends Controller
{
    public function roleIndex(){
        $roles = Role::latest()->paginate(20);
        $permissions = Permission::latest()->where('status',1)->get();
        return view('admin.role-permission.role-index',compact('roles','permissions'));
    }
    public function roleStore(Request $request){
        try{
            $validate = Validator::make($request->all(),[
                'name' => 'required',
            ]);
            if($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }

            $role = new Role();
            $role->name = $request->name;
            $role->permission_ids = json_encode($request->permission_ids);
            $role->status = $request->status;
            $role->save();

            foreach ($request->permission_ids as $permission){
                $permit = new RolePermission();
                $permit->role_id = $role->id;
                $permit->permission_id = $permission;
                $permit->save();
            }
            toastr()->success('Role Create Success.');
            return back();
        }
        catch(Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function roleUpdate(Request $request,$id){
        try{
            $validate = Validator::make($request->all(),[
                'name' => 'required',
            ]);
            if($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $role = Role::find($id);
            $role->name = $request->name;
            $role->permission_ids = json_encode($request->permission_ids);
            $role->status = $request->status;
            $role->save();

            $rolePermissions = RolePermission::where('role_id',$id)->whereNotIn('permission_id',$request->permission_ids)->pluck('id')->toArray();
            RolePermission::destroy($rolePermissions);

            foreach ($request->permission_ids as $permission){
                $permit = RolePermission::where('role_id',$id)->where('permission_id',$permission)->first();
                if (!$permit){
                    $permit = new RolePermission();
                    $permit->role_id = $role->id;
                    $permit->permission_id = $permission;
                    $permit->save();
                }
            }
            toastr()->success('Role Update Success.');
            return back();
        }
        catch(Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function roleDestroy($id){
        try{
            $role = Role::find($id);
            $rolePermissionIds = RolePermission::where('role_id',$role->id)->pluck('id')->toArray();
            RolePermission::destroy($rolePermissionIds);
            $role->delete();
            toastr()->success('Delete Successfully.');
            return back();
        }
        catch(Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function permissionIndex(){
        $permissions = Permission::latest()->get();
        $routeCollections = Route::getRoutes();
        return view('admin.role-permission.permission-index',compact('permissions','routeCollections'));
    }
    public function permissionStore(Request $request){
        try{
            $validate = Validator::make($request->all(),[
                'name' => 'required',
            ]);
            if($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $permission = new Permission();
            $permission->name = $request->name;
            $permission->status = $request->status;
            $permission->save();
            toastr()->success('Rermission Create Success.');
            return back();
        }
        catch(Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function permissionUpdate(Request $request,$id){
        try{
            $validate = Validator::make($request->all(),[
                'name' => 'required',
            ]);
            if($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $permission = Permission::find($id);
            $permission->name = $request->name;
            $permission->status = $request->status;
            $permission->save();
            toastr()->success('permission Update Success.');
            return back();
        }
        catch(Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function permissionDestroy($id){
        try{
            $permission = Permission::find($id);
            $permission->delete();
            toastr()->success('Delete Successfully.');
            return back();
        }
        catch(Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
    public function userRoleIndex(){
        $users = User::latest()->whereNotIn('role',['admin'])->paginate(20);
        $roles = Role::where('status',1)->get();
        return view('admin.role-permission.user-role-permission',compact('users','roles'));
    }
    public function userRoleUpdate(Request $request,$id){

        try {
            $user = User::find($id);
            if ($request->role_id){
                $userRoles = UserRole::where('user_id',$id)->whereNotIn('role_id',$request->role_id)->pluck('id')->toArray();
                UserRole::destroy($userRoles);
                foreach ($request->role_id as $role){
                    $permit = UserRole::where('user_id',$id)->where('role_id',$role)->first();
                    if (!$permit){
                        $permit = new UserRole();
                        $permit->user_id = $user->id;
                        $permit->role_id = $role;
                        $permit->save();
                    }
                }
            }
            toastr()->success('User Role Updated Successfully..');
            return back();
        }
        catch (Exception $exception){
            toastr()->error($exception->getMessage());
            return back();
        }
    }


}
