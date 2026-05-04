    <!-- Favicon -->
    <link rel="shortcut icon" href="{{URL::asset('build/img/favicon.png')}}">

    <!-- Apple Icon -->
    <link rel="apple-touch-icon" href="{{URL::asset('build/img/apple-icon.png')}}">

@if (!Route::is(['layout-mini', 'layout-hidden', 'layout-hover-view', 'layout-full-width', 'layout-rtl', 'login-basic', 'login-illustration', 'login-cover', 'login', 'register-basic', 'register-illustration', 'register-cover', 'forgot-password-basic', 'forgot-password-illustration', 'forgot-password-cover', 'reset-password-basic', 'reset-password-illustration', 'reset-password-cover', 'email-verification-basic', 'email-verification-illustration', 'email-verification-cover', 'success-basic', 'success-illustration', 'success-cover', 'two-step-verification-basic', 'two-step-verification-illustration', 'two-step-verification-cover', 'lock-screen', 'error-404', 'error-500', 'coming-soon', 'under-maintenance']))
    <!-- Theme Config Js -->
    @if(app()->getLocale()=='en')
    <script src="{{URL::asset('build/js/theme-script.js')}}"></script>
@endif
@endif

    @if(app()->getLocale()=='en')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/css/bootstrap.min.css')}}">
@endif

    @if(app()->getLocale()=='ar')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/css/bootstrap.rtl.min.css')}}">
@endif

    <!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{URL::asset('build/plugins/fontawesome/css/fontawesome.min.css')}}">
	<link rel="stylesheet" href="{{URL::asset('build/plugins/fontawesome/css/all.min.css')}}">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/tabler-icons/tabler-icons.min.css')}}">

@if (Route::is(['icon-bootstrap']))
    <!-- Bootstrap Icon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/bootstrap/bootstrap-icons.min.css')}}">
@endif

@if (Route::is(['icon-feather', 'tables-basic']))
    <!-- Feather CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/feather/feather.css')}}">
@endif

@if (Route::is(['icon-flag']))
    <!-- Flag CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/flags/flags.css')}}">
@endif

@if (Route::is(['icon-ionic']))
    <!-- Ionic CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/ionic/ionicons.css')}}">
@endif

@if (Route::is(['icon-material']))
    <!-- Material CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/material/materialdesignicons.css')}}">
@endif

@if (Route::is(['icon-pe7']))
    <!-- Pe7 CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/pe7/pe-icon-7.css')}}">
@endif

@if (Route::is(['icon-remix']))
    <!-- Remix Icon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/remix/remixicon.css')}}">
@endif

@if (Route::is(['icon-simpleline']))
    <!-- Simpleline CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/simpleline/simple-line-icons.css')}}">
@endif

@if (Route::is(['icon-themify']))
    <!-- Themify CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/themify/themify.css')}}">
@endif

@if (Route::is(['icon-typicons']))
    <!-- Typicon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/typicons/typicons.css')}}">
@endif

@if (Route::is(['icon-weather']))
    <!-- Weather CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/weather/weathericons.css')}}">
@endif

    <!-- Simplebar CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/simplebar/simplebar.min.css')}}">

    <!-- Daterangepikcer CSS -->
	<link rel="stylesheet" href="{{URL::asset('build/plugins/daterangepicker/daterangepicker.css')}}">
    @if(app()->getLocale()=='ar')
    <!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{URL::asset('build/css/bootstrap-datetimepicker.min.css')}}">
    @endif

    <!-- Bootstrap Tagsinput CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">


@if (Route::is(['contact-messages', 'create-patient', 'edit-patient', 'new-appointment', 'patient-details', 'patients-doctor-details', 'security-settings', 'ticket-details', 'tickets']))
	<!-- intltelinput CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/intltelinput/css/intlTelInput.css')}}">
    <link rel="stylesheet" href="{{URL::asset('build/plugins/intltelinput/css/demo.css')}}">
@endif

@if (Route::is(['assets', 'expenses', 'income', 'invoices', 'patient-details', 'patient-doctor-details', 'payments', 'roles-and-permissions', 'services', 'staffs', 'transactions', 'ui-rangeslider']))
    <!-- Rangeslider CSS -->
	<link rel="stylesheet" href="{{URL::asset('build/plugins/ion-rangeslider/css/ion.rangeSlider.css')}}">
	<link rel="stylesheet" href="{{URL::asset('build/plugins/ion-rangeslider/css/ion.rangeSlider.min.css')}}">
@endif

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/css/dataTables.bootstrap5.min.css')}}">

@if (Route::is(['notificationsList.create']))
    <!-- Quill CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/quill/quill.snow.css')}}">
@endif

@if (Route::is(['form-editors']))
    <!-- Quill css -->
    <link href="{{URL::asset('build/plugins/quill/quill.core.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('build/plugins/quill/quill.snow.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('build/plugins/quill/quill.bubble.css')}}" rel="stylesheet" type="text/css">
@endif

@if (Route::is(['email-reply', 'search-list', 'social-feed']))
    <!-- Fancybox -->
	<link rel="stylesheet" href="{{URL::asset('build/plugins/fancybox/jquery.fancybox.min.css')}}">
@endif

@if (Route::is(['kanban-view']))
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{URL::asset('build/css/owl.carousel.min.css')}}">
@endif

@if (Route::is(['chart-c3']))
    <!-- ChartC3 CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/c3-chart/c3.min.css')}}">
@endif

@if (Route::is(['chart-morris']))
    <!-- Morris CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/morris/morris.css')}}">
@endif

@if (Route::is(['form-pickers', 'kanban-view', 'notes', 'todo-list', 'todo']))
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/flatpickr/flatpickr.min.css')}}">
@endif

@if (Route::is(['form-range-slider']))
    <!-- nouisliderribute css -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/nouislider/nouislider.min.css')}}">
@endif

{{--@if (Route::is(['notificationsList.create']))--}}
    <!-- Choices CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/choices.js/public/assets/styles/choices.min.css')}}">
{{--@endif--}}

@if (Route::is(['form-wizard']))
    <!-- Wizard CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/twitter-bootstrap-wizard/form-wizard.css')}}">
@endif

@if (Route::is(['gallery', 'ui-lightbox', 'widgets']))
    <!-- Glightbox CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/lightbox/glightbox.min.css')}}">
@endif

@if (Route::is(['maps-leaflet']))
    <!-- Leaflet Maps CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/leaflet/leaflet.css')}}">
@endif

@if (Route::is(['maps-vector']))
    <!-- Jsvector Maps -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/jsvectormap/css/jsvectormap.min.css')}}">
@endif

@if (Route::is(['ui-sweetalerts']))
    <!-- Sweetalert2 CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/sweetalert2/sweetalert2.min.css')}}">
@endif


    <!-- Toatr CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/toastr/toatr.css')}}">


    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/select2/css/select2.min.css')}}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/css/style.css')}}" id="app-style">

{{--    <link href='https://fonts.googleapis.com/css?family=Tajawal' rel='stylesheet'>--}}
{{--    <style type="text/css">--}}
{{--        body, h1, h2, h3, h4, h5, h6, * {--}}
{{--            font-family: 'Tajawal';--}}
{{--        }--}}
{{--    </style>--}}

    <style>
        .ms-auto {
            margin-top:auto;;
        }
    </style>
