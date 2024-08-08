@extends('admin.empty')

@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-fluid">
                    <!--begin::Order details page-->
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10">
                            <!--begin:::Tabs-->
                            <ul
                                class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-lg-n2 me-auto">
                                <!--begin:::Tab item-->
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                        href="#kt_ecommerce_sales_order_summary">Order Summary</a>
                                </li>
                                <!--end:::Tab item-->
                                <!--begin:::Tab item-->

                                <!--end:::Tab item-->
                            </ul>
                            <!--end:::Tabs-->
                            <!--begin::Button-->
                            <a href="{{ route('bookings.index') }}"
                                class="btn btn-icon btn-light btn-active-secondary btn-sm ms-auto me-lg-n7">
                            </a>
                            <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                                <i class="ki-outline ki-edit-up fs-2"></i>Edit status</button>
                            <!--begin::Menu-->
                            <div id="edit_status_menu"
                                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{ route('bookings.update.status', $booking).'?status=completed' }}"
                                        class="menu-link px-3">Completed
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{ route('bookings.update.status', $booking).'?status=placed' }}"
                                        class="menu-link px-3">Placed</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{ route('bookings.update.status', $booking).'?status=canceled' }}"
                                        class="menu-link px-3">Canceled</a>
                                </div>
                                <!--end::Menu item-->
                                <!--end::Export-->
                            </div>


                            <!--end::Button-->
                            <!--begin::Button-->



                            <!--end::Button-->
                        </div>
                        <!--begin::Order summary-->
                        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                            <!--begin::Order details-->
                            <div class="card card-flush py-4 flex-row-fluid">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Booking Details (#{{ $booking->id }})</h2>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                            <tbody class="fw-semibold text-gray-600">
                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ki-outline ki-calendar fs-2 me-2"></i>Date Added
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold text-end">{{ $booking->created_at }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ki-outline ki-wallet fs-2 me-2"></i>Payment Method
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold text-end">{{ $booking->payment_method }}
                                                        <img src="{{ asset('assets/media/svg/card-logos/visa.svg') }}"
                                                            class="w-50px ms-2" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ki-outline ki-status fs-2 me-2"></i>Status
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold text-end"><span
                                                            class="@if ($booking->status == 'placed') badge badge-light-warning
                                                    @elseif ($booking->status == 'completed')
                                                    badge badge-light-success
                                                    @else
                                                    badge badge-light-danger @endif">{{ $booking->status }}</span>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Order details-->
                            <!--begin::Customer details-->
                            <div class="card card-flush py-4 flex-row-fluid">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>User Details</h2>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                            <tbody class="fw-semibold text-gray-600">
                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ki-outline ki-profile-circle fs-2 me-2"></i>User
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold text-end">
                                                        <div class="d-flex align-items-center justify-content-end">
                                                            <!--begin:: Avatar -->
                                                            <div
                                                                class="symbol symbol-circle symbol-25px overflow-hidden me-3">
                                                                <a href="">
                                                                    <div class="symbol-label">
                                                                        <img src="{{ asset('assets/media/avatars/300-23.jpg') }}"
                                                                            alt="Logo" class="w-100" />
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <!--end::Avatar-->
                                                            <!--begin::Name-->
                                                            <a href="../../demo25/dist/apps/ecommerce/customers/details.html"
                                                                class="text-gray-600 text-hover-primary">{{ $booking->user->name }}</a>
                                                            <!--end::Name-->
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ki-outline ki-sms fs-2 me-2"></i>Email
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold text-end">
                                                        <a href=""
                                                            class="text-gray-600 text-hover-primary">{{ $booking->user->email }}</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ki-outline ki-phone fs-2 me-2"></i>Phone
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold text-end">{{ $booking->user->phone }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Customer details-->

                        </div>
                        <!--end::Order summary-->
                        <!--begin::Tab content-->
                        <div class="tab-content">
                            <!--begin::Tab pane-->
                            <div class="tab-pane fade show active" id="kt_ecommerce_sales_order_summary" role="tab-panel">
                                <!--begin::Orders-->
                                <div class="d-flex flex-column gap-7 gap-lg-10">
                                    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                                        <!--begin::Payment address-->
                                        <div class="card card-flush py-4 flex-row-fluid position-relative">
                                            <!--begin::Background-->
                                            <div
                                                class="position-absolute top-0 end-0 bottom-0 opacity-10 d-flex align-items-center me-5">
                                                <i class="ki-solid ki-two-credit-cart" style="font-size: 14em"></i>
                                            </div>
                                            <!--end::Background-->
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h2>Billing Info</h2>
                                                </div>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                Transaction Id : {{ $booking->transaction_id }}<br>
                                                Invoice Reference : {{ $booking->invoice_reference }}<br>
                                                Total Amount : {{ $booking->total_price }}<br>
                                                PromoCode : {{ $booking->promoCode->code ?? 'There is no promo code' }}<br>
                                                Discount :
                                                {{ $booking->promoCode->discount ?? 'There is no promo code' }}<br>
                                                Payment : {{ $booking->payment }}
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Payment address-->

                                    </div>
                                    <!--begin::Product List-->
                                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>
                                                    @if ($booking->place_id == null)
                                                        Service
                                                    @else
                                                        Place
                                                    @endif
                                                </h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <div class="table-responsive">
                                                <!--begin::Table-->
                                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                    <thead>
                                                        <tr
                                                            class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                            <th class="min-w-175px">Info</th>
                                                            <th class="min-w-70px text-end">Vendor Email</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody class="fw-semibold text-gray-600">
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">

                                                                    <!--begin::Title-->
                                                                    <div class="ms-5">
                                                                        <a href=""
                                                                            class="fw-bold text-gray-600 text-hover-primary">
                                                                            @if ($booking->place_id == null)
                                                                                {{ $booking->service->title }}
                                                                            @else
                                                                                {{ $booking->place->title }}
                                                                            @endif
                                                                        </a>
                                                                        <div class="fs-7 text-muted">Category :
                                                                            @if ($booking->place_id == null)
                                                                                {{ $booking->service->category->title }}
                                                                            @else
                                                                                {{ $booking->place->category->title }}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Title-->
                                                                </div>
                                                            </td>
                                                            <td class="text-end">
                                                                @if ($booking->place_id == null)
                                                                    {{ $booking->service->vendor->email }}
                                                                @else
                                                                    {{ $booking->place->vendor->email }}
                                                                @endif
                                                            </td>

                                                        </tr>



                                                    </tbody>
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Product List-->
                                </div>
                                <!--end::Orders-->
                            </div>
                            <!--end::Tab pane-->

                        </div>
                        <!--end::Tab content-->
                    </div>
                    <!--end::Order details page-->
                </div>
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->

    </div>
@endsection
