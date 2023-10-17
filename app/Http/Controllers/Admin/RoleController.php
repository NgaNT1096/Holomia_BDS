<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;


class RoleController extends Controller
{
    public function index()
    {
        if (Gate::allows(config('constants.USER_PERMISSION'))) {
            $permissions = Permission::get();
            $roles = Role::with('permissions')->paginate(100);;

            return Inertia::render(
                'Admin/Roles',
                ['permissions' => $permissions, 'roles' => $roles]
            );
        } else {
            $erros = "You don't have permission !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }
    public function store(Request $request)
    {
      
        if (Gate::allows(config('constants.USER_PERMISSION'))) {
            $this->validate($request, [
                'name' => 'required|unique:roles',
                'permission' =>  'required'
            ]);
            $role = Role::create($request->except('permission'));
            $permissions = $request->input('permission') ? $request->input('permission') : [];
            $permissions_list = [];
            foreach($permissions as $index=>$permission){
                $permissions_list[$index] = $permission['name'];
            }
    
            $role->givePermissionTo($permissions_list);
            return redirect()->back()->with('success', 'Create role successfully');
        } else {
            $erros = "You don't have permission !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }
    public function update(Request $request, $id)
    {

        if (Gate::allows(config('constants.USER_PERMISSION'))) {
            $role = Role::findOrFail($id);

            $this->validate($request, [
                'name' => 'required|unique:roles,name,' . $role->id,
            ]);
            $role->update($request->except('permission'));
            $permissions = $request->input('permission') ? $request->input('permission') : [];

            $role->syncPermissions($permissions);
            return redirect()->back()->with('success', 'Update role successfully');
        } else {
            $erros = "You don't have permission !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }

    public function delete($id)
    {

        if (Gate::allows(config('constants.USER_PERMISSION'))) {

            $role = Role::findOrFail($id);
            $role->delete();
            return redirect()->back()->with('success', 'Delete role successfully');
        } else {
            $erros = "You don't have permission !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }
}
