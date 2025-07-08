<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    //
    public function index()
    {
        $specializations = Specialization::with('category')->paginate(10);
        return view('admin.specializations.index', compact('specializations'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('admin.specializations.add', compact('categories'));
    }
   public function store(Request $request)
{
    // 1. Validation
    $validatedData = $request->validate([
        'name'         => 'required|string|max:255',
        'name_ar'      => 'required|string|max:255',
        'description'  => 'nullable|string',
        'category_id'  => 'required|exists:categories,id',
        'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // 2. Handle image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();

        // ✅ حفظ الصورة في assets/specializations
        $image->move(base_path('assets/specializations'), $imageName);

        $validatedData['image'] = $imageName;
    }

    // 3. Create record
    Specialization::create($validatedData);

    // 4. Redirect with success
    return redirect()->route('specialization.index')->with('success', 'Specialization created successfully.');
}


    public function edit($id)
    {
        $specialization = Specialization::findOrFail($id);
        $categories = Category::all();
        return view('admin.specializations.edit', compact('specialization', 'categories'));
    }
    public function update(Request $request, $id)
{
    $specialization = Specialization::findOrFail($id);

    // 1. التحقق من البيانات
    $validatedData = $request->validate([
        'name'         => 'required|string|max:255',
        'name_ar'      => 'required|string|max:255',
        'description'  => 'nullable|string',
        'category_id'  => 'required|exists:categories,id',
        'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // 2. التعامل مع الصورة
    if ($request->hasFile('image')) {
        // حذف الصورة القديمة إن وُجدت
        if ($specialization->image) {
            $oldPath = base_path('assets/specializations/' . $specialization->image);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // رفع الصورة الجديدة
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(base_path('assets/specializations'), $imageName);

        $validatedData['image'] = $imageName;
    }

    // 3. التحديث
    $specialization->update($validatedData);

    return redirect()->route('specialization.index')->with('success', 'Specialization updated successfully.');
}

    public function delete($id)
    {
        $specialization = Specialization::findOrFail($id);
        $specialization->delete();
        return redirect()->route('specialization.index')->with('success', 'Specialization deleted successfully.');
    }

}
