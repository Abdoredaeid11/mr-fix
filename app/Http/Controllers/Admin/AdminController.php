<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    //
     public function index(){
        $admins = Admin::paginate();
        return view('admin.admins.index',compact('admins'));
    }
    public function create()
    {
        return view('admin.admins.add');
    }

    public function store(Request $request){
       //
       $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|unique:admins,email',
        'phone'      => 'nullable|string|max:20|unique:admins,phone',
        'password'   => 'required|string|min:6|confirmed',
        'avatar'=>'nullable',
        'address'    => 'nullable|string',
        'country'    => 'nullable|string',
        'region'     => 'nullable|string',
    ]);
    if ($request->hasFile('avatar')) {
        // يخزن الصورة في مجلد 'avatars' داخل التخزين العام storage/app/public/avatars
        $path = $request->file('avatar')->store('assets/avatars', 'public');
        $validated['avatar'] = $path;
    }
    $admin = Admin::create([
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'email'      => $request->email,
        'phone'      => $request->phone,
        'password'   => Hash::make($request->password),
        'address'    => $request->address,
        'country'    => $request->country,
        'region'     => $request->region,
        'avatar'=> $validated['avatar'],
    ]);

    return redirect()->route('admin.index')->with('success', 'Admin created successfully.');


    }
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request,$id){
        //
        $admin = Admin::findOrFail($id);

        $request->validate([
            'first_name' => 'string|max:255',
            'last_name'  => 'string|max:255',
            'email'      => ["email", Rule::unique('admins')->ignore($id)],
            'phone'      => ["string", "max:20", Rule::unique('admins')->ignore($id)],
            'password' => 'nullable|string|min:6|confirmed',
            'address'    => 'string',
            'avatar'=>'nullable',
            'country'    => 'string',
            'region'     => 'string',
        ]);

        $admin->update($request->only(['first_name', 'last_name', 'email', 'phone', 'address', 'country', 'region']));

        if ($request->has('password')) {
            $admin->update(['password' => Hash::make($request->password)]);
        }


        return redirect()->route('admin.index')->with('success', 'Admin updated successfully.');
    }
     public function delete($id)
{
    $user = Admin::findOrFail($id);

    // حذف المستخدم من قاعدة البيانات
    $user->delete();

    return redirect()->route('admin.index')->with('success', 'admin deleted successfully.');
}
}
