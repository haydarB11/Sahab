@extends('admin.empty')

@section('content')
    @include('admin.admins.add-user-modal', ['roles' => $roles])
    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-fluid">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-6">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                                    <input type="text" data-kt-user-table-filter="search"
                                        class="form-control form-control-solid w-250px ps-13" placeholder="Search user" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">


                                    <!--begin::Add user-->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_user">
                                        <i class="ki-outline ki-plus fs-2"></i>Add User</button>
                                    <!--end::Add user-->
                                </div>
                                <!--end::Toolbar-->



                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body py-4">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                                <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                        <th class="min-w-50px">id</th>
                                        <th class="min-w-125px">Admin</th>
                                        <th class="min-w-125px">Role</th>
                                        <th class="min-w-125px">Last login</th>
                                        <th class="min-w-125px">Joined Date</th>
                                        <th class="text-end min-w-100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-semibold">

                                    @foreach ($admins as $admin)
                                        @include('admin.admins.edit-user-modal', [$roles, $admin])
                                        <tr>
                                            <td data-admin-id="admin_id">{{ $admin->id }}</td>

                                            <td class="d-flex align-items-center">
                                                <!--begin:: Avatar -->
                                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                    <a>
                                                        <span
                                                            class="symbol-label @if ($loop->index%3==0) bg-danger  @elseif ($loop->index%2==0)
                                                                    bg-primary
                                                                    @else
                                                                    bg-warning @endif text-inverse-warning  fw-bold">{{ ucfirst(substr($admin->name, 0, 1)) }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::User details-->
                                                <div class="d-flex flex-column">
                                                    <a class="text-gray-800 text-hover-primary mb-1">{{ $admin->name }}</a>
                                                    <span>{{ $admin->email }}</span>
                                                </div>
                                                <!--begin::User details-->
                                            </td>
                                            <td>{{ optional($admin->roles->first())->name }}</td>
                                            <td>
                                                <div class="badge badge-light fw-bold">
                                                    {{ \Carbon\Carbon::parse($admin->last_login)->diffForHumans() }}</div>
                                            </td>

                                            <td> {{ \Carbon\Carbon::parse($admin->created_at)->format('Y/m/d') }}</td>
                                            <td class="text-end">
                                                <a href="#"
                                                    class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                    data-kt-menu="true">
                                                    <!--begin::Menu item-->


                                                    <div class="menu-item px-3">
                                                        <a href="#" data-kt-users-table-filter="edit_row"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#kt_modal_update_user{{ $admin->id }}"
                                                            class="menu-link px-3">Edit</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3"
                                                            data-kt-users-table-filter="delete_row">Delete</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu-->
                                            </td>
                                        </tr>
                                    @endforeach




                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->

    </div>
    <!--end:::Main-->
@endsection
