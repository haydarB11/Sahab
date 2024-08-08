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
                                    <input type="text" data-customer-filter="search"
                                        class="form-control form-control-solid w-250px ps-12"
                                        placeholder="Search customer" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">


                                <div class="w-100 mw-150px">
                                    <!--begin::Select2-->
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="true" data-placeholder="Status" data-customer-filter="status">
                                        <option></option>
                                        <option value="all">All</option>
                                        <option value="IsActive">IsActive</option>
                                        <option value="InActive">InActive</option>
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
                            <table class="table  align-middle table-row-dashed fs-6 gy-5" id="kt_datatable_customers">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">

                                        <th class="min-w-10px">Customer Id</th>
                                        <th class=" min-w-100px">Full Name</th>
                                        <th class=" min-w-100px">Email</th>
                                        <th class=" min-w-100px">Mobile Number</th>
                                        <th class=" min-w-100px">Total Bookings</th>
                                        <th class=" min-w-100px">Total Bookings Amount</th>
                                        <th class=" min-w-100px">Status</th>
                                        <th class=" min-w-100px">Registration Date</th>
                                        <th class=" min-w-70px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @forelse ($customers as $customer)
                                        <tr>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Thumbnail-->

                                                    <!--end::Thumbnail-->
                                                    <div class="ms-5">
                                                        <!--begin::Title-->
                                                        <a href="{{ route('customers.show', $customer) }}"
                                                            class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                                            data-customer-filter="customer_id"
                                                            >{{ $customer->id }}</a>
                                                        <!--end::Title-->
                                                    </div>
                                                </div>
                                            </td>

                                            <td class=" text-black pe-0" data-customer-filter="customer_name">{{ $customer->name }}</td>
                                            <td class=" text-black pe-0">{{ $customer->email }}</td>
                                            <td class=" text-black pe-0">{{ $customer->phone }}</td>
                                            <td class="  text-black pe-0">{{ $customer->bookings->count() }}</td>
                                            <td class=" text-black pe-0">{{  $customer->bookings->sum('payment') ?? 0 }} KWD</td>


                                            <td class=" text-black pe-0 pl-20" data-order="@if ($customer->status == "activated") IsActive
                                                @else
                                                InActive @endif">
                                                <p class="d-none">
                                                    @if ($customer->status == 'activated')
                                                        IsActive
                                                    @else
                                                        InActive
                                                    @endif
                                                </p>
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input customer-toggle" type="checkbox"
                                                        value="1" name="status" id="customerToggle{{ $customer->id }}"
                                                        data-customer-id="{{ $customer->id }}"
                                                        @if ($customer->status == "activated") checked @endif />
                                                    <span class="form-check-label fw-semibold text-muted">
                                                        Active
                                                    </span>
                                                </label>
                                            </td>
                                            <td class=" text-black pe-0">{{ \Carbon\Carbon::parse($customer->created_at)->format('Y-m-d')  }}</td>


                                            <td class="">
                                                <a href="#"
                                                    class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                    <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                    data-kt-menu="true">

                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('customer.bookings',$customer) }}" class="menu-link px-3"
                                                           >View Bookings</a>
                                                    </div>

                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('customers.edit',$customer) }}" class="menu-link px-3"
                                                           >Edit</a>
                                                    </div>


                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="" class="menu-link px-3"
                                                            data-customer-filter="delete_row">Delete</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu-->
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
        document.querySelectorAll('.customer-toggle').forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                var customerId = this.dataset.customerId;
                var status = this.checked ? 1 : 0;
                $.ajax({
                    url: `/admin/customers/status/${customerId}/?status=${status}`,
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
