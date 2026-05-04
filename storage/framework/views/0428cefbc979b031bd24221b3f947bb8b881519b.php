    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo e(URL::asset('build/img/favicon.png')); ?>">

    <!-- Apple Icon -->
    <link rel="apple-touch-icon" href="<?php echo e(URL::asset('build/img/apple-icon.png')); ?>">

<?php if(!Route::is(['layout-mini', 'layout-hidden', 'layout-hover-view', 'layout-full-width', 'layout-rtl', 'login-basic', 'login-illustration', 'login-cover', 'login', 'register-basic', 'register-illustration', 'register-cover', 'forgot-password-basic', 'forgot-password-illustration', 'forgot-password-cover', 'reset-password-basic', 'reset-password-illustration', 'reset-password-cover', 'email-verification-basic', 'email-verification-illustration', 'email-verification-cover', 'success-basic', 'success-illustration', 'success-cover', 'two-step-verification-basic', 'two-step-verification-illustration', 'two-step-verification-cover', 'lock-screen', 'error-404', 'error-500', 'coming-soon', 'under-maintenance'])): ?>
    <!-- Theme Config Js -->
    <?php if(app()->getLocale()=='en'): ?>
    <script src="<?php echo e(URL::asset('build/js/theme-script.js')); ?>"></script>
<?php endif; ?>
<?php endif; ?>

    <?php if(app()->getLocale()=='en'): ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/bootstrap.min.css')); ?>">
<?php endif; ?>

    <?php if(app()->getLocale()=='ar'): ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/bootstrap.rtl.min.css')); ?>">
<?php endif; ?>

    <!-- Fontawesome CSS -->
	<link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/fontawesome/css/fontawesome.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/fontawesome/css/all.min.css')); ?>">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/tabler-icons/tabler-icons.min.css')); ?>">

<?php if(Route::is(['icon-bootstrap'])): ?>
    <!-- Bootstrap Icon CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/icons/bootstrap/bootstrap-icons.min.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['icon-feather', 'tables-basic'])): ?>
    <!-- Feather CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/icons/feather/feather.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['icon-flag'])): ?>
    <!-- Flag CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/icons/flags/flags.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['icon-ionic'])): ?>
    <!-- Ionic CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/icons/ionic/ionicons.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['icon-material'])): ?>
    <!-- Material CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/material/materialdesignicons.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['icon-pe7'])): ?>
    <!-- Pe7 CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/icons/pe7/pe-icon-7.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['icon-remix'])): ?>
    <!-- Remix Icon CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/icons/remix/remixicon.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['icon-simpleline'])): ?>
    <!-- Simpleline CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/simpleline/simple-line-icons.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['icon-themify'])): ?>
    <!-- Themify CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/icons/themify/themify.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['icon-typicons'])): ?>
    <!-- Typicon CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/icons/typicons/typicons.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['icon-weather'])): ?>
    <!-- Weather CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/icons/weather/weathericons.css')); ?>">
<?php endif; ?>

    <!-- Simplebar CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/simplebar/simplebar.min.css')); ?>">

    <!-- Daterangepikcer CSS -->
	<link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/daterangepicker/daterangepicker.css')); ?>">
    <?php if(app()->getLocale()=='ar'): ?>
    <!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="<?php echo e(URL::asset('build/css/bootstrap-datetimepicker.min.css')); ?>">
    <?php endif; ?>

    <!-- Bootstrap Tagsinput CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')); ?>">


<?php if(Route::is(['contact-messages', 'create-patient', 'edit-patient', 'new-appointment', 'patient-details', 'patients-doctor-details', 'security-settings', 'ticket-details', 'tickets'])): ?>
	<!-- intltelinput CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/intltelinput/css/intlTelInput.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/intltelinput/css/demo.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['assets', 'expenses', 'income', 'invoices', 'patient-details', 'patient-doctor-details', 'payments', 'roles-and-permissions', 'services', 'staffs', 'transactions', 'ui-rangeslider'])): ?>
    <!-- Rangeslider CSS -->
	<link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/ion-rangeslider/css/ion.rangeSlider.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/ion-rangeslider/css/ion.rangeSlider.min.css')); ?>">
<?php endif; ?>

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/dataTables.bootstrap5.min.css')); ?>">

<?php if(Route::is(['notificationsList.create'])): ?>
    <!-- Quill CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/quill/quill.snow.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['form-editors'])): ?>
    <!-- Quill css -->
    <link href="<?php echo e(URL::asset('build/plugins/quill/quill.core.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(URL::asset('build/plugins/quill/quill.snow.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(URL::asset('build/plugins/quill/quill.bubble.css')); ?>" rel="stylesheet" type="text/css">
<?php endif; ?>

<?php if(Route::is(['email-reply', 'search-list', 'social-feed'])): ?>
    <!-- Fancybox -->
	<link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/fancybox/jquery.fancybox.min.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['kanban-view'])): ?>
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/owl.carousel.min.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['chart-c3'])): ?>
    <!-- ChartC3 CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/c3-chart/c3.min.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['chart-morris'])): ?>
    <!-- Morris CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/morris/morris.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['form-pickers', 'kanban-view', 'notes', 'todo-list', 'todo'])): ?>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/flatpickr/flatpickr.min.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['form-range-slider'])): ?>
    <!-- nouisliderribute css -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/nouislider/nouislider.min.css')); ?>">
<?php endif; ?>


    <!-- Choices CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/choices.js/public/assets/styles/choices.min.css')); ?>">


<?php if(Route::is(['form-wizard'])): ?>
    <!-- Wizard CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/twitter-bootstrap-wizard/form-wizard.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['gallery', 'ui-lightbox', 'widgets'])): ?>
    <!-- Glightbox CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/lightbox/glightbox.min.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['maps-leaflet'])): ?>
    <!-- Leaflet Maps CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/leaflet/leaflet.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['maps-vector'])): ?>
    <!-- Jsvector Maps -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/jsvectormap/css/jsvectormap.min.css')); ?>">
<?php endif; ?>

<?php if(Route::is(['ui-sweetalerts'])): ?>
    <!-- Sweetalert2 CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/sweetalert2/sweetalert2.min.css')); ?>">
<?php endif; ?>


    <!-- Toatr CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/toastr/toatr.css')); ?>">


    <!-- Select2 CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/plugins/select2/css/select2.min.css')); ?>">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/style.css')); ?>" id="app-style">








    <style>
        .ms-auto {
            margin-top:auto;;
        }
    </style>
<?php /**PATH C:\xampp\htdocs\Other\randvous\TakafolJoodNew\resources\views/layout_new/partials/head-css.blade.php ENDPATH**/ ?>