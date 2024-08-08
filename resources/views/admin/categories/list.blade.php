@extends('admin.empty')

@section('content')
    <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-fluid">
                    <!--begin::universitys-->
                    <div class="card card-flush" style="padding: 50px; margin: 10px">
                        <!--begin::Card header-->
                        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                                    <input type="text" data-category-filter="search"
                                        class="form-control form-control-solid w-250px ps-12"
                                        placeholder="Search category" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">


                                <div class="w-100 mw-150px">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Status" data-category-filter="status">
                                        <option></option>
                                        <option value="all">All</option>
                                        <option value="IsActive">Active</option>
                                        <option value="InActive">In Active</option>
                                    </select>
                                    <!--end::Select2-->
                                </div>

                                <a href="{{ route('categories.create',['type' => request()->input('type') ]) }}" class="btn btn-primary">Add category</a>


                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="table-responsive">

                            <!--begin::Table-->
                            <table class="table  align-middle table-row-dashed fs-6 gy-5" id="kt_datatable_categories">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">

                                        <th class="w-1px">category Id</th>
                                        <th class=" min-w-100px">Title English</th>
                                        <th class=" min-w-100px">Title Arabic</th>
                                        <th class=" min-w-100px">icon</th>
                                        <th class=" min-w-100px">Status</th>
                                        <th class=" min-w-50px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @forelse ($categories as $category)
                                        <tr>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Thumbnail-->

                                                    <!--end::Thumbnail-->
                                                    <div class="ms-5">
                                                        <!--begin::Title-->
                                                        <a href="{{ route('categories.edit', ['type' => request()->input('type') ,'category'=>$category]) }}"
                                                            class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                                            data-category-filter="category_id">{{ $category->id }}</a>
                                                        <!--end::Title-->
                                                    </div>
                                                </div>
                                            </td>

                                            <td class=" pe-0 text-gray-800" data-category-filter="category_name">
                                                {{ $category->title }}</td>
                                            <td class=" pe-0 text-gray-800" data-category-filter="category_name">
                                                {{ $category->title_ar }}</td>
                                            <td class=" pe-0 text-gray-800"><img src="{{ asset($category->icon) }}"
                                                    alt="icon" width="100px" height="100px"></td>


                                            <td
                                                data-order="@if ($category->status == 1) IsActive
                                                @else
                                                InActive @endif">
                                                <p class="d-none ">
                                                    @if ($category->status == 1)
                                                        IsActive
                                                    @else
                                                        InActive
                                                    @endif
                                                </p>
                                                <label class="form-check form-switch form-check-custom form-check-solid"
                                                    style="padding-left: 50px;">
                                                    <input class="form-check-input category-toggle" type="checkbox"
                                                        value="1" name="status" id="categoryToggle{{ $category->id }}"
                                                        data-category-id="{{ $category->id }}"
                                                        @if ($category->status == 1) checked @endif />
                                                    <span class="form-check-label fw-semibold text-muted text-gray-800">
                                                        Active
                                                    </span>
                                                </label>
                                            </td>

                                            <td class="text-end">


                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ route('categories.edit', ['type' => request()->input('type') ,'category'=>$category]) }}">
                                                        <span>
                                                            <i class="ki-duotone ki-pencil fs-2qx text-sucess">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                                <span class="path4"></span>
                                                            </i>
                                                        </span>

                                                    </a>
                                                    <span data-category-filter="delete_row">
                                                        <i class="ki-duotone ki-trash fs-2qx text-danger">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                        </i>

                                                    </span>
                                                </div>
                                                <!--end::Menu item-->





                                            </td>

                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::universitys-->
                </div>
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->

    </div>

    <script>
        document.querySelectorAll('.category-toggle').forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                var categoryId = this.dataset.categoryId;
                var status = this.checked ? 1 : 0;
                $.ajax({
                    url: `/admin/categories/status/${categoryId}/?status=${status}`,
                    type: "GET",
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
                                message: response.message,
                                position: 'topRight'
                            });


                        }

                    },
                    error: function(xhr, status, error) {
                        console.log(error);

                        iziToast.error({
                            message: 'An error occurred: ' + error,
                            position: 'topRight'
                        });
                    }
                });

            });
        });
    </script>
@endsection
