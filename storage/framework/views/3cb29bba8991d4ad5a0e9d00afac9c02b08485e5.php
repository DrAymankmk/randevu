<?php $__env->startSection('content'); ?>

    <!-- ========================
    Start Page Content
========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">

            <!-- Start Page Header -->
            <div class="d-flex align-items-sm-center flex-sm-row flex-column gap-2 mb-3 pb-3 border-bottom">
                <div class="flex-grow-1">
                    <h4 class="fw-bold mb-0"><?php echo e(trans('admin.cities')); ?><span class="badge badge-soft-primary border border-primary fs-13 fw-medium ms-2"><?php echo e(trans('admin.Total cities')); ?> : <?php echo e(count($data['cities'])); ?></span></h4>
                </div>
                <div class="text-end d-flex">
                    <a href="javascript:void(0);" class="btn btn-primary text-white ms-2 fs-13 btn-md" data-bs-toggle="modal" data-bs-target="#add_city"><i class="ti ti-plus me-1"></i><?php echo e(trans('admin.Add New City')); ?></a>
                </div>

            </div>
            <!-- End Page Header -->

            <div class=" d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                <div class="search-set mb-3">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <div class="table-search d-flex align-items-center mb-0">
                            <div class="search-input">
                                <a href="javascript:void(0);" class="btn-searchset"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex table-dropdown mb-3 pb-1 right-content align-items-center flex-wrap row-gap-3">
                    <div class="dropdown me-2">
                        <a href="javascript:void(0);" class="btn btn-white fs-14 py-1 bg-white border d-inline-flex text-dark align-items-center" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="ti ti-filter text-gray-5 me-1"></i><?php echo e(trans('admin.Filters')); ?>

                        </a>
                        <div class="dropdown-menu dropdown-lg dropdown-menu-end filter-dropdown p-0" id="filter-dropdown">
                            <div class="d-flex align-items-center justify-content-between border-bottom filter-header">
                                <h5 class="mb-0 fw-bold"><?php echo e(trans('admin.Filter')); ?></h5>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);" class="link-danger text-decoration-underline"><?php echo e(trans('admin.Clear All')); ?></a>
                                </div>
                            </div>
                            <form action="#">
                                <div class="filter-body pb-0">
                                    <div class="mb-3">
                                        <label class="form-label mb-1 text-dark fs-14 fw-medium"><?php echo e(trans('admin.date')); ?></label>
                                        <div class="input-icon-end position-relative">
                                            <input type="text" class="form-control datetimepicker" name="date_from" placeholder="dd/mm/yyyy">
                                            <span class="input-icon-addon" >
                                                <i class="ti ti-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <label class="form-label"><?php echo e(trans('admin.status')); ?></label>
                                        </div>
                                        <select class="select" name="status" required>
                                            <option value="1" selected><?php echo e(trans('admin.Active')); ?></option>
                                            <option value="0"><?php echo e(trans('admin.Inactive')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="filter-footer d-flex align-items-center justify-content-end border-top">
                                    <a href="javascript:void(0);" class="btn btn-light btn-md me-2" id="close-filter"><?php echo e(trans('admin.Close')); ?></a>
                                    <button type="submit" class="btn btn-primary btn-md"><?php echo e(trans('admin.Filter')); ?></button>
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

            <div class="table-responsive">
                <table class="table table-nowrap datatable">
                    <thead class="thead-light">
                    <tr>
                        <th><?php echo e(trans('admin.name')); ?></th>
                        <th><?php echo e(trans('admin.Created Date')); ?></th>
                        <th><?php echo e(trans('admin.No of Clinics')); ?></th>
                        <th><?php echo e(trans('admin.Status')); ?></th>
                        <th><?php echo app('translator')->get('admin.created_by'); ?></th>
                        <th><?php echo e(trans('admin.Action')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $data['cities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr id="row-<?php echo e($city->id); ?>">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h6 class="mb-0 fs-14 fw-semibold"><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_staff"><?php echo e(app()->getLocale() == 'en' ? $city->name_en : $city->name_ar); ?></a></h6>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo e($city->created_at->format('d M Y')); ?></td>
                            <td><?php echo e($city->clinics_count ?? 0); ?></td>
                            <td><span class="badge <?php if($city->status == 1): ?> badge-soft-success border border-success <?php else: ?> badge-soft-danger border border-danger <?php endif; ?>  px-2 py-1 fs-13 fw-medium"><?php if($city->status == 1): ?> <?php echo app('translator')->get('admin.Active'); ?> <?php else: ?> <?php echo app('translator')->get('admin.Inactive'); ?> <?php endif; ?> </span></td>
                            <td><?php echo e($city->admin->name ?? null); ?></td>

                            <td>
                                <a href="javascript: void(0);" class="link-reset fs-18 p-1" data-bs-toggle="modal" data-bs-target="#edit_city_<?php echo e($city->id); ?>"> <i class="ti ti-pencil"></i></a>

                                <a href="javascript:void(0);"
                                   class="link-reset fs-18 p-1 delete-btn"
                                   data-route="<?php echo e(route('destroy-city',$city->id)); ?>"
                                   data-id="row-<?php echo e($city->id); ?>"
                                   data-bs-toggle="modal"
                                   data-bs-target="#genericDeleteModal">
                                    <i class="ti ti-trash"></i>
                                </a>
                            </td>
                            <!-- Start Add Modal -->
                            <div id="edit_city_<?php echo e($city->id); ?>" class="modal fade">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="text-dark modal-title fw-bold"><?php echo e(trans('admin.edit_city')); ?> <?php echo e(app()->getLocale() == 'en' ? $city->name_en : $city->name_ar); ?></h4>
                                            <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
                                        </div>
                                        <form action="<?php echo e(route('update-city',$city->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label"><?php echo e(trans('admin.name_ar')); ?><span class="text-danger ms-1">*</span></label>
                                                    <input type="text" class="form-control"  placeholder="<?php echo app('translator')->get('admin.name_ar'); ?>" name="name_ar"
                                                           value="<?php echo e($city->name_ar); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label"><?php echo e(trans('admin.name_en')); ?><span class="text-danger ms-1">*</span></label>
                                                    <input type="text" class="form-control"  placeholder="<?php echo app('translator')->get('admin.name_en'); ?>" name="name_en"
                                                           value="<?php echo e($city->name_en); ?>" required>
                                                </div>
                                                <div class="mb-0">
                                                    <label class="form-label"><?php echo e(trans('admin.status')); ?></label>
                                                    <select class="select" name="status">
                                                        <option value="1" <?php if($city->status == 1): ?> selected <?php endif; ?>><?php echo app('translator')->get('admin.Active'); ?></option>
                                                        <option value="0" <?php if($city->status == 0): ?> selected <?php endif; ?>><?php echo app('translator')->get('admin.Inactive'); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer d-flex align-items-center gap-1">
                                                <button type="button" class="btn btn-white border" data-bs-dismiss="modal"><?php echo e(trans('admin.cancel')); ?></button>
                                                <button type="submit" class="btn btn-primary"><?php echo e(trans('admin.Save Changes')); ?></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Add Modal -->

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                </table>
            </div>

        </div>
        <!-- End Content -->

        <?php $__env->startComponent('components.footer'); ?>
        <?php echo $__env->renderComponent(); ?>

    </div>



    <!-- ========================
        End Page Content
    ========================= -->
    <!-- Start Add Modal -->
    <div id="add_city" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-dark modal-title fw-bold"><?php echo e(trans('admin.Add New City')); ?></h4>
                    <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
                </div>
                <form id="add_department_form" action="<?php echo e(route('add-city')); ?>"
                      method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(trans('admin.name_ar')); ?><span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control"  placeholder="<?php echo app('translator')->get('admin.name_ar'); ?>" name="name_ar"
                                   value="<?php echo e(old('name_ar')); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo e(trans('admin.name_en')); ?><span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control"  placeholder="<?php echo app('translator')->get('admin.name_en'); ?>" name="name_en"
                                   value="<?php echo e(old('name_en')); ?>" required>
                        </div>

                        <div class="mb-0">
                            <label class="form-label"><?php echo e(trans('admin.status')); ?></label>
                            <select class="select" name="status" required>
                                <option value="1" selected><?php echo app('translator')->get('admin.Active'); ?></option>
                                <option value="0"><?php echo app('translator')->get('admin.Inactive'); ?></option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer d-flex align-items-center gap-1">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal"><?php echo e(trans('admin.cancel')); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo e(trans('admin.Add New City')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Add Modal -->



    <!-- General Delete Modal -->
    <div class="modal fade" id="genericDeleteModal">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form id="genericDeleteForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <div class="modal-body text-center position-relative z-1">
                        <img src="<?php echo e(URL::asset('build/img/bg/delete-modal-bg-01.png')); ?>" class="img-fluid position-absolute top-0 start-0 z-n1" alt="">
                        <img src="<?php echo e(URL::asset('build/img/bg/delete-modal-bg-02.png')); ?>" class="img-fluid position-absolute bottom-0 end-0 z-n1" alt="">
                        <div class="mb-3">
                            <span class="avatar avatar-lg bg-danger text-white"><i class="ti ti-trash fs-24"></i></span>
                        </div>
                        <h5 class="fw-bold mb-1"><?php echo e(trans('admin.Delete Confirmation')); ?></h5>
                        <p class="mb-3"><?php echo e(trans('admin.Are you sure want to delete?')); ?></p>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal"><?php echo e(trans('admin.Cancel')); ?></button>
                            <button type="submit" class="btn btn-danger" id="confirmDeleteBtn"><?php echo e(trans('admin.Yes, Delete')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout_new.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Other\randvous\TakafolJoodNew\resources\views/main_admin/cities.blade.php ENDPATH**/ ?>