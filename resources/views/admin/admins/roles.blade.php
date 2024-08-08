@extends('admin.empty')

@section('content')
    @include('admin.admins.add-role-modal', ['permissions' => $permissions])
    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-fluid">
                    <!--begin::Row-->
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
                        @foreach ($roles as $role)
                            <!--begin::Col-->
                            @include('admin.admins.update-role', ['role' => $role])

                            <div class="col-md-4">
                                <!--begin::Card-->
                                <div class="card card-flush h-md-100">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>{{ $role->name }}</h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-1">
                                        <!--begin::Users-->
                                        <div class="fw-bold text-gray-600 mb-5">Total users with this role:
                                            {{ $role->users->count() }}</div>
                                        <!--end::Users-->
                                        <!--begin::Permissions-->

                                        <div class="d-flex flex-column text-gray-600">
                                            @foreach ($role->permissions->take(5) as $permission)
                                                <div class="d-flex align-items-center py-2">
                                                    <span class="bullet bg-primary me-3"></span>
                                                    {{ $permission->name }}
                                                </div>
                                            @endforeach


                                            @if (count($role->permissions) > 5)
                                                <div class='d-flex align-items-center py-2'>
                                                    <span class='bullet bg-primary me-3'></span>
                                                    <em>and {{ count($role->permissions) - 5 }} more...</em>
                                                </div>
                                            @endif

                                        </div>
                                        <!--end::Permissions-->
                                    </div>
                                    <!--end::Card body-->
                                    <!--begin::Card footer-->

                                    <div class="card-footer flex-wrap pt-0">

                                        <button type="button" data-kt-roles-table-filter="edit_row"
                                            class="btn btn-light btn-active-light-primary my-1" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_update_role{{ $role->id }}">Edit Role</button>
                                    </div>
                                    <!--end::Card footer-->
                                </div>
                                <!--end::Card-->
                            </div>
                            <!--end::Col-->
                        @endforeach




                        <!--begin::Add new card-->
                        <div class="col-md-4">
                            <!--begin::Card-->
                            <div class="card h-md-100">
                                <!--begin::Card body-->
                                <div class="card-body d-flex flex-center">
                                    <!--begin::Button-->
                                    <button type="button" class="btn btn-clear d-flex flex-column flex-center"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_add_role">
                                        <!--begin::Illustration-->
                                        <img src="assets/media/illustrations/sketchy-1/4.png" alt=""
                                            class="mw-100 mh-150px mb-7" />
                                        <!--end::Illustration-->
                                        <!--begin::Label-->
                                        <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Role</div>
                                        <!--end::Label-->
                                    </button>
                                    <!--begin::Button-->
                                </div>
                                <!--begin::Card body-->
                            </div>
                            <!--begin::Card-->
                        </div>
                        <!--begin::Add new card-->
                    </div>
                    <!--end::Row-->


                </div>
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->

    </div>
    <!--end:::Main-->

@endsection
