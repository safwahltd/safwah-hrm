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
        if(auth()->user()->hasPermission('admin role index')){
            $roles = Role::latest()->paginate(20);
            $permissionsGroup = Permission::where('status',1)->orderBy('name','asc')->get()
                ->groupBy(function ($permission) {
                    if (str_contains($permission->name, 'salary')) {
                        return 'Salary';
                    } elseif (str_contains($permission->name, 'asset')) {
                        return 'Asset';
                    } elseif (str_contains($permission->name, 'designation')) {
                        return 'Designation';
                    } elseif (str_contains($permission->name, 'department')) {
                        return 'Department';
                    } elseif (str_contains($permission->name, 'holiday')) {
                        return 'Holiday';
                    } elseif (str_contains($permission->name, 'attendance')) {
                        return 'Attendance';
                    } elseif (str_contains($permission->name, 'leave')) {
                        return 'Leave';
                    } elseif (str_contains($permission->name, 'termination')) {
                        return 'Termination';
                    } elseif (str_contains($permission->name, 'role')) {
                        return 'Role';
                    } elseif (str_contains($permission->name, 'permission')) {
                        return 'Permission';
                    } elseif (str_contains($permission->name, 'setting')) {
                        return 'Settings';
                    } elseif (str_contains($permission->name, 'notice')) {
                        return 'Notice';
                    } elseif (str_contains($permission->name, 'report')) {
                        return 'Report';
                    } elseif (str_contains($permission->name, 'expense')) {
                        return 'Expense';
                    } elseif (str_contains($permission->name, 'advance money')) {
                        return 'Advance Money';
                    } elseif (str_contains($permission->name, 'password')) {
                        return 'Password Update';
                    } elseif (str_contains($permission->name, 'email')) {
                        return 'Email Update';
                    } elseif (str_contains($permission->name, 'workingday')) {
                        return 'Working Day Management';
                    } elseif (str_contains($permission->name, 'policy')) {
                        return 'Policy Management';
                    }  elseif (str_contains($permission->name, 'form')) {
                        return 'Form Management';
                    }  elseif (str_contains($permission->name, 'clock')) {
                        return 'Clock In / Out';
                    } elseif (str_contains($permission->name, 'employees')) {
                        return 'Employee Management';
                    } elseif (str_contains($permission->name, 'hr')) {
                        return 'HR Dashboard';
                    } else {
                        return 'Others';
                    }
                });
            return view('admin.role-permission.role-index',compact('roles','permissionsGroup'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function roleStore(Request $request){
        if(auth()->user()->hasPermission('admin role store')){
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
                if ($request->permission_ids){
                    foreach ($request->permission_ids as $permission){
                        $permit = new RolePermission();
                        $permit->role_id = $role->id;
                        $permit->permission_id = $permission;
                        $permit->save();
                    }
                }
                toastr()->success('Role Create Success.');
                return back();
            }
            catch(Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function roleUpdate(Request $request,$id){
        if(auth()->user()->hasPermission('admin role update')){
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
                if ($request->permission_ids){
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
                toastr()->error('No Permission Selected.');
                return back();

            }
            catch(Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function roleDestroy($id){
        if(auth()->user()->hasPermission('admin role destroy')){
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
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function permissionIndex(){
        if(auth()->user()->hasPermission('admin permission index')){
            $permissions = Permission::latest()->where('soft_delete',0)->get();
            $routeCollections = Route::getRoutes();
            return view('admin.role-permission.permission-index',compact('permissions','routeCollections'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function permissionStore(Request $request){
        if(auth()->user()->hasPermission('admin permission store')){
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
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function permissionUpdate(Request $request,$id){
        if(auth()->user()->hasPermission('admin permission update')){
            try{
                $validate = Validator::make($request->all(),[
                    'status' => 'required',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
                $permission = Permission::find($id);
                $permission->name = $permission->name;
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
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function permissionDestroy($id){
        if(auth()->user()->hasPermission('admin permission destroy')){
            try{
                $permission = Permission::find($id);
                $permission->name = $permission->name;
                $permission->soft_delete = 1;
                $permission->save();
                toastr()->success('Delete Successfully.');
                return back();
            }
            catch(Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function userRoleIndex(){
        if(auth()->user()->hasPermission('admin user role')){
            $users = User::latest()->whereNotIn('role',['admin'])->paginate(20);
            $roles = Role::where('status',1)->get();
            return view('admin.role-permission.user-role-permission',compact('users','roles'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function userRoleUpdate(Request $request,$id){
        if(auth()->user()->hasPermission('admin user role update')){
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
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }


}
