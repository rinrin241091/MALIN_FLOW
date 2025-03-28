@extends('backend.dashboard.layout')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Sửa tài liệu</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <form method="POST" action="{{ route('document.update', $document->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Tiêu đề tài liệu <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $document->title }}" required>
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id">Danh mục <span class="text-danger">*</span></label>
                <select class="form-control" id="category_id" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $document->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('document.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</div>
@endsection