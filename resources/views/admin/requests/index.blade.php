@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">{{ __(key: 'message.orders') }}</div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('request.create') }}" class="btn btn-primary">{{ __('message.Add') }}</a>
            </div>
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
                    toastr.success('{{ session('success') }}', 'تمت العملية بنجاح!');
                </script>
            @endif
            @if($requests->count()>0)
            <form method="GET" class="mb-3">
        <div style="display: flex; gap: 10px;">
        <input type="date" name="from" value="{{ request('from') }}">
        <input type="date" name="to" value="{{ request('to') }}">

        <select name="status">
            <option value="">All status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>pending</option>
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>in_progress</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>completed</option>
            <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>canceled</option>
        </select>

        <button type="submit">search</button>
     </div>
</form>
@else
@endif
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                     <th>#</th>
<th>{{ __('message.client') }}</th>
<th>{{ __('message.provider') }}</th>
<th>{{ __('message.category') }}</th>
<th>{{ __('message.specialization') }}</th>
<th>{{ __('message.price') }}</th>
<th>{{ __('message.request_date') }}</th>
<th>{{ __('message.status') }}</th>
<th>{{ __('message.actions') }}</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $req)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $req->client->first_name }} {{ $req->client->last_name }}</td>
                            <td>{{ optional($req->provider)->first_name ?? 'غير محدد' }}</td>
                            <td>{{ optional($req->category)->name ?? 'غير محدد' }}</td>
                            <td>{{ optional($req->specialization)->name ?? 'غير محدد' }}</td>
                            <td>{{ number_format($req->price, 2) }} ج</td>
                            <td>
                                @if ($req->created_at)
                                    {{ $req->created_at->format('Y-m-d') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $req->status }}</td>
                <td class="text-nowrap">
    <div class="d-flex align-items-center">
        <a href="{{ route('request.edit', $req->id) }}" class="btn btn-sm btn-success me-2">
            {{ __('message.edit') }}
        </a>
        <form action="" method="POST" onsubmit="return confirm('Are you sure?')">
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
    {{ $requests->links('pagination::bootstrap-5') }}
</div>


        </div>
    </div>
@endsection
