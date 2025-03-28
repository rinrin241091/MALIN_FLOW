@extends('backend.dashboard.layout')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Quản lý tài liệu</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <a href="{{ route('document.create') }}" class="btn btn-primary mb-3">Thêm tài liệu</a>
        <table class="table table-scriped table-bordered">
            <thead>
                <tr>
                    <th class="text-center">STT</th> 
                    <th class="text-center">Tiêu đề</th> 
                    <th class="text-center">Mã định danh</th> 
                    <th class="text-center">Danh mục</th> 
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $index => $document)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $document->title }}</td>
                        <td class="text-center">{{ $document->identifier }}</td>
                        <td>{{ $document->category->name }}</td>
                        <td class="text-center">
                            <a href="{{ route('document.edit', $document->id) }}" class="btn btn-success btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('document.destroy', $document->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa tài liệu này?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Không có tài liệu nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection