@extends('backend.dashboard.layout')

@section('title', 'Thêm mới kho lưu trữ')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Quản lý danh mục</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('category.warehouses') }}">Kho lưu trữ</a>
            </li>
            <li class="active">
                <strong>Thêm mới</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Thêm mới kho lưu trữ</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="{{ route('category.warehouses.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="fond_id">Phông</label>
                            <select name="fond_id" id="fond_id" class="form-control" required>
                                <option value="">Chọn phông</option>
                                @foreach($fonds as $fond)
                                    <option value="{{ $fond->id }}">{{ $fond->name }}</option>
                                @endforeach
                            </select>
                            @error('fond_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Tên kho</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="location">Vị trí</label>
                            <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}">
                        </div>
                        <div class="form-group">
                            <label for="capacity">Sức chứa</label>
                            <input type="number" name="capacity" id="capacity" class="form-control" value="{{ old('capacity') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <a href="{{ route('category.warehouses') }}" class="btn btn-default">Hủy</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection