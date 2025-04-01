$(document).ready(function() {
    // Lấy tất cả các input fields trừ select phông
    const $inputs = $('input, textarea').not('#fond_id');
    const $submitBtn = $('button[type="submit"]');

    // Hàm kiểm tra và toggle trạng thái các fields
    function toggleFields() {
        const fondSelected = $('#fond_id').val() !== '' && $('#fond_id').val() !== null;
        
        // Toggle trạng thái disabled của các input
        $inputs.prop('disabled', !fondSelected);
        
        // Nếu không có phông được chọn, xóa giá trị các input
        if (!fondSelected) {
            $inputs.val('');
        }
        
        // Toggle nút submit
        $submitBtn.prop('disabled', !fondSelected);
    }

    // Chạy lần đầu khi load trang
    toggleFields();

    // Thêm event listener cho select phông
    $('#fond_id').on('change', function() {
        toggleFields();
    });

    // Thêm class cho các trường bắt buộc
    $('label').each(function() {
        if ($(this).text().includes('*')) {
            $(this).addClass('required-field');
        }
    });

    // Style cho các trường disabled
    $inputs.on('mouseenter', function() {
        if ($(this).prop('disabled')) {
            $(this).attr('title', 'Vui lòng chọn phông trước');
        }
    });
  
    
    if ($.fn.select2) {
        $('#fond_id').select2({
            placeholder: 'Chọn phông',
            allowClear: true
        });
    }
});