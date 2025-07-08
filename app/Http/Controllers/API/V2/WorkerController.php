<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kyc;
use Illuminate\Support\Facades\Storage;


class WorkerController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'front_image'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'back_image'   => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'selfie_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $workerId = auth()->id();
    $existing = Kyc::where('worker_id', $workerId)->first();

    // تجهيز مجلد التخزين
    $destinationPath = base_path('assets/kyc');
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0777, true);
    }

    // توليد أسماء فريدة للصور
    $frontName  = uniqid() . '_front.' . $request->file('front_image')->getClientOriginalExtension();
    $backName   = uniqid() . '_back.'  . $request->file('back_image')->getClientOriginalExtension();
    $selfieName = uniqid() . '_selfie.' . $request->file('selfie_image')->getClientOriginalExtension();

    // نقل الصور للمجلد
    $request->file('front_image')->move($destinationPath, $frontName);
    $request->file('back_image')->move($destinationPath, $backName);
    $request->file('selfie_image')->move($destinationPath, $selfieName);

    if ($existing) {
        if (
            !is_null($existing->front_image) &&
            !is_null($existing->back_image) &&
            !is_null($existing->selfie_image)
        ) {
            return response()->json(['message' => 'تم تقديم طلب KYC مسبقًا'], 400);
        }

        // تعديل نفس السجل لو الصور كانت null
        $existing->update([
            'front_image'  => 'assets/kyc/' . $frontName,
            'back_image'   => 'assets/kyc/' . $backName,
            'selfie_image' => 'assets/kyc/' . $selfieName,
            'status'       => 'pending',
        ]);

        return response()->json(['message' => 'تم تحديث بيانات التحقق بنجاح ✅']);
    }

    // إنشاء سجل جديد
    $kyc = new Kyc();
    $kyc->worker_id     = $workerId;
    $kyc->front_image   = 'assets/kyc/' . $frontName;
    $kyc->back_image    = 'assets/kyc/' . $backName;
    $kyc->selfie_image  = 'assets/kyc/' . $selfieName;
    $kyc->status        = 'pending';
    $kyc->save();

    return response()->json(['message' => 'تم إرسال بيانات التحقق بنجاح ✅']);
}





}
