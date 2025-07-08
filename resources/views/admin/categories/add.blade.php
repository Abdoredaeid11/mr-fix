@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">إضافة عنصر جديد</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- الاسم بالإنجليزية -->
                <div class="col-md-6 mb-3">
                    <label for="name">Name (EN)</label>
                    <input type="text" name="name" id="name"
                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- الاسم بالعربية -->
                <div class="col-md-6 mb-3">
                    <label for="name_ar">الاسم (AR)</label>
                    <input type="text" name="name_ar" id="name_ar"
                        class="form-control {{ $errors->has('name_ar') ? 'is-invalid' : '' }}"
                        value="{{ old('name_ar') }}">
                    @error('name_ar')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- السلاج -->
                <div class="col-md-6 mb-3">
                    <label for="slug">Slug (اختياري)</label>
                    <input type="text" name="slug" id="slug"
                        class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}"
                        value="{{ old('slug') }}">
                    @error('slug')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- الصورة -->
                <div class="col-md-6 mb-3">
                    <label for="image">الصورة</label>
                    <img id="imagePreview" class="image-preview" style="display:none;">
                    <input type="file" name="image" id="image"
                        class="form-control-file {{ $errors->has('image') ? 'is-invalid' : '' }}"
                        accept="image/*"
                        onchange="previewImage(this, 'imagePreview')">
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">حفظ</button>
        </form>
    </div>
</div>

<!-- معاينة الصورة -->
<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            preview.style.width = '150px';
            preview.style.height = '150px';
            preview.style.objectFit = 'cover';
            preview.style.borderRadius = '8px';
            preview.style.marginTop = '10px';
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }
</script>
@endsection
