<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use Illuminate\Http\Request;

class KycController extends Controller
{
    //
public function index(Request $request)
{
    $query = Kyc::with('worker');

    if ($request->filled('role')) {
        $query->whereHas('worker', function ($q) use ($request) {
            $q->where('role', $request->role);
        });
    }

    $kycs = $query->latest()->paginate(10);

    return view('admin.kyc.index', compact('kycs'));
}

    public function approve($id)
    {
        $kyc=Kyc::with('worker')->findOrFail($id);
        $kyc->update(['status' => 'approved', 'rejection_reason' => null]);
        $worker=$kyc->worker->role='worker';
        $kyc->worker->save();

        return redirect()->route('kyc.index')->with('success', 'KYC approved successfully.');
    }

    public function rejectForm($id)
    {
        $kyc = Kyc::findOrFail($id);
        return view('admin.kyc.reject', compact('kyc'));
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);
        $kyc = Kyc::findOrFail($id);

        $kyc->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'front_image'=>null,
            'back_image'=>null,
            'selfie_image'=>null,
        ]);

        return redirect()->route('kyc.index')->with('success', 'KYC rejected with reason.');
    }
}
