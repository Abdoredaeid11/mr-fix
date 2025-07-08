<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WorkerController extends Controller
{
    public function index(Request $request)
{
    $query = User::where('role', 'worker');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('first_name', 'LIKE', "%$search%")
              ->orWhere('email', 'LIKE', "%$search%");
        });
    }

    $workers = $query->paginate(10);

    return view('admin.workers.index', compact('workers'));
}
 public function create()
    {
        return view('admin.workers.add');
    }
    public function store(Request $request)
    {
        //
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
            'avatar' => 'nullable',
            'address' => 'nullable|string',
            'country' => 'nullable|string',
            'region' => 'nullable|string',
        ]);
        if ($request->hasFile('avatar')) {
            // يخزن الصورة في مجلد 'avatars' داخل التخزين العام storage/app/public/avatars
            $path = $request->file('avatar')->store('assets/avatars', 'public');
            $validated['avatar'] = $path;
        }
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'country' => $request->country,
            'region' => $request->region,
            'avatar' => $validated['avatar'],
            'role' => 'worker', // Assuming the default role is 'user'
        ]);

        return redirect()->route('worker.index')->with('success', 'worker created successfully.');

    }


        public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.workers.edit', compact('user'));
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
        'avatar'     => 'nullable|image',
        'country'    => 'string',
        'region'     => 'string',
    ]);

    $data = $request->only(['first_name', 'last_name', 'email', 'phone', 'address', 'country', 'region']);

    // الباسورد لو اتبعت
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    // الصورة لو اتبعتت
    if ($request->hasFile('avatar')) {
        // حذف القديمة
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // خزّن الجديدة
        $data['avatar'] = $request->file('avatar')->store('assets/avatars', 'public');
    }

    // تحديث كل البيانات
    $user->update($data);

    return redirect()->route('worker.index')->with('success', 'User updated successfully.');
}


    public function active($id)
    {
        //
        $worker = Worker::findOrFail($id);
        $worker->profile->update(['status' => 'accept']);

        return redirect()->route('admin.workers.index')->with('success', 'Worker activated successfully.');

    }
    public function inactive($id)
    {
        //
        $worker = Worker::findOrFail($id);
        $worker->profile()->update(['status' => 'pending']);
        return redirect()->route('admin.workers.index')->with('error', 'Worker blocked successfully.');
    }
    public function block($id)
    {
        //
        $worker = Worker::findOrFail($id);
        $worker->profile->update(['status' => 'fail']);

        return response()->json([
            'message' => 'Worker blocked successfully',
            'worker' => $worker->load('profile')
        ]);
    }
    public function unblock($id)
    {
        //
        $worker = Worker::findOrFail($id);
        $worker->profile->update(['status' => 'accept']);

        return redirect()->route('admin.workers.index')->with('success', 'Worker unblocked successfully.');
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

    return redirect()->route('worker.index')->with('success', 'Worker deleted successfully.');
}

}
