@extends('admin.empty')

@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
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
                                    <input type="text" data-message-filter="search"
                                        class="form-control form-control-solid w-250px ps-12"
                                        placeholder="Search Messages" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                <div class="w-100 mw-150px">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Status" data-message-filter="status">
                                        <option></option>
                                        <option value="all">All</option>
                                        <option value="Is Seen">Seen</option>
                                        <option value="Not Seen">Not Seen</option>
                                    </select>
                                    <!--end::Select2-->
                                </div>

                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="table-responsive">

                            <!--begin::Table-->
                            <table class="table  align-middle table-row-dashed fs-6 gy-5" id="kt_datatable_messages">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">

                                        <th class="min-w-50px">Request Id</th>
                                        <th class="text-end min-w-70px">Name</th>
                                        <th class="text-end min-w-70px">Email</th>
                                        <th class="text-end min-w-70px">Phone</th>
                                        <th class="text-end min-w-70px">Status</th>
                                        <th class="text-end min-w-70px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @forelse ($messages as $message)
                                        <tr>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Thumbnail-->

                                                    <!--end::Thumbnail-->
                                                    <div class="ms-5">
                                                        <!--begin::Title-->
                                                        <span data-bs-toggle="modal"
                                                            data-bs-target="#kt_modal_scrollable_1{{ $message->id }}"
                                                            class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                                            data-message-filter="message_id">{{ $message->id }}</span>
                                                        <!--end::Title-->
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-end text-black pe-0">{{ $message->user->name }}</td>
                                            <td class="text-end text-black  pe-0">{{ $message->user->email }}</td>
                                            <td class="text-end text-black  pe-0">{{ $message->user->phone }}</td>
                                            <td class="text-start pe-0">
                                                <p class="d-none ">
                                                    @if ($message->status == 1)
                                                        Is Seen
                                                    @else
                                                        Not Seen
                                                    @endif
                                                </p>
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input message-toggle" type="checkbox"
                                                        value="1" name="status" id="messageToggle{{ $message->id }}"
                                                        data-message-id="{{ $message->id }}"
                                                        @if ($message->status == 1) checked @endif />
                                                    <span class="form-check-label fw-semibold text-muted">
                                                        Seen
                                                    </span>
                                                </label>
                                            </td>

                                            <div class="modal fade" tabindex="-1"
                                                id="kt_modal_scrollable_1{{ $message->id }}">
                                                <div class="modal-dialog modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Message Request</h5>

                                                            <!--begin::Close-->
                                                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="ki-duotone ki-cross fs-2x"><span
                                                                        class="path1"></span><span
                                                                        class="path2"></span></i>
                                                            </div>
                                                            <!--end::Close-->
                                                        </div>

                                                        <div class="modal-body">
                                                            <p>{{ $message->message }}</p>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <td class="text-end">


                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <span data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_scrollable_1{{ $message->id }}"
                                                        class="menu-link px-3">
                                                        <i class="ki-duotone ki-eye fs-2qx text-danger">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                        </i>
                                                        view
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
        document.querySelectorAll('.message-toggle').forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                var messageId = this.dataset.messageId;
                var status = this.checked ? 1 : 0;
                $.ajax({
                    url: `/admin/contact-us/status/${messageId}/${status}`,
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
                                message: response.success,
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
                console.log('Message ' + messageId + ' status changed to ' + (status == 1 ? 'Active' :
                    'Inactive'));
            });
        });
    </script>
@endsection
