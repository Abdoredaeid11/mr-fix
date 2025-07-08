@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add Specialization</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('specialization.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- الاسم بالإنجليزية --}}
            <div class="mb-3">
                <label for="name" class="form-label">Specialization Name (EN)</label>
                <input type="text" name="name" id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="e.g. Electric Fix">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- الاسم بالعربية --}}
            <div class="mb-3">
                <label for="name_ar" class="form-label">Specialization Name (AR)</label>
                <input type="text" name="name_ar" id="name_ar"
                       class="form-control @error('name_ar') is-invalid @enderror"
                       value="{{ old('name_ar') }}" placeholder="مثال: صيانة كهرباء">
                @error('name_ar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- وصف التخصص --}}
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description"
                          class="form-control @error('description') is-invalid @enderror"
                          rows="3" placeholder="Short description...">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- التصنيف --}}
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id"
                        class="form-control @error('category_id') is-invalid @enderror">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- الصورة --}}
            <div class="mb-3">
                <label for="image" class="form-label">Specialization Image</label>
                <input type="file" name="image" id="image"
                       class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('specialization.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
