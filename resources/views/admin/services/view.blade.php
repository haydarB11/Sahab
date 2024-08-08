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
                                        href="#kt_service_details">service Details</a>
                                </li>
                                <!--end:::Tab item-->
                                <!--begin:::Tab item-->

                                <!--end:::Tab item-->
                            </ul>
                            <!--end:::Tabs-->
                            <!--begin::Button-->
                            <a href="{{ route('services.index') }}"
                                class="btn btn-icon btn-light btn-active-secondary btn-sm ms-auto me-lg-n7">
                            </a>

                            <!--begin::Menu-->



                            <!--end::Button-->
                            <!--begin::Button-->
                            <a href="{{ route('services.edit', $service) }}" class="btn btn-primary">Edit Service</a>


                            <!--end::Button-->
                        </div>
                        <!--begin::Order summary-->
                        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                            <!--begin::Order details-->
                            <div class="card card-flush py-4 flex-row-fluid">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Service Details (#{{ $service->id }})</h2>
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
                                                    <td class="fw-bold text-end">{{ $service->created_at }}</td>
                                                </tr>

                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ki-outline ki-status fs-2 me-2"></i>Available Status
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold text-end"><span
                                                            class="@if ($service->available == 1) badge badge-light-success
                                                    @else
                                                    badge badge-light-danger @endif">
                                                            @if ($service->available == 1)
                                                                Available
                                                            @else
                                                                Not Available
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ki-outline ki-status fs-2 me-2"></i>Bookable Status
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold text-end"><span
                                                            class="@if ($service->bookable == 1) badge badge-light-success
                                                    @else
                                                    badge badge-light-danger @endif">
                                                            @if ($service->bookable == 1)
                                                                Bookable
                                                            @else
                                                                Not Bookable
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ki-outline ki-status fs-2 me-2"></i>Featured Status
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold text-end"><span
                                                            class="@if ($service->featured == 1) badge badge-light-success
                                                    @else
                                                    badge badge-light-danger @endif">
                                                            @if ($service->featured == 1)
                                                                Featured
                                                            @else
                                                                Not Featured
                                                            @endif
                                                        </span>
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
                                        <h2>Vendor Details</h2>
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
                                                            <i class="ki-outline ki-profile-circle fs-2 me-2"></i>Vendor
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
                                                            <a href=""
                                                                class="text-gray-600 text-hover-primary">{{ $service->vendor->name }}</a>
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
                                                            class="text-gray-600 text-hover-primary">{{ $service->vendor->email }}</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ki-outline ki-phone fs-2 me-2"></i>Phone
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold text-end">{{ $service->vendor->phone }}</td>
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
                            <div class="tab-pane fade show active" id="kt_service_details" role="tab-panel">
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
                                                    <h2>Service Info</h2>
                                                </div>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                <div class="table-responsive">
                                                    <!--begin::Table-->
                                                    <table
                                                        class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                                        <tbody class="fw-semibold text-gray-600">
                                                            <tr>
                                                                <td class="text-muted">
                                                                    <div class="d-flex align-items-center">
                                                                        <i
                                                                            class="ki-outline ki-calendar fs-2 me-2"></i>Title
                                                                    </div>
                                                                </td>
                                                                <td class="fw-bold text-start">{{ $service->title }}</td>
                                                            </tr>

                                                            <tr>
                                                                <td class="text-muted">
                                                                    <div class="d-flex align-items-center">
                                                                        <i
                                                                            class="ki-outline ki-calendar fs-2 me-2"></i>Category
                                                                    </div>
                                                                </td>
                                                                <td class="fw-bold text-start">
                                                                    {{ $service->category->title }}
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td class="text-muted">
                                                                    <div class="d-flex align-items-center">
                                                                        <i
                                                                            class="ki-outline ki-calendar fs-2 me-2"></i>Description
                                                                    </div>
                                                                </td>
                                                                <td class="fw-bold text-start">{{ $service->description }}
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td class="text-muted">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="ki-outline ki-calendar fs-2 me-2"></i>
                                                                        Price
                                                                    </div>
                                                                </td>
                                                                <td class="fw-bold text-start">{{ $service->price }}
                                                                    KWD</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="ki-outline ki-calendar fs-2 me-2"></i>
                                                                        Duration
                                                                    </div>
                                                                </td>
                                                                <td class="fw-bold text-start">{{ $service->duration }}
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td class="text-muted">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="ki-outline ki-calendar fs-2 me-2"></i>
                                                                        Capacity
                                                                    </div>
                                                                </td>
                                                                <td class="fw-bold text-start">
                                                                    {{ $service->max_capacity }}
                                                                </td>
                                                            </tr>




                                                        </tbody>
                                                    </table>
                                                    <!--end::Table-->
                                                </div>
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
                                                    Available Times
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

                                                            <th class="min-w-100px text-end">start time</th>
                                                            <th class="min-w-100px text-end">end time</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody class="fw-semibold text-gray-600">
                                                        @forelse($service->availableTimes as $time)
                                                            <tr>

                                                                <td class="text-end text-black">
                                                                    {{ $time->starting_date }}
                                                                </td>
                                                                <td class="text-end text-black">
                                                                    {{ $time->ending_date }}
                                                                </td>


                                                            </tr>

                                                        @empty

                                                            <p class="text-center">There is no times for this service</p>
                                                        @endforelse




                                                    </tbody>
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                        </div>
                                        <!--end::Card body-->
                                    </div>

                                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>
                                                    Service Images
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

                                                            <th class="min-w-100px text-end">image</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody class="fw-semibold text-gray-600">
                                                        @forelse($service->serviceImages as $image)
                                                            <tr>

                                                                <td class="text-end text-black">
                                                                   <img src="{{ asset('/storage' . $image->image) }}" alt="image" width="150px" height="150px">
                                                                </td>



                                                            </tr>

                                                        @empty

                                                            <p class="text-center">There is no images for this service</p>
                                                        @endforelse




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
