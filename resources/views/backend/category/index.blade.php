@extends('backend.dashboard.layout')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Quản lý danh mục</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <a href="{{ route('category.create') }}" class="btn btn-primary mb-3">Thêm danh mục</a>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="textcenter">STT</th>
                    <th class="textcenter">Tên danh mục</th>
                    <th class="textcenter">Loại</th>
                    <th class="textcenter">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $index => $category)
                    @include('backend.category.category_row', ['category' => $category, 'index' => $index + 1, 'level' => 0])
                @empty
                    <tr>
                        <td colsan="4" class="text-center">Không có danh mục nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection