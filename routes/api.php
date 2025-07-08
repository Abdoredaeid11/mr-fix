<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V2\WorkerController;
use App\Http\Controllers\API\V2\Auth\UserAuthController;
use App\Http\Controllers\API\V2\MainController;
use App\Http\Controllers\API\V2\UserController;
use GuzzleHttp\Psr7\Request;
use App\Http\Controllers\API\V2\RequestController;
use App\Http\Controllers\API\V2\NotificationController;

use App\Http\Controllers\API\V2\specializationController;

use App\Http\Controllers\API\V2\AvailabilityController;





/*Route::post('worker/login', [WorkerAuthController::class, 'login']);
Route::post('worker/register', [WorkerAuthController::class, 'register']);
Route::middleware('auth.worker')->group(function () {
    Route::post('worker/logout', [WorkerAuthController::class, 'logout']);
    Route::post('worker/profile/update', [WorkerAuthController::class, 'update_profile']);
    Route::post('worker/address/add', [WorkerAuthController::class, 'add_address']);
    Route::get('worker/dashboard', function () {
        return response()->json(['message' => 'Worker Dashboard']);
    });
});*/
//     ->>>>>>>>>>>>>>>>>>>>>>    users
Route::post('user/login', [UserAuthController::class, 'login']);
Route::post('user/register', [UserAuthController::class, 'register']);
route::get('user/{id}', [UserController::class, 'get_user']);





Route::middleware('auth.user')->prefix('user')->group(function () {
    Route::get('home', [MainController::class, 'getAllCategoriesAndWorkers']);
    Route::post('profile/update', [UserController::class, 'update_profile']);
        Route::get('/workers/index/{location_id}', [MainController::class, 'getworkers']);
            Route::post('worker/profile', [WorkerController::class, 'store']);


        //     ->>>>>>>>>>>>>>>>>>>>>>    address

    Route::post('address/add', [UserController::class, 'add_address']);
        Route::get('address/index', [UserController::class, 'get_locations']);

    


    //     ->>>>>>>>>>>>>>>>>>>>>>    requests

    Route::get('requests/list', [RequestController::class, 'index']);
    Route::post('requests/store', [RequestController::class, 'store']);
    Route::delete('requests/delete/{id}', [RequestController::class, 'delete']);
    
    
    
    //     ->>>>>>>>>>>>>>>>>>>>    notifications 
      Route::get('/notifications/index', [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/respond', [NotificationController::class, 'respond']);
    
    
    Route::post('/save-token', [NotificationController::class, 'save']);
    Route::post('/request/notify', [NotificationController::class, 'notify']);

Route::post('/order/accept', [NotificationController::class, 'acceptOrder']);
    
    Route::post('availability/store', [AvailabilityController::class, 'store']);

        //     ->>>>>>>>>>>>>>>>>>>>>>    reveiws
        
        Route::post('reviews/store', [MainController::class, 'store']);


Route::post('/worker-specializations', [specializationController::class, 'store']);

    Route::post('logout', [UserAuthController::class, 'logout']);
    Route::get('dashboard', function () {
        return response()->json(['message' => 'User Dashboard']);
    });
});
//  ->>>>>>>> categories
Route::get('categories', [MainController::class, 'getAllCategories']);

Route::get('/worker/{workerId}/availability', [AvailabilityController::class, 'getWorkerAvailability']);

route::get('spcializations', [MainController::class, 'getAllSpecializations']);

Route::post('/send-notification', [NotificationController::class, 'send']);

Route::get('/get-token', function () {
    return \App\Helpers\FirebaseHelper::getAccessToken();
});
