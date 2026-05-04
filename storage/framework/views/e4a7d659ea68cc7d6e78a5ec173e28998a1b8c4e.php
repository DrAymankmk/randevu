<?php $page = 'appointments-list'; ?>

<?php $__env->startSection('content'); ?>

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">

            <!-- Start Page Header -->
            <div class="d-flex align-items-sm-center flex-sm-row flex-column gap-2 pb-3 mb-3 border-1 border-bottom">
                <div class="flex-grow-1">
                    <h4 class="fw-semibold mb-0"> <?php echo app('translator')->get('admin.reception.appointments_list'); ?> </h4>
                </div>
                <div class="text-end d-flex">
                    <!-- dropdown-->













                    <div class="bg-white border shadow-sm rounded px-1 pb-0 text-center d-flex align-items-center justify-content-center">
                        <a href="<?php echo e(route('appointments-list')); ?>" class="bg-light rounded p-1 d-flex align-items-center justify-content-center"> <i class="ti ti-list fs-14 text-dark"></i></a>
                    </div>

                </div>
            </div>
            <!-- End Page Header -->

            <!--  Start Filter -->
            <div class=" d-flex align-items-center justify-content-between flex-wrap">
                <div class="d-flex align-items-center gap-2">
                    <div class="search-set mb-3">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <div class="table-search d-flex align-items-center mb-0">
                                <div class="search-input">
                                    <a href="javascript:void(0);" class="btn-searchset"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex table-dropdown mb-3 right-content align-items-center flex-wrap row-gap-3">
                    <div class="dropdown me-2">
                        <a href="javascript:void(0);" class="bg-white border rounded btn btn-md text-dark fs-14 py-1 align-items-center d-flex fw-normal" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="ti ti-filter text-gray-5 me-1"></i><?php echo app('translator')->get('admin.Filters'); ?>
                        </a>
                        <div class="dropdown-menu dropdown-lg dropdown-menu-end filter-dropdown p-0" id="filter-dropdown">
                            <div class="d-flex align-items-center justify-content-between border-bottom filter-header">
                                <h4 class="mb-0 fw-bold"><?php echo app('translator')->get('admin.Filter'); ?></h4>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);" class="link-danger text-decoration-underline"><?php echo app('translator')->get('admin.Clear All'); ?></a>
                                </div>
                            </div>
                            <form method="GET" action="<?php echo e(route('appointments-list')); ?>">
                                <div class="filter-body pb-0">
                                    
                                    <div class="mb-3">
                                        <label class="form-label"><?php echo app('translator')->get('admin.Doctor'); ?></label>
                                        <select name="doctor_id" class="form-select">
                                            <option value="">All</option>
                                            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($doctor->id); ?>" <?php echo e(request('doctor_id') == $doctor->id ? 'selected' : ''); ?>>
                                                    <?php echo e($doctor->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    
                                    <div class="mb-3">
                                        <label class="form-label"><?php echo app('translator')->get('admin.Date'); ?></label>
                                        <input type="date" class="form-control" name="date" value="<?php echo e(request('date')); ?>">
                                    </div>

                                    
                                    <div class="mb-3">
                                        <label class="form-label"><?php echo app('translator')->get('admin.reservation_status'); ?></label>
                                        <select name="status_id" class="form-select">
                                            <option value="">All</option>
                                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($status->id); ?>" <?php echo e(request('status_id') == $status->id ? 'selected' : ''); ?>>
                                                    <?php echo e(app()->getLocale() == 'en' ? $status->name_en : $status->name_ar); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="filter-footer d-flex align-items-center justify-content-end border-top">
                                    <a href="<?php echo e(route('appointments-list')); ?>" class="btn btn-light btn-md me-2 fw-medium"><?php echo app('translator')->get('admin.Clear'); ?></a>
                                    <button type="submit" class="btn btn-primary btn-md fw-medium"><?php echo app('translator')->get('admin.Filter'); ?></button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="dropdown">
                        <a href="javascript:void(0);"
                           class="dropdown-toggle btn bg-white btn-md d-inline-flex align-items-center fw-normal rounded border text-dark px-2 py-1 fs-14"
                           data-bs-toggle="dropdown">
                            <span class="me-1"><?php echo app('translator')->get('admin.Sort By'); ?> :</span>
                            <?php echo e(request('sort') === 'oldest' ? __('admin.Oldest') : __('admin.Recent')); ?>

                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-2">
                            <li>
                                <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'recent'])); ?>"
                                   class="dropdown-item rounded-1">
                                    <?php echo app('translator')->get('admin.Recent'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'oldest'])); ?>"
                                   class="dropdown-item rounded-1">
                                    <?php echo app('translator')->get('admin.Oldest'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
            <!--  End Filter -->

            <!--  Start Table -->
            <div class="table-responsive">
                <table class="table datatable table-nowrap">
                    <thead class="">
                    <tr>
                        <td>#</td>
                        <th><?php echo app('translator')->get('admin.reservation_number'); ?></th>
                        <th><?php echo app('translator')->get('admin.date'); ?></th>
                        <th><?php echo app('translator')->get('admin.specialize'); ?></th>
                        <th><?php echo app('translator')->get('admin.doctor_name'); ?></th>
                        <th><?php echo app('translator')->get('admin.patient_name'); ?></th>
                        <th><?php echo app('translator')->get('admin.file_type'); ?></th>
                        <th><?php echo app('translator')->get('admin.file_number'); ?></th>
                        <th><?php echo app('translator')->get('admin.reservation_status'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $data['reservations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($index  + 1); ?></td>
                            <td><?php echo e($reservation->booking_number); ?></td>
                            <td><?php echo e($reservation->date); ?> <?php echo e($reservation->appointment); ?></td>
                            <?php $__currentLoopData = $reservation->doctor->specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $special): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td><?php echo e(app()->getLocale() == 'en' ? $special->specialties->name_en ?? null : $special->specialties->name_ar ?? null); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <td><?php echo e($reservation->doctor->name); ?></td>
                            <td class="profile-image"><a
                                    href="<?php echo e(route('appointments',$reservation->user_id)); ?>"><img
                                        width="28" height="28"
                                        src="<?php echo e($reservation->user->image ?? null); ?>"
                                        class="rounded-circle m-r-5"
                                        alt=""><?php echo e(collect(explode('-', $reservation->user->name ?? ''))->take(2)->join(' ')); ?></a></td>
                            <td><?php if($reservation->user->company_id != null): ?>
                                    <?php echo app('translator')->get('admin.insurance'); ?>
                                <?php else: ?>
                                    <?php echo app('translator')->get('admin.cash'); ?>
                                <?php endif; ?></td>
                            <td><a><?php echo e($reservation->user->file_number); ?></a></td>
                            <td><?php echo e(app()->getLocale() == 'en' ? $reservation->reservation_status->name_en ?? null : $reservation->reservation_status->name_ar ?? null); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <?php echo e($data['reservations']->links()); ?>

            </div>

            <!--  End Table -->

        </div>
        <!-- End Content -->

        <?php $__env->startComponent('components.footer'); ?>
        <?php echo $__env->renderComponent(); ?>

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout_new.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Other\randvous\TakafolJoodNew\resources\views/main_admin/appointments.blade.php ENDPATH**/ ?>