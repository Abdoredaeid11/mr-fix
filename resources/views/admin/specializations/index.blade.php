@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">{{ __(key: 'message.services') }}</div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('specialization.create') }}" class="btn btn-primary">{{ __('message.Add') }}</a>
            </div>
            @if (session('success'))
                <script>
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": 5000, // الوقت بالـ milliseconds (هنا 5 ثواني)
                        "positionClass": "toast-top-center", // تغيير مكان الرسالة
                        "newestOnTop": true, // ظهور الرسائل الجديدة في الأعلى
                        "preventDuplicates": true // منع ظهور نفس الرسالة أكثر من مرة
                    };
                    toastr.success('{{ session('success') }}', 'تمت العملية بنجاح!');
                </script>
            @endif
            <table class="table table-striped mt-3">
    <thead>
        <tr>
            <th>#</th>
<th>{{ __('message.image') }}</th>
<th>{{ __('message.specialization_name') }}</th>
<th>{{ __('message.category') }}</th>
<th>{{ __('message.actions') }}</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($specializations as $spec)
            <tr>
                <td>{{ $loop->iteration }}</td>

                {{-- ✅ الصورة --}}
                <td>
                    @if ($spec->image)
                        <img src="{{ asset('assets/specializations/' . $spec->image) }}" alt="image" width="60" height="60" style="object-fit: cover; border-radius: 6px;">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>

                <td>{{ $spec->name }}</td>
                <td>{{ optional($spec->category)->name ?? 'Not Assigned' }}</td>
                <td>
                    <a href="{{ route('specialization.edit', $spec->id) }}" class="btn btn-sm btn-success">
                        {{ __('message.edit') }}
                    </a>
                    <form action="{{ route('specialization.delete', $spec->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">
                            {{ __('message.delete') }}
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


            <div class="card-sub d-flex justify-content-center">
{{ $specializations->links('pagination::bootstrap-5') }}
            </div>


        </div>
    </div>
@endsection
