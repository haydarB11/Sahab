 <!--begin::Modal - Add task-->
 <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Modal header-->
             <div class="modal-header" id="kt_modal_add_user_header">
                 <!--begin::Modal title-->
                 <h2 class="fw-bold">Add User</h2>
                 <!--end::Modal title-->
                 <!--begin::Close-->
                 <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                     <i class="ki-outline ki-cross fs-1"></i>
                 </div>
                 <!--end::Close-->
             </div>
             <!--end::Modal header-->
             <!--begin::Modal body-->
             <div class="modal-body px-5 my-7">
                 <!--begin::Form-->
                 <form id="kt_modal_add_user_form" class="form" action="{{ route('admins.store') }}" method="POST">
                     @csrf
                     <!--begin::Scroll-->
                     <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_add_user_header"
                         data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="required fw-semibold fs-6 mb-2">Full Name</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <input type="text" name="user_name" class="form-control form-control-solid mb-3 mb-lg-0"
                                 placeholder="Full name" />
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="required fw-semibold fs-6 mb-2">Email</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <input type="email" name="user_email"
                                 class="form-control form-control-solid mb-3 mb-lg-0"
                                 placeholder="example@domain.com" />
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="fv-row mb-7">
                             <!--begin::Label-->
                             <label class="required fw-semibold fs-6 mb-2">Password</label>
                             <!--end::Label-->
                             <!--begin::Input-->
                             <input type="password" name="password"
                                 class="form-control form-control-solid mb-3 mb-lg-0" />
                             <!--end::Input-->
                         </div>
                         <!--end::Input group-->
                         <!--begin::Input group-->
                         <div class="mb-5">
                             <!--begin::Label-->
                             <label class="required fw-semibold fs-6 mb-5">Role</label>
                             <!--end::Label-->
                             <!--begin::Roles-->
                             @foreach ($roles as $role)
                                 <!--begin::Input row-->
                                 <div class="d-flex fv-row">
                                     <!--begin::Radio-->
                                     <div class="form-check form-check-custom form-check-solid">
                                         <!--begin::Input-->
                                         <input class="form-check-input me-3" name="user_role" type="radio"
                                             value="{{ $role->id }}"
                                             id="kt_modal_update_role_option_{{ $role->id }}"
                                             @if ($loop->first) @checked(true) @endif />
                                         <!--end::Input-->
                                         <!--begin::Label-->
                                         <label class="form-check-label"
                                             for="kt_modal_update_role_option_{{ $role->id }}">
                                             <div class="fw-bold text-gray-800">{{ $role->name }}</div>

                                         </label>
                                         <!--end::Label-->
                                     </div>
                                     <!--end::Radio-->
                                 </div>
                                 <!--end::Input row-->
                                 @if (!$loop->last)
                                     <div class='separator separator-dashed my-5'></div>
                                 @endif
                             @endforeach


                             <!--end::Roles-->
                         </div>
                         <!--end::Input group-->
                     </div>
                     <!--end::Scroll-->
                     <!--begin::Actions-->
                     <div class="text-center pt-10">
                         <button type="reset" class="btn btn-light me-3"
                             data-kt-users-modal-action="cancel">Discard</button>
                         <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                             <span class="indicator-label">Submit</span>
                             <span class="indicator-progress">Please wait...
                                 <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                         </button>
                     </div>
                     <!--end::Actions-->
                 </form>
                 <!--end::Form-->
             </div>
             <!--end::Modal body-->
         </div>
         <!--end::Modal content-->
     </div>
     <!--end::Modal dialog-->
 </div>
 <!--end::Modal - Add task-->
