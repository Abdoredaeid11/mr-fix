<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Specialization;
use App\Models\User;
use App\Models\RequestModel;
use App\Models\Kyc;
use Carbon\Carbon; // 👈 مهم جدًا



class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'categoryCount'     => Category::count(),
            'specializationCount' => Specialization::count(),
            'clientCount'       => User::where('role', 'user')->count(),
            'workerCount'       => User::where('role', 'worker')->count(),
            'orders'            => RequestModel::count(),
            'kycs'              => Kyc::where('status', 'pending')->count(),
            'topClients'        => $this->getTopClients(),
            'topWorkers'        => $this->getTopWorkers(),
'lateWorkers' => $this->getLateWorkers(),
        ]);
    }

    protected function getTopClients()
    {
        return User::where('role', 'user')
            ->withCount('requestsAsClient')
            ->orderByDesc('requests_as_client_count')
            ->take(5)
            ->get();
    }

    protected function getTopWorkers()
    {
        return User::where('role', 'worker')
            ->withCount('requestsAsProvider')
            ->orderByDesc('requests_as_provider_count')
            ->take(5)
            ->get();
    }

protected function getLateWorkers()
{
    $lateThreshold = Carbon::now()->subHours(6);

    return User::where('role', 'worker')
        ->with(['requestsAsProvider' => function ($query) use ($lateThreshold) {
            $query->whereIn('status', ['pending', 'in_progress'])
                  ->where('created_at', '<', $lateThreshold);
        }])
        ->get()
        ->filter(function ($worker) {
            return $worker->requestsAsProvider->count() >= 3;
        });
}
}