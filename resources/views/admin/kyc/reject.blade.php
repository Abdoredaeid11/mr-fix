@extends('admin.layout.master')

@section('title', 'رفض التحقق')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">رفض طلب التحقق</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('kyc.reject', $kyc->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="rejection_reason">سبب الرفض:</label>
                <textarea name="rejection_reason" id="rejection_reason" rows="4" class="form-control" required>{{ old('rejection_reason') }}</textarea>
                @error('rejection_reason')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-danger">رفض الطلب</button>
                <a href="{{ route('kyc.index') }}" class="btn btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
