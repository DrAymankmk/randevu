<?php $__env->startSection('content'); ?>
    <style>
        .modal-select label {
            z-index: 99999 !important;
        }

        .select2-container--default.select2-container--open {
            z-index: 9999 !important;
        }

        .add-table-invoice {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .success {
            background-color: #28C76F20;
        }

        .success i {
            color: #28C76F !important;
        }

        .danger {
            background-color: #ea545520;
        }

        .danger i {
            color: #ea5455 !important;
        }
    </style>

    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo app('translator')->get('main.packages'); ?></a>
                            </li>
                            <li class="breadcrumb-item px-2"><i id="breadcrumbArrow"></i></li>
                            <li class="breadcrumb-item active p-0"><?php echo app('translator')->get('main.packages'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Page Header End -->

            <!-- Table Data -->
            <div class="row">
                <!-- Branches -->
                <div class="col-sm-12">
                    <div class="card card-table show-entire">
                        <div class="card-body">
                            <!-- Table Header -->
                            <div class="page-table-header mb-2">
                                <form action="<?php echo e(route('packages.index')); ?>" method="get">
                                    <div class="row align-items-center gap-2 d-md-flex d-block">
                                        <div class="col">
                                            <div class="doctor-table-blk">
                                                <h3><?php echo app('translator')->get('main.packages'); ?> (<?php echo e(count($data['packages'])); ?> )</h3>










                                            </div>
                                        </div>
                                        <div
                                            class="col-auto text-end py-2 ms-auto download-grp add-group sm:flex-row flex-col">
                                            <a href="javascript:void(0);" data-bs-toggle="modal"
                                               data-bs-target="#add_package"
                                               class="btn btn-primary text-nowrap w-100 border"><span><?php echo app('translator')->get('main.add_new_package'); ?></span></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /Table Header -->
                            <div class="position-relative">
                                <div class="table-loader">
                                    <div class="spinner"></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table border-0 custom-table comman-table datatable mb-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo app('translator')->get('admin.name_ar'); ?></th>
                                            <th><?php echo app('translator')->get('admin.name_en'); ?></th>
                                            <th><?php echo app('translator')->get('main.duration'); ?></th>
                                            <th><?php echo app('translator')->get('main.price'); ?></th>
                                            <th><?php echo app('translator')->get('main.numbers_users'); ?></th>
                                            <th><?php echo app('translator')->get('admin.status'); ?></th>
                                            <th><?php echo app('translator')->get('admin.options'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody id="cities-list">
                                        <?php $__currentLoopData = $data['packages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($index  + 1); ?></td>
                                                <td><a><?php echo e($package->name_ar); ?></a></td>
                                                <td><a><?php echo e($package->name_en); ?></a></td>
                                                <td><?php echo e($package->duration); ?></td>
                                                <td><?php echo e($package->price); ?></td>
                                                <td><?php echo e($package->subscriptions_package_users_count ?? 0); ?></td>
                                                <td>
                                                    <?php if($package->status == 1): ?>
                                                        <button
                                                            class="custom-badge status-green"><?php echo app('translator')->get('admin.Active'); ?></button>
                                                    <?php else: ?>
                                                        <button
                                                            class="custom-badge status-red"><?php echo app('translator')->get('admin.In Active'); ?></button>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="d-flex gap-2">
                                                    <a href="javascript:void(0)" class="add-table-invoice"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#edit_package_<?php echo e($package->id); ?>"
                                                       title="Edit"><i
                                                            class="fa fa-pen-to-square"></i></a>
                                                    <a href="javascript:void(0)" class="add-table-invoice danger"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#delete_package_<?php echo e($package->id); ?>"
                                                       title="Delete"><i class="fa fa-trash-can"></i></a>

                                                    <!-- Delete Department Modal -->
                                                    <div id="delete_package_<?php echo e($package->id); ?>"
                                                         class="modal fade delete-modal" role="dialog">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <form class="needs-validation" novalidate=""
                                                                      action="<?php echo e(route('packages.destroy',$package->id)); ?>"
                                                                      method="POST">
                                                                    <?php echo e(method_field('delete')); ?>

                                                                    <?php echo e(csrf_field()); ?>

                                                                    <div class="modal-body text-center">
                                                                        <img src="/assets/img/sent.png" alt=""
                                                                             width="50" height="46">
                                                                        <h3><?php echo app('translator')->get('admin.Are you sure you want to delete this?'); ?></h3>
                                                                        <div class="m-t-20"><a href="#"
                                                                                               class="btn btn-white"
                                                                                               data-bs-dismiss="modal"><?php echo app('translator')->get('admin.close'); ?></a>
                                                                            <button type="submit"
                                                                                    class="btn btn-danger"><?php echo app('translator')->get('admin.delete'); ?></button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Delete Department Modal End -->

                                                    <!-- Add Department Modal -->
                                                    <div class="modal custom-modal modal-bg fade bank-details"
                                                         id="edit_package_<?php echo e($package->id); ?>" role="dialog">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header py-2 px-3">
                                                                    <div class="form-header text-start mb-0">
                                                                        <h4 class="mb-0"><?php echo app('translator')->get('main.edit_package'); ?></h4>
                                                                    </div>
                                                                    <button type="button" class="close"
                                                                            data-bs-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body text-start py-4 px-3">
                                                                    <form id="add_department_form"
                                                                          action="<?php echo e(route('packages.update',$package->id)); ?>"
                                                                          method="POST">
                                                                        <?php echo csrf_field(); ?>
                                                                        <?php echo e(method_field('put')); ?>

                                                                        <div class="bank-inner-details">

                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group local-forms">
                                                                                        <label><?php echo app('translator')->get('admin.name_ar'); ?>
                                                                                            <span
                                                                                                class="login-danger">*</span></label>
                                                                                        <input class="form-control"
                                                                                               placeholder="<?php echo app('translator')->get('admin.name_ar'); ?>"
                                                                                               name="name_ar"
                                                                                               value="<?php echo e($package->name_ar); ?>"
                                                                                               required>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-12">
                                                                                    <div class="form-group local-forms">
                                                                                        <label><?php echo app('translator')->get('admin.name_en'); ?>
                                                                                            <span
                                                                                                class="login-danger">*</span></label>
                                                                                        <input class="form-control"
                                                                                               placeholder="<?php echo app('translator')->get('admin.name_en'); ?>"
                                                                                               name="name_en"
                                                                                               value="<?php echo e($package->name_en); ?>"
                                                                                               required>
                                                                                    </div>
                                                                                </div>


                                                                                <div class="col-12">
                                                                                    <div class="form-group local-forms">
                                                                                        <label><?php echo app('translator')->get('main.duration'); ?>
                                                                                            <span
                                                                                                class="login-danger">*</span></label>
                                                                                        <input type="number" class="form-control"
                                                                                               placeholder="<?php echo app('translator')->get('main.duration'); ?>"
                                                                                               name="duration"
                                                                                               value="<?php echo e($package->duration); ?>"
                                                                                               required>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-12">
                                                                                    <div class="form-group local-forms">
                                                                                        <label><?php echo app('translator')->get('main.price'); ?>
                                                                                            <span
                                                                                                class="login-danger">*</span></label>
                                                                                        <input type="number" class="form-control"
                                                                                               placeholder="<?php echo app('translator')->get('main.price'); ?>"
                                                                                               name="price"
                                                                                               value="<?php echo e($package->price); ?>"
                                                                                               required>
                                                                                    </div>
                                                                                </div>


                                                                                <div class="col-12">
                                                                                    <div class="form-group local-forms modal-select">
                                                                                        <label><?php echo app('translator')->get('admin.status'); ?> <span class="login-danger">*</span></label>
                                                                                        <select class="form-control select" name="status">
                                                                                            <option selected="true"
                                                                                                    disabled="disabled"><?php echo app('translator')->get('admin.select'); ?> <?php echo app('translator')->get('admin.status'); ?></option>
                                                                                            <option value="1" <?php if($package->status == 1): ?> selected <?php endif; ?>><?php echo app('translator')->get('admin.Active'); ?></option>
                                                                                            <option value="0" <?php if($package->status == 0): ?> selected <?php endif; ?>><?php echo app('translator')->get('admin.In Active'); ?></option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>


                                                                            </div>

                                                                        </div>

                                                                        <div class="modal-footer p-3">

                                                                            <div class="bank-details-btn">
                                                                                <a href="javascript:void(0);"
                                                                                   data-bs-dismiss="modal"
                                                                                   class="btn bank-cancel-btn me-2"><?php echo e(trans('admin.cancel')); ?></a>
                                                                                <button class="btn bank-save-btn"
                                                                                        type="submit">
                                                                                    <?php echo e(trans('admin.edit')); ?>

                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Add Department Modal End -->
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accounts -->
            </div>
            <!-- Table Data End -->
        </div>
        <!-- /Page Content -->
    </div>

    <!-- Add Department Modal -->
    <div class="modal custom-modal modal-bg fade bank-details" id="add_package" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2 px-3">
                    <div class="form-header text-start mb-0">
                        <h4 class="mb-0"><?php echo app('translator')->get('main.add_new_package'); ?></h4>
                    </div>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="add_package_form" action="<?php echo e(route('packages.store')); ?>"
                      method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="modal-body text-start py-4 px-3">
                        <div class="bank-inner-details">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group local-forms">
                                        <label><?php echo app('translator')->get('admin.name_ar'); ?> <span class="login-danger">*</span></label>
                                        <input class="form-control" placeholder="<?php echo app('translator')->get('admin.name_ar'); ?>" name="name_ar"
                                               value="<?php echo e(old('name_ar')); ?>" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group local-forms">
                                        <label><?php echo app('translator')->get('admin.name_en'); ?> <span class="login-danger">*</span></label>
                                        <input class="form-control" placeholder="<?php echo app('translator')->get('admin.name_en'); ?>" name="name_en"
                                               value="<?php echo e(old('name_en')); ?>" required>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="form-group local-forms">
                                        <label><?php echo app('translator')->get('main.duration'); ?>
                                            <span
                                                class="login-danger">*</span></label>
                                        <input type="number" class="form-control"
                                               placeholder="<?php echo app('translator')->get('main.duration'); ?>"
                                               name="duration"
                                               value="<?php echo e(old('duration')); ?>"
                                               required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group local-forms">
                                        <label><?php echo app('translator')->get('main.price'); ?>
                                            <span
                                                class="login-danger">*</span></label>
                                        <input type="number" class="form-control"
                                               placeholder="<?php echo app('translator')->get('main.price'); ?>"
                                               name="price"
                                               value="<?php echo e(old('price')); ?>"
                                               required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group local-forms modal-select">
                                        <label><?php echo app('translator')->get('admin.status'); ?> <span class="login-danger">*</span></label>
                                        <select class="form-control select" name="status">
                                            <option selected="true"
                                                    disabled="disabled"><?php echo app('translator')->get('admin.select'); ?> <?php echo app('translator')->get('admin.status'); ?></option>
                                            <option value="1"><?php echo app('translator')->get('admin.Active'); ?></option>
                                            <option value="0"><?php echo app('translator')->get('admin.In Active'); ?></option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer p-3">

                        <div class="bank-details-btn">
                            <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn bank-cancel-btn me-2"><?php echo e(trans('admin.cancel')); ?></a>
                            <button class="btn bank-save-btn" type="submit"><?php echo e(trans('admin.add')); ?></button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Department Modal End -->
    <script src="<?php echo e(asset('/admin/js/jquery-3.2.1.min.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout_new.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Other\randvous\TakafolJoodNew\resources\views/main_admin/packages/index.blade.php ENDPATH**/ ?>