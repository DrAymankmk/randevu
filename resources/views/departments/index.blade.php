@extends('layouts.default')
@section('content')
    <!-- Right sidebar Ends-->
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <div class="page-header-left">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i data-feather="home"> </i> @lang('admin.dashboard') </a></li>
                                <li class="breadcrumb-item active">@lang('admin.departments')
                                    ( {{ $data['departments']->total() }} )
                                </li>
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
                        @if( count($data['departments']) > 0)
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="display dataTable" id="basic-1">
                                        <thead>
                                        <tr>
                                            <th style="display: none">#</th>
                                            <th>@lang('admin.name_en')</th>
                                            <th>@lang('admin.name_ar')</th>
                                            <th>@lang('admin.numbers_of_doctors')</th>
                                            <th>@lang('admin.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['departments'] as $index=>$department)
                                            <tr>
                                                <td style="display: none">{{ $index + 1 }}</td>
                                                <td>{{ $department->name_en }}</td>
                                                <td>{{ $department->name_ar }}</td>
                                                <td>{{ $department->doctors_count  }}</td>
                                                <td>
                                                    @if (auth()->user()->app_type != 6 || auth()->user()->hasPermissionTo('department_edit'))
                                                    @if($department->type == 2)
                                                        <button class="btn btn-primary" type="button"
                                                                data-toggle="modal"
                                                                data-target="#{{ $department->id }}"
                                                                data-whatever="@test"><i class="fa fa-edit"
                                                                                         title="@lang('admin.edit')"></i>
                                                        </button>
                                                    @endif
                                                    @endif
                                                        @if (auth()->user()->app_type != 6 || auth()->user()->hasPermissionTo('department_shift'))

                                                                                                            <form action="{{route('department-shifts',$department->id)}}"
                                                          method="get" style="display: inline-block">
                                                        <button class="btn btn-info btn-sm" type="submit" data-whatever="@test" title="@lang('admin.shifts_item')"><i class="fa fa-stack-exchange"></i></button>

                                                    </form>
                                                        @endif
                                                        @if (auth()->user()->app_type != 6 || auth()->user()->hasPermissionTo('department_employees'))

                                                    <form action="{{ route('department-employees', $department->id) }}"
                                                          method="get" style="display: inline-block">
                                                        <button class="btn btn-success btn-sm" type="submit"
                                                                data-whatever="@test" title="@lang('admin.employees')">
                                                            <i class="fa fa-user-md"></i>
                                                        </button>
                                                    </form>
                                                        @endif

                                                    <div class="modal fade" id="{{ $department->id }}" tabindex="-1"
                                                         role="dialog"
                                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"> @lang('admin.edit_data')
                                                                        {{ $department->name_en }} </h5>
                                                                    <button class="close" type="button"
                                                                            data-dismiss="modal"
                                                                            aria-label="Close">
                                                                        <span aria-hidden="true">×</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="needs-validation" novalidate=""
                                                                          action="{{route('edit-department',$department->id)}}"
                                                                          method="POST"
                                                                          enctype="multipart/form-data">
                                                                        {{ method_field('POST') }}
                                                                        {{ csrf_field() }}
                                                                        <div class="form-group">

                                                                            <label for="validationCustom05"
                                                                                   class="col-form-label page-header-left">@lang('admin.name_ar')
                                                                            </label>
                                                                            <input class="form-control"
                                                                                   name="name_ar"
                                                                                   type="text"
                                                                                   value="{{ $department->name_ar }}"
                                                                                   placeholder="@lang('admin.name_ar')"
                                                                                   required="">
                                                                            <div
                                                                                class="invalid-feedback">{{ $errors->first('name_ar') }}</div>
                                                                        </div>
                                                                        <span class="text-danger page-header-left"
                                                                              style="color: red;">{{$errors->first('name_ar')}}</span>

                                                                        <div class="form-group">

                                                                            <label for="validationCustom05"
                                                                                   class="col-form-label page-header-left">@lang('admin.name_en')
                                                                            </label>
                                                                            <input class="form-control"
                                                                                   name="name_en"
                                                                                   type="text"
                                                                                   value="{{ $department->name_en }}"
                                                                                   placeholder="@lang('admin.name_en')"
                                                                                   required="">
                                                                            <div
                                                                                class="invalid-feedback">{{ $errors->first('name_en') }}</div>
                                                                        </div>
                                                                        <span class="text-danger page-header-left"
                                                                              style="color: red;">{{$errors->first('name_en')}}</span>

                                                                        <div class="modal-footer">
                                                                            <button class="btn btn-primary"
                                                                                    type="submit">
                                                                                @lang('admin.edit')
                                                                            </button>
                                                                            <button class="btn btn-secondary"
                                                                                    type="button"
                                                                                    data-dismiss="modal">@lang('admin.close')
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{ $data['departments']->links() }}
                        @else
                            <h4 class="text-center" style="color: #ff0000"> @lang('admin.no_data') </h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function change_status_city(id, value) {
            if (value == 0) {
                value = 1;
            } else {
                value = 0;
            }
            axios.get('update-status-department/' + id + '/' + value)
                .then(function (response) {
                    location.reload();
                })
                .catch(function (error) {
                    console.log(error);
                    alert(error);
                });
        }
    </script>

@endsection
