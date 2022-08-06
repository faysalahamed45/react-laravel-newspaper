<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $data = Admin::find(Auth::user()->id);
        return view('admin.profile', compact('data'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'email' => 'required|email|max:100|unique:users,email,'.Auth::user()->id.',id',
        ]);

        $formData = [
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
        ];
        $data = Admin::find(Auth::user()->id);
        $data->update($formData);

        $request->session()->flash('successMessage', __('lang.ModelUpdated', ['model' => __('lang.Profile')]));
        return redirect()->route('admin.profile');
    }

    public function password()
    {
        $data = Admin::find(Auth::user()->id);
        return view('admin.profile', compact('data'))->with('password', 1);
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|max:20|min:8|confirmed',
        ]);

        $data = Admin::find(Auth::user()->id);

        if (!Hash::check($request->current_password, $data->password)) {
            $request->session()->flash('errorMessage', "The specified password does not match the database password");
            return redirect()->route('admin.profile');
        } else {
            $formData = [
                'password' => Hash::make($request->password),
            ];
            $data->update($formData);

            $request->session()->flash('successMessage', __('lang.ModelUpdated', ['model' => __('lang.Password')]));
            return redirect()->route('admin.profile');
        }
    }
}
