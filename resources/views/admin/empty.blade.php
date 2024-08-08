@include('admin.layouts.header')

<!--end::Header-->


@include('admin.layouts.sidebar')

<!--begin::Main-->

<body id="kt_app_body" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true"
    data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true"
    data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" class="app-default"
    style="padding: 5px;">



    @yield('content')


</body>
<!--begin::Footer-->
@include('admin.layouts.footer')


<!--begin::Javascript-->








<script>
    var hostUrl = "assets/";
</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->

<!--end::Custom Javascript-->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>

<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>


<script src="{{ asset('assets/js/custom/admin/booking.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/admins/add.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/admins/table.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/admins/roles/add.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/admins/roles/update-role.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/admins/roles/roles.js') }}"></script>

<script src="{{ asset('assets/js/custom/admin/vendor.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/update-vendor.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/add-vendor.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/add-amenities.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/add-category.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/category.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/amenities.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/customer.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/places.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/service.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/update-place.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/message.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/update-service.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/update-customer.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/update-category.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/banner.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/add-banner.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/update-content.js') }}"></script>
<script src="{{ asset('assets/js/custom/admin/update-profile.js') }}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->

<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>


<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
    https://firebase.google.com/docs/web/setup#available-libraries -->

<script>
    function getTimeDifference(notificationDate) {
        var currentTime = new Date();
        var notificationTime = new Date(notificationDate);
        var timeDifference = Math.floor((currentTime - notificationTime) / 1000); // Difference in seconds

        if (timeDifference < 60) {
            return timeDifference + " s ago";
        } else if (timeDifference < 3600) {
            return Math.floor(timeDifference / 60) + " m ago";
        } else if (timeDifference < 86400) {
            return Math.floor(timeDifference / 3600) + " h ago";
        } else {
            return Math.floor(timeDifference / 86400) + " d ago";
        }
    }

    function deletenumer() {
        const countElement = document.getElementById('numm');
        if (countElement) {
            countElement.innerText = 0;
        }

    }
    $("#notificaions-list").on("click", "li a", function() {
        window.open($(this).attr("href"), "_blank");
    });

    function getall() {
        $.ajax({
            url: "/admin/notification/all",
            type: "GET",
            processData: false,
            contentType: false,

            success: function(response) {
                var notifications = response.data;
                $("#notificaions-list").empty();
                notifications.forEach(function(notification) {
                    var listItemHtml = `
                <li >
                    <div class="d-flex flex-stack py-4">
                                                            <!--begin::Section-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Symbol-->
                                                                <div class="symbol symbol-35px me-4">
                                                                    <span class="symbol-label bg-light-primary">
                                                                        <i
                                                                            class="ki-duotone ki-abstract-28 fs-2 text-primary">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                    </span>
                                                                </div>
                                                                <!--end::Symbol-->
                                                                <!--begin::Title-->
                                                                <div class="mb-0 me-2">
                                                                    <a href="${notification.link}"
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-bold">${notification.type}</a>
                                                                    <div class="text-gray-400 fs-7">${notification.data}
                                                                    </div>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Section-->
                                                            <!--begin::Label-->
                                                            <span class="badge badge-light fs-8">${getTimeDifference(notification.created_at)}</span>
                                                            <!--end::Label-->
                                                        </div>
                </li>
            `;
                    // Append the new list item HTML to the <ul> element
                    $("#notificaions-list").append(listItemHtml);
                });
            },

            error: function(xhr, status, error) {
                console.log(error);

            },
        })
    }
    getall();

    // Your web app's Firebase configuration
    const firebaseConfig = {

        apiKey: "AIzaSyCjwYsi-2cSxfAvRb4mEOgd7fLhlQQbkYA",
        authDomain: "sahab-62d2e.firebaseapp.com",
        projectId: "sahab-62d2e",
        storageBucket: "sahab-62d2e.appspot.com",
        messagingSenderId: "10965210378",
        appId: "1:10965210378:web:9b97882eacbecf5f4c56f3"

    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    const messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {
        messaging.requestPermission().then(function() {
            return messaging.getToken()
        }).then(function(token) {

            axios.post("{{ route('fcmToken') }}", {
                _method: "PATCH",
                token
            }).then(({
                data
            }) => {
                //console.log(data)
            }).catch(({
                response: {
                    data
                }
            }) => {
                console.error(data)
            })

        }).catch(function(err) {
            console.log(`Token Error :: ${err}`);
        });
    }
    initFirebaseMessagingRegistration();
    let notificationCount = 0;
    messaging.onMessage(function(payload) {
        //console.log(payload);
        const {
            body,
            title,
            link
        } = payload.data;

        notificationCount++;

        const options = {
            body,
            icon: "{{ asset('images/icons/logo-icon.svg') }}", // Specify the path to your notification icon
        };
        const audio = new Audio("{{ asset('notify.mp3') }}");
        audio.play();
        new Notification(title, options);
        getall();
        const countElement = document.getElementById('numm');
        if (countElement) {
            countElement.innerText = notificationCount;
        }
    });
</script>
<!--end::Modal - New Address-->
</body>
<!--end::Body-->

</html>
