@extends('admin.empty')

@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Basic info-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                        data-bs-target="#kt_account_profile_details" aria-expanded="true"
                        aria-controls="kt_account_profile_details">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Add Faq</h3>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Content-->
                    <div id="kt_account_settings_profile_details" class="collapse show">
                        <!--begin::Form-->
                        <form id="kt_add_faqs_form" method="POST" class="form"
                            data-kt-redirect="{{ route('faqs.index') }}">
                            @csrf
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">

                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Question English</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="question_en"
                                            class="form-control form-control-lg form-control-solid"
                                            placeholder="question En" />
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Question Arabic</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="question_ar"
                                            class="form-control form-control-lg form-control-solid"
                                            placeholder="question Ar" />
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Answer English</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="answer_en"
                                            class="form-control form-control-lg form-control-solid" placeholder="Answer En" />
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Answer Arabic</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="answer_ar"
                                            class="form-control form-control-lg form-control-solid" placeholder="Answer Ar" />
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <div class="d-flex flex-stack w-lg-50">
                                    <!--begin::Label-->
                                    <div class="me-5">
                                        <label class="fs-6 fw-semibold form-label">
                                            Status</label>
                                    </div>
                                    <!--end::Label-->

                                    <!--begin::Switch-->
                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                        <input id="toggleCheckbox1" class="form-check-input" type="checkbox" value="1"
                                            name="status" checked />
                                        <span class="form-check-label fw-semibold text-muted">
                                            Active
                                        </span>
                                    </label>

                                    <!--end::Switch-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Actions-->

                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <a href="{{ route('bookings.index') }}"
                                        class="btn btn-light btn-active-light-primary me-2">Discard</a>
                                    <button type="submit" class="btn btn-primary" id="btn_add_form">
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

    <script>
        document.getElementById("kt_add_faqs_form").addEventListener("submit", function(event) {
            event.preventDefault();

            var formData = new FormData(this);
            if (formData.get('question_en') == "") {
                iziToast.error({
                    message: "You must input question English",
                    position: 'topRight'
                });
            }
            else if(formData.get('question_ar') == ""){
                iziToast.error({
                    message: "You must input question Arabic",
                    position: 'topRight'
                });

            }
             else if (formData.get('answer_en') == "") {
                iziToast.error({
                    message: "You must input answer English",
                    position: 'topRight'
                });
            }
            else if (formData.get('answer_ar') == "") {
                iziToast.error({
                    message: "You must input answer Arabic",
                    position: 'topRight'
                });
            }
             else {
                document.querySelector('.indicator-label').style.display = 'none';
                document.querySelector('#btn_add_form').disabled = true;
                document.querySelector('.indicator-progress').style.display = 'inline';
                $.ajax({
                    url: "{{ route('faqs.store') }}",
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
                                    '{{ route('faqs.index') }}'; // Change '/new-page' to the URL you want to redirect to
                            }, 2000);

                        }
                        document.querySelector('.indicator-progress').style.display = 'none';
                        document.querySelector('.indicator-label').style.display = 'inline';
                        document.querySelector('#btn_add_form').disabled = false;
                    },
                    error: function(xhr, status, error) {
                        console.log(error);

                        iziToast.error({
                            message: 'An error occurred: ' + error,
                            position: 'topRight'
                        });
                        document.querySelector('.indicator-progress').style.display = 'none';
                        document.querySelector('.indicator-label').style.display = 'inline';
                        document.querySelector('#btn_add_form').disabled = false;
                    }
                });
            }
        });
    </script>
@endsection
