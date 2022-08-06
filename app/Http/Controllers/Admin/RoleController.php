<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller {

    public function index(Request $request)
    {
        $this->authorize('list role');

        $sql = Role::where('guard_name', 'admin')->orderBy('name', 'ASC');

        if ($request->q) {
            $sql->where('name', 'LIKE', $request->q.'%');
        }

        $records = $sql->paginate($request->limit ?? 15);

        return view('admin.role', compact('records'))->with('list', 1);
    }

    public function create()
    {
        $this->authorize('create role');

        $permissions = Permission::where('guard_name', 'admin')->get();
        $permissionArr = [];
        foreach($permissions as $per) {
            $permissionArr[$per->module_name][] = (object) [
                'id' => $per->id,
                'name' => $per->name,
            ];
        }

        $rolePermissions = [];
        
        return view('admin.role', compact('permissionArr', 'rolePermissions'))->with('create', 1);
    }

    public function store(Request $request)
    {
        $this->authorize('create role');

        $this->validate($request, [
            'name' => 'required|max:100',
            'permissions' => 'required|array|min:1',
        ]);

        $storeData = [
            'name' => $request->name,
        ];
        $data = Role::create($storeData);
        $data->syncPermissions($request->permissions);

        $request->session()->flash('successMessage', __('lang.ModelCreated', ['model' => __('lang.Role')]));
        return redirect()->route('admin.role.create', qArray());
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('edit role');

        $data = Role::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.role.index', qArray());
        }

        $permissions = Permission::where('guard_name', 'admin')->get();
        $permissionArr = [];
        foreach($permissions as $per) {
            $permissionArr[$per->module_name][] = (object) [
                'id' => $per->id,
                'name' => $per->name,
            ];
        }

        $rolePermissions = $data->getPermissionNames()->toArray();

        return view('admin.role', compact('data', 'permissionArr', 'rolePermissions'))->with('edit', $id);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit role');

        $this->validate($request, [
            'name' => 'required|max:100',
            'permissions' => 'required|array|min:1',
        ]);

        $data = Role::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.role.index', qArray());
        }

        $storeData = [
            'name' => $request->name,
        ];

        $data->update($storeData);
        $data->syncPermissions($request->permissions);

        $request->session()->flash('successMessage', __('lang.ModelUpdated', ['model' => __('lang.Role')]));
        return redirect()->route('admin.role.index', qArray());
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('delete role');

        $data = Role::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.role.index', qArray());
        }

        $data->delete();
        
        $request->session()->flash('successMessage', __('lang.ModelDeleted', ['model' => __('lang.Role')]));
        return redirect()->route('admin.role.index', qArray());
    }
}
