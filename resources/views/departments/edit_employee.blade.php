@extends('layouts.default')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <div class="page-header-left">
                            <h3>@lang('admin.edit') {{ $data['employee']->name ?? null }}</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i
                                            data-feather="home"> </i> @lang('admin.dashboard') </a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{route('department-employees', $data['employee']->app_type)}}"><i
                                            data-feather="eye"> </i> {{ $data['employee']->name }} </a></li>

                            </ol>
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
                                  action="{{route('update-department-employee', $data['employee']->id)}}"
                                  method="POST" enctype="multipart/form-data">
                                {{ method_field('POST') }}
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">@lang('admin.name')</label>
                                            <input class="form-control" id="validationCustom01" type="text"
                                                   placeholder="@lang('admin.name')"
                                                   value="{{ $data['employee']->name }}" name="name"
                                                   required="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">@lang('admin.mobile_number')</label>
                                            <label for="validationCustom02"> </label>
                                            <input class="form-control" id="validationCustom02" type="number"
                                                   placeholder="@lang('admin.mobile_number')"
                                                   value="{{ $data['employee']->phone }}" name="phone"
                                                   required="">

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
                                                       placeholder="@lang('admin.email')"
                                                       value="{{ $data['employee']->email }}"
                                                       name="email" aria-describedby="inputGroupPrepend"
                                                       required="">
                                                <div class="invalid-feedback">@lang('admin.enter') @lang('admin.email')
                                                    .
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom03">@lang('admin.password')</label>
                                            <input class="form-control" id="validationCustom03" type="password"
                                                   placeholder="@lang('admin.password')"
                                                   name="password"
                                                   required="">
                                            <div class="invalid-feedback">@lang('admin.enter') @lang('admin.password')
                                                .
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-row">
                                        <div class="col-md-1 mb-3">
                                            <div class="form-group">
                                                <img src="{{$data['employee']->image }}"
                                                     class="img-thumbnail image-preview img-80 rounded-circle" alt=""
                                                     style="width:80px;height:80px">
                                            </div>
                                        </div>

                                        <div class="col-md-5 mb-3">
                                            <label for="validationCustom01">@lang('admin.image')</label>
                                            <div class="custom-file">
                                                <input class="custom-file-input" id="validatedCustomFile" type="file"
                                                       name="image">
                                                <label class="custom-file-label"
                                                       for="validatedCustomFile"> @lang('admin.select') @lang('admin.image')
                                                    ...</label>
                                                <div
                                                    class="invalid-feedback">@lang('admin.select') @lang('admin.image')</div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="gender">@lang('admin.gender')</label>
                                            <select id="gender" class="form-control"
                                                    name="gender" required>
                                                <option value="1"
                                                        @if($data['employee']->gender == 1)  selected @endif>@lang('admin.male')</option>
                                                <option value="2"
                                                        @if($data['employee']->gender == 2)  selected @endif>@lang('admin.female')</option>
                                            </select>
                                            <div class="invalid-feedback">{{ $errors->first('gender') }}</div>
                                        </div>
                                    </div>


                                    @if($data['employee']->app_type == 3)
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="degree_id">@lang('admin.doctor_degrees')</label>
                                                <select id="degree_id" class="form-control"
                                                        name="degree_id" required>
                                                    <option value="">@lang('admin.select')</option>
                                                    @foreach( $data['degree'] as $degree_item)
                                                        <option value="{{$degree_item->id}}"
                                                                @if($data['employee']->degree_id == $degree_item->id)  selected @endif>{{$degree_item->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">{{ $errors->first('degree_id') }}</div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="specialist_id">@lang('admin.specialization')</label>
                                                <select id="specialist_id"
                                                        class="js-example-placeholder-multiple form-control"
                                                        name="specialist_id">
                                                    <option value="">@lang('admin.select')</option>
                                                    @foreach($data['specializations'] as $specialist)
                                                        <option value="{{ $specialist->id }}" {{ (!in_array($specialist->id,$data['specialty_ids'])) ? '' : 'selected'}}>{{ app()->getLocale() == 'en' ? $specialist->name_en : $specialist->name_ar }}</option>
                                                    @endforeach
                                                </select>
                                                <div
                                                    class="invalid-feedback">{{ $errors->first('specialist_ids') }}</div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label
                                                    for="sub_specialist_ids">@lang('admin.sub_specialization')</label>
                                                <select id="sub_specialist_ids"
                                                        class="js-example-placeholder-multiple form-control"
                                                        name="sub_specialist_ids[]" multiple="multiple" required>
                                                    @foreach($data['sub_specializations'] as $specialist)
                                                        <option
                                                            value="{{ $specialist->id }}" {{ (!in_array($specialist->id,$data['sub_specialty_ids'])) ? '' : 'selected'}}>{{ app()->getLocale() == 'en' ? $specialist->name_en : $specialist->name_ar }}</option>
                                                    @endforeach
{{--                                                    <option value="">@lang('admin.select_specialist')</option>--}}
                                                </select>
                                                <div
                                                    class="invalid-feedback">{{ $errors->first('sub_specialist_ids') }}</div>
                                            </div>


                                            <div class="col-md-6 mb-3">
                                                <label for="consultation_duration">@lang('admin.Consultation duration in minutes')</label>
                                                <input class="form-control" id="consultation_duration" type="number"
                                                       placeholder="@lang('admin.Consultation duration in minutes')" value="{{ $doctor_appointments->consultation_duration ?? 0 }}"
                                                       name="consultation_duration"
                                                       required="">
                                                <div class="invalid-feedback">@lang('admin.enter') @lang('admin.Consultation duration in minutes').
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="appointments_online">@lang('admin.Percentage of online patient')</label>
                                                <input class="form-control" id="appointments_online" type="number"
                                                       placeholder="@lang('admin.Percentage of offline patient')" value="{{ $doctor_appointments->appointments_online ?? 0 }}"
                                                       name="appointments_online"
                                                       required="">
                                                <div class="invalid-feedback">@lang('admin.enter') @lang('admin.Percentage of offline patient').
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="appointments_reception">@lang('admin.Percentage of online patient')</label>
                                                <input class="form-control" id="appointments_reception" type="number"
                                                       placeholder="@lang('admin.Percentage of offline patient')" value="{{ $doctor_appointments->appointments_reception ?? 0 }}"
                                                       name="appointments_reception"
                                                       required="">
                                                <div class="invalid-feedback">@lang('admin.enter') @lang('admin.Percentage of offline patient').
                                                </div>
                                            </div>

                                        </div>
                                    @endif


                                    @if($data['employee']->app_type != 3)

                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="specialist_ids">@lang('admin.specialization')</label>
                                                <select id="specialist_ids"
                                                        class="js-example-placeholder-multiple form-control"
                                                        name="specialist_ids[]" multiple="multiple">
                                                    @foreach($data['specializations'] as $specialist)
                                                        <option
                                                            value="{{ $specialist->id }}" {{ (!in_array($specialist->id,$data['employee']->specialties->pluck('specialty_id')->toArray())) ? '' : 'selected'}}>{{ app()->getLocale() == 'en' ? $specialist->name_en : $specialist->name_ar }}</option>
                                                    @endforeach
                                                </select>
                                                <div
                                                    class="invalid-feedback">{{ $errors->first('specialist_ids') }}</div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                                <div class="col-md-4 mb-3">
                                    <button class="btn btn-primary"
                                            type="submit">@lang('admin.edit')
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('/admin/js/jquery-3.2.1.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            $('#specialist_id').on('change', function () {
                var specialist_id = this.value;
                $('#sub_specialist_ids').html('');
                $.ajax({
                    url: '{{ route('getSubSpecialist') }}?specialist_id=' + specialist_id,
                    type: 'get',
                    dataType: 'json',
                    success: function (res) {
                        if (res.specialists_count > 0) { // all was ok
                            {{--$('#sub_specialist_ids').html('<option value="">@lang('admin.select')</option>');--}}
                            $.each(res.data, function (key, value) {
                                $('#sub_specialist_ids').append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                        } else {
                            $('#sub_specialist_ids').html('<option value="">@lang('admin.no_data')</option>');
                        }
                    }
                });
            });
        });
    </script>

    <!-- END PAGE CONTENT WRAPPER -->
@endsection
