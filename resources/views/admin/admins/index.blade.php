@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">{{ __(key: 'message.admins') }}</div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('admin.create') }}" class="btn btn-primary">{{ __('message.Add') }}</a>
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
        <th>{{ __('message.first_name') }}</th>
        <th>{{ __('message.last_name') }}</th>
        <th>{{ __('message.email') }}</th>
        <th>{{ __('message.phone') }}</th>
        <th>{{ __('message.status') }}</th>
        <th>{{ __('message.actions') }}</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($admins as $admin)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $admin->first_name }}</td>
            <td>{{ $admin->last_name }}</td>
            <td>{{ $admin->email }}</td>
            <td>{{ $admin->phone }}</td>

            <td>{{ $admin->status }}</td>
       <td class="text-nowrap">
    <div class="d-flex align-items-center">
        <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-sm btn-success me-2">
            {{ __('message.edit') }}
        </a>
        <form action="{{ route('admin.delete', $admin->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">
                {{ __('message.delete') }}
            </button>
        </form>
    </div>
</td>

        </tr>
        @endforeach
    </tbody>
</table>

            <div class="card-sub d-flex justify-content-center">
                {{ $admins->links() }}
            </div>


        </div>
    </div>
@endsection
