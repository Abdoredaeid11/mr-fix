<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkerAddress;
use App\Models\WorkerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class UserController extends Controller
{

public function update_profile(Request $request)
{
    $validator = Validator::make($request->all(), [
        'first_name'   => 'nullable|string|max:255',
        'last_name'    => 'nullable|string|max:255',
        'email'        => 'nullable|email|unique:users,email,' . auth()->id(),
        'password'     => 'nullable|string|min:6|confirmed',
        'phone'        => 'nullable|string|max:20',
        'avatar'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = auth()->user();

    if ($request->filled('first_name')) {
        $user->first_name = $request->first_name;
    }

    if ($request->filled('last_name')) {
        $user->last_name = $request->last_name;
    }

    if ($request->filled('email')) {
        $user->email = $request->email;
    }

    if ($request->filled('phone')) {
        $user->phone = $request->phone;
    }

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

if ($request->hasFile('avatar')) {
    $file = $request->file('avatar');
    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

    // حذف الصورة القديمة
    $oldPath = base_path('avatars/' . $user->avatar);
    if ($user->avatar && file_exists($oldPath)) {
        unlink($oldPath);
    }

    // رفع الصورة إلى public_html/avatars
    $file->move(base_path('avatars'), $filename);

    // حفظ الاسم في قاعدة البيانات
    $user->avatar = $filename;
    $user->save();
}


    return response()->json(['message' => 'تم تحديث البيانات بنجاح ✅'], 200);
}


     public function add_address(Request $request)
{
    $validator = Validator::make($request->all(), [
        'add' => 'required|string|max:255',
        'country' => 'nullable|string|max:255',
        'region' => 'nullable|string|max:255',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric'
  
    ]);
    

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = $request->user(); // سواء API auth أو web


    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $maxAddresses = $user->role === 'worker' ? 3 : 3;

    $addressCount = WorkerAddress::where('worker_id', $user->id)->count();
    if ($addressCount >= $maxAddresses) {
        return response()->json([
            'message' => 'You have reached the maximum number of addresses allowed'
        ], 403);
    }

    $isDefualt = $addressCount === 0 ? 1 : ($request->defualt ? 1 : 0);

    if ($isDefualt) {
        WorkerAddress::where('worker_id', $user->id)->update(['defualt' => 0]);
    }

    $address = new WorkerAddress();
    $address->worker_id = $user->id;
    $address->address = htmlentities($request->add);
    $address->country = htmlentities($request->country);
    $address->region = htmlentities($request->region);
    $address->latitude = htmlentities($request->latitude);
    $address->longitude = htmlentities($request->longitude);
    $address->defualt = $isDefualt;
    $address->save();

    return response()->json(['message' => 'Address Added Successfully'], 200);
}


   public function get_user(Request $request, $id)
{
    // نجيب اليوزر مع التخصص والفئة
    $user = User::with(['specialization:id,name', 'category:id,name'])->findOrFail($id);

    // لو مستخدم عادي (user)
    if ($user->role === 'user') {
        $data = [
            'id' => $user->id,
            'role' => $user->role,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
         'avatar' => $user->avatar ? asset('assets/avatars/' . $user->avatar) : null,
         'address'=>$user->address,
            'country' => $user->country,
            'status' => $user->status,
            'created_at' => $user->created_at,
        ];
    }
    // لو عامل (worker)
  elseif ($user->role === 'worker') {
    $data = [
        'id' => $user->id,
        'role' => $user->role,
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'email' => $user->email,
        'phone' => $user->phone,
         'avatar' => $user->avatar ? asset('assets/avatars/' . $user->avatar) : null,        'latitude' => $user->latitude,
        'longitude' => $user->longitude,
        'rate' => $user->rate,
        'candidate' => $user->candidate,
        'address' => $user->address,
        'country' => $user->country,
        'region' => $user->region,
        'status' => $user->status,
        'last_active_at' => $user->last_active_at,
        'created_at' => $user->created_at,
        'updated_at' => $user->updated_at,
        'category' => $user->category->name ?? null,
        'specializations' => $user->specializations->map(function ($spec) {
            return [
                'id' => $spec->id,
                'name' => $spec->name,
                'name_ar' => $spec->name_ar,

                'price' => $spec->pivot->price,
            ];
        }),
    ];
} else {
        return response()->json(['message' => 'Unknown user role'], 400);
    }

    return response()->json(['user' => $data], 200);
}
  public function get_address( $id)
    {
                $user = User::with('addresses')->findOrFail($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($user->role == 'worker') {
            $address = $user->addresses;
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($address);
    }
    public function get_locations(){
    $user = auth('user')->user();
    $address=$user->addresses;
    if(!$address){
                    return response()->json(['message' => 'there is no addresses '], 400);

    }
        return response()->json(['address' => $address], 200);

        
        
    }

}
