@extends('admin.empty')

@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid" style="padding: 50px; margin: 10px">
                <!--begin::Basic info-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                        data-bs-target="#kt_account_profile_details" aria-expanded="true"
                        aria-controls="kt_account_profile_details">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Edit Service</h3>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Content-->
                    <div id="kt_service_details" class="collapse show">
                        <!--begin::Form-->
                        <form id="kt_edit_service_form" method="POST" class="form"
                            action="{{ route('services.update', $service->id) }}"
                            data-kt-redirect="{{ route('services.index') }}">
                            @csrf
                            <!--begin::Card body-->

                            <div class="card-body border-top p-9">

                                <input type="hidden" name="_method" value="PUT">

                                <!--begin::Input group-->


                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Title</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="title"
                                            class="form-control form-control-lg form-control-solid" placeholder="title"
                                            value="{{ $service->title }}" />
                                    </div>
                                    <!--end::Col-->
                                </div>


                                <div class="d-flex flex-column mb-7 fv-row">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="required">Category</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    @php
                                        $categories = \App\Models\Category::all();
                                    @endphp
                                    <select name="category" aria-label="Select a Category" data-control="select2"
                                        data-placeholder="Select a Tag..." data-dropdown-parent="#kt_edit_service_form"
                                        class="form-select form-select-solid fw-bold">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if ($service->category_id == $category->id) selected @endif>
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>

                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Description</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <textarea name="description" class="form-control form-control-lg form-control-solid" placeholder="description"
                                            rows="7">{{ $service->description }}</textarea>
                                    </div>
                                    <!--end::Col-->
                                </div>


                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Duration</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="number" name="duration"
                                            class="form-control form-control-lg form-control-solid" placeholder="duration"
                                            value="{{ $service->duration }}" />
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Capacity</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="number" name="capacity"
                                            class="form-control form-control-lg form-control-solid" placeholder="capacity"
                                            value="{{ $service->max_capacity }}" />
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Price</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="number" name="price"
                                            class="form-control form-control-lg form-control-solid" placeholder="price"
                                            value="{{ $service->price }}" />
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Notice Period</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="time" name="notice_period"
                                            class="form-control form-control-lg form-control-solid"
                                            placeholder="notice period " value="{{ $service->notice_period }}" />
                                    </div>
                                    <!--end::Col-->
                                </div>


                                <!--begin::switch-->
                                <div class="d-flex flex-stack w-lg-50 mb-6">

                                    <div class="me-5">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold">Available ?</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="fs-7 fw-semibold text-muted">If you want to make this service
                                            available</div>
                                        <!--end::Input-->
                                    </div> <!--end::Label-->
                                    <!--begin::Col-->
                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input category-toggle" type="checkbox" value="1"
                                            name="available" id="serviceToggle{{ $service->id }}"
                                            data-service-id="{{ $service->id }}"
                                            @if ($service->available == 1) checked @endif />
                                        <span class="form-check-label fw-semibold text-muted text-gray-800">
                                            Available
                                        </span>
                                    </label>
                                </div>
                                <!--end::switch-->

                                <!--begin::switch-->
                                <div class="d-flex flex-stack w-lg-50 mb-6">

                                    <div class="me-5">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold">Bookable ?</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="fs-7 fw-semibold text-muted">If you want to make this service
                                            bookable</div>
                                        <!--end::Input-->
                                    </div> <!--end::Label-->
                                    <!--begin::Col-->
                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input category-toggle" type="checkbox" value="1"
                                            name="bookable" id="serviceToggle{{ $service->id }}"
                                            data-service-id="{{ $service->id }}"
                                            @if ($service->bookable == 1) checked @endif />
                                        <span class="form-check-label fw-semibold text-muted text-gray-800">
                                            Bookable
                                        </span>
                                    </label>
                                </div>
                                <!--end::switch-->

                                <!--begin::switch-->
                                <div class="d-flex flex-stack w-lg-50 mb-6">

                                    <div class="me-5">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold">Featured ?</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="fs-7 fw-semibold text-muted">If you want to make this service
                                            Featured</div>
                                        <!--end::Input-->
                                    </div> <!--end::Label-->
                                    <!--begin::Col-->
                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input category-toggle" type="checkbox" value="1"
                                            name="featured" id="serviceToggle{{ $service->id }}"
                                            data-service-id="{{ $service->id }}"
                                            @if ($service->featured == 1) checked @endif />
                                        <span class="form-check-label fw-semibold text-muted text-gray-800">
                                            Featured
                                        </span>
                                    </label>
                                </div>
                                <!--end::switch-->

                                <!--begin::Media-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Images</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-2">
                                            <!--begin::Dropzone-->
                                            <div class="dropzone" id="kt_ecommerce_add_product_media">
                                                <!--begin::Message-->
                                                <div class="dz-message needsclick">
                                                    <!--begin::Icon-->
                                                    <i class="ki-outline ki-file-up text-primary fs-3x"></i>
                                                    <!--end::Icon-->
                                                    <!--begin::Info-->
                                                    <div class="ms-4">
                                                        <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or
                                                            click to upload.</h3>
                                                        <span class="fs-7 fw-semibold text-gray-400">Upload up to 10
                                                            files</span>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                            </div>
                                            <!--end::Dropzone-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">Set the service images.</div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Card header-->
                                </div>
                                <!--end::Media-->


                                <!--begin::Actions-->

                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <a href="{{ route('services.index') }}"
                                        class="btn btn-light btn-active-light-primary me-2">Discard</a>
                                    <button type="submit" class="btn btn-primary" id="btn_edit_form">
                                        <span class="indicator-label">Save Changes</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Basic info-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->

    </div>

    {{-- <script>
        document.getElementById("kt_edit_category_form").addEventListener("submit", function(event) {
            event.preventDefault();

            var formData = new FormData(this);
            if (formData.get('name_en') == "") {
                iziToast.error({
                    message: "You must input name English",
                    position: 'topRight'
                });
            }
            else if (formData.get('name_ar') == "") {
                iziToast.error({
                    message: "You must input name Arabic",
                    position: 'topRight'
                });
            }

            else {
                document.querySelector('.indicator-label').style.display = 'none';
                document.querySelector('#btn_edit_form').disabled = true;
                document.querySelector('.indicator-progress').style.display = 'inline';
                $.ajax({
                    url: "{{ route('category.update',$category) }}",
                    type: "POST",
                    data: formData,
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
                            setTimeout(function() {
                                window.location.href =
                                    '{{ route('category.index') }}'; // Change '/new-page' to the URL you want to redirect to
                            }, 2000);

                        }
                        document.querySelector('.indicator-progress').style.display = 'none';
                        document.querySelector('.indicator-label').style.display = 'inline';
                        document.querySelector('#btn_edit_form').disabled = false;
                    },
                    error: function(xhr, status, error) {
                        console.log(error);

                        iziToast.error({
                            message: 'An error occurred: ' + error,
                            position: 'topRight'
                        });
                        document.querySelector('.indicator-progress').style.display = 'none';
                        document.querySelector('.indicator-label').style.display = 'inline';
                        document.querySelector('#btn_edit_form').disabled = false;
                    }
                });
            }
        });
    </script> --}}
@endsection
