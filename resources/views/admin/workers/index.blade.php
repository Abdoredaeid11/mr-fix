@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">{{ __(key: 'message.workers') }}</div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <a href="{{route('worker.create')}}" class="btn btn-primary">{{ __('message.Add') }}</a>
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
            <form method="GET" action="{{ route('worker.index') }}" class="mb-3">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث بالاسم أو الإيميل" class="form-control" style="max-width: 300px; display: inline-block;">
    <button type="submit" class="btn btn-primary">بحث</button>
</form>
    <table class="table table-striped mt-3">
    <thead>
      <tr>
        <th>#</th>
        <th>{{ __('message.first_name') }}</th>
        <th>{{ __('message.last_name') }}</th>
        <th>{{ __('message.email') }}</th>
        <th>{{ __('message.phone') }}</th>

        <th>{{ __('message.image') }}</th>
        <th>{{ __('message.status') }}</th>
        <th>{{ __('message.role') }}</th>
        <th> {{ __('message.actions') }}</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($workers as $worker)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $worker->first_name }}</td>
            <td>{{ $worker->last_name }}</td>
            <td>{{ $worker->email }}</td>
            <td>{{ $worker->phone }}</td>

            <td>
                @if($worker->avatar)
                    <img src="{{ asset('storage/'.$worker->avatar) }}" width="60" height="60" loading="lazy">
                @else
                    <span class="text-muted">No image</span>
                @endif
            </td>
            <td>{{ $worker->status }}</td>
            <td>{{ $worker->role }}</td>
<td class="text-nowrap">
    <div class="d-flex align-items-center">
        <a href="{{ route('worker.edit', $worker->id) }}" class="btn btn-sm btn-success me-2">
            {{ __('message.edit') }}
        </a>
        <form action="{{ route('worker.delete', $worker->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
                {{ $workers->links() }}
            </div>


        </div>
    </div>
@endsection
