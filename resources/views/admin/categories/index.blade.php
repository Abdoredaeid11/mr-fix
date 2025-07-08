@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">{{ __(key: 'message.categories') }}</div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <a href="{{route('category.create')}}" class="btn btn-primary">{{ __('message.Add') }}</a>
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
                        <th>{{ __('message.name') }}</th>
                        <th>{{ __('message.name_ar') }}</th>
                        <th>{{ __('message.slug') }}</th>
                        <th>{{ __('message.image') }}</th>              
                        <th>{{ __('message.actions') }}</th>

                   
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->name_ar }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                @if ($category->image)
                                    <img src="{{ asset('assets/category/' . $category->image) }}" width="60" height="60" loading="lazy">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                           <td class="text-nowrap">
    <div class="d-flex align-items-center">
        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-success me-2">
            {{ __('message.edit') }}
        </a>
        <form action="{{ route('category.delete', $category->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
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
                {{ $categories->links() }}
            </div>


        </div>
    </div>
@endsection
