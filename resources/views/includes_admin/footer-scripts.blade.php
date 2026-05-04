@if(auth()->user()->app_type == 2 ||  auth()->user()->app_type == 6)
    {{--    <script>--}}
    {{--        function uploadImage(e) {--}}
    {{--            document.getElementById('avatar').src = URL.createObjectURL(e.target.files[0]);--}}
    {{--        }--}}
    {{--    </script>--}}

    <!-- jQuery -->
    <script src="/reception/assets/js/jquery-3.6.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="/reception/assets/js/bootstrap.bundle.min.js"></script>

    <!-- Feather Js -->
    <script src="/reception/assets/js/feather.min.js"></script>

    <!-- Slimscroll -->
    <script src="/reception/assets/js/jquery.slimscroll.js"></script>


    <script src="/reception/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/reception/assets/plugins/datatables/datatables.min.js"></script>

    @if(Request::segment(2) == 'patients')
        <script src="/reception/assets/js/qr-code.js"></script>
    @endif

    <!-- Select2 Js -->
    <script src="/reception/assets/js/select2.min.js"></script>


{{--    @if(Request::segment(2) == 'add-patient' || Request::segment(2) == 'edit-patient' || (Request::segment(2) == 'appointments') ))--}}
        <!-- Datepicker Core JS -->
        <script src="/reception/assets/plugins/moment/moment.min.js"></script>
        <script src="/reception/assets/js/bootstrap-datetimepicker.min.js"></script>
{{--    @endif--}}

    @if(Request::segment(2) != 'add-patient' || Request::segment(2) != 'edit-patient'))
        <!-- Datatables JS -->
{{--        <script src="/reception/assets/plugins/datatables/jquery.dataTables.min.js"></script>--}}
{{--        <script src="/reception/assets/plugins/datatables/datatables.min.js"></script>--}}

        <!-- counterup JS -->
        <script src="/reception/assets/js/jquery.waypoints.js"></script>
        <script src="/reception/assets/js/jquery.counterup.min.js"></script>

        <!-- Apexchart JS -->
        <script src="/reception/assets/plugins/apexchart/apexcharts.min.js"></script>
        <script src="/reception/assets/plugins/apexchart/chart-data.js"></script>
    @endif

{{--    @if((Request::segment(2) == 'attachments') || (Request::segment(2) == 'appointments') )--}}
{{--        <script src="/reception/assets/plugins/datatables/jquery.dataTables.min.js"></script>--}}
{{--        <script src="/reception/assets/plugins/datatables/datatables.min.js"></script>--}}
{{--    @endif--}}


{{--    <script src="/reception/assets/plugins/moment/moment.min.js"></script>--}}
{{--    <script src="/reception/assets/js/bootstrap-datetimepicker.min.js"></script>--}}




    <!-- Custom JS -->
    <script src="/reception/assets/js/app.js"></script>

@else
    <!-- jQuery -->
    <script src="/assets/js/jquery-3.6.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="/assets/js/bootstrap.bundle.min.js"></script>

    <!-- Feather Js -->
    <script src="/assets/js/feather.min.js"></script>

    <!-- Slimscroll -->
    <script src="/assets/js/jquery.slimscroll.js"></script>

    <!-- Select2 Js -->
    <script src="/assets/js/select2.min.js"></script>

    <!-- Datatables JS -->
    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables/datatables.min.js"></script>

    {{--@if( Request::segment(2) == 'notifications')--}}
    <!-- Datepicker Core JS -->
    <script src="/assets/plugins/moment/moment.min.js"></script>
    <script src="/assets/js/bootstrap-datetimepicker.min.js"></script>
    {{--@endif--}}

    <!-- counterup JS -->
    <script src="/assets/js/jquery.waypoints.js"></script>
    <script src="/assets/js/jquery.counterup.min.js"></script>

    <!-- Apexchart JS -->
    <script src="/assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="/assets/plugins/apexchart/chart-data.js"></script>

    <!-- Circle Progress JS -->
    <script src="/assets/js/circle-progress.min.js"></script>

    <!-- Custom JS -->
    <script src="/assets/js/app.js"></script>

@endif

<link rel="stylesheet" href="{{ asset('/admin/js/noty/noty.css') }}">
<script src="{{ asset('/admin/js/noty/noty.min.js') }}"></script>

<script src="{{asset('admin/js/notify/bootstrap-notify.min.js')}}"></script>


@if (session('success'))

    <script>
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: "{{ session('success') }}",
            timeout: 2000,
            killer: true
        }).show();
    </script>
@endif

@if (session('error'))
    <script>
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: "{{ session('error') }}",
            timeout: 2000,
            killer: true
        }).show();
    </script>
@endif

@if (session('failed'))
    <script>
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: "{{ session('failed') }}",
            timeout: 2000,
            killer: true
        }).show();
    </script>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            new Noty({
                type: 'error',
                layout: 'topRight',
                text: "{{ $error }}",
                timeout: 3000,
                killer: true
            }).show();
        </script>
    @endforeach
@endif


<script>
    $(document).ready(function () {
        $('.delete-confirm').on('click', function(e) {
            e.preventDefault();
            var deleteUrl = $(this).data('delete-url');
            var rowToDelete = $(this).closest('.row-to-delete'); // Assuming each row has a class 'row-to-delete'
            var modal = $(this).closest('.modal');
            // Send AJAX request to delete the row
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Remove the row from the UI
                    rowToDelete.remove();
                    modal.modal('hide');

                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: response,
                        timeout: 2000,
                        killer: true
                    }).show();
                    // Optionally, you can show a success message using Noty or any other notification library
                },
                error: function(xhr, status, error) {
                    // Handle error, show error message if necessary
                }
            });
        });

        // if($('.datetimepicker').length > 0) {
        //     $('.datetimepicker').datetimepicker({
        //         format: 'YYYY-MM-DD'
        //     });
        // }
        });
</script>
