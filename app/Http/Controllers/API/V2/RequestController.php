<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use App\Notifications\NewRequestNotification;
use Carbon\Carbon;
use App\Models\WorkerAvailability;



class RequestController extends Controller
{
    //
public function index()
{
 $user = auth()->user();
 
 
 
if (!$user) {
    return response()->json(['message' => 'Unauthenticated'], 401);
}
    if ($user->role == 'user') {
        $requests = $user->requestsAsClient()
            ->select('id', 'status', 'note', 'provider_id', 'category_id','specialization_id', 'created_at')
            ->with([
                'category:id,name',
                'provider:id,first_name,last_name,rate,avatar,phone',
    'provider.completedRequestsAsProvider',
                'specialization:id,name',
            ])
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'status' => $request->status,
                    'note' => $request->note,
                    'scheduled_at'=>$request->scheduled_at,
                    'category' => $request->category->name ?? null,
                    'provider' => [
                        'id' =>$request->provider->id,
                        'name' => $request->provider->first_name . ' ' . $request->provider->last_name,
                        'rate' => $request->provider->rate,
                        'avatar' => $request->provider->avatar,
                        'phone' => $request->provider->phone,
 'completed_requests_count' => $request->provider->completedRequestsAsProvider->count(),
                          ],
                                                  'specialization_name' => $request->specialization->name, 
                'specialization_description' => $request->specialization->description, 
                    'created_at' => $request->created_at,
                ];
            });
  
      return response()->json([
        'requests' => $requests,
    ]);

    } elseif ($user->role == 'worker') {

    $asClient = $user->requestsAsClient()
        ->with(['provider:id,first_name,last_name,rate,avatar,phone',
    'provider.completedRequestsAsProvider',
    'category:id,name',
    'specialization:id,name'])
        ->get()
        ->map(function ($request) {
            return [
                'id' => $request->id,
                'type' => 'requested', // هو اللي طلبها
                'status' => $request->status,
                'note' => $request->note,
                'provider' => [
                        'id' =>$request->provider->id,
                        'name' => $request->provider->first_name . ' ' . $request->provider->last_name,
                        'rate' => $request->provider->rate,
                        'avatar' => $request->provider->avatar,
                        'phone' => $request->provider->phone,
                            'completed_requests_count' => $request->provider->completedRequestsAsProvider->count(),
],
                'category' => $request->category->name ?? null,
                'specialization_name' => $request->specialization->name, 
                'specialization_description' => $request->specialization->description, 
                'created_at' => $request->created_at,
            ];
        });

    // الطلبات اللي اتبعتت له كعامل
    $asProvider = $user->requestsAsProvider()
        ->with(['client:id,first_name', 'category:id,name'])
        ->get()
        ->map(function ($request) {
            return [
                'id' => $request->id,
                'type' => 'assigned', // اتبعتت له
                'status' => $request->status,
                'note' => $request->note,
                'client_name' => $request->client->first_name ?? null,
                'category' => $request->category->name ?? null,
                'specialization_name' => $request->specialization->name, 
                'specialization_description' => $request->specialization->description, 
                'created_at' => $request->created_at,
            ];
        });

    // دمج النوعين في مجموعة واحدة
    $requests = $asClient->concat($asProvider)->values();

 
  

    // استجابة JSON موحدة
    return response()->json([
        'requests' => $requests,
    ]);
}
 else {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    return response()->json($requests); // للمستخدم العادي فقط
} 



public function store(Request $request)
{
    $validator = \Validator::make($request->all(), [
        'provider_id' => 'required|exists:users,id',
        'category_id' => 'required|exists:categories,id',
        'specialization_id' => 'required|exists:specializations,id',
        'price'        => 'required|numeric',
        'scheduled_at' => 'required|date',
        'note'         => 'nullable|string|max:500',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Inputs required',
            'errors'  => $validator->errors(),
        ], 422);
    }

    $client = auth('user')->user();
    $provider = User::findOrFail($request->provider_id);
    $scheduled = Carbon::parse($request->scheduled_at);
    $day = $scheduled->format('l'); // ex: Sunday

    $isAvailable = WorkerAvailability::where('worker_id', $provider->id)
        ->where('day', $day)
        ->whereTime('start_time', '<=', $scheduled->format('H:i:s'))
        ->whereTime('end_time', '>=', $scheduled->format('H:i:s'))
        ->exists();

    if (! $isAvailable) {
        return response()->json(['message' => 'الموعد المختار غير متاح للعامل'], 422);
    }

    $start = $scheduled;
    $end = $scheduled->copy()->addHour();

    $hasConflict = RequestModel::where('provider_id', $provider->id)
        ->where(function ($query) use ($start, $end) {
            $query->whereBetween('scheduled_at', [$start, $end])
                  ->orWhere(function ($q) use ($start) {
                      $q->where('scheduled_at', '<', $start)
                        ->whereRaw("DATE_ADD(scheduled_at, INTERVAL 1 HOUR) > ?", [$start]);
                  });
        })
        ->exists();

    if ($hasConflict) {
        return response()->json(['message' => 'العامل لديه طلب آخر متداخل مع هذا الموعد'], 422);
    }

    $newRequest = RequestModel::create([
        'client_id'         => $client->id,
        'provider_id'       => $provider->id,
        'category_id'       => $request->category_id,
        'specialization_id' => $request->specialization_id,
        'note'              => htmlentities($request->note),
        'scheduled_at'      => $request->scheduled_at,
        'price'             => $request->price,
    ]);

    return response()->json([
        'message' => 'تم إنشاء الطلب بنجاح',
        'request' => $newRequest
    ], 201);
}


 public function delete( $id)
    {
        $requestModel = RequestModel::find($id);
        if (!$requestModel) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        // Check if the authenticated user is the client of the request
        if ($requestModel->client_id !== auth('user')->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $requestModel->delete();
        return response()->json(['message' => 'Request deleted successfully']);
    }
    
   
    
}
