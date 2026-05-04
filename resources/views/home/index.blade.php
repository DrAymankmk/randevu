@extends('layouts.default')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <div class="page-header-left">
                            {{--                            <h3>{{ trans('admin.dashboard') }}</h3>--}}
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href=" {{route('admin.dashboard')}}"><i data-feather="home"> </i> {{ trans('admin.dashboard') }}  </a></li>
                            </ol>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{--    @if (auth()->user()->hasPermissionTo('عرض الصفحة الرئيسية'))--}}
        <!-- Container-fluid starts-->
        <div class="container-fluid">

                <div class="row">

                        <div class="col-sm-6 col-xl-6 col-lg-6">
                            <div class="card o-hidden">
                                <div class="bg-primary b-r-4 card-body">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center"><i data-feather="plus"></i>
                                        </div>
                                        <div class="media-body"><span class="m-0">
                                            <a style="color: #fff;" href="{{ route('department-employees',3) }}"
                                               target="_blank">@lang('admin.add_doctor')</a></span>
                                            <h4 class="mb-0 counter">{{ $data['doctors'] }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <div class="col-sm-6 col-xl-6 col-lg-6">
                                <div class="card o-hidden">
                                    <div class="bg-primary b-r-4 card-body">
                                        <div class="media static-top-widget">
                                            <div class="align-self-center text-center"><i data-feather="plus"></i>
                                            </div>
                                            <div class="media-body"><span class="m-0">
                                            <a style="color: #fff;" href="{{ route('department-employees',2) }}"
                                               target="_blank">@lang('admin.add_receptionist')</a></span>
                                                <h4 class="mb-0 counter">0</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="col-sm-6 col-xl-6 col-lg-6">
                            <div class="card o-hidden">
                                <div class="card-body" style="background: #53CEEA;">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center" style="color: #fff"><i data-feather="eye"></i>
                                        </div>
                                        <div class="media-body"><span class="m-0">
                                            <a style="color: #fff;" href="{{route('posts')}}"
                                               target="_blank">@lang('admin.numbers_of_doctors')</a></span>
                                            <h4 class="mb-0 counter" style="color: #fff"> {{ $data['doctors'] }} </h4>
                                            {{--                                        <i class="icon-bg" data-feather="arrow-down"></i>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-6 col-lg-6">
                            <div class="card o-hidden">
                                <div class=" b-r-4 card-body" style="background: #FFA140;">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center" style="color: #fff"><i data-feather="arrow-right"></i>
                                        </div>
                                        <div class="media-body"><span class="m-0">
                                            <a style="color: #fff;" href=""
                                               target="_blank">@lang('admin.numbers_of_reservations')</a></span>
                                            <h4 class="mb-0 counter" style="color: #fff">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ trans('admin.last_seven_days_complains') }} <span class="digits"></span></h4>
                            </div>
                            @if(count($data['complains_charts']) > 0)
                                <div class="card-body chart-block ">
                                    <div class="chart-overflow" id="complains_charts"></div>
                                </div>
                            @else
                                <h6 style="text-align: center;color: #f00">{{ trans('admin.no_data') }}</h6>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ trans('admin.last_seven_days_Reservations') }} <span class="digits"></span></h4>
                            </div>
                            @if(count($data['reservations_charts']) > 0)
                                <div class="card-body chart-block ">
                                    <div class="chart-overflow" id="reservations_charts"></div>
                                </div>
                            @else
                                <h6 style="text-align: center;color: #f00">{{ trans('admin.no_data') }}</h6>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
        <!-- Container-fluid Ends-->

    </div>




@endsection





