<form id="bulk-action-form" action="{{ route('user.bulkDelete') }}" method="POST">
    @csrf
    @method('DELETE')
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" value="" id="checkAll" class="input-checkAll"> 
                    </th>
                    <th class="text-center">STT</th>
                    <th style="width:90px">Avatar</th>
                    <th class="text-center">Họ tên</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Số điện thoại</th>
                    <th class="text-center">Địa chỉ</th>
                    <th class="text-center">Active-user</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if(@isset($users) && is_object($users) && $users->count() > 0)
                    @foreach($users as $key => $user)
                        <tr>
                            <td>
                                <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="input-checkbox checkBoxItem"> 
                            </td>
                            <td>
                                {{ ($users->currentPage() - 1) * $users->perPage() + $key + 1 }}
                            </td>
                            <td>
                                @if($user->image)
                                    <img src="{{ asset($user->image) }}" alt="User Avatar" class="avatar-img" width="50">
                                @else
                                    <span>User Avatar</span>
                                @endif
                            </td>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                {{ $user->phone }}
                            </td>
                            <td>
                                {{ $user->address }}
                            </td>
                            <td class="text-center"> 
                                <input type="checkbox" class="js-switch" {{ $user->status ? 'checked' : '' }} data-user-id="{{ $user->id }}" onchange="toggleUserStatus(this)" />
                            </td>
                            <td class="text-center"> 
                                @can('edit user')
                                    <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-success">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                                @can('delete user')
                                    <form action="{{ route('user.destroy', ['id' => $user->id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa thành viên này?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="text-center">Không tìm thấy thành viên nào.</td>
                    </tr>    
                @endif
            </tbody>
        </table>
    </div>
    @can('delete user')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa các thành viên đã chọn?')">Xóa hàng loạt</button>
    @endcan
</form>

</script>
<!-- Thêm Switchery và SweetAlert2 -->
<link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JavaScript -->
<script>
    document.querySelectorAll('.js-switch').forEach(function(element) {
        new Switchery(element, { color: '#1ab394' });
    });

    // Chọn tất cả checkbox
    document.getElementById('checkAll').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.checkBoxItem');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Hàm thay đổi trạng thái user
    function toggleUserStatus(element) {
        const userId = element.getAttribute('data-user-id');
        const newStatus = element.checked ? 1 : 0; // true -> 1, false -> 0

        Swal.fire({
            title: 'Xác nhận',
            text: `Bạn có chắc chắn muốn ${newStatus ? 'kích hoạt' : 'vô hiệu hóa'} tài khoản này?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Có',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('{{ route('user.toggleStatus') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Thành công!', data.message, 'success');
                    } else {
                        Swal.fire('Lỗi!', data.message, 'error');
                        element.checked = !element.checked; // Hoàn tác nếu có lỗi
                    }
                })
                .catch(error => {
                    Swal.fire('Lỗi!', 'Có lỗi xảy ra khi cập nhật trạng thái.', 'error');
                    element.checked = !element.checked; // Hoàn tác nếu có lỗi
                });
            } else {
                element.checked = !element.checked; // Hoàn tác nếu người dùng hủy
            }
        });
    }
</script>