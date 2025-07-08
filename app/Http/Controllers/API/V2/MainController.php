<?php
namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Specialization;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RequestModel;
use App\Models\Review;



class MainController extends Controller
{

    public function getAllCategoriesAndWorkers(Request $request)
        {

            $request->validate([
                'radius' => 'nullable|numeric|min:1',
                'per_page' => 'nullable|integer|min:1'
            ]);

            $user = $request->user('user');
            $user_latitude = $user->latitude;
            $user_longitude = $user->longitude;

            $radius = $request->radius ?? 10;
            $perPage = $request->per_page ?? 12;

            $workers = User::selectRaw("
                users.*,
                ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) *
                cos( radians( longitude ) - radians(?) ) +
                sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance
            ", [$user_latitude, $user_longitude, $user_latitude])
            ->where('role', 'worker') // فلترة المستخدمين اللي هم عمال فقط
            ->where('status', 'active') // اختيار النشطين فقط
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->paginate($perPage);

            return response()->json([
                'workers' => $workers
            ]);
        }
     public function getAllCategories()
{
    $categories = Category::with('specializations')->get();

    // تعديل الصورة قبل الإرجاع
    $categories->transform(function ($category) {
        $category->image = $category->image
            ? asset('assets/category/' . $category->image)
            : null; // أو تحط صورة افتراضية هنا لو حبيت
        return $category;
    });

    return response()->json([
        'categories' => $categories
    ]);
}

  public function getAllSpecializations()
{
    $specializations = Specialization::with(['workers' => function ($query) {
        $query->select('users.id', 'first_name', 'last_name')
              ->where('role', 'worker');
    }])->paginate(10);

    $data = $specializations->map(function ($specialization) {
        return [
            'id' => $specialization->id,
            'name' => $specialization->name,
            'description' => $specialization->description,
'image' => $specialization->image
    ? asset('assets/specializations/' . $specialization->image)
    : null,
    'workers' => $specialization->workers->map(function ($worker) {
                return [
                    'id' => $worker->id,
                    'first_name' => $worker->first_name,
                    'last_name' => $worker->last_name,
                    'price' => $worker->pivot->price,
                ];
            }),
        ];
    });

    return response()->json([
        'status' => true,
        'message' => 'Specializations with workers',
        'data' => $data,
        'pagination' => [
            'current_page' => $specializations->currentPage(),
            'last_page' => $specializations->lastPage(),
            'per_page' => $specializations->perPage(),
            'total' => $specializations->total(),
            'next_page_url' => $specializations->nextPageUrl(),
            'prev_page_url' => $specializations->previousPageUrl(),
        ],
    ]);
}

//->>>>>>>>>>>>>>>>>>>reviews
public function store(Request $request)
{
      $validator = \Validator::make($request->all(), [
        'to_user_id' => 'nullable|exists:users,id',
        'request_id' => 'required|exists:requests,id',
        'rating'     => 'required|integer|min:1|max:5',
        'comment'    => 'nullable|string|max:1000',
    ]);

   if ($validator->fails()) {
        return response()->json([
            'message' => 'Inputs required',
            'errors' => $validator->errors(),
        ], 422);
    }

    $fromUser = auth('user')->user();

    // تأكد إنه طرف في الطلب
    $requestModel = RequestModel::where('id', $request->request_id)
        ->where(function($q) use ($fromUser) {
            $q->where('client_id', $fromUser->id)
              ->orWhere('provider_id', $fromUser->id);
        })->firstOrFail();

    // مين الطرف التاني؟
    if ($fromUser->id == $requestModel->client_id) {
        $toUserId = $requestModel->provider_id;
    } else {
        $toUserId = $requestModel->client_id;
    }

    // احفظ التقييم
    $review = Review::create([
        'from_user_id' => $fromUser->id,
        'to_user_id'   => $toUserId,
        'request_id'   => $requestModel->id,
        'rating'       => $request->rating,
        'comment'      => $request->comment,
    ]);

    return response()->json(['message' => 'Review submitted', 'review' => $review]);
}

public function getworkers(Request $request,$location_id){

       $request->validate([
                'specialization' => 'required',
                

            ]);

$specializationId=$request->specialization;
            $user = auth('user')->user();
            if(!$user){
                    return response()->json(['message' => 'Unauthorized'], 401);
            }
            
$location = $user->addresses()->findOrFail($location_id);
            $user_latitude = $location->latitude;
            $user_longitude = $location->longitude;


            $radius = $request->radius ?? 10;
            $perPage = $request->per_page ?? 12;

$workers = User::where('role', 'worker')
    ->where('status', 'active')
    ->whereHas('specializations', function ($q) use ($specializationId) {
        $q->where('specializations.id', $specializationId);
    })
    ->with(['defaultAddress','category', 'specializations' => function ($q) use ($specializationId) {
        $q->where('specializations.id', $specializationId);
    }])
    ->get()
    ->filter(function ($worker) use ($user_latitude, $user_longitude, $radius) {
        if (!$worker->defaultAddress) return false;

        $lat = $worker->defaultAddress->latitude;
        $lng = $worker->defaultAddress->longitude;

        $distance = 6371 * acos(
            cos(deg2rad($user_latitude)) * cos(deg2rad($lat)) *
            cos(deg2rad($lng) - deg2rad($user_longitude)) +
            sin(deg2rad($user_latitude)) * sin(deg2rad($lat))
        );

        return $distance <= $radius;
    })
    ->map(function ($worker) {
        return [
            'id' => $worker->id,
            'name' => $worker->first_name.' '.$worker->last_name,
            'phone' => $worker->phone,
            'rate' => $worker->rate,
            'user_image' => $worker->avatar,
            'address' => optional($worker->defaultAddress)->address,
            'latitude' => optional($worker->defaultAddress)->latitude,
            'longitude' => optional($worker->defaultAddress)->longitude,
            'specializations' => $worker->specializations->map(function ($spec) {
                return [
                    'name' => $spec->name,
                    'image' => $spec->image,
                    'price' => $spec->pivot->price,
                    'category_id' => optional($spec->category)->id,

                ];
            }),
        ];
    })->values();

return response()->json([
    'workers' => $workers
]);



}

}
