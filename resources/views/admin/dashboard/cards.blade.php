<div>
    <!--begin::Row-->
    <div class="row gy-5 g-xl-10">
        <!--begin::Col-->
        <div class="col-6 col-xl-3 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                    <!--begin::Icon-->
                    <div class="m-0">
                        <i class="ki-duotone ki-compass fs-2hx text-gray-600">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <!--end::Icon-->
                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7">
                        <!--begin::Number-->
                        <div>
                            <span id="total_bookings" class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2">{{$total}}</span>
                        </div>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-7 text-gray-500">Total Reservations</span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-6 col-xl-3 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                    <!--begin::Icon-->
                    <div class="m-0">
                        <i class="ki-duotone ki-chart-simple fs-2hx text-gray-600">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                    </div>
                    <!--end::Icon-->
                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7">
                        <!--begin::Number-->
                        <span id="tickets_count" class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2">{{$totalToday}}</span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-7 text-gray-500">Today Reservation</span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-6 col-xl-3 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                    <!--begin::Icon-->
                    <div class="m-0">
                        <i class="ki-duotone ki-map fs-2hx text-gray-600">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </div>
                    <!--end::Icon-->
                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7">
                        <!--begin::Number-->
                        <span id="bookings_count" class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2">{{$totalPlaced}}</span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-7 text-gray-500">Placed Reservation</span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-6 col-xl-3 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                    <!--begin::Icon-->
                    <div class="m-0">
                        <i class="ki-duotone ki-abstract-39 fs-2hx text-gray-600">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <!--end::Icon-->
                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7">
                        <!--begin::Number-->
                        <span id="active_vendors" class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2">{{$totalCanceled}}</span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-7 text-gray-500">Canceled Reservation</span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</div>
