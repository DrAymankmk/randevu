<?php
    use App\Models\AppType;
    use Carbon\Carbon;
?>



<?php $__env->startSection('content'); ?>

    <div class="page-wrapper">
        <div class="content pb-0">

            <!-- Page Header -->
            <div class="d-flex align-items-sm-center justify-content-between flex-wrap gap-2 mb-4">
                <h4 class="fw-bold mb-0"><?php echo e(trans('admin.Admin Dashboard')); ?></h4>
            </div>

            <!-- =======================
                TOP STAT CARDS
            ======================== -->
            <div class="row">
                <?php
                    $bgColors = ['bg-primary','bg-success','bg-danger','bg-warning','bg-info','bg-secondary'];
                ?>

                <?php $__currentLoopData = $data['app_types']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $bgColor = $bgColors[$loop->index % count($bgColors)]; ?>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="position-relative border card rounded-2 shadow-sm">
                            <img src="<?php echo e(asset('build/img/bg/bg-01.svg')); ?>" class="position-absolute start-0 top-0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                <span class="avatar <?php echo e($bgColor); ?> rounded-circle">
                                    <i class="ti ti-calendar-heart fs-24"></i>
                                </span>
                                    <div class="text-end">
                                    <span class="badge <?php echo e($app_type->growth_percent >= 0 ? 'bg-success' : 'bg-danger'); ?>">
                                        <?php echo e($app_type->growth_percent >= 0 ? '+' : ''); ?><?php echo e($app_type->growth_percent); ?>%
                                    </span>
                                        <p class="fs-13 mb-0"><?php echo app('translator')->get('main.in last 7 Days'); ?></p>
                                    </div>
                                </div>
                                <p class="mb-1">
                                    <?php echo e(app()->getLocale() == 'en' ? $app_type->name_en : $app_type->name_ar); ?>

                                </p>
                                <h3 class="fw-bold mb-0"><?php echo e($app_type->accounts_count); ?></h3>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- =======================
                STATISTICS + POPULAR DOCTORS
            ======================== -->
            <div class="row">
                <div class="col-xl-8">

                    <!-- Appointment Statistics -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="fw-bold mb-0"><?php echo app('translator')->get('main.Appointment Statistics'); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2 mb-3">
                                <?php $__currentLoopData = $data['statuses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="bg-light border p-2 text-center rounded-2">
                                            <p class="mb-1">
                                                <i class="ti ti-point-filled <?php echo e($status->color); ?>"></i>
                                                <?php echo e(app()->getLocale() == 'en' ? $status->name_en : $status->name_ar); ?>

                                            </p>
                                            <h5 class="fw-bold mb-0"><?php echo e($status->reservations_count); ?></h5>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div id="s-col-19"></div>
                        </div>
                    </div>

                    <!-- Popular Doctors -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="fw-bold mb-0"><?php echo app('translator')->get('main.Popular Doctors'); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <?php $__currentLoopData = $data['top_doctors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-4">
                                        <div class="border rounded-2 p-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="<?php echo e($doctor->image); ?>" class="rounded-circle me-2" width="45">
                                                <div>
                                                    <strong>Dr. <?php echo e($doctor->name); ?></strong>
                                                    <div class="fs-13 text-muted">
                                                        <?php echo e($doctor->reservations_count); ?> <?php echo app('translator')->get('main.Bookings'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>

                    <!-- =======================
                        EXPIRING CLINICS
                    ======================== -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="fw-bold mb-0"><?php echo app('translator')->get('main.Clinics Expiring Soon'); ?></h5>

                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-white" data-bs-toggle="dropdown">
                                    <span id="expiryLabel"><?php echo app('translator')->get('main.Weekly'); ?></span>
                                    <i class="ti ti-chevron-down ms-1"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item expiry-btn" data-target="week" href="#"><?php echo app('translator')->get('main.Weekly'); ?></a></li>
                                    <li><a class="dropdown-item expiry-btn" data-target="month" href="#"><?php echo app('translator')->get('main.Monthly'); ?></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-body">

                            <!-- WEEK -->
                            <div id="expiry-week">
                                <div class="row g-3">
                                    <?php $__empty_1 = true; $__currentLoopData = $data['expiring_clinics_week']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clinic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="col-md-4">
                                            <div class="border rounded-2 p-3 h-100">
                                                <img src="<?php echo e($clinic->image); ?>" class="rounded-circle me-2" width="45">
                                                <h6 class="fw-semibold"><?php echo e($clinic->name); ?></h6>
                                                <span class="badge badge-soft-danger">
                                                <?php echo app('translator')->get('main.Expiry Date'); ?>:
                                                <?php echo e(Carbon::parse($clinic->package_end_date)->translatedFormat('d M Y')); ?>

                                            </span>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <p class="text-muted"><?php echo app('translator')->get('main.No clinics expiring this week'); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- MONTH -->
                            <div id="expiry-month" class="d-none">
                                <div class="row g-3">
                                    <?php $__empty_1 = true; $__currentLoopData = $data['expiring_clinics_month']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clinic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="col-md-4">
                                            <div class="border rounded-2 p-3 h-100">
                                                <h6 class="fw-semibold"><?php echo e($clinic->name); ?></h6>
                                                <span class="badge badge-soft-warning">
                                                <?php echo app('translator')->get('main.Expiry Date'); ?>:
                                                <?php echo e(Carbon::parse($clinic->package_end_date)->translatedFormat('d M Y')); ?>

                                            </span>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <p class="text-muted"><?php echo app('translator')->get('main.No clinics expiring this month'); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- Right Column Appointments -->
                <div class="col-xl-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="fw-bold mb-0"><?php echo app('translator')->get('main.Appointments'); ?></h5>
                        </div>
                        <div class="card-body">
                            <?php $__currentLoopData = $data['appointments']->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-light p-3 rounded-2 mb-2">
                                    <strong><?php echo e($appointment->doctor->name); ?></strong>
                                    <div class="fs-13 text-muted">
                                        <?php
                                            [$start, $end] = explode(' - ', $appointment->appointment);

                                            $startDate = \Carbon\Carbon::parse($appointment->date . ' ' . $start);
                                            $endDate   = \Carbon\Carbon::parse($appointment->date . ' ' . $end);
                                        ?>

                                        <?php echo e($startDate->translatedFormat('D, d M Y, h:i A')); ?>

                                        -
                                        <?php echo e($endDate->translatedFormat('h:i A')); ?>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('appointments-list')); ?>" class="btn btn-light w-100">
                                <?php echo app('translator')->get('main.View All Appointments'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php $__env->startComponent('components.footer'); ?> <?php echo $__env->renderComponent(); ?>
    </div>

    <!-- Toggle Script -->
    <script>
        document.querySelectorAll('.expiry-btn').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                document.getElementById('expiry-week').classList.add('d-none');
                document.getElementById('expiry-month').classList.add('d-none');
                document.getElementById('expiry-' + btn.dataset.target).classList.remove('d-none');
                document.getElementById('expiryLabel').innerText = btn.innerText;
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout_new.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Other\randvous\TakafolJoodNew\resources\views/home/main_dashboard.blade.php ENDPATH**/ ?>