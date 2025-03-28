<div class="filter-wrapper">
    <div class="uk-flex uk-flex-middle uk-flex-space-between">
        <div class="action">
            <form action="{{ route('user.index') }}" method="GET">
                <div class="uk-flex uk-flex-middle">
                    <!-- Dropdown chọn số lượng bản ghi -->
                    <div class="perpage mr10">
                        <select name="perpage" class="form-control input-sm perpage filter" onchange="this.form.submit()">
                            @for($i = 20; $i <= 200; $i+=20)
                                <option value="{{ $i }}" {{ request('perpage', 20) == $i ? 'selected' : '' }}>{{ $i }} bản ghi</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Dropdown chọn nhóm thành viên -->
                    <div class="user-catalogue mr10">
                        <select name="user_catalogue_id" class="form-control" onchange="this.form.submit()">
                            <option value="0" {{ request('user_catalogue_id', 0) == 0 ? 'selected' : '' }}>Chọn nhóm thành viên</option>
                            <option value="1" {{ request('user_catalogue_id') == 1 ? 'selected' : '' }}>Quản trị viên</option>
                        </select>
                    </div>

                    <!-- Ô tìm kiếm -->
                    <div class="input-group">
                        <input
                            type="text"
                            name="keyword"
                            value="{{ request('keyword') }}"
                            placeholder="Nhập từ khóa bạn muốn tìm kiếm...."
                            class="form-control"
                        >
                        <span class="input-group-btn">
                            <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm">
                                Tìm kiếm
                            </button>
                        </span>
                    </div>

                    <!-- Nút thêm mới thành viên -->
                    @can('add user')
                        <a href="{{ route('user.addUser') }}" class="btn btn-danger ml10">
                            <i class="fa fa-plus mr5"></i>Thêm mới thành viên
                        </a>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>