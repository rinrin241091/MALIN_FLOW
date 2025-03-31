document.addEventListener('DOMContentLoaded', function () {
    // Get elements
    const checkAll = document.getElementById('checkAll');
    const checkBoxItems = document.querySelectorAll('.checkBoxItem');
    const selectedCount = document.getElementById('selected-count');
    const bulkActionForm = document.getElementById('bulk-action-form');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');

    console.log('Form action:', bulkActionForm ? bulkActionForm.action : 'Form not found');
    console.log('Delete button:', bulkDeleteBtn ? 'Found' : 'Not found');

    // Kiểm tra xem các element có tồn tại không
    if (!bulkActionForm || !selectedCount) {
        console.error('Required elements not found');
        return;
    }

    // Cập nhật số lượng thành viên được chọn
    const updateSelectedCount = () => {
        const checkedItems = document.querySelectorAll('.checkBoxItem:checked');
        console.log('Checked items:', checkedItems.length);
        if (selectedCount) {
            selectedCount.textContent = `Đã chọn: ${checkedItems.length} thành viên`;
        }
        
        // Disable/Enable nút xóa hàng loạt
        if (bulkDeleteBtn) {
            bulkDeleteBtn.disabled = checkedItems.length === 0;
        }
    };

    // Xử lý "Chọn tất cả"
    if (checkAll) {
        checkAll.addEventListener('change', function () {
            checkBoxItems.forEach(item => {
                item.checked = checkAll.checked;
            });
            updateSelectedCount();
        });
    }

    // Xử lý khi thay đổi trạng thái ô tick
    checkBoxItems.forEach(item => {
        item.addEventListener('change', function () {
            if (!this.checked && checkAll) {
                checkAll.checked = false;
            }
            updateSelectedCount();
        });
    });

    // Xử lý submit form xóa hàng loạt
    if (bulkActionForm) {
        bulkActionForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const checkedItems = document.querySelectorAll('.checkBoxItem:checked');
            
            if (checkedItems.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cảnh báo',
                    text: 'Vui lòng chọn ít nhất một thành viên để xóa.'
                });
                return;
            }

            Swal.fire({
                title: 'Xác nhận xóa',
                text: `Bạn có chắc chắn muốn xóa ${checkedItems.length} thành viên đã chọn?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Có, xóa!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tạo FormData từ form
                    const formData = new FormData(bulkActionForm);
                    
                    // Thêm các user_ids vào FormData
                    checkedItems.forEach(item => {
                        formData.append('user_ids[]', item.value);
                    });

                    // Submit using fetch
                    fetch(bulkActionForm.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            throw new Error(data.message || 'Thao tác không thành công');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: error.message || 'Có lỗi xảy ra khi thực hiện thao tác'
                        });
                    });
                }
            });
        });
    }

    // Cập nhật số lượng ban đầu
    updateSelectedCount();
    
    // Xử lý mở modal chỉnh sửa
    const editButtons = document.querySelectorAll('.btn-edit-user');
    if (editButtons.length > 0) {
        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const userId = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const email = this.getAttribute('data-email');
                const phone = this.getAttribute('data-phone');
                const address = this.getAttribute('data-address');
                const image = this.getAttribute('data-image');

                // Điền dữ liệu vào form trong modal
                const editNameInput = document.getElementById('edit_name');
                const editEmailInput = document.getElementById('edit_email');
                const editPhoneInput = document.getElementById('edit_phone');
                const editAddressInput = document.getElementById('edit_address');
                const imagePreview = document.getElementById('edit_image_preview');
                const editForm = document.getElementById('editUserForm');

                if (editNameInput) editNameInput.value = name || '';
                if (editEmailInput) editEmailInput.value = email || '';
                if (editPhoneInput) editPhoneInput.value = phone || '';
                if (editAddressInput) editAddressInput.value = address || '';

                // Hiển thị ảnh hiện tại
                if (imagePreview) {
                    if (image) {
                        imagePreview.src = image;
                        imagePreview.style.display = 'block';
                    } else {
                        imagePreview.style.display = 'none';
                    }
                }

                // Thiết lập action cho form
                if (editForm) {
                    editForm.action = `/user/${userId}`; // Route user.update
                }
            });
        });
    }

    // Xử lý nút "Cập nhật" trong modal
    const saveUserChangesBtn = document.getElementById('saveUserChanges');
    if (saveUserChangesBtn) {
        saveUserChangesBtn.addEventListener('click', function () {
            const editForm = document.getElementById('editUserForm');
            if (editForm) {
                editForm.submit();
            }
        });
    }
});

