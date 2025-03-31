<!-- jQuery -->
<script src="{{ asset('backend/js/jquery-2.1.1.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>

<!-- MetisMenu Plugin JavaScript -->
<script src="{{ asset('backend/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>

<!-- SlimScroll -->
<script src="{{ asset('backend/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('backend/js/inspinia.js') }}"></script>
<script src="{{ asset('backend/js/plugins/pace/pace.min.js') }}"></script>

<!-- jQuery UI -->
<script src="{{ asset('backend/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<script src="{{ asset('backend/library/library.js') }}"></script>
<script src="{{ asset('backend/js/bulk-actions.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Initialize metisMenu -->
<script>
$(function() {
    $('#side-menu').metisMenu();
});
</script>

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
