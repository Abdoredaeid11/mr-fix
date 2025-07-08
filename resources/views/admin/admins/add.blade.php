@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('message.add_admin') }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- First Name -->
                <div class="col-md-6 mb-3">
                    <label for="first_name">{{ __('message.first_name') }}</label>
                    <input type="text" name="first_name" id="first_name"
                        class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                        value="{{ old('first_name') }}">
                    @error('first_name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="col-md-6 mb-3">
                    <label for="last_name">{{ __('message.last_name') }}</label>
                    <input type="text" name="last_name" id="last_name"
                        class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                        value="{{ old('last_name') }}">
                    @error('last_name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="col-md-6 mb-3">
                    <label for="email">{{ __('message.email') }}</label>
                    <input type="email" name="email" id="email"
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="col-md-6 mb-3">
                    <label for="phone">{{ __('message.phone') }}</label>
                    <input type="text" name="phone" id="phone"
                        class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                        value="{{ old('phone') }}">
                    @error('phone')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="col-md-6 mb-3">
                    <label for="password">{{ __('message.password') }}</label>
                    <input type="password" name="password" id="password"
                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="col-md-6 mb-3">
                    <label for="password_confirmation">{{ __('message.confirm_password') }}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="form-control">
                </div>

                <!-- Address -->
                <div class="col-md-6 mb-3">
                    <label for="address">{{ __('message.address') }}</label>
                    <input type="text" name="address" id="address"
                        class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                        value="{{ old('address') }}">
                    @error('address')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Country -->
                <div class="col-md-6 mb-3">
                    <label for="country">{{ __('message.country') }}</label>
                    <input type="text" name="country" id="country"
                        class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}"
                        value="{{ old('country') }}">
                    @error('country')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Region -->
                <div class="col-md-6 mb-3">
                    <label for="region">{{ __('message.region') }}</label>
                    <input type="text" name="region" id="region"
                        class="form-control {{ $errors->has('region') ? 'is-invalid' : '' }}"
                        value="{{ old('region') }}">
                    @error('region')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Avatar -->
                <div class="col-md-6 mb-3">
                    <label for="avatar">{{ __('message.avatar') }}</label>
                    <img id="avatarPreview" class="avatar-preview" style="display:none; width:150px; height:150px; object-fit:cover; border-radius:8px; margin-top:10px;">
                    <input type="file" name="avatar" id="avatar"
                        class="form-control-file {{ $errors->has('avatar') ? 'is-invalid' : '' }}"
                        accept="image/*"
                        onchange="previewImage(this, 'avatarPreview')">
                    @error('avatar')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <button type="submit" class="btn btn-primary mt-3">
                {{ __('message.save') }}
            </button>
        </form>
    </div>
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
        } else {
            preview.style.display = 'none';
        }
    }
</script>

<style>
    .avatar-preview {
        width: 150px !important;
        height: 150px !important;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 10px;
    }
</style>

@endsection
