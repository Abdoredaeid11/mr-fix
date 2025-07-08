<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Models\RequestModel;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WorkerController;
use App\Http\Controllers\Admin\DashboardController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/clear-opcache', function () {
    if (function_exists('opcache_reset')) {
        opcache_reset();
        return 'OPcache cleared ✅';
    }
    return 'OPcache function not available ❌';
});

Route::get('checkLanguage/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session()->put('locale', $locale);

        return redirect()->back();
    }
})->name('checkLanguage');



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/logout', function () {
    Auth::logout();  // هنا استخدمنا Guard معين "admin"
    return redirect('admin/dashboard'); // إعادة التوجيه بعد الخروج
})->name('logout');

require __DIR__ . '/auth.php';





Route::middleware(['auth:admin'])->prefix('control-panel')->group(function () {
    Route::get('/admin/home', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('users', UserController::class);


    //categories
Route::get('categories', [CategoryController::class, 'index'])->name('category.index');

     Route::get('categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/add', [CategoryController::class, 'store'])->name('category.store');
     Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/{id}/update', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}/delete', [CategoryController::class, 'delete'])->name('category.delete');

    //users
    Route::get('users', [UserController::class, 'index'])->name('user.index');
    Route::get('users/create', [UserController::class, 'create'])->name('user.create');

    Route::post('/user/add', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');

    Route::post('/user/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::post('/user/{id}/block', [UserController::class, 'block'])->name('user.block');
    Route::post('/user/{id}/unblock', [UserController::class, 'unblock'])->name('user.unblock');
    Route::delete('/user/{id}/delete', [UserController::class, 'delete'])->name('user.delete');

    //workers
    Route::get('workers', [WorkerController::class, 'index'])->name('worker.index');
    Route::get('/worker/create', [WorkerController::class, 'create'])->name('worker.create');
    Route::get('/worker/{id}/edit', [WorkerController::class, 'edit'])->name('worker.edit');
    Route::post('/worker/add', [WorkerController::class, 'store'])->name('worker.store');
    Route::put('/worker/{id}/update', [WorkerController::class, 'update'])->name('worker.update');
    Route::post('/worker/{id}/active', [WorkerController::class, 'active'])->name('worker.active');
    Route::post('/worker/{id}/inactive', [WorkerController::class, 'inactive'])->name('worker.inactive');
    Route::post('/worker/{id}/block', [WorkerController::class, 'block'])->name('worker.block');
    Route::post('/worker/{id}/unblock', [WorkerController::class, 'unblock'])->name('worker.unblock');
    Route::delete('/worker/{id}/delete', [WorkerController::class, 'delete'])->name('worker.delete');

    //admins
    Route::get('admins', [AdminController::class, 'index'])->name('admin.index');
    Route::get('admins/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/add', [AdminController::class, 'store'])->name('admin.store');


    Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{id}/update', [AdminController::class, 'update'])->name('admin.update');

    Route::delete('/admin/{id}/delete', [AdminController::class, 'delete'])->name('admin.delete');



    //->>>>>>>>>>>>>>>>>>>>>  Requests Routes <<<<<<<<<<<<<<<<<<<<<<<
    Route::get('requests', [App\Http\Controllers\Admin\RequestController::class, 'index'])->name('request.index');
    Route::get('/request/create', [App\Http\Controllers\Admin\RequestController::class, 'create'])->name('request.create');
    Route::get('/request/{id}/show', [App\Http\Controllers\Admin\RequestController::class, 'show'])->name('request.show');
    Route::post('/request/add', [App\Http\Controllers\Admin\RequestController::class, 'store'])->name('request.store');
    Route::post('/request/{id}/accept', [App\Http\Controllers\Admin\RequestController::class, 'accept'])->name('request.accept');
    Route::post('/request/{id}/reject', [App\Http\Controllers\Admin\RequestController::class, 'reject'])->name('request.reject');
    Route::get('/request/{id}/edit', [App\Http\Controllers\Admin\RequestController::class, 'edit'])->name('request.edit');
    Route::put('/request/{id}/update', [App\Http\Controllers\Admin\RequestController::class, 'update'])->name('request.update');
    Route::delete('/request/{id}/delete', [App\Http\Controllers\Admin\RequestController::class, 'delete'])->name('request.delete');


    //->>>>>>>>>>>>>>>>>>>>>  Specializations Routes <<<<<<<<<<<<<<<<<<<<<<<
    Route::get('specializations', [App\Http\Controllers\Admin\SpecializationController::class, 'index'])->name('specialization.index');
    Route::get('/specialization/create', [App\Http\Controllers\Admin\SpecializationController::class, 'create'])->name('specialization.create');
    Route::post('/specialization/add', [App\Http\Controllers\Admin\SpecializationController::class, 'store'])->name('specialization.store');
    Route::get('/specialization/{id}/edit', [App\Http\Controllers\Admin\SpecializationController::class, 'edit'])->name('specialization.edit');
    Route::put('/specialization/{id}/update', [App\Http\Controllers\Admin\SpecializationController::class, 'update'])->name('specialization.update');
    Route::delete('/specialization/{id}/delete', [App\Http\Controllers\Admin\SpecializationController::class, 'delete'])->name('specialization.delete');

//->>>>>>>>>>>>>>>>>>>>>  KYC Routes <<<<<<<<<<<<<<<<<<<<<<<
    Route::get('kyc', [App\Http\Controllers\Admin\KycController::class, 'index'])->name('kyc.index');
    Route::get('/kyc/{id}/show', [App\Http\Controllers\Admin\KycController::class, 'show'])->name('kyc.show');
    Route::post('/kyc/{id}/approve', [App\Http\Controllers\Admin\KycController::class, 'approve'])->name('kyc.approve');
    Route::put('/kyc/{id}/reject', [App\Http\Controllers\Admin\KycController::class, 'reject'])->name('kyc.reject');
    Route::get('/kyc/{id}/reject-form', [App\Http\Controllers\Admin\KycController::class, 'rejectForm'])->name('kyc.rejectForm');


Route::get('/dashboard/counts', function () {
    return response()->json([
        'requests' => \App\Models\RequestModel::count(),
        'workers' => \App\Models\User::where('role', 'worker')->count(),
        'users' => \App\Models\User::where('role', 'user')->count(),
        'kyc' => \App\Models\Kyc::where('status','pending')->count(), // غيّر حسب اسم الموديل عندك
    ]);
})->name('dashboard.counts');


});
