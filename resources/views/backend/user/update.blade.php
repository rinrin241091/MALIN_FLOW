
<div class="row mt20">
    <div class="col-lg-6 col-md-8 col-sm-12 mx-auto">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Cập nhật thông tin thành viên</h5>
            </div>
            <div class="ibox-content">
                <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    @method('PUT')

                    <!-- Tên -->
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Tên <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Số điện thoại -->
                    <div class="form-group">
                        <label for="phone" class="col-sm-3 control-label">Số điện thoại <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Mật khẩu -->
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Mật khẩu mới</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Để trống nếu không muốn thay đổi">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Địa chỉ -->
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label">Địa chỉ <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}" required>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Ảnh đại diện -->
                    <div class="form-group">
                        <label for="image" class="col-sm-3 control-label">Ảnh đại diện</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control-file" id="image" name="image">
                            @if($user->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $user->image) }}" alt="Avatar" class="img-thumbnail" style="max-width: 100px;">
                                </div>
                            @endif
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Nút Cập nhật -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">Hủy</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .form-horizontal .form-group {
    margin-bottom: 20px;
}
.form-horizontal .control-label {
    font-weight: 600;
}
.form-horizontal .form-control {
    border-radius: 5px;
    box-shadow: none;
    transition: border-color 0.3s ease;
}
.form-horizontal .form-control:focus {
    border-color: #1ab394;
    box-shadow: 0 0 5px rgba(26, 179, 148, 0.3);
}
.text-danger {
    font-size: 0.9em;
    margin-top: 5px;
    display: block;
}
.btn-primary {
    background-color: #1ab394;
    border-color: #1ab394;
    transition: background-color 0.3s ease;
}
.btn-primary:hover {
    background-color: #179d82;
    border-color: #179d82;
}

</style>
