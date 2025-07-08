<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::paginate(10);
        return view('admin.categories.index',compact('categories'));
    }
    public function create(){
        
                return view('admin.categories.add');

    }


public function store(Request $request)
{
    // 1. Validation
    $request->validate([
        'name'     => 'required|string|max:255',
        'name_ar'  => 'required|string|max:255',
        'slug'     => 'nullable|string|max:255|unique:categories,slug',
        'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // 2. تجهيز السلاج
    $slug = $request->slug ?? \Str::slug($request->name);

    // 3. رفع الصورة
    $imageName = null;
    if ($request->hasFile('image')) {
        $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();

        // تأكد أن المجلد موجود
        $destination = base_path('assets/category');
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        // رفع الصورة
        $request->image->move($destination, $imageName);
    }

    // 4. حفظ البيانات
    \App\Models\Category::create([
        'name'     => $request->name,
        'name_ar'  => $request->name_ar,
        'slug'     => $slug,
        'image'    => $imageName,
    ]);

    // 5. Redirect
    return redirect()->route('category.index')->with('success', 'تمت إضافة القسم بنجاح');
}


 public function edit($id)
{
    $category = Category::findOrFail($id); // Get the category or fail

    return view('admin.categories.edit', compact('category'));
}
public function update(Request $request, $id)
{    $category = Category::findOrFail($id);

    $request->validate([
        'name'     => 'required|string|max:255',
        'name_ar'  => 'required|string|max:255',
        'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $category->name = $request->name;
    $category->name_ar = $request->name_ar;
    $category->slug = Str::slug($request->name);

   if ($request->hasFile('image')) {
        $destination = base_path('assets/category');

        // حذف الصورة القديمة لو موجودة
        if ($category->image && file_exists($destination . '/' . $category->image)) {
            unlink($destination . '/' . $category->image);
        }

        // اسم جديد للصورة
        $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();

        // تأكد أن المجلد موجود
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        // رفع الصورة
        $request->image->move($destination, $imageName);

        // حفظ اسم الصورة
        $category->image = $imageName;
    }

$category->save();


    return redirect()->route('category.index')->with('success', 'تم تحديث القسم بنجاح ✅');
}

 public function delete($id)
{
    $category = Category::findOrFail($id);

    // تعديل المسار لمجلد categories مباشرة
    if ($category->image && file_exists(base_path('assets/category/' . $category->image))) {
        unlink(base_path('assets/category/' . $category->image));
    }

    $category->delete();

 return redirect()->back()->with('success', 'تمت حذف القسم بنجاح');

}
}
