@extends('admin.layout.master')

@section('content')
<style>
    .image-preview {
        width: 150px !important;
        height: 150px !important;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 10px;
    }
</style>

<div class="container">
    <h1>{{ __('message.edit_category') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
 
    <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Name English -->
            <div class="col-md-6 mb-3">
                <label for="name">{{ __('message.name') }}</label>
                <input type="text" name="name" id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $category->name) }}">
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Name Arabic -->
            <div class="col-md-6 mb-3">
                <label for="name_ar">{{ __('message.name_ar') }}</label>
                <input type="text" name="name_ar" id="name_ar"
                    class="form-control @error('name_ar') is-invalid @enderror"
                    value="{{ old('name_ar', $category->name_ar) }}">
                @error('name_ar')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Slug -->
            <div class="col-md-6 mb-3">
                <label for="slug">{{ __('message.slug') }}</label>
                <input type="text" name="slug" id="slug"
                    class="form-control @error('slug') is-invalid @enderror"
                    value="{{ old('slug', $category->slug) }}">
                @error('slug')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Image -->
            <div class="col-md-6 mb-3">
                <label for="image">{{ __('message.image') }}</label>

                <img
                    src="{{ $category->image ? asset('assets/category/' . $category->image) : '#' }}"
                    class="image-preview"
                    id="imagePreview"
                    style="{{ $category->image ? '' : 'display: none;' }}"
                >

                <input type="file" name="image" id="image"
                    class="form-control-file @error('image') is-invalid @enderror"
                    onchange="previewImage(this, 'imagePreview')" accept="image/*">
                @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">{{ __('message.update_category') }}</button>
    </form>
</div>

<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
