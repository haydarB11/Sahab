@extends('admin.empty')
@section('content')
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack mb-5">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                Notifications
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('admin')}}" class="text-muted text-hover-primary">
                        Home
                    </a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    Notifications
                </li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Toolbar container-->
    <div class="card mb-5 mb-xl-10 mx-6" id="kt_profile_details_view">
        <!--begin::Card header-->
        <div class="card-header cursor-pointer">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Push Notification</h3>
            </div>
            <!--end::Card title-->

        </div>
        <!--begin::Card header-->

        <!--begin::Card body-->
        <div class="card-body">
            <div class="alert alert-success" id="successContainer1" style="display: none;"></div>
            <div class="alert alert-danger" id="errorContainer1" style="display: none;"></div>
            <form id="kt_modal_push_notification_form" class="form" action="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Notification Title</label>
                        <input type="text" id="title" name="title" class="form-control form-control-solid mb-3 mb-lg-0"/>
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fw-semibold fs-6 mb-2">Notification Message</label>
                        <input type="text" name="body" id="body" class="form-control form-control-solid mb-3 mb-lg-0"/>
                    </div>
                </div>
                <div class="text-center pt-10">
                    <button id="submitBtn" class="btn btn-primary submitBtn push-notification" data-kt-users-modal-action="submit" >
                        <span class="indicator-label">Send</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                    </button>
                </div>
            </form>
        </div>
        <!--end::Card body-->
    </div>
    <script type="text/javascript">
        $(document).ready(function() {

            // click on submit in edit modal
            $(document).on('click', '.push-notification', function(event){
                event.preventDefault();
                var url = "{{route('admin.pushNotifications')}}";
                var formData = new FormData($('#kt_modal_push_notification_form')[0]);
                sweetConfirm(function (confirmed) {
                    if (confirmed) {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function () {
                                showSuccesFunction();
                                $(".swal2-confirm").on("click", function() {
                                    location.reload();
                                });
                            },
                            error: function() {
                                $('#errorContainer1').text('Could not send the notification').show();
                                setTimeout(function() {
                                    $('#errorContainer1').fadeOut('slow', function() {
                                        $('#errorContainer1').empty();
                                    });
                                }, 5000);
                            }
                        });
                    }
                })

            });

            function displayErrors(errors) {
                var errorContainer = $('#errorContainer');
                errorContainer.empty();

                if (!$.isEmptyObject(errors)) {
                    errorContainer.show();
                    $.each(errors, function(key, value) {
                        errorContainer.append('<li>' + value + '</li>');
                    });
                } else {
                    errorContainer.hide();
                }
                // Hide the error container after 5 seconds (5000 milliseconds)
                setTimeout(function() {
                    errorContainer.fadeOut('slow', function() {
                        errorContainer.empty();
                        errorContainer.css('display', 'none');
                    });
                }, 5000);
            }
        });
    </script>
@endsection
