<!-- Mainly scripts -->

<script src="backend/js/bootstrap.min.js"></script>
<script src="backend/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="backend/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="backend/library/library.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/3.0.7/metisMenu.min.js"></script>
<!-- Trong script.blade.php -->
<script src="{{ asset('backend/js/bulk-actions.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- jQuery UI -->
<script src="backend/js/plugins/jquery-ui/jquery-ui.min.js"></script>
@if(isset($config['js']) && is_array($config['js']))
    @foreach($config['js'] as $key => $val)
        {!! '<script src="'.$val.'"></script>' !!}
    @endforeach
@endif


@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@endif

<script>
    $(document).ready(function () {
        $('#side-menu').metisMenu();  
    });
</script>