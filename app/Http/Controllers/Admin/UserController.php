<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;


class UserController extends Controller
{
  public function index(Request $request)
{
    $query = User::where('role', 'user');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('first_name', 'LIKE', "%$search%")
              ->orWhere('email', 'LIKE', "%$search%");
        });
    }

    $users = $query->paginate(20);

    return view('admin.users.index', compact('users'));
}
    public function create()
    {
        return view('admin.users.add');
    }

    public function store(Request $request){
       //
       $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|unique:users,email',
        'phone'      => 'nullable|string|max:20|unique:users,phone',
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
    $user = User::create([
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'email'      => $request->email,
        'phone'      => $request->phone,
        'password'   => Hash::make($request->password),
        'address'    => $request->address,
        'country'    => $request->country,
        'region'     => $request->region,
        'avatar'=> $validated['avatar'],
        'role'       => 'user', // Assuming the default role is 'user'
    ]);

    return redirect()->route('user.index')->with('success', 'User created successfully.');


    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

   public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'first_name' => 'string|max:255',
        'last_name'  => 'string|max:255',
        'email'      => ["email", Rule::unique('users')->ignore($id)],
        'phone'      => ["string", "max:20", Rule::unique('users')->ignore($id)],
        'password'   => 'nullable|string|min:6|confirmed',
        'address'    => 'string',
        'country'    => 'string',
        'region'     => 'string',
        'avatar'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // تحديث الحقول العادية
    $user->update(Arr::except($validated, ['password', 'avatar']));

    // تحديث الباسورد لو موجود
    if ($request->filled('password')) {
        $user->update(['password' => Hash::make($request->password)]);
    }

    // تحديث الصورة لو مرفوعة
    if ($request->hasFile('avatar')) {
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('assets/avatars', 'public');
        $user->update(['avatar' => $path]);
    }

    return redirect()->route('user.index')->with('success', 'User updated successfully.');
}

    public function block($id){
        //
        $user = User::findOrFail($id);
        $user->update(['status' => 'banned']);

        return redirect()->route('user.index')->with('success', 'User has been blocked.');
    }
    public function unblock($id){
        //
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);

        return redirect()->route('user.index')->with('success', 'User has been blocked.');
    }
   public function delete($id)
{
    $user = User::findOrFail($id);

    // حذف الصورة من التخزين إذا كانت موجودة
    if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
        Storage::disk('public')->delete($user->avatar);
    }

    // حذف المستخدم من قاعدة البيانات
    $user->delete();

    return redirect()->route('user.index')->with('success', 'User deleted successfully.');
}
}
