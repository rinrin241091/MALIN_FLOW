
<form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="name" placeholder="Tên" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Số điện thoại" required>
    <input type="password" name="password" placeholder="Mật khẩu" required>
    <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
    <input type="text" name="address" placeholder="Địa chỉ" required>
    <input type="file" name="image" placeholder="Ảnh đại diện" required>
    <button type="submit">Thêm thành viên</button>
    <a href="{{ Route('dashboard.index') }}">Quay lại</a>
</form>
