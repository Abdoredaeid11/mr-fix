@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">{{ __('message.kycs') }}</div>
        </div>
        <div class="card-body">
            

            @if (session('success'))
                <script>
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": 5000,
                        "positionClass": "toast-top-center",
                        "newestOnTop": true,
                        "preventDuplicates": true
                    };
                    toastr.success('{{ session('success') }}', '{{ __('message.success_message') }}');
                </script>
            @endif

                  @if ($kycs->count() > 0)
                <form method="GET" action="{{ route('kyc.index') }}" class="mb-3">
                    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">

                        {{-- فلترة حسب الدور --}}
                        <select name="role" class="form-control" style="width: 200px;">
                            <option value="">{{ __('message.all') }}</option>
                            <option value="worker" {{ request('role') == 'worker' ? 'selected' : '' }}>
                                {{ __('message.worker') }}</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>
                                {{ __('message.user') }}</option>
                        </select>

                        <button type="submit" class="btn btn-primary">{{ __('message.search') }}</button>

                        @if (request()->has('role'))
                            <a href="{{ route('kyc.index') }}" class="btn btn-secondary">{{ __('message.reset') }}</a>
                        @endif
                    </div>
                </form>
            @else

            @endif

            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('message.name') }}</th>
                        <th>{{ __('message.email') }}</th>
                        <th>{{ __('message.phone') }}</th>
                        <th>{{ __('message.image') }}</th>
                        <th>{{ __('message.status') }}</th>
                        <th>{{ __('message.rejection_reason') }}</th>
                        <th>{{ __('message.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kycs as $kyc)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kyc->worker->first_name }} {{ $kyc->worker->last_name }}</td>
                            <td>{{ $kyc->worker->email }}</td>
                            <td>{{ $kyc->worker->phone }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kycModal"
                                    onclick="previewKycImages(
                                        '{{ asset( $kyc->front_image) }}',
                                        '{{ asset( $kyc->back_image) }}',
                                        '{{ asset( $kyc->selfie_image) }}'
                                    )">
                                    {{ __('message.view_images') }}
                                </button>
                            </td>
                            <td>
                                @if ($kyc->status == 'approved')
                                    <span class="badge bg-success">{{ __('message.approved') }}</span>
                                @elseif ($kyc->status == 'rejected')
                                    <span class="badge bg-danger">{{ __('message.rejected') }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ __('message.pending') }}</span>
                                @endif
                            </td>
                            <td>{{ $kyc->rejection_reason ?? '—' }}</td>
                            <td class="text-nowrap">
    <div class="d-flex align-items-center">
        @if ($kyc->status == 'pending')
            <form action="{{ route('kyc.approve', $kyc->id) }}" method="POST" class="me-2" onsubmit="return confirm('{{ __('message.confirm_approve') }}')">
                @csrf
                <button class="btn btn-sm btn-success">
                    {{ __('message.approve') }}
                </button>
            </form>

            <a href="{{ route('kyc.rejectForm', $kyc->id) }}" class="btn btn-sm btn-danger">
                {{ __('message.reject') }}
            </a>

        @elseif ($kyc->status == 'rejected')
            <form action="{{ route('kyc.approve', $kyc->id) }}" method="POST" onsubmit="return confirm('{{ __('message.confirm_approve') }}')">
                @csrf
                <button class="btn btn-sm btn-success">
                    {{ __('message.approve') }}
                </button>
            </form>

        @elseif ($kyc->status == 'approved')
            <a href="{{ route('kyc.rejectForm', $kyc->id) }}" class="btn btn-sm btn-danger">
                {{ __('message.reject') }}
            </a>
        @endif
    </div>
</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="card-sub d-flex justify-content-center">
                {{ $kycs->links() }}
            </div>
        </div>
    </div>

    <!-- KYC Image Modal -->
    <div class="modal fade" id="kycModal" tabindex="-1" aria-labelledby="kycModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('message.kyc_images') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-around flex-wrap">
                    <div class="text-center m-2">
                        <h6>{{ __('message.front_id') }}</h6>
                        <img id="frontImage" src="" class="img-fluid rounded border" style="max-height: 300px;">
                    </div>
                    <div class="text-center m-2">
                        <h6>{{ __('message.back_id') }}</h6>
                        <img id="backImage" src="" class="img-fluid rounded border" style="max-height: 300px;">
                    </div>
                    <div class="text-center m-2">
                        <h6>{{ __('message.selfie') }}</h6>
                        <img id="selfieImage" src="" class="img-fluid rounded border" style="max-height: 300px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewKycImages(front, back, selfie) {
            document.getElementById('frontImage').src = front;
            document.getElementById('backImage').src = back;
            document.getElementById('selfieImage').src = selfie;
        }
    </script>
@endsection
