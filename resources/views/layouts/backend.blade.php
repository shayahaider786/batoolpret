<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Zaylish Studio</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <!-- <a class="navbar-brand brand-logo" href="{{ route('admin.dashboard') }}"><img
                        src="../../../backend/assets/images/logo.svg" alt="logo" /></a> -->
                <a class="navbar-brand brand-logo text-white" href="{{ route('admin.dashboard') }}"><h1>Zaylish Studio</h1></a>
                <!-- <a class="navbar-brand brand-logo-mini" href="{{ route('admin.dashboard') }}"><img
                        src="../../../backend/assets/images/logo-mini.svg" alt="logo" /></a> -->
                <a class="navbar-brand brand-logo-mini text-white" href="{{ route('admin.dashboard') }}"><h1>ZS</h1></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>
                @if(request()->routeIs('admin.products.index'))
                <div class="search-field d-none d-xl-block">
                    <form class="d-flex align-items-center h-100" action="{{ route('admin.products.index') }}" method="GET">
                        <div class="input-group">
                            <div class="input-group-prepend bg-transparent">
                                <i class="input-group-text border-0 mdi mdi-magnify"></i>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   class="form-control bg-transparent border-0" 
                                   placeholder="Search products by name..."
                                   value="{{ request('search') }}">
                            @if(request('search'))
                            <div class="input-group-append">
                                <a href="{{ route('admin.products.index') }}" class="input-group-text bg-transparent border-0" style="cursor: pointer;">
                                    <i class="mdi mdi-close"></i>
                                </a>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
                @elseif(request()->routeIs('admin.orders.index'))
                <div class="search-field d-none d-xl-block">
                    <form class="d-flex align-items-center h-100" action="{{ route('admin.orders.index') }}" method="GET">
                        <div class="input-group">
                            <div class="input-group-prepend bg-transparent">
                                <i class="input-group-text border-0 mdi mdi-magnify"></i>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   class="form-control bg-transparent border-0" 
                                   placeholder="Search orders by order number..."
                                   value="{{ request('search') }}">
                            @if(request('search'))
                            <div class="input-group-append">
                                <a href="{{ route('admin.orders.index') }}" class="input-group-text bg-transparent border-0" style="cursor: pointer;">
                                    <i class="mdi mdi-close"></i>
                                </a>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
                @endif
                <ul class="navbar-nav navbar-nav-right">

                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown"
                            aria-expanded="false">
                            <div class="nav-profile-img">
                                <img src="../../../backend/assets/images/faces-clipart/pic-4.png" alt="image">
                            </div>
                            <div class="nav-profile-text">
                                <p class="mb-1 text-black">{{ Auth::user()->name }}</p>
                            </div>
                        </a>
                        <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm"
                            aria-labelledby="profileDropdown" data-x-placement="bottom-end">

                            <div class="p-2">
                                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    <span>Log Out</span>
                                    <i class="mdi mdi-logout ml-1"></i>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav position-relative">
                    <li class="nav-item nav-category"></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <span class="icon-bg"><i class="mdi mdi-view-dashboard menu-icon"></i></span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.categories.index') }}">
                            <span class="icon-bg"><i class="mdi mdi-package-variant menu-icon"></i></span>
                            <span class="menu-title">Categories</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.products.index') }}">
                            <span class="icon-bg"><i class="mdi mdi-package-variant menu-icon"></i></span>
                            <span class="menu-title">Products</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.sliders.index') }}">
                            <span class="icon-bg"><i class="mdi mdi-image-multiple menu-icon"></i></span>
                            <span class="menu-title">Sliders</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.ready-to-wears.index') }}">
                            <span class="icon-bg"><i class="mdi mdi-tshirt-crew menu-icon"></i></span>
                            <span class="menu-title">Ready To Wear</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.best-seller-videos.index') }}">
                            <span class="icon-bg"><i class="mdi mdi-video menu-icon"></i></span>
                            <span class="menu-title">Best Seller Videos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.testimonials.index') }}">
                            <span class="icon-bg"><i class="mdi mdi-comment-text-multiple menu-icon"></i></span>
                            <span class="menu-title">Testimonials</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.blogs.index') }}">
                            <span class="icon-bg"><i class="mdi mdi-book-open-page-variant menu-icon"></i></span>
                            <span class="menu-title">Blogs</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.orders.index') }}">
                            <span class="icon-bg"><i class="mdi mdi-cart menu-icon"></i></span>
                            <span class="menu-title">Orders</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.payments.index') }}">
                            <span class="icon-bg"><i class="mdi mdi-credit-card menu-icon"></i></span>
                            <span class="menu-title">Payments</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.coupons.index') }}">
                            <span class="icon-bg"><i class="mdi mdi-tag menu-icon"></i></span>
                            <span class="menu-title">Coupons</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.reviews.index') }}">
                            <span class="icon-bg"><i class="mdi mdi-star menu-icon"></i></span>
                            <span class="menu-title">Reviews</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.contacts.index') }}">
                            <span class="icon-bg"><i class="mdi mdi-email menu-icon"></i></span>
                            <span class="menu-title">Contacts</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.customers.index') }}">
                            <span class="icon-bg"><i class="mdi mdi-account-group menu-icon"></i></span>
                            <span class="menu-title">Customers</span>
                        </a>
                    </li>

                    <li class="nav-item sidebar-user-actions mt-5">
                        <div class="sidebar-user-menu">
                            <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" class="nav-link"><i class="mdi mdi-logout menu-icon"></i>
                                <span class="menu-title">Log Out</span></a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                  @csrf
                              </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                @yield('content')
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="footer-inner-wraper">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright ©
                                2020</span>
                        </div>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('backend/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('backend/assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/jquery-circle-progress/js/circle-progress.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('backend/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('backend/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('backend/assets/js/misc.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('backend/assets/js/dashboard.js') }}"></script>
    <!-- End custom js for this page -->
    @stack('scripts')
</body>

</html>
