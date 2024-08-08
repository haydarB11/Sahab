@extends('admin.empty')

@section('content')
    @include('admin.components.add-banner-modal')
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

                            <!--begin::Card toolbar-->
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">




                                <button type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_add_banners"
                                    class="btn btn-primary">Add Banner</button>


                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="table-responsive">

                            <!--begin::Table-->
                            <table class="table  align-middle table-row-dashed fs-6 gy-5" id="kt_datatable_banners">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">

                                        <th class=" min-w-100px">id</th>
                                        <th class=" min-w-100px">banner</th>
                                        <th class=" min-w-100px">status</th>
                                        <th class=" min-w-70px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @forelse ($images as $image)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Thumbnail-->

                                                    <!--end::Thumbnail-->
                                                    <div class="ms-5">
                                                        <!--begin::Title-->
                                                        <a href=""
                                                            class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                                            data-banners-filter="banners_id">{{ $image->id }}</a>
                                                        <!--end::Title-->
                                                    </div>
                                                </div>
                                            </td>

                                            <td class=" pe-0 text-gray-800"><img
                                                    src="{{ asset('/storage/' . $image->image) }}" alt="image"
                                                    width="100px" height="100px"></td>
                                            <td
                                                data-order="@if ($image->status == 1) IsActive
                                                    @else
                                                    InActive @endif">
                                                <p class="d-none ">
                                                    @if ($image->status == 1)
                                                        IsActive
                                                    @else
                                                        InActive
                                                    @endif
                                                </p>
                                                <label class="form-check form-switch form-check-custom form-check-solid"
                                                    style="padding-left: 50px;">
                                                    <input class="form-check-input image-toggle" type="checkbox"
                                                        value="1" name="status" id="imageToggle{{ $image->id }}"
                                                        data-image-id="{{ $image->id }}"
                                                        @if ($image->status == 1) checked @endif />
                                                    <span class="form-check-label fw-semibold text-muted text-gray-800">
                                                        Active
                                                    </span>
                                                </label>
                                            </td>
                                            <td>


                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <span data-banners-filter="delete_row" class="menu-link px-3">
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
        document.querySelectorAll('.image-toggle').forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                var imageId = this.dataset.imageId;
                var status = this.checked ? 1 : 0;
                $.ajax({
                    url: `/admin/banners/status/${imageId}/${status}`,
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
                                message: response.success,
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
