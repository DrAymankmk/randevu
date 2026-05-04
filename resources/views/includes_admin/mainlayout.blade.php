<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    @include('includes_admin.head')
    @yield('styles')
</head>
<body dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}" lang="{{app()->getLocale() == 'ar' ? 'ar' : 'en'}}">
<div class="main-wrapper">
    @include('includes_admin.header')
    @include('includes_admin.nav')
    @yield('content')
    @include('includes_admin.footer-scripts')
    @if(auth()->user()->app_type == 5)
        @include('includes_admin.modals.edit')
        @yield('includes')
    @endif

    <div class="sidebar-overlay no-print" data-reff=""></div>
</div>

@yield('scripts')
@if(auth()->user()->app_type == 5)
    <script>
        $('body').on('click', '.update-modal', function (event) {
            event.preventDefault();
            var url, targetModal;
            url = $(this).attr('href');
            targetModal = $('#update-modal');

            // Get contents
            $.ajax({
                method: 'GET',
                url: url,
                success: function (data) {
                    targetModal.find('#updateModalLabel').text(data.title);
                    targetModal.find('.modal-body').html(data.view);

                    // Initialize datetimepicker after loading the content
                    $('.datetimepicker').datetimepicker({
                        format: 'MM-DD-YYYY'
                    });

                },
                error: function () {

                }
            });

            // Show modal
            targetModal.modal();
        });
    </script>
@endif
</body>
</html>

