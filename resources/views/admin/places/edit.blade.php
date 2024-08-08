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
                            <h3 class="fw-bold m-0">Edit Place</h3>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Content-->
                    <div id="kt_place_details" class="collapse show">
                        <!--begin::Form-->
                        <form id="kt_edit_place_form" method="POST" class="form"
                            action="{{ route('places.update', $place->id) }}"
                            data-kt-redirect="{{ route('places.index') }}">
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
                                            value="{{ $place->title }}" />
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <div class="d-flex flex-column mb-7 fv-row">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="required">Tag</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="tag" aria-label="Select a Tag" data-control="select2"
                                        data-placeholder="Select a Tag..." data-dropdown-parent="#kt_edit_place_form"
                                        class="form-select form-select-solid fw-bold">
                                        <option value="All" @if ($place->tag == 'All') selected @endif>All
                                        </option>
                                        <option value="Girls Only" @if ($place->tag == 'Girls Only') selected @endif>Girls
                                            Only</option>
                                        <option value="Family Only" @if ($place->tag == 'Family Only') selected @endif>Family
                                            Only</option>
                                    </select>
                                    <!--end::Input-->
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
                                        data-placeholder="Select a Tag..." data-dropdown-parent="#kt_edit_place_form"
                                        class="form-select form-select-solid fw-bold">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if ($place->category_id == $category->id) selected @endif>
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>

                                <div class="d-flex flex-column mb-7 fv-row">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="required">Amenities</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    @php
                                        $amens = \App\Models\Amenity::all();
                                    @endphp
                                    <select name="amenities[]" aria-label="Select a amenities" data-control="select2"
                                        multiple data-placeholder="Select a amenities..."
                                        data-dropdown-parent="#kt_edit_place_form"
                                        class="form-select form-select-solid fw-bold">
                                        @foreach ($amens as $amen)
                                            <option value="{{ $amen->id }}"
                                                @if ($place->availablePlaceAmenities->contains($amen->id)) selected @endif>
                                                {{ $amen->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>


                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Address</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <textarea name="address" rows="5" class="form-control form-control-lg form-control-solid" placeholder="address">{{ $place->address }}</textarea>
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Description</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <textarea name="description" class="form-control form-control-lg form-control-solid" placeholder="description"
                                            rows="7">{{ $place->description }}</textarea>
                                    </div>
                                    <!--end::Col-->
                                </div>



                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Week Day Price</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="number" name="weekday_price"
                                            class="form-control form-control-lg form-control-solid"
                                            placeholder="weekday price " value="{{ $place->weekday_price }}" />
                                    </div>
                                    <!--end::Col-->
                                </div>


                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Week End Price</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="number" name="weekend_price"
                                            class="form-control form-control-lg form-control-solid"
                                            placeholder="weekend price " value="{{ $place->weekend_price }}" />
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
                                        <div class="fs-7 fw-semibold text-muted">If you want to make this place
                                            available</div>
                                        <!--end::Input-->
                                    </div> <!--end::Label-->
                                    <!--begin::Col-->
                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input category-toggle" type="checkbox" value="1"
                                            name="available" id="placeToggle{{ $place->id }}"
                                            data-place-id="{{ $place->id }}"
                                            @if ($place->available == 1) checked @endif />
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
                                        <div class="fs-7 fw-semibold text-muted">If you want to make this place
                                            bookable</div>
                                        <!--end::Input-->
                                    </div> <!--end::Label-->
                                    <!--begin::Col-->
                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input category-toggle" type="checkbox" value="1"
                                            name="bookable" id="placeToggle{{ $place->id }}"
                                            data-place-id="{{ $place->id }}"
                                            @if ($place->bookable == 1) checked @endif />
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
                                        <div class="fs-7 fw-semibold text-muted">If you want to make this place
                                            Featured</div>
                                        <!--end::Input-->
                                    </div> <!--end::Label-->
                                    <!--begin::Col-->
                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input category-toggle" type="checkbox" value="1"
                                            name="featured" id="placeToggle{{ $place->id }}"
                                            data-place-id="{{ $place->id }}"
                                            @if ($place->featured == 1) checked @endif />
                                        <span class="form-check-label fw-semibold text-muted text-gray-800">
                                            Featured
                                        </span>
                                    </label>
                                </div>
                                <!--end::switch-->



                                <!--begin::Actions-->

                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <a href="{{ route('places.index') }}"
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
