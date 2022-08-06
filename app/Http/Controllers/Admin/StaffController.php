<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class StaffController extends Controller {

    public function index(Request $request)
    {
        $this->authorize('list staff');

        $sql = Admin::orderBy('name', 'ASC');

        if ($request->q) {
            $sql->where('name', 'LIKE', $request->q.'%')
                ->orWhere('mobile', 'LIKE', $request->q.'%')
                ->orWhere('email', 'LIKE', $request->q.'%');
        }

        if ($request->status) {
            $sql->where('status', $request->status);
        }

        $records = $sql->paginate($request->limit ?? 15);

        $roles = Role::where('guard_name', 'admin')->get();

        return view('admin.staff', compact('records', 'roles'))->with('list', 1);
    }

    public function create()
    {
        $this->authorize('create staff');

        $roles = Role::where('guard_name', 'admin')->get();
        return view('admin.staff', compact('roles'))->with('create', 1);
    }

    public function store(Request $request)
    {
        $this->authorize('create staff');

        $this->validate($request, [
            'name' => 'required|max:100',
            'email' => 'required|email|max:100|unique:admins,email',
            'password' => 'required|max:20|min:8|confirmed',
            'role' => 'required',
            'status' => 'required|in:Active,Deactivated',
        ]);

        $storeData = [
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ];
        $data = Admin::create($storeData);
        $data->syncRoles([$request->role]);

        $request->session()->flash('successMessage', __('lang.ModelCreated', ['model' => __('lang.Staff')]));
        return redirect()->route('admin.staff.create', qArray());
    }

    public function show(Request $request, $id)
    {
        $this->authorize('show staff');

        $data = Admin::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.staff.index', qArray());
        }

        return view('admin.staff', compact('data'))->with('show', $id);
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('edit staff');

        $data = Admin::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.staff.index', qArray());
        }
        
        $roles = Role::where('guard_name', 'admin')->get();

        return view('admin.staff', compact('data', 'roles'))->with('edit', $id);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit staff');

        $this->validate($request, [
            'name' => 'required|max:100',
            'email' => 'required|email|max:100|unique:admins,email,'.$id.',id',
            'role' => 'required',
            'status' => 'required|in:Active,Deactivated',
        ]);

        $data = Admin::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.staff.index', qArray());
        }

        $storeData = [
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'status' => $request->status,
            'updated_by' => Auth::user()->id,
        ];

        if ($request->password != '') {
            $this->validate($request, [
                'password' => 'required|max:20|min:8|confirmed',
            ]);
            $storeData['password'] = Hash::make($request->password);
        }

        $data->update($storeData);
        $data->syncRoles([$request->role]);

        $request->session()->flash('successMessage', __('lang.ModelUpdated', ['model' => __('lang.Staff')]));
        return redirect()->route('admin.staff.index', qArray());
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('delete staff');

        $data = Admin::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', __('lang.RowNotFound'));
            return redirect()->route('admin.staff.index', qArray());
        }

        $data->delete();
        
        $request->session()->flash('successMessage', __('lang.ModelDeleted', ['model' => __('lang.Staff')]));
        return redirect()->route('admin.staff.index', qArray());
    }
}
