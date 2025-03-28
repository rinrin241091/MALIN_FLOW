<div class="ibox-tools">
    <a class="collapse-link" data-toggle="tooltip" title="Thu gọn/Mở rộng">
        <i class="fa fa-chevron-up"></i>
    </a>
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" data-toggle="tooltip" title="Tùy chọn">
        <i class="fa fa-wrench"></i>
    </a>
    <ul class="dropdown-menu dropdown-user">
        <li><a href="#">Config option 1</a></li>
        <li><a href="#">Config option 2</a></li>
    </ul>
    <a class="close-link" data-toggle="tooltip" title="Đóng">
        <i class="fa fa-times"></i>
    </a>
</div>

<!-- Khởi tạo tooltip -->
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>