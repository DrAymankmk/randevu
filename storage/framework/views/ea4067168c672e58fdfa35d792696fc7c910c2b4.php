<?php $page = 'clinics'; ?>

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
                    <h4 class="fw-bold mb-0"><?php echo e(trans('main.clinics')); ?> <span class="badge badge-soft-primary fw-medium border py-1 px-2 border-primary fs-13 ms-1"><?php echo e(trans('main.Total Clinics')); ?> : <?php echo e($clinics->total()); ?></span></h4>
                </div>
                <div class="text-end d-flex">
                    <!-- dropdown-->
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    <div class="bg-white border shadow-sm rounded px-1 pb-0 text-center d-flex align-items-center justify-content-center">
                        <a href="<?php echo e(route('clinics')); ?>" class="bg-light rounded p-1 d-flex align-items-center justify-content-center"> <i class="ti ti-list fs-14 text-dark"></i></a>
                    </div>

                    <a href="<?php echo e(route('add-clinic')); ?>" class="btn btn-primary ms-2 fs-13 btn-md"><i class="ti ti-plus me-1"></i><?php echo e(trans('main.add_clinic')); ?></a>
                </div>
            </div>
            <!-- End Page Header -->

            <!--  Start Filter -->
            <div class=" d-flex align-items-center justify-content-between flex-wrap">
                <div>
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
                            <i class="ti ti-filter text-gray-5 me-1"></i><?php echo e(trans('admin.Filters')); ?>

                        </a>
                        <div class="dropdown-menu dropdown-lg dropdown-menu-end filter-dropdown p-0" id="filter-dropdown">
                            <div class="d-flex align-items-center justify-content-between border-bottom filter-header">
                                <h4 class="mb-0 fw-bold"><?php echo e(trans('admin.Filter')); ?></h4>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);" class="link-danger text-decoration-underline"><?php echo e(trans('admin.Clear All')); ?></a>
                                </div>
                            </div>
                            <form action="#">
                                <div class="filter-body pb-0">
                                    <div class="mb-3">
                                        <label class="form-label mb-1 text-dark fs-14 fw-medium">Date<span class="text-danger">*</span></label>
                                        <div class="input-icon-end position-relative">
                                            <input type="text" class="form-control bookingrange" placeholder="dd/mm/yyyy">
                                            <span class="input-icon-addon">
                                                <i class="ti ti-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <label class="form-label">Status</label>
                                            <a href="javascript:void(0);" class="link-primary mb-1">Reset</a>
                                        </div>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" class="dropdown-toggle btn bg-white  d-flex align-items-center justify-content-start fs-13 p-2 fw-normal border" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                                                Select <i class="ti ti-chevron-down ms-auto"></i>
                                            </a>
                                            <div class="dropdown-menu shadow-lg w-100 dropdown-info p-3">
                                                <ul class="mb-3">
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                                            <input class="form-check-input m-0 me-2" type="checkbox">
                                                            Available
                                                        </label>
                                                    </li>
                                                    <li class="mb-0">
                                                        <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                                            <input class="form-check-input m-0 me-2" type="checkbox">
                                                            Unavailable
                                                        </label>
                                                    </li>
                                                </ul>
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <a href="javascript:void(0);" class="btn btn-outline-white w-100 close-filter">Cancel</a>
                                                    </div>
                                                    <div class="col-6">
                                                        <a href="javascript:void(0);" class="btn btn-primary w-100">Select</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter-footer d-flex align-items-center justify-content-end border-top">
                                    <a href="javascript:void(0);" class="btn btn-light btn-md me-2 fw-medium" id="close-filter"><?php echo e(trans('main.Close')); ?></a>
                                    <button type="submit" class="btn btn-primary btn-md fw-medium"><?php echo e(trans('admin.Filter')); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle btn bg-white btn-md d-inline-flex align-items-center fw-normal rounded border text-dark px-2 py-1 fs-14" data-bs-toggle="dropdown">
                            <span  class="me-1"> <?php echo e(trans('admin.Sort By')); ?> : </span>  <?php echo e(trans('admin.Recent')); ?>

                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-2">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1"><?php echo e(trans('admin.Recent')); ?></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1"><?php echo e(trans('admin.Oldest')); ?></a>
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
                        <th><?php echo app('translator')->get('admin.image'); ?></th>
                        <th><?php echo app('translator')->get('main.package'); ?></th>
                        <th><?php echo app('translator')->get('main.expired_date'); ?></th>
                        <th><?php echo app('translator')->get('main.no.branches'); ?></th>
                        <th><?php echo e(trans('admin.Created Date')); ?></th>
                        <th><?php echo app('translator')->get('admin.status'); ?></th>
                        <th><?php echo app('translator')->get('admin.action'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $clinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clinic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr id="row-<?php echo e($clinic->id); ?>">
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="<?php echo e(route('clinic-details', $clinic->id)); ?>" class="avatar avatar-md me-2">
                                        <img src="<?php echo e($clinic->image); ?>" alt="<?php echo e($clinic->name); ?>" class="rounded-circle">
                                    </a>
                                    <a href="<?php echo e(route('clinic-details',$clinic->id)); ?>" class="text-dark fw-semibold"><?php echo e($clinic->name ?? null); ?> <span class="text-body fs-13 fw-normal d-block"> <?php echo e(app()->getLocale() == 'en' ? $clinic->city->name_en ?? null : $clinic->city->name_ar ?? null); ?> </span>  </a>
                                </div>
                            </td>
                            <td><?php echo e($clinic->currentPackage?->name_ar ?? null); ?></td>
                            <td><?php echo e($clinic->package_end_date); ?></td>
                            <td><?php echo e(0); ?></td>
                            <td><?php echo e($clinic->created_at->format('d M Y')); ?></td>
                            <td>
                                <div class="d-inline-block me-2">
                                    <div class="form-check form-switch ps-0 mb-0">
                                        <input type="checkbox"
                                               id="clinic<?php echo e($clinic->id); ?>"
                                               class="form-check-input m-0"
                                               <?php echo e($clinic->status == 1 ? 'checked' : ''); ?>

                                               onchange="change_status_clinic(<?php echo e($clinic->id); ?>,<?php echo e($clinic->status); ?>)">


                                    </div>
                                </div>
                                <span class="badge
        <?php echo e($clinic->status == 1 ? 'badge-soft-success border border-success' : 'badge-soft-danger border border-danger'); ?>

        d-inline-block px-2 py-1 fs-13 fw-medium">
        <?php echo e($clinic->status == 1 ? __('admin.Active') : __('admin.Inactive')); ?>

    </span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('clinic-details', $clinic->id)); ?>" class="link-reset fs-18 p-1"> <i class="ti ti-eye"></i></a>
                                <a href="javascript:void(0);"
                                   class="link-reset fs-18 p-1 delete-btn"
                                   data-route="<?php echo e(route('destroy-clinic', $clinic->id)); ?>"
                                   data-id="row-<?php echo e($clinic->id); ?>"
                                   data-bs-toggle="modal"
                                   data-bs-target="#genericDeleteModal">
                                    <i class="ti ti-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <!--  End Table -->
        </div>
        <!-- End Content -->
        <?php echo e($clinics->links()); ?>


        <?php $__env->startComponent('components.footer'); ?>
        <?php echo $__env->renderComponent(); ?>

        <?php echo $__env->make('layout_new.partials.delete_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>

    <!-- ========================
        End Page Content
    ========================= -->


    <script>
        function change_status_clinic(id, value) {
            if (value == 0) {
                value = 1;
            } else {
                value = 0;
            }
            $.ajax({
                url: '/admin/update-status-clinic/' + id + '/' + value,
                type: 'get',
                dataType: 'json',
                success: function (data) {
                    showToast(data.message); // مثلاً: "تم الحذف بنجاح"
                     window.location.replace(data.route);
                }
            });
        }
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout_new.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Other\randvous\TakafolJoodNew\resources\views/main_admin/clinics.blade.php ENDPATH**/ ?>