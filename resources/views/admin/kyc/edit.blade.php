@extends('admin.layout.master')

@section('content')
<style>
    .avatar-preview {
        width: 150px !important;
        height: 150px !important;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 10px;
    }
</style>

<div class="container">
    <h1>{{ __('message.edit_user') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('worker.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- First Name -->
            <div class="col-md-6 mb-3">
                <label for="first_name">{{ __('message.first_name') }}</label>
                <input type="text" name="first_name" id="first_name"
                    class="form-control @error('first_name') is-invalid @enderror"
                    value="{{ old('first_name', $user->first_name) }}">
                @error('first_name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Last Name -->
            <div class="col-md-6 mb-3">
                <label for="last_name">{{ __('message.last_name') }}</label>
                <input type="text" name="last_name" id="last_name"
                    class="form-control @error('last_name') is-invalid @enderror"
                    value="{{ old('last_name', $user->last_name) }}">
                @error('last_name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="col-md-6 mb-3">
                <label for="email">{{ __('message.email') }}</label>
                <input type="email" name="email" id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}">
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone -->
            <div class="col-md-6 mb-3">
                <label for="phone">{{ __('message.phone') }}</label>
                <input type="text" name="phone" id="phone"
                    class="form-control @error('phone') is-invalid @enderror"
                    value="{{ old('phone', $user->phone) }}">
                @error('phone')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="col-md-6 mb-3">
                <label for="password">{{ __('message.password') }}</label>
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="{{ __('message.leave_blank_if_no_change') }}">
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="col-md-6 mb-3">
                <label for="password_confirmation">{{ __('message.confirm_password') }}</label>
                <input type="password" name="password" id="password"
               class="form-control @error('password') is-invalid @enderror"
                placeholder="{{ __('message.leave_blank_if_no_change') }}">
                @error('password_confirmation')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Address -->
            <div class="col-md-6 mb-3">
                <label for="address">{{ __('message.address') }}</label>
                <input type="text" name="address" id="address"
                    class="form-control @error('address') is-invalid @enderror"
                    value="{{ old('address', $user->address) }}">
                @error('address')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Country -->
            <div class="col-md-6 mb-3">
                <label for="country">{{ __('message.country') }}</label>
                <input type="text" name="country" id="country"
                    class="form-control @error('country') is-invalid @enderror"
                    value="{{ old('country', $user->country) }}">
                @error('country')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Region -->
            <div class="col-md-6 mb-3">
                <label for="region">{{ __('message.region') }}</label>
                <input type="text" name="region" id="region"
                    class="form-control @error('region') is-invalid @enderror"
                    value="{{ old('region', $user->region) }}">
                @error('region')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Avatar -->
            <div class="col-md-6 mb-3">
                <label for="avatar">{{ __('message.avatar') }}</label>

                <img
                    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : '#' }}"
                    class="avatar-preview"
                    id="avatarPreview"
                    style="{{ $user->avatar ? '' : 'display: none;' }}"
                >

                <input type="file" name="avatar" id="avatar"
                    class="form-control-file @error('avatar') is-invalid @enderror"
                    onchange="previewImage(this, 'avatarPreview')" accept="image/*">
                @error('avatar')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">{{ __('message.update_user') }}</button>
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
