@extends('admin.empty')

@section('content')
    @include('admin.components.add-amenities-modal')
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
                                    <input type="text" data-amenity-filter="search"
                                        class="form-control form-control-solid w-250px ps-12"
                                        placeholder="Search Amenity" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">


                                <div class="w-100 mw-150px">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Status" data-amenity-filter="status">
                                        <option></option>
                                        <option value="all">All</option>
                                        <option value="IsActive">Active</option>
                                        <option value="InActive">Inactive</option>
                                    </select>
                                    <!--end::Select2-->
                                </div>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_add_amenities"
                                    class="btn btn-primary">Add Amenities</button>

                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="table-responsive">

                            <!--begin::Table-->
                            <table class="table  align-middle table-row-dashed fs-6 gy-5" id="kt_datatable_amenities">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">

                                        <th class="min-w-10px">Amenities Id</th>
                                        <th class=" min-w-70px">Title English</th>
                                        <th class=" min-w-70px">Title Arabic</th>
                                        <th class=" min-w-70px">Icon</th>
                                        <th class="min-w-70px">Status</th>
                                        <th class=" min-w-70px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @forelse ($amenities as $amenity)
                                        <tr>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Thumbnail-->

                                                    <!--end::Thumbnail-->
                                                    <div class="ms-5">
                                                        <!--begin::Title-->
                                                        <a type="button"
                                                            class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                                            data-amenity-filter="amenity_id">{{ $amenity->id }}</a>
                                                        <!--end::Title-->
                                                    </div>
                                                </div>
                                            </td>

                                            <td class=" pe-0 text-black" data-amenity-filter="amenity_name">
                                                {{ $amenity->title }}</td>
                                            <td class=" pe-0 text-black" data-amenity-filter="amenity_name">
                                                {{ $amenity->title_ar }}</td>
                                            <td class=" pe-0"><img src="{{ asset($amenity->icon) }}" alt="logo"
                                                    width="80px" height="80px"></td>



                                            <td class="pe-0 pl-20 text-black"
                                                data-order="@if ($amenity->status == 1) Active
                                                @else
                                                InActive @endif">

                                                <p class="d-none ">
                                                    @if ($amenity->status == 1)
                                                        IsActive
                                                    @else
                                                        InActive
                                                    @endif
                                                </p>
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input amenity-toggle" type="checkbox"
                                                        value="1" name="status" id="amenityToggle{{ $amenity->id }}"
                                                        data-amenity-id="{{ $amenity->id }}"
                                                        @if ($amenity->status == 1) checked @endif />
                                                    <span class="form-check-label fw-semibold text-muted">
                                                        Active
                                                    </span>
                                                </label>
                                            </td>

                                            <td>


                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <span data-amenity-filter="delete_row" class="menu-link px-3">
                                                        <i class="ki-duotone ki-trash fs-2qx text-danger">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                        </i>
                                                        delete
                                                    </span>
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

    <script>
        document.querySelectorAll('.amenity-toggle').forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                var amenityId = this.dataset.amenityId;
                var status = this.checked ? 1 : 0;
                $.ajax({
                    url: `/admin/amenities/status/${amenityId}/?status=${status}`,
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
