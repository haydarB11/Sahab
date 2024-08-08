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
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Fill Content In Your Sahab App</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <!--begin::Form-->
                    <form id="kt_update_content_form" method="POST" action="{{ route('static_content.update.all') }}" class="form">
                        @csrf
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                            @foreach ($content as $co)
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label for="{{ $loop->index }}" class="col-lg-4 col-form-label required fw-semibold fs-6">{{ $co->description }}</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <textarea name="{{ $co->title }}" id="{{ $loop->index }}" class="form-control mb-2" placeholder="Enter here" rows="5">{{ $co->content }}</textarea>
                                </div>
                                <!--end::Col-->
                            </div>
                            @endforeach


                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <a href="{{ route('admin') }}" class="btn btn-light btn-active-light-primary me-2">Discard</a>
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
        document.getElementById("kt_fill_content_form").addEventListener("submit", function(event) {
            event.preventDefault();

            var formData = new FormData(this);
            if (formData.get('steps_en') == "" ||
                formData.get('steps_ar') == "" || formData.get('newapp_en') == "" ||
                formData.get('newapp_ar') == "" || formData.get('applying_en') == "" || formData.get(
                    'applying_ar') == "" || formData.get('recentapp_en') == "" || formData.get('recentapp_ar') ==
                "" || formData.get('searchcollage_en') == "" || formData.get('searchcollage_ar') == "" ||
                formData.get('questionary_en') == "" || formData.get('questionary_ar') == "" || formData.get(
                    'additional_en') == "" || formData.get('additional_ar') == "") {
                iziToast.error({
                    message: "You must fill all field ",
                    position: 'topRight'
                });
            } else {
                document.querySelector('.indicator-label').style.display = 'none';
                document.querySelector('#btn_add_form').disabled = true;
                document.querySelector('.indicator-progress').style.display = 'inline';
                $.ajax({
                    url: "{{ route('update.contentall') }}",
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
// setTimeout(function() {
// window.location.href =
// '{{ route('faqs.index') }}'; // Change '/new-page' to the URL you want to redirect to
// }, 2000);

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
</script> --}}
@endsection
