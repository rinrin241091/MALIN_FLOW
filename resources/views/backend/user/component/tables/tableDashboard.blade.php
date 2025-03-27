<form id="bulk-action-form" action="{{ route('user.bulkDelete') }}" method="POST">
    @csrf
    @method('DELETE')
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
            <th class="text-center">Trạng thái</th>
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
                        <td>
                            <img src="{{ asset('storage/' . $user->image) }}" alt="User Avatar">
                        </td>
                        <td>
                            {{$user->name}}
                        </td>
                        <td>
                            {{$user->email}}
                        </td>
                        <td>
                            {{$user->phone}}
                        </td>
                        <td>
                            {{$user->address}}
                        </td>
                        <td class="text-center"> 
                            <input type="checkbox" class="js-switch" {{ $user->isOnline() ? 'checked' : '' }} disabled />
                        </td>
                        <td class="text-center"> 
                            @can('edit user')
                                <a href="{{ route('user.edit', ['id' => $user->id])}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('delete user')
                                <form action="{{ route('user.destroy', ['id' => $user->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center">Không tìm thấy thành viên nào.</td>
                </tr>    
            @endif
        </tbody>
    </table>
    @can('delete user')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa các thành viên đã chọn?')">Xóa hàng loạt</button>
    @endcan
</form>