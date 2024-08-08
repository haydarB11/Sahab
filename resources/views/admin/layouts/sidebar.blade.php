<!--begin::Wrapper-->
<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
    <!--begin::Sidebar-->
    <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
        data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
        data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
        <!--begin::Logo-->
        <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
            <!--begin::Logo image-->
            <a href="{{ route('admin') }}">
                <img alt="Logo" src="{{ asset('assets/logo.svg') }}"
                    class="h-65px w-200px app-sidebar-logo-default" />
                <img alt="Logo" src="{{ asset('assets/logotitle.svg') }}"
                    class="h-20px  app-sidebar-logo-minimize" />
            </a>
            <!--end::Logo image-->
            <!--begin::Sidebar toggle-->
            <!--begin::Minimized sidebar setup:
            if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on") {
                1. "src/js/layout/sidebar.js" adds "sidebar_minimize_state" cookie value to save the sidebar minimize state.
                2. Set data-kt-app-sidebar-minimize="on" attribute for body tag.
                3. Set data-kt-toggle-state="active" attribute to the toggle element with "kt_app_sidebar_toggle" id.
                4. Add "active" class to to sidebar toggle element with "kt_app_sidebar_toggle" id.
            }
        -->
            <div id="kt_app_sidebar_toggle"
                class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
                data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                data-kt-toggle-name="app-sidebar-minimize">
                <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
            <!--end::Sidebar toggle-->
        </div>
        <!--end::Logo-->
        <!--begin::sidebar menu-->
        <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
            <!--begin::Menu wrapper-->
            <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
                <!--begin::Scroll wrapper-->
                <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true"
                    data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                    data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                    data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                    data-kt-scroll-save-state="true">
                    <!--begin::Menu-->
                    <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                        id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                        <!--begin:Dashboard Menu item-->
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->routeIs('admin') ? 'active' : '' }}"
                                href="{{ route('admin') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-messages fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Dashboard</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <!--end:Dashboard Menu link-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Management</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--begin:Places Menu item-->

                        @if (auth('admin')->user()->hasPermissionTo('place-list'))
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span
                                    class="menu-link {{ request()->routeIs('places.index', 'categories.index') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-basket  fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Places</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ request()->routeIs('categories.index') ? 'active' : '' }}"
                                            href='{{ route('categories.index',['type' => 'place']) }}'>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Places Categories</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ request()->routeIs('places.index') ? 'active' : '' }}"
                                            href='{{ route('places.index') }}'>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">All Places</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <!--end:Places Menu item-->
                        @endif
                        <!--begin:Services Menu item-->
                        @if (auth('admin')->user()->hasPermissionTo('service_list'))
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span
                                    class="menu-link {{ request()->routeIs('services.index', 'categories.index') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-purchase  fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Services</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ request()->routeIs('categories.index') ? 'active' : '' }}"
                                            href='{{ route('categories.index',['type' => 'service']) }}'>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Service Categories</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ request()->routeIs('services.index') ? 'active' : '' }}"
                                            href='{{ route('services.index') }}'>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">All Service</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <!--end:Services Menu item-->
                        @endif
                        @if (auth('admin')->user()->hasPermissionTo('booking_list'))
                            <!--begin:Bookings Menu item-->
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link {{ request()->routeIs('bookings.index') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-office-bag  fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Bookings</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ request()->routeIs('booking.index') ? 'active' : '' }}"
                                            href='{{ route('bookings.index') }}'>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Bookings</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ request()->routeIs('bookings.index') ? 'active' : '' }}"
                                            href='{{ route('bookings.index') }}'>
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Reports</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                </div>
                                <!--end:Menu sub-->
                            </div>
                        @endif
                        <!--end:Bookings Menu item-->
                        <!--begin:Users Menu item-->

                        @if (auth('admin')->user()->hasPermissionTo('vendors_list') || auth('admin')->user()->hasPermissionTo('customers_list'))

                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Users Menu link-->
                                <span
                                    class="menu-link {{ request()->routeIs('vendors.index', 'customers.index') ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-badge  fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Users</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">
                                    <!--begin:Menu item-->
                                    @if (auth('admin')->user()->hasPermissionTo('vendors_list'))
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ request()->routeIs('vendors.index') ? 'active' : '' }}"
                                                href='{{ route('vendors.index') }}'>
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">All Vendors</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                    @endif
                                    <!--end:Menu item-->
                                    <!--begin:Menu sub-->
                                    @if (auth('admin')->user()->hasPermissionTo('customers_list'))
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ request()->routeIs('customers.index') ? 'active' : '' }}"
                                                href='{{ route('customers.index') }}'>
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">All Customers</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                    @endif

                                    @if (auth('admin')->user()->hasPermissionTo('admins_list'))
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ request()->routeIs('admins.index') ? 'active' : '' }}"
                                                href='{{ route('admins.index') }}'>
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">All Admins</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                    @endif
                                    <!--end:Menu item-->
                                </div>
                        @endif
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Users Menu item-->
                    <!--begin:Settings Menu item-->
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-book-open  fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span>
                            <span class="menu-title">Settings</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->

                            @if (auth('admin')->user()->hasPermissionTo('amenities_list'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('amenities.index') ? 'active' : '' }}"
                                        href='{{ route('amenities.index') }}'>
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">All Amenities</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            @if (auth('admin')->user()->hasPermissionTo('banners_manage'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('static-content.index') ? 'active' : '' }}"
                                        href='{{ route('static-content.index') }}'>
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">All Banners</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            @if (auth('admin')->user()->hasPermissionTo('content_manage'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('static-content.create') ? 'active' : '' }}"
                                        href='{{ route('static-content.create') }}'>
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">All Static Content</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif
                            <!--end:Menu item-->
                            <!--begin:Menu item-->

                            @if (auth('admin')->user()->hasPermissionTo('contact_us_view'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('messages.index') ? 'active' : '' }}"
                                        href="{{ route('messages.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Contact Us</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                                <!--end:Menu item-->
                            @endif

                            @if (auth('admin')->user()->hasPermissionTo('role-list'))
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ request()->routeIs('roles.index') ? 'active' : '' }}"
                                        href="{{ route('roles.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">All Roles</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endif

                             <!--begin:Menu item-->
                             <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link" href="{{ route('admin.notifications') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                    <span class="menu-title">Push Notifications</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Settings Menu item-->

                    <!--end:Menu sub-->
                    <!--end:Menu link-->

                    <!--end:Menu item-->
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Scroll wrapper-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->

</div>
<!--end::Sidebar-->
