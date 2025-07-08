<?php
namespace App\Http\Controllers\API\V2\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Worker;
use App\Models\WorkerAddress;
use App\Models\WorkerProfile;
use Illuminate\Support\Facades\Validator;

class WorkerAuthController extends Controller
{
    public function register(Request $request)
    {


        $validator = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:workers',
            'password' => 'required|string|min:8',
        ]);

        $worker = Worker::create([
            'first_name' => htmlentities($request->first_name),
            'last_name' => htmlentities($request->last_name),
            'email' => htmlentities($request->email),
            'password' => htmlentities(Hash::make($request->password)),
        ]);

        $token = $worker->createToken('WorkerToken')->plainTextToken;

        return response()->json(['token' => $token, 'worker' => $worker], 201);
    }

    public function update_profile(Request $request){
        $validator = Validator::make($request->all(), [
            'national_id' => 'required|numeric|digits:14',
            'age' => 'required|numeric|digits:2',
            'experiance' => 'nullable|numeric|digits:2',
            'info' => 'nullable|string|max:500',
            'price' => 'required|float'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $worker = $request->user('worker');
        $profile = new WorkerProfile();
        $profile->worker_id = $worker->id;
        $profile->national_id = htmlentities($request->national_id);
        $profile->age = htmlentities($request->age);
        $profile->experiance = htmlentities($request->experiance);
        $profile->info = htmlentities($request->info);
        $profile->price = htmlentities($request->price);
        $profile->status = 'pending';
        $profile->save();

        return response()->json(['message' => 'Worker Profile Updated'], 200);
    }

    public function add_address(Request $request){
        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'region' =>  'nullable|string|max:255',
            // 'latitude' => 'nullable|numeric',
            // 'longitude' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $worker = $request->user('worker');
        if (!$worker) {
            return response()->json(['message' => 'Worker not found'], 404);
        }
        $addressCount = WorkerAddress::where('worker_id', $worker->id)->count();
        if ($addressCount >= 3) {
            return response()->json(['message' => 'A worker can only have up to 3 addresses'], 403);
        }
        // if ($request->default) {
        //     WorkerAddress::where('worker_id', $worker->id)->update(['default' => 0]);
        // }
           // If this is the first address, set it as default
    $isDefault = $addressCount === 0 ? 1 : ($request->default ? 1 : 0);

    // If a new default address is set, reset others
    if ($isDefault) {
        WorkerAddress::where('worker_id', $worker->id)->update(['default' => 0]);
    }

        $address = new WorkerAddress();
        $address->worker_id = $worker->id;
        $address->address = htmlentities($request->address);
        $address->country = htmlentities($request->country);
        $address->region = htmlentities($request->region);
        $address->latitude = htmlentities($request->latitude);
        $address->longitude = htmlentities($request->longitude);
        $address->default = $isDefault;
        $address->save();

        return response()->json(['message' => 'Worker Address Added'], 200);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }
        $worker = Worker::where('email', $request->email)->first();

        if (!$worker || !Hash::check($request->password, $worker->password)) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }
        $token = $worker->createToken('WorkerToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ]);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }
}
