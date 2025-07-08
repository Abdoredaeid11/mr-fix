@extends('admin.layout.master')

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Add Request</h3>
  </div>
  <div class="card-body">
    <form action="{{ route('request.store') }}" method="POST">
      @csrf

      <div class="row">
        {{-- Client --}}
        <div class="col-md-6 mb-3">
          <label for="client_id">Client</label>
          <select name="client_id" id="client_id" class="form-control @error('client_id') is-invalid @enderror">
            <option value="">-- Select Client --</option>
            @foreach($clients as $client)
              <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                {{ $client->first_name }} {{ $client->last_name }}
              </option>
            @endforeach
          </select>
          @error('client_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Provider --}}
        <div class="col-md-6 mb-3">
          <label for="provider_id">Provider</label>
          <select name="provider_id" id="provider_id" class="form-control @error('provider_id') is-invalid @enderror">
            <option value="">-- Select Provider --</option>
            @foreach($providers as $prov)
              <option value="{{ $prov->id }}" {{ old('provider_id') == $prov->id ? 'selected' : '' }}>
                {{ $prov->first_name }} {{ $prov->last_name }}
              </option>
            @endforeach
          </select>
          @error('provider_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Category --}}
        <div class="col-md-6 mb-3">
          <label for="category_id">Category</label>
          <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
            <option value="">-- Select Category --</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
          @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-3">
  <label for="status">Status</label>
  <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
    <option value="">-- Select Status --</option>
    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
  </select>
  @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

        {{-- Specialization --}}
        <div class="col-md-6 mb-3">
          <label for="specialization_id">Specialization</label>
          <select name="specialization_id" id="specialization_id" class="form-control @error('specialization_id') is-invalid @enderror">
            <option value="">-- Select Specialization --</option>
            @foreach($specializations as $spec)
              <option value="{{ $spec->id }}" {{ old('specialization_id') == $spec->id ? 'selected' : '' }}>
                {{ $spec->name }}
              </option>
            @endforeach
          </select>
          @error('specialization_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Price --}}
        <div class="col-md-6 mb-3">
          <label for="price">Price</label>
          <input type="number" step="0.01" name="price" id="price"
                 class="form-control @error('price') is-invalid @enderror"
                 value="{{ old('price') }}">
          @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>

      <button type="submit" class="btn btn-primary mt-3">Save Request</button>
    </form>
  </div>
</div>
@endsection
