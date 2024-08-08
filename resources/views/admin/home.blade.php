@extends('admin.empty')


@section('content')
    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">

                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack mb-5">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                        <!--begin::Title-->
                        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                            Dashboard
                        </h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="javascript:;" class="text-muted text-hover-primary">
                                    Home
                                </a>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-500 w-5px h-2px"></span>
                            </li>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                Dashboard
                            </li>
                            <!--end::Item-->
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page title-->
                </div>
                <!--end::Toolbar container-->
            </div>
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">

                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <!--begin::Row-->
                                <div class="row g-5 g-xl-10 mb-xl-10 d-flex">
                                    <!--begin::Col-->
                                        <!--begin::Card widget 4-->
                                        <div class="card card-flush h-md-50 mb-5 mb-xl-1 m-5" style="flex-basis:45%">
                                            <!--begin::Header-->
                                            <div class="card-header pt-5">
                                                <!--begin::Title-->
                                                <div class="card-title d-flex flex-column">
                                                    <!--begin::Info-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Currency-->
                                                        <span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">$</span>
                                                        <!--end::Currency-->
                                                        <!--begin::Amount-->
                                                        <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $totalMonthly }}</span>
                                                        <!--end::Amount-->
                                                        <!--begin::Badge-->
                                                        <span class="badge badge-light-success fs-base">

                                                        <!--end::Badge-->
                                                    </div>
                                                    <!--end::Info-->
                                                    <!--begin::Subtitle-->
                                                    <span class="text-gray-400 pt-1 fw-semibold fs-6">Total Sales in KWD</span>
                                                    <!--end::Subtitle-->
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-2 pb-4 d-flex align-items-center">
                                                <!--begin::Chart-->
                                                <div class="d-flex flex-center me-5 pt-2">
                                                    <div id="kt_card_widget_4_chart" style="min-width: 70px; min-height: 70px" data-kt-size="70" data-kt-line="11"></div>
                                                </div>
                                                <!--end::Chart-->
                                                <!--begin::Labels-->
                                                <div class="d-flex flex-column content-justify-center w-100">
                                                    <!--begin::Label-->
                                                    <div class="d-flex fs-6 fw-semibold align-items-center">
                                                        <!--begin::Bullet-->
                                                        <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>
                                                        <!--end::Bullet-->
                                                        <!--begin::Label-->
                                                        <div class="text-gray-500 flex-grow-1 me-4">Places</div>
                                                        <!--end::Label-->
                                                        <!--begin::Stats-->
                                                        <div class="fw-bolder text-gray-700 text-xxl-end">$ {{ $pricePlaces }}</div>
                                                        <!--end::Stats-->
                                                    </div>
                                                    <!--end::Label-->
                                                    <!--begin::Label-->
                                                    <div class="d-flex fs-6 fw-semibold align-items-center my-3">
                                                        <!--begin::Bullet-->
                                                        <div class="bullet w-8px h-6px rounded-2 bg-primary me-3"></div>
                                                        <!--end::Bullet-->
                                                        <!--begin::Label-->
                                                        <div class="text-gray-500 flex-grow-1 me-4">Services</div>
                                                        <!--end::Label-->
                                                        <!--begin::Stats-->
                                                        <div class="fw-bolder text-gray-700 text-xxl-end">$ {{ $priceServices }}</div>
                                                        <!--end::Stats-->
                                                    </div>
                                                    <!--end::Label-->

                                                </div>
                                                <!--end::Labels-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card widget 4-->
                                        <!--begin::Card widget 5-->
                                        <div class="card card-flush h-md-50 mb-xl-10 m-5 py-1" style="flex-basis:45%; background-color:#e9ca8b">
                                            <!--begin::Header-->
                                            <div class="card-header pt-5">
                                                <!--begin::Title-->
                                                <div class="card-title d-flex flex-column">
                                                    <!--begin::Info-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Amount-->
                                                        <span class="fs-2hx fw-bold text-light me-2 lh-1 ls-n2">{{ $totalDay }}</span>
                                                        <!--end::Amount-->

                                                    </div>
                                                    <!--end::Info-->
                                                    <!--begin::Subtitle-->
                                                    <span class="text-light-400 pt-1 text-light fw-semibold fs-6">Daily Sales in KWD</span>
                                                    <!--end::Subtitle-->
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <br>
                                            <!--end::Header-->
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex align-items-end pt-0">
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center flex-column mt-3 w-100">
                                                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                        <span class="fw-bolder fs-6 text-light">to Goal</span>
                                                        <span class="fw-bold text-light fs-6 text-light-400">100%</span>
                                                    </div>
                                                    <div class="h-8px mx-3 w-100 rounded" style="background-color:white !important">
                                                        <div class="rounded h-8px" role="progressbar" style="width: 62%; background-color:#78b5e2" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <!--end::Progress-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card widget 5-->
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                                    <!--begin::Col-->
                                    <div class="col-xl-12 mb-xl-10">
                                        <!--begin::Chart widget 38-->
                                        @include('admin.dashboard.widget_38')
                                        <!--end::Chart widget 38-->
                                        <!--begin::Chart widget 20-->
                                        @include('admin.dashboard.widget_20')
                                        <!--end::Chart widget 20-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row gy-5 g-xl-10">
                                    <!--begin::Col-->
                                    <div class="col-xl-12 mb-5 mb-xl-5">
                                        <!--begin::Row-->
                                        <div class="row g-lg-5 g-xl-10">
                                            <!--begin::Col-->
                                            <div class="col-md-6 col-xl-6 mb-5 mb-xl-10">
                                                <!--begin::Card widget 10-->
                                                <div class="card card-flush h-md-100 mb-lg-10">
                                                    <!--begin::Header-->
                                                    <div class="card-header pt-5">
                                                        <!--begin::Title-->
                                                        <div class="card-title d-flex flex-column">
                                                            <!--begin::Amount-->
                                                            <span
                                                                class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $totalServices + $totalPlaces }}</span>
                                                            <!--end::Amount-->
                                                            <!--begin::Subtitle-->
                                                            <span class="text-gray-400 pt-1 fw-semibold fs-6">Total
                                                                Places And Services</span>
                                                            <!--end::Subtitle-->
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Header-->
                                                    <!--begin::Card body-->
                                                    <div class="card-body d-flex align-items-end pt-0">
                                                        <!--begin::Wrapper-->
                                                        <div class="d-flex align-items-center flex-wrap">
                                                            {{-- <!--begin::Chart-->
                                                            <div class="d-flex me-7 me-xxl-10">
                                                                <div id="kt_card_widget_10_chart" class="min-h-auto"
                                                                    style="height: 78px; width: 78px" data-kt-size="78"
                                                                    data-kt-line="11"></div>
                                                            </div>
                                                            <!--end::Chart--> --}}
                                                            <!--begin::Labels-->
                                                            <div
                                                                class="d-flex flex-column content-justify-center flex-grow-1">
                                                                <!--begin::Label-->
                                                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                                                    <!--begin::Bullet-->
                                                                    <div
                                                                        class="bullet w-8px h-6px rounded-2 bg-success me-3">
                                                                    </div>
                                                                    <!--end::Bullet-->
                                                                    <!--begin::Label-->
                                                                    <div
                                                                        class="fs-6 fw-semibold text-gray-400 flex-shrink-0">
                                                                        Total Number Of Places</div>
                                                                    <!--end::Label-->
                                                                    <!--begin::Separator-->
                                                                    <div
                                                                        class="separator separator-dashed min-w-10px flex-grow-1 mx-2">
                                                                    </div>
                                                                    <!--end::Separator-->
                                                                    <!--begin::Stats-->
                                                                    <div class="ms-auto fw-bolder text-gray-700 text-end">
                                                                        {{ $totalPlaces }}</div>
                                                                    <!--end::Stats-->
                                                                </div>
                                                                <!--end::Label-->
                                                                <!--begin::Label-->
                                                                <div
                                                                    class="d-flex fs-6 fw-semibold align-items-center my-1">
                                                                    <!--begin::Bullet-->
                                                                    <div
                                                                        class="bullet w-8px h-6px rounded-2 bg-primary me-3">
                                                                    </div>
                                                                    <!--end::Bullet-->
                                                                    <!--begin::Label-->
                                                                    <div
                                                                        class="fs-6 fw-semibold text-gray-400 flex-shrink-0">
                                                                        Total Number Of Services</div>
                                                                    <!--end::Label-->
                                                                    <!--begin::Separator-->
                                                                    <div
                                                                        class="separator separator-dashed min-w-10px flex-grow-1 mx-2">
                                                                    </div>
                                                                    <!--end::Separator-->
                                                                    <!--begin::Stats-->
                                                                    <div class="ms-auto fw-bolder text-gray-700 text-end">
                                                                        {{ $totalServices }}</div>
                                                                    <!--end::Stats-->
                                                                </div>
                                                                <!--end::Label-->

                                                            </div>
                                                            <!--end::Labels-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--end::Card body-->
                                                </div>
                                                <!--end::Card widget 10-->
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-md-6 col-xl-6 mb-md-5 mb-xl-10">

                                                <!--begin::Card widget 7-->
                                                <div class="card card-flush h-md-100 mb-lg-10">
                                                    <!--begin::Header-->
                                                    <div class="card-header pt-5">
                                                        <!--begin::Title-->
                                                        <div class="card-title d-flex flex-column">
                                                            <!--begin::Amount-->
                                                            <span
                                                                class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ $totalUsers }}</span>
                                                            <!--end::Amount-->
                                                            <!--begin::Subtitle-->
                                                            <span class="text-gray-400 pt-1 fw-semibold fs-6">Total Register
                                                                Users</span>
                                                            <!--end::Subtitle-->
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Header-->
                                                    <!--begin::Card body-->
                                                    <div class="card-body d-flex flex-column justify-content-end pe-0">
                                                        <!--begin::Title-->
                                                        <span class="fs-6 fw-bolder text-gray-800 d-block mb-2">Last
                                                            Users</span>
                                                        <!--end::Title-->
                                                        <!--begin::Users group-->
                                                        <div class="symbol-group symbol-hover flex-nowrap">
                                                            @foreach ($lastUsers as $user)
                                                                <div class="symbol symbol-35px symbol-circle"
                                                                    data-bs-toggle="tooltip" title="{{ $user->name }}">
                                                                    <span
                                                                        class="symbol-label @if ($loop->first) bg-danger  @elseif ($loop->last)
                                                                    bg-primary
                                                                    @else
                                                                    bg-warning @endif text-inverse-warning  fw-bold">{{ ucfirst(substr($user->name, 0, 1)) }}</span>
                                                                </div>
                                                            @endforeach


                                                            <a href="{{ route('customers.index') }}"
                                                                class="symbol symbol-35px symbol-circle">
                                                                <span
                                                                    class="symbol-label bg-light text-gray-400 fs-8 fw-bold">+
                                                                    {{ $totalUsers }}</span>
                                                            </a>
                                                        </div>
                                                        <!--end::Users group-->
                                                    </div>
                                                    <!--end::Card body-->
                                                </div>
                                                <!--end::Card widget 7-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!-- begin:cards row -->
                                <div class="row gy-5 g-xl-10">
                                    <div class="col-xl-12 mb-5 mb-xl-10">
                                        @include('admin.dashboard.cards')
                                    </div>
                                </div>
                                <!-- end:cards row -->
                            </div>
                            <!--end::Content container-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->

                </div>


            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->

    </div>
    <!--end:::Main-->
    <script>
        $(document).ready(function () {
            // update chart when choose a date from date picker dropdown
            $('.datePicker .ranges li').click(function() {
                var parent = $(this).closest('.datePicker');
                var parentId = parent.attr('id');
                var idParts = parentId.split('_');
                var chartId = idParts[1];

                var val=$(this).data("range-key");

                if(val == 'Today') {
                    start = moment().format('YYYY-MM-DD');
                    end = moment().format('YYYY-MM-DD');
                    updateChartData(start, end, chartId);

                } else if (val == 'Yesterday') {
                    start = moment().subtract(1, 'day').format('YYYY-MM-DD');
                    end = moment().subtract(1, 'day').format('YYYY-MM-DD');
                    updateChartData(start, end, chartId);

                } else if(val == 'Last 7 Days') {
                    start = moment().subtract(6, 'days').format('YYYY-MM-DD');
                    end = moment().format('YYYY-MM-DD');
                    updateChartData(start, end, chartId);

                } else if(val == 'Last 30 Days') {
                    start = moment().subtract(29, 'days').format('YYYY-MM-DD');
                    end = moment().format('YYYY-MM-DD');
                    updateChartData(start, end, chartId);

                } else if (val == 'This Month') {
                    start = moment().startOf('month').format('YYYY-MM-DD');
                    end = moment().endOf('month').format('YYYY-MM-DD');
                    updateChartData(start, end, chartId);

                } else if (val == 'Last Month') {
                    start = moment().subtract(1, 'month').startOf('month').format('YYYY-MM-DD');
                    end = moment().subtract(1, 'month').endOf('month').format('YYYY-MM-DD');
                    updateChartData(start, end, chartId);
                }
            });

            // update chart when choose a date from date picker custom range
            $('.datePicker .applyBtn').click(function(){
                var parent = $(this).closest('.datePicker');
                var parentId = parent.attr('id');
                var idParts = parentId.split('_');
                var chartId = idParts[1];

                var selected = $('.drp-buttons .drp-selected').text();
                const [startDateText, endDateText] = selected.split(" - ");
                const startDate = moment(startDateText, 'MM/DD/YYYY').format('YYYY-MM-DD');
                const endDate = moment(endDateText, 'MM/DD/YYYY').format('YYYY-MM-DD');
                start = startDate;
                end = endDate;
                console.log(start);
                updateChartData(start, end, chartId);
            });

            var updateChartData = function(start, end, chartId) {
                // Send an AJAX request to the Laravel route
                $.ajax({
                    url: '/admin/update-widget-'+chartId,
                    type: 'GET',
                    data: {
                        start: start,
                        end: end,
                    },
                    success: function(response) {
                        var newSeries = response.bookings;
                        var newCategories = response.data;

                        if(chartId == 38){
                            var chart = KTChartsWidget38;
                            data3 = newSeries;
                            data4 = newCategories;
                        } else {
                            var chart = KTChartsWidget20;
                            data1 = newSeries;
                            data2 = newCategories;
                        }
                        chart.getOptions().destroy();
                        "undefined" != typeof module && (module.exports = chart), KTUtil.onDOMContentLoaded((function() {
                            chart.init()
                        }));
                    },
                    error: function(xhr, status, error) {
                        // Handle the error if needed
                        console.log(error);
                    }
                });
            }
        });
    </script>
@endsection
