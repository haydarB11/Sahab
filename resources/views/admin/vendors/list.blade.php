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
                                    <input type="text" data-vendor-filter="search"
                                        class="form-control form-control-solid w-250px ps-12" placeholder="Search Vendor" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">


                                <div class="w-100 mw-150px">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Status" data-vendor-filter="status">
                                        <option></option>
                                        <option value="all">All</option>
                                        <option value="IsActive">IsActive</option>
                                        <option value="InActive">InActive</option>
                                    </select>
                                    <!--end::Select2-->
                                </div>

                                <a href="{{ route('vendors.create') }}" class="btn btn-primary">Add Vendor</a>


                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="table-responsive">

                            <!--begin::Table-->
                            <table class="table  align-middle table-row-dashed fs-6 gy-5" id="kt_datatable_vendors">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">

                                        <th class="min-w-10px">vendor Id</th>
                                        <th class="text-end min-w-70px">Name</th>
                                        <th class="text-end min-w-50px">Mobile Number</th>
                                        <th class="text-end min-w-50px">Email</th>
                                        <th class="text-end min-w-50px">Supplier Code</th>
                                        <th class="text-end min-w-50px">Commission</th>
                                        <th class="text-end min-w-50px">Status</th>
                                        <th class="text-end min-w-70px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @forelse ($vendors as $vendor)
                                        <tr>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Thumbnail-->

                                                    <!--end::Thumbnail-->
                                                    <div class="ms-5">
                                                        <!--begin::Title-->
                                                        <a href="{{ route('vendors.show', $vendor) }}"
                                                            class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                                            data-vendor-filter="vendor_id">{{ $vendor->id }}</a>
                                                        <!--end::Title-->
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-end pe-0 text-black" data-vendor-filter="vendor_name">
                                                {{ $vendor->name }}</td>
                                            <td class="text-end pe-0 text-black">{{ $vendor->phone }}</td>
                                            <td class="text-end pe-0 text-black">{{ $vendor->email }}</td>
                                            <td class="text-end pe-0 text-black">{{ $vendor->supplier_code }}</td>
                                            <td class="text-end pe-0 text-black">{{ $vendor->commission }}</td>


                                            <td class="text-end pe-0 pl-20 text-black"
                                                data-order="@if ($vendor->status == 'activated') IsActive
                                                @else
                                                InActive @endif">
                                                <p class="d-none">
                                                    @if ($vendor->status == 'activated')
                                                        IsActive
                                                    @else
                                                        InActive
                                                    @endif
                                                </p>
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input vendor-toggle" type="checkbox"
                                                        value="1" name="status" id="vendorToggle{{ $vendor->id }}"
                                                        data-vendor-id="{{ $vendor->id }}"
                                                        @if ($vendor->status == 'activated') checked @endif />
                                                    <span class="form-check-label fw-semibold text-muted">
                                                        Active
                                                    </span>
                                                </label>
                                            </td>


                                            <td class="text-end">
                                                <a href="#"
                                                    class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                    data-kt-menu="true">

                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('vendor.places', $vendor) }}"
                                                            class="menu-link px-3">View Places</a>
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('vendor.services', $vendor) }}"
                                                            class="menu-link px-3">View Services</a>
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('vendors.edit', $vendor) }}"
                                                            class="menu-link px-3">Edit</a>
                                                    </div>


                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="" class="menu-link px-3"
                                                            data-vendor-filter="delete_row">Delete</a>
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
        document.querySelectorAll('.vendor-toggle').forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                var vendorId = this.dataset.vendorId;
                var status = this.checked ? 1 : 0;
                $.ajax({
                    url: `/admin/vendors/status/${vendorId}/?status=${status}`,
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
