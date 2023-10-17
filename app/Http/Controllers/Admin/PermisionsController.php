<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

use Illuminate\Http\Response;

class PermisionsController extends Controller
{
    public function index()
    {
        if (Gate::allows(config('constants.USER_PERMISSION'))) {
            $permissions = Permission::paginate(10);

            $total = count($permissions);

            return Inertia::render(
                'Admin/Permissions',
                ['permissions' => $permissions, 'total' => $total]
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
                'name' => 'required|unique:permissions',
            ]);

            Permission::create($request->all());

            return redirect()->back()->with('success', 'Create permission successfully');
        } else {
            $erros = "You don't have permission !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }
    public function update(Request $request, $id)
    {
        if (Gate::allows(config('constants.USER_PERMISSION'))) {
            $permission = Permission::find($id);


            if ($permission == null) {
                $msg = [
                    'msg' => 'The permission is not found'
                ];
                return response()->json($msg, Response::HTTP_BAD_REQUEST);
            }

            $this->validate($request, [
                'name' => 'required|unique:permissions,name,' . $permission->id,
            ]);

            $permission->name = $request->name;
            $permission->save();

            return redirect()->back()->with('success', 'Update permission successfully');
        } else {
            $erros = "You don't have permission !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }

    public function delete($id)
    {

        if (Gate::allows(config('constants.USER_PERMISSION'))) {
            $permission = Permission::find($id);

            if ($permission == null) {
                $msg = [
                    'msg' => 'The permission is not found'
                ];
                return response()->json($msg, Response::HTTP_BAD_REQUEST);
            }
            $permission->delete();
            return redirect()->back()->with('success', `Delete {{$permission->name}} permission successfully`);
        } else {
            $erros = "You don't have permission !!";
            return Inertia::render('Erros/401', ['erros' => $erros]);
        }
    }
}
