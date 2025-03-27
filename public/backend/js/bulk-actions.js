document.addEventListener('DOMContentLoaded', function () {
    const checkAll = document.getElementById('checkAll');
    const checkBoxItems = document.querySelectorAll('.checkBoxItem');
    const selectedCount = document.getElementById('selected-count');

    // Cập nhật số lượng thành viên được chọn
    const updateSelectedCount = () => {
        const checkedItems = document.querySelectorAll('.checkBoxItem:checked');
        selectedCount.textContent = `Đã chọn: ${checkedItems.length} thành viên`;
    };

    // Xử lý "Chọn tất cả"
    checkAll.addEventListener('change', function () {
        checkBoxItems.forEach(item => {
            item.checked = checkAll.checked;
        });
        updateSelectedCount();
    });

    // Xử lý khi thay đổi trạng thái ô tick
    checkBoxItems.forEach(item => {
        item.addEventListener('change', function () {
            if (!this.checked) {
                checkAll.checked = false;
            }
            updateSelectedCount();
        });
    });

    // Ngăn submit form nếu không chọn bản ghi
    document.getElementById('bulk-action-form').addEventListener('submit', function (e) {
        const checkedItems = document.querySelectorAll('.checkBoxItem:checked');
        if (checkedItems.length === 0) {
            e.preventDefault();
            alert('Vui lòng chọn ít nhất một thành viên để xóa.');
        }
    });

    // Cập nhật số lượng ban đầu
    updateSelectedCount();
    
    // Xử lý mở modal chỉnh sửa
    const editButtons = document.querySelectorAll('.btn-edit-user');
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const email = this.getAttribute('data-email');
            const phone = this.getAttribute('data-phone');
            const address = this.getAttribute('data-address');
            const image = this.getAttribute('data-image');

            // Điền dữ liệu vào form trong modal
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_phone').value = phone;
            document.getElementById('edit_address').value = address;

            // Hiển thị ảnh hiện tại
            const imagePreview = document.getElementById('edit_image_preview');
            if (image) {
                imagePreview.src = image;
                imagePreview.style.display = 'block';
            } else {
                imagePreview.style.display = 'none';
            }

            // Thiết lập action cho form
            const form = document.getElementById('editUserForm');
            form.action = `/user/${userId}`; // Route user.update
        });
    });

    // Xử lý nút "Cập nhật" trong modal
    document.getElementById('saveUserChanges').addEventListener('click', function () {
        const form = document.getElementById('editUserForm');
        form.submit();
    });
});

