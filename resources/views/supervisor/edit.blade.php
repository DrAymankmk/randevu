@extends('layouts.default')
@section('content')

    <style>
        h4 {
            font-size: 15px;
            margin: 0 0 7px 0;
            font-weight: 600;
        }
    </style>

    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <div class="page-header-left">
                            <h5>@lang('admin.edit') ( {{ $supervisor->name }})</h5>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="needs-validation" novalidate=""
                                  action="{{route('EditAccountSupervisor', $supervisor->id)}}"
                                  method="POST" enctype="multipart/form-data">
                                {{ method_field('POST') }}
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">@lang('admin.name')</label>
                                            <input class="form-control" id="validationCustom01" type="text"
                                                   placeholder="اسم المشرف" value="{{ $supervisor->name}}"
                                                   name="name"
                                                   required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">@lang('admin.mobile_number')</label>
                                            <label for="validationCustom02"> </label>
                                            <input class="form-control" id="validationCustom02" type="number"
                                                   placeholder="رقم الهاتف " value="{{ $supervisor->phone }}"
                                                   name="phone"
                                                   required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustomUsername">@lang('admin.email')</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"
                                                                                       id="inputGroupPrepend">@</span>
                                                </div>
                                                <input class="form-control" id="validationCustomUsername" type="email"
                                                       placeholder="البريد الالكترونى" value="{{$supervisor->email }}"
                                                       name="email" aria-describedby="inputGroupPrepend"
                                                       required="">
                                                <div class="invalid-feedback">ادخل البريد الالكترونى.</div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom05">@lang('admin.image')</label>
                                            <div class="custom-file">
                                                <input class="custom-file-input" type="file"
                                                       name="image">
                                                <label class="custom-file-label" for="validatedCustomFile">اختر
                                                    صوره</label>
                                                <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <img src="{{$supervisor->image }}"
                                                 style="width: 80px;height: 80px"
                                                 class="img-thumbnail image-preview img-80 rounded-circle" alt="">
                                        </div>

                                    </div>


                                </div>
                                <div class="col-md-4 mb-3">
                                    <button class="btn btn-primary"
                                            type="submit"> @lang('admin.edit')
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="{{asset('/admin/js/jquery-3.2.1.min.js')}}"></script>

            <script>
                $(document).ready(function () {
                    // Listen for click on toggle checkbox
                    $('#select-all').click(function(event) {
                        if(this.checked) {
                            // Iterate each checkbox
                            $(':checkbox').each(function() {
                                this.checked = true;
                            });
                        } else {
                            $(':checkbox').each(function() {
                                this.checked = false;
                            });
                        }
                    });
                });
            </script>

            <!-- END PAGE CONTENT WRAPPER -->
@endsection
