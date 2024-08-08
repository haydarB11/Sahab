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
                            <h3 class="fw-bold m-0">Edit category</h3>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Content-->
                    <div id="kt_category_details" class="collapse show">
                        <!--begin::Form-->
                        <form id="kt_edit_category_form" method="POST" class="form"
                            action="{{ route('categories.update', $category->id) }}"
                            data-kt-redirect="{{ route('categories.index',['type' => request()->input('type') ]) }}">
                            @csrf
                            <!--begin::Card body-->

                            <div class="card-body border-top p-9">

                                <input type="hidden" name="_method" value="PUT">

                                <div class="row mb-7 mt-7">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Icon</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Image input-->
                                        <div class="image-input image-input-outline" data-kt-image-input="true"
                                            style="background-image: url('assets/media/svg/avatars/blank.svg')">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-125px h-125px"
                                                style="background-image: url({{ asset($category->icon) }})">
                                            </div>
                                            <!--end::Preview existing avatar-->
                                            <!--begin::Label-->
                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                title="Change avatar">
                                                <i class="ki-outline ki-pencil fs-7"></i>
                                                <!--begin::Inputs-->
                                                <input type="file" name="icon" accept=".png, .jpg, .jpeg" />
                                                <input type="hidden" name="avatar_remove"  value="{{ $category->icon }}"/>
                                                <!--end::Inputs-->
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Cancel-->
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                title="Cancel avatar">
                                                <i class="ki-outline ki-cross fs-2"></i>
                                            </span>
                                            <!--end::Cancel-->
                                            <!--begin::Remove-->
                                            <span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                title="Remove avatar">
                                                <i class="ki-outline ki-cross fs-2"></i>
                                            </span>
                                            <!--end::Remove-->
                                        </div>
                                        <!--end::Image input-->
                                        <!--begin::Hint-->
                                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                        <!--end::Hint-->
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Title English</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="title"
                                            class="form-control form-control-lg form-control-solid" placeholder="title"
                                            value="{{ $category->title }}" />
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Title Arabic</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="title_ar"
                                            class="form-control form-control-lg form-control-solid"
                                            placeholder="العنوان"  dir="rtl" value="{{ $category->title_ar }}"/>
                                    </div>
                                    <!--end::Col-->
                                </div>




                                <!--begin::Actions-->

                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <a href="{{ route('categories.index',['type' => request()->input('type') ]) }}"
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
