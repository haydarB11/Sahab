<div class="modal fade" id="kt_modal_add_amenities" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="{{ route('amenities.store') }}" id="kt_modal_add_amenities_form" data-kt-redirect="{{ route('amenities.index') }}">
                @csrf
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_amenities_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Add a Amenities</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_modal_add_amenities_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->

                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_amenities_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_amenities_header" data-kt-scroll-wrappers="#kt_modal_add_amenities_scroll" data-kt-scroll-offset="300px">

                         <!--begin::Input group-->
                         <div class="row mb-7 mt-7" >
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
                                        style="background-image: url()">
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
                                        <input type="hidden" name="avatar_remove" />
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
                        <!--end::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Title</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" placeholder="Title" name="title" />
                            <!--end::Input-->
                        </div>
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Title ِArabic</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" dir="rtl" placeholder="العنوان" name="title_ar" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack">
                                <!--begin::Label-->
                                <div class="me-5">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold">Active ?</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="fs-7 fw-semibold text-muted">If you want to make this Amenities Active</div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Label-->
                                <!--begin::Switch-->
                                <label class="form-check form-switch form-check-custom form-check-solid">
                                    <!--begin::Input-->
                                    <input class="form-check-input" name="status" type="checkbox" value="1" id="kt_modal_add_amenities_active" checked="checked" />
                                    <!--end::Input-->
                                    <!--begin::Label-->
                                    <span class="form-check-label fw-semibold text-muted" for="kt_modal_add_amenities_active">Yes</span>
                                    <!--end::Label-->
                                </label>
                                <!--end::Switch-->
                            </div>
                            <!--begin::Wrapper-->
                        </div>

                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="reset" id="kt_modal_add_amenities_cancel" class="btn btn-light me-3">Discard</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" id="kt_modal_add_amenities_submit" class="btn btn-primary">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
