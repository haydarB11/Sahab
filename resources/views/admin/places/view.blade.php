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
                                        href="#kt_place_details">Place Details</a>
                                </li>
                                <!--end:::Tab item-->
                                <!--begin:::Tab item-->

                                <!--end:::Tab item-->
                            </ul>
                            <!--end:::Tabs-->
                            <!--begin::Button-->
                            <a href="{{ route('places.index') }}"
                                class="btn btn-icon btn-light btn-active-secondary btn-sm ms-auto me-lg-n7">
                            </a>

                            <!--begin::Menu-->



                            <!--end::Button-->
                            <!--begin::Button-->
                            <a href="{{ route('places.edit', $place) }}" class="btn btn-primary">Edit Place</a>


                            <!--end::Button-->
                        </div>
                        <!--begin::Order summary-->
                        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                            <!--begin::Order details-->
                            <div class="card card-flush py-4 flex-row-fluid">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>Place Details (#{{ $place->id }})</h2>
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
                                                    <td class="fw-bold text-end">{{ $place->created_at }}</td>
                                                </tr>

                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ki-outline ki-status fs-2 me-2"></i>Available Status
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold text-end"><span
                                                            class="@if ($place->available == 1) badge badge-light-success
                                                    @else
                                                    badge badge-light-danger @endif">
                                                            @if ($place->available == 1)
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
                                                            class="@if ($place->bookable == 1) badge badge-light-success
                                                    @else
                                                    badge badge-light-danger @endif">
                                                            @if ($place->bookable == 1)
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
                                                            class="@if ($place->featured == 1) badge badge-light-success
                                                    @else
                                                    badge badge-light-danger @endif">
                                                            @if ($place->featured == 1)
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
                                                                class="text-gray-600 text-hover-primary">{{ $place->vendor->name }}</a>
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
                                                            class="text-gray-600 text-hover-primary">{{ $place->vendor->email }}</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ki-outline ki-phone fs-2 me-2"></i>Phone
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold text-end">{{ $place->vendor->phone }}</td>
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
                            <div class="tab-pane fade show active" id="kt_place_details" role="tab-panel">
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
                                                    <h2>Place Info</h2>
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
                                                                <td class="fw-bold text-start">{{ $place->title }}</td>
                                                            </tr>

                                                            <tr>
                                                                <td class="text-muted">
                                                                    <div class="d-flex align-items-center">
                                                                        <i
                                                                            class="ki-outline ki-calendar fs-2 me-2"></i>Category
                                                                    </div>
                                                                </td>
                                                                <td class="fw-bold text-start">{{ $place->category->title }}
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td class="text-muted">
                                                                    <div class="d-flex align-items-center">
                                                                        <i
                                                                            class="ki-outline ki-calendar fs-2 me-2"></i>Address
                                                                    </div>
                                                                </td>
                                                                <td class="fw-bold text-start">{{ $place->address }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted">
                                                                    <div class="d-flex align-items-center">
                                                                        <i
                                                                            class="ki-outline ki-calendar fs-2 me-2"></i>Description
                                                                    </div>
                                                                </td>
                                                                <td class="fw-bold text-start">{{ $place->description }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="ki-outline ki-calendar fs-2 me-2"></i>Tag
                                                                    </div>
                                                                </td>
                                                                <td class="fw-bold text-start">{{ $place->tag }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted">
                                                                    <div class="d-flex align-items-center">
                                                                        <i
                                                                            class="ki-outline ki-calendar fs-2 me-2"></i>WeekDay
                                                                        Price
                                                                    </div>
                                                                </td>
                                                                <td class="fw-bold text-start">{{ $place->weekday_price }}
                                                                    KWD</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted">
                                                                    <div class="d-flex align-items-center">
                                                                        <i
                                                                            class="ki-outline ki-calendar fs-2 me-2"></i>WeekEnd
                                                                        Price
                                                                    </div>
                                                                </td>
                                                                <td class="fw-bold text-start">{{ $place->weekend_price }}
                                                                    KWD</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted">
                                                                    <div class="d-flex align-items-center">
                                                                        <i
                                                                            class="ki-outline ki-calendar fs-2 me-2"></i>Amenities
                                                                    </div>
                                                                </td>
                                                                <td class="fw-bold text-start">
                                                                    @forelse ($place->amenities as $ame)
                                                                        {{ $ame->title }}
                                                                        @if (!$loop->last)
                                                                            ,
                                                                        @endif

                                                                    @empty
                                                                        There is no Amenities
                                                                    @endforelse
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
                                                    Special Days
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
                                                            <th class="min-w-175px">Title</th>
                                                            <th class="min-w-70px text-end">price</th>
                                                            <th class="min-w-70px text-end">start date</th>
                                                            <th class="min-w-70px text-end">end date</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody class="fw-semibold text-gray-600">
                                                        @forelse($place->specialDays as $day)
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <!--begin::Title-->
                                                                        <div class="ms-5">
                                                                            <div class="fs-7 text-muted">
                                                                                {{ $day->title }}
                                                                            </div>
                                                                        </div>
                                                                        <!--end::Title-->
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    {{ $day->price }} KWD
                                                                </td>
                                                                <td class="text-end">
                                                                    {{ $day->start_date }}
                                                                </td>
                                                                <td class="text-end">
                                                                    {{ $day->end_date }}
                                                                </td>

                                                            </tr>

                                                        @empty
                                                        @endforelse




                                                    </tbody>
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Product List-->

                                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>
                                                    Place Images
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
                                                        @forelse($place->placeImages as $image)
                                                            <tr>

                                                                <td class="text-end text-black">
                                                                   <img src="{{ asset( $image->image) }}" alt="image" width="150px" height="150px">
                                                                </td>



                                                            </tr>

                                                        @empty

                                                            <p class="text-center">There is no images for this place</p>
                                                        @endforelse




                                                    </tbody>
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                        </div>
                                        <!--end::Card body-->
                                    </div>
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
