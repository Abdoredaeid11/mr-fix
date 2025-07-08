<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;
use App\Models\UserSpecialization;


class specializationController extends Controller
{
    //
    public function index()
    {
        $specializations =Specialization::with('category')->get();
        
        return response()->json([
            'specializations' => $specializations
        ]);
    }
    
public function store(Request $request)
{
    $request->validate([
        'specializations' => 'required|array',
        'specializations.*.specialization_id' => 'required|exists:specializations,id',
        'specializations.*.price' => 'required|numeric|min:0',
    ]);

    // تحقق من التكرار داخل array التخصصات
    $ids = array_column($request->specializations, 'specialization_id');
    if (count($ids) !== count(array_unique($ids))) {
        return response()->json([
            'message' => 'لا يمكن تكرار نفس التخصص أكثر من مرة.'
        ], 422);
    }

    $user = auth()->user();
    foreach ($request->specializations as $item) {
        $c=UserSpecialization::Create(
            [
                'user_id' => $user->id,
                'specialization_id' => $item['specialization_id'],
                'price' => $item['price'],
            ]
            
        );
    }
    return response()->json(['message' => 'تمت إضافة التخصصات بنجاح']);
}

}
