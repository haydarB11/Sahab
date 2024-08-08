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
                                    <input type="text" data-service-filter="search"
                                        class="form-control form-control-solid w-250px ps-12" placeholder="Search service" />
                                </div>
                                <!--end::Search-->


                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-service-toolbar="base">
                                    <!--begin::Filter-->
                                    <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                                        data-kt-menu-servicement="bottom-end">
                                        <i class="ki-outline ki-filter fs-2"></i>Filter</button>
                                    <!--begin::Menu 1-->
                                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true"
                                        id="kt-toolbar-filter">
                                        <!--begin::Header-->
                                        <div class="px-7 py-5">
                                            <div class="fs-4 text-dark fw-bold">Filter Options</div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Separator-->
                                        <div class="separator border-gray-200"></div>
                                        <!--end::Separator-->
                                        <!--begin::Content-->
                                        <div class="px-7 py-5" data-service-filter="form">

                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fs-5 fw-semibold mb-3">Available Status:</label>
                                                <!--end::Label-->
                                                <!--begin::Options-->
                                                <div class="d-flex flex-row flex-wrap fw-semibold"
                                                    data-service-filter="available">
                                                    <!--begin::Option-->
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                        <input class="form-check-input" type="radio" name="available"
                                                            value="all" checked="checked" />
                                                        <span class="form-check-label text-gray-600">All</span>
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                        <input class="form-check-input" type="radio" name="available"
                                                            value="IsActive" />
                                                        <span class="form-check-label text-gray-600">Available</span>
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio" name="available"
                                                            value="InActive" />
                                                        <span class="form-check-label text-gray-600">Not Available</span>
                                                    </label>
                                                    <!--end::Option-->

                                                </div>
                                                <!--end::Options-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fs-5 fw-semibold mb-3">Bookable Status:</label>
                                                <!--end::Label-->
                                                <!--begin::Options-->
                                                <div class="d-flex flex-row flex-wrap fw-semibold"
                                                    data-service-filter="bookable">
                                                    <!--begin::Option-->
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                        <input class="form-check-input" type="radio" name="bookable"
                                                            value="all" checked="checked" />
                                                        <span class="form-check-label text-gray-600">All</span>
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                        <input class="form-check-input" type="radio" name="bookable"
                                                            value="IsBookable" />
                                                        <span class="form-check-label text-gray-600">Bookable</span>
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio" name="bookable"
                                                            value="NotBookable" />
                                                        <span class="form-check-label text-gray-600">Not Bookable</span>
                                                    </label>
                                                    <!--end::Option-->

                                                </div>
                                                <!--end::Options-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fs-5 fw-semibold mb-3">Featured Status:</label>
                                                <!--end::Label-->
                                                <!--begin::Options-->
                                                <div class="d-flex flex-row flex-wrap fw-semibold"
                                                    data-service-filter="featured">
                                                    <!--begin::Option-->
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                        <input class="form-check-input" type="radio" name="featured"
                                                            value="all" checked="checked" />
                                                        <span class="form-check-label text-gray-600">All</span>
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                        <input class="form-check-input" type="radio" name="featured"
                                                            value="IsFeatured" />
                                                        <span class="form-check-label text-gray-600">Featured</span>
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="radio" name="featured"
                                                            value="NotFeatured" />
                                                        <span class="form-check-label text-gray-600">Not Featured</span>
                                                    </label>
                                                    <!--end::Option-->

                                                </div>
                                                <!--end::Options-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Actions-->
                                            <div class="d-flex justify-content-end">
                                                <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                                    data-kt-menu-dismiss="true" data-service-filter="reset">Reset</button>
                                                <button type="submit" class="btn btn-primary"
                                                    data-kt-menu-dismiss="true" data-service-filter="filter">Apply</button>
                                            </div>
                                            <!--end::Actions-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Menu 1-->
                                    <!--end::Filter-->

                                    <!--begin::Add customer-->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_customer">Add service</button>
                                    <!--end::Add customer-->
                                </div>
                                <!--end::Toolbar-->

                            </div>
                            <!--end::Card toolbar-->

                            <!--begin::Card body-->
                            <div class="table-responsive">

                                <!--begin::Table-->
                                <table class="table  align-middle table-row-dashed fs-6 gy-5" id="kt_datatable_services">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">

                                            <th class="w-1px">service Id</th>
                                            <th class=" min-w-150px">info</th>
                                            <th class=" min-w-100px">Description</th>
                                            <th class=" min-w-100px">Capacity</th>
                                            <th class=" min-w-100px">Service Duration</th>
                                            <th class=" min-w-100px">Notice period</th>
                                            <th class=" min-w-100px">Price</th>
                                            <th class=" min-w-100px">Post Status</th>
                                            <th class=" min-w-70px">Booking Status</th>
                                            <th class=" min-w-70px">Featured</th>
                                            <th class=" min-w-70px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @forelse ($services as $service)
                                            <tr>

                                                <td>
                                                    <div class="d-flex align-items-center">

                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="{{ route('services.show', $service) }}"
                                                                class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                                                data-service-filter="service_id"
                                                                >{{ $service->id }}</a>
                                                            <!--end::Title-->
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="text-start pe-0 text-gray-800">
                                                    <div class="d-flex flex-column">
                                                        <a href="{{ route('services.show',$service) }}"
                                                            class="text-gray-800 text-hover-primary mb-1" data-service-filter="service_name">{{ $service->title }}</a>
                                                        <span>category : {{ $service->category->title }}</span>
                                                    </div>
                                                </td>
                                                <td class=" pe-0 text-gray-800">
                                                    {{ strlen($service->description) > 50 ? substr($service->description, 0, 50) . '...' : $service->description }}
                                                </td>
                                                <td class=" pe-0 text-gray-800">{{ $service->max_capacity }}</td>
                                                <td class=" pe-0 text-gray-800">{{ $service->duration }}</td>

                                                <td class=" pe-0 text-gray-800">{{ $service->notice_period }}</td>
                                                <td class=" pe-0 text-gray-800">{{ $service->price }} KWD</td>


                                                <td class=""
                                                    data-order="@if ($service->available == 1) IsActive
                                                @else
                                                InActive @endif">


                                                    <span
                                                        class="@if ($service->available == 1) badge badge-light-success
                                                    @else
                                                    badge badge-light-danger @endif">
                                                        @if ($service->available == 1)
                                                            IsActive
                                                        @else
                                                            InActive
                                                        @endif
                                                    </span>

                                                </td>

                                                <td class=""
                                                    data-order="@if ($service->bookable == 1) IsBookable
                                            @else
                                            NotBookable @endif">


                                                    <span
                                                        class="@if ($service->bookable == 1) badge badge-light-success
                                                @else
                                                badge badge-light-danger @endif">
                                                        @if ($service->bookable == 1)
                                                            IsBookable
                                                        @else
                                                            NotBookable
                                                        @endif
                                                    </span>

                                                </td>
                                                <td class=""
                                                    data-order="@if ($service->featured == 1) IsFeatured
                                        @else
                                        NotFeatured @endif">


                                                    <span
                                                        class="@if ($service->featured == 1) badge badge-light-success
                                            @else
                                            badge badge-light-danger @endif">
                                                        @if ($service->featured == 1)
                                                            IsFeatured
                                                        @else
                                                            NotFeatured
                                                        @endif
                                                    </span>

                                                </td>


                                                <td class="">
                                                    <a href="#"
                                                        class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                                        data-kt-menu-trigger="click"
                                                        data-kt-menu-servicement="bottom-end">Actions
                                                        <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                        data-kt-menu="true">

                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('services.show', $service) }}"
                                                                class="menu-link px-3">View</a>
                                                        </div>

                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('services.edit', $service) }}"
                                                                class="menu-link px-3">Edit</a>
                                                        </div>


                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="" class="menu-link px-3"
                                                                data-service-filter="delete_row">Delete</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
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

        <script>
            document.querySelectorAll('.service-toggle').forEach(function(toggle) {
                toggle.addEventListener('change', function() {
                    var serviceId = this.dataset.serviceId;
                    var status = this.checked ? 1 : 0;
                    $.ajax({
                        url: `/admin/services/status/${serviceId}/?status=${status}`,
                        type: "GET",
                        dataType: "JSON",
                        processData: false,
                        contentType: false,

                        success: function(response) {

                            if (response.errors) {
                                console.log(response);
                                var errorMsg = '';
                                $.each(response.errors, function(field, errors) {
                                    $.each(errors, function(index, error) {
                                        errorMsg += error + '<br>';
                                    });
                                });
                                iziToast.error({
                                    message: errorMsg,
                                    position: 'topRight'
                                });

                            } else {
                                iziToast.success({
                                    message: response.message,
                                    position: 'topRight'
                                });


                            }

                        },
                        error: function(xhr, status, error) {
                            console.log(error);

                            iziToast.error({
                                message: 'An error occurred: ' + error,
                                position: 'topRight'
                            });
                        }
                    });

                });
            });
        </script>
    @endsection
