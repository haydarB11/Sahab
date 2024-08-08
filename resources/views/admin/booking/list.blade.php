@extends('admin.empty')

@section('content')
    <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-fluid">
                    <!--begin::universitys-->
                    <div class="card card-flush" style="padding: 50px; margin: 10px">
                        <!--begin::Card header-->
                        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                                    <input type="text" data-booking-filter="search"
                                        class="form-control form-control-solid w-250px ps-12"
                                        placeholder="Search Booking" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-1">

                                <div id="booking_views_export" class="d-none"></div>

                                <div class="w-100 mw-150px">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Status" data-booking-filter="status">
                                        <option></option>
                                        <option value="all">All</option>
                                        <option value="placed">Placed</option>
                                        <option value="completed">Completed</option>
                                        <option value="canceled">Canceled</option>
                                    </select>
                                    <!--end::Select2-->
                                </div>
                                <!--begin::Flatpickr-->
                                <div class="input-group w-250px">
                                    <input name="date_filter" class="form-control form-control-solid rounded rounded-end-0"
                                        placeholder="Pick date range" id="kt_booking_flatpickr" />
                                    <button class="btn btn-icon btn-light" id="kt_booking_flatpickr_clear">
                                        <i class="ki-outline ki-cross fs-2"></i>
                                    </button>
                                </div>
                                <!--end::Flatpickr-->

                                <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-end">
                                    <i class="ki-outline ki-exit-up fs-2"></i>Export</button>
                                <!--begin::Menu-->
                                <div id="booking_export_menu"
                                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                    data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-booking-export="pdf">Export As Pdf
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-booking-export="excel">Export as
                                            Excel</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-booking-export="csv">Export as
                                            CSV</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--end::Export-->
                                </div>
                                <!--end::Add university-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="table-responsive">

                            <!--begin::Table-->
                            <table class="table  align-middle table-row-dashed fs-6 gy-5" id="kt_datatable_booking">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">

                                        <th class="min-w-10px">Booking Id</th>
                                        <th class="text-end min-w-100px">Title</th>
                                        <th class="text-end min-w-100px">Category</th>
                                        <th class="text-end min-w-100px">Full Name</th>
                                        <th class="text-end min-w-100px">Email</th>
                                        <th class="text-end min-w-100px">Mobile Number</th>
                                        <th class="text-end min-w-170px">Date Range</th>
                                        <th class="text-end min-w-100px">Promo code</th>
                                        <th class="text-end min-w-100px">Discount amount</th>
                                        <th class="text-end min-w-100px">Total Amount</th>
                                        <th class="text-end min-w-100px">Payment Method</th>
                                        <th class="text-end min-w-100px">Transaction ID</th>
                                        <th class="text-end min-w-100px">Invoice Reference</th>
                                        <th class="text-end min-w-100px">Status</th>
                                        <th class="text-end min-w-100px">Date</th>
                                        <th class="text-end min-w-70px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @forelse ($bookings as $booking)
                                        <tr>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Thumbnail-->

                                                    <!--end::Thumbnail-->
                                                    <div class="ms-5">
                                                        <!--begin::Title-->
                                                        <a href="{{ route('bookings.show', $booking) }}"
                                                            class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                                            data-booking-filter="booking_id">{{ $booking->id }}</a>
                                                        <!--end::Title-->
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-end pe-0 text-black">
                                                {{ $booking->place_id === null ? $booking->service->title?? "Deleted" : $booking->place->title ?? "Deleted" }}
                                            </td>
                                            <td class="text-end pe-0 text-black">
                                                {{ $booking->place_id === null ? $booking->service->category->title ?? "Deleted": $booking->place->category->title?? "Deleted" }}
                                            </td>
                                            <td class="text-end pe-0 text-gray-800">{{ $booking->user->name ?? "Deleted" }}</td>
                                            <td class="text-end pe-0"><a class="text-gray-800 text-hover-primary mb-1"
                                                    href="">{{ $booking->user->email ?? "Deleted" }}</a> </td>
                                            <td class="text-end pe-0">{{ $booking->user->phone ?? "Deleted" }}</td>
                                            <td class="text-start pe-0 text-gray-800">
                                                <div class="d-flex flex-column">
                                                    @if ($booking->place_id === null)
                                                        {{ \Carbon\Carbon::parse($booking->starting_date)->format('Y/m/d H:i') }}-{{ \Carbon\Carbon::parse($booking->ending_date)->format('H:i') }}
                                                    @else
                                                        {{ \Carbon\Carbon::parse($booking->starting_date)->format('Y/m/d') }}
                                                        {{ \Carbon\Carbon::parse($booking->ending_date)->format('Y/m/d') }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-end pe-0 text-primary">
                                                {{ $booking->promoCode->code ??
                                                    'No Promo
                                                                                        Code' }}
                                            </td>
                                            <td class="text-end pe-0">
                                                {{ $booking->promoCode->discount ?? 'No Promo Code' }}</td>
                                            <td class="text-end pe-0 text-gray-800">{{ $booking->total_price }}</td>
                                            <td class="text-end pe-0 text-gray-800">
                                                {{ $booking->paymentMethod->payment_method ?? '' }}</td>
                                            <td class="text-end pe-0 text-gray-800">{{ $booking->transaction_id }}</td>
                                            <td class="text-end pe-0 text-gray-800">{{ $booking->invoice_reference }}</td>
                                            <td class="text-end pe-0"
                                                data-order="@if ($booking->status == 'placed') Placed
                                                @elseif ($booking->status == 'completed')
                                                Completed
                                                @else
                                                Canceled @endif">
                                                <span
                                                    class="@if ($booking->status == 'placed') badge badge-light-warning
                                                    @elseif ($booking->status == 'completed')
                                                    badge badge-light-success
                                                    @else
                                                    badge badge-light-danger @endif">{{ $booking->status }}</span>
                                            </td>


                                            <td class="text-end pe-0">
                                                {{ \Carbon\Carbon::parse($booking->created_at)->format('Y-m-d') }}</td>

                                            <td class="text-end">


                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="{{ route('bookings.show', $booking) }}">
                                                        <span class="menu-link px-3">
                                                            <i class="ki-duotone ki-eye fs-2qx text-danger">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                                <span class="path4"></span>
                                                            </i>
                                                            view
                                                        </span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->


                                            </td>

                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::universitys-->
                </div>
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->

    </div>
@endsection
