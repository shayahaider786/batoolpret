<!DOCTYPE html>
<html lang="en">

<head>
    <title>Batool Pret - The Pure One</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Batool Pret - The Pure One. Discover our premium collection of elegant fashion and lifestyle products.">
    <meta name="keywords" content="Batool Pret, fashion, clothing, grace in every thread, premium fashion, lifestyle">
    <meta name="author" content="Batool Pret">
    <meta property="og:site_name" content="Batool Pret">
    <meta property="og:title" content="Batool Pret - The Pure One">
    <meta property="og:description"
        content="Batool Pret - The Pure One. Discover our premium collection of elegant fashion and lifestyle products.">
    <!--===============================================================================================-->
    @stack('meta')
    @stack('canonical')
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/icons/favicons.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('frontend/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('frontend/fonts/iconic/css/material-design-iconic-font.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/fonts/linearicons-v1.0.0/icon-font.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/animsition/css/animsition.min.css') }}"> --}}
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/daterangepicker/daterangepicker.css') }}">
    <!--===============================================================================================-->
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/MagnificPopup/magnific-popup.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('frontend/vendor/perfect-scrollbar/perfect-scrollbar.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset('https://unpkg.com/swiper@8/swiper-bundle.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/navbar-premium.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/mobile-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/banner-section.css') }}">
    @stack('styles')
    <!--===============================================================================================-->
    <!-- Google Analytics tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-N7323YQZYG"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-N7323YQZYG');
    </script>
    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1596194501725991');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1596194501725991&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->

    <!-- TikTok Pixel Code Start -->
    <script>
        ! function(w, d, t) {
            w.TiktokAnalyticsObject = t;
            var ttq = w[t] = w[t] || [];
            ttq.methods = ["page", "track", "identify", "instances", "debug", "on", "off", "once", "ready", "alias",
                "group", "enableCookie", "disableCookie", "holdConsent", "revokeConsent", "grantConsent"
            ], ttq.setAndDefer = function(t, e) {
                t[e] = function() {
                    t.push([e].concat(Array.prototype.slice.call(arguments, 0)))
                }
            };
            for (var i = 0; i < ttq.methods.length; i++) ttq.setAndDefer(ttq, ttq.methods[i]);
            ttq.instance = function(t) {
                for (
                    var e = ttq._i[t] || [], n = 0; n < ttq.methods.length; n++) ttq.setAndDefer(e, ttq.methods[n]);
                return e
            }, ttq.load = function(e, n) {
                var r = "https://analytics.tiktok.com/i18n/pixel/events.js",
                    o = n && n.partner;
                ttq._i = ttq._i || {}, ttq._i[e] = [], ttq._i[e]._u = r, ttq._t = ttq._t || {}, ttq._t[e] = +new Date,
                    ttq._o = ttq._o || {}, ttq._o[e] = n || {};
                n = document.createElement("script");
                n.type = "text/javascript", n.async = !0, n.src = r + "?sdkid=" + e + "&lib=" + t;
                e = document.getElementsByTagName("script")[0];
                e.parentNode.insertBefore(n, e)
            };


            ttq.load('D6HHD4BC77U7C65PCLVG');
            ttq.page();
        }(window, document, 'ttq');
    </script>
    <!-- TikTok Pixel Code End -->
    <noscript>
        <img height="1" width="1" style="display:none;" alt=""
            src="https://analytics.tiktok.com/i18n/pixel/events.js?sdkid=D6HHD4BC77U7C65PCLVG&lib=ttq" />
    </noscript>
</head>

<body>

    <!-- Header -->
    <header>
        <!-- Header desktop -->
        <div class="container-menu-desktop">
            <!-- Topbar -->
            <div class="top-bar">
                <div class="content-topbar flex-sb-m h-full container">
                    <div class="left-top-bar text-white d-flex align-items-center">
                        <div class="social-icons-top d-flex align-items-center">
                            <a href="#" target="blank"
                                class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                                <i class="fa fa-facebook"></i>
                            </a>

                            <a href="#" target="blank"
                                class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                                <i class="fa fa-instagram"></i>
                            </a>

                            <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16"
                                target="blank">
                                <i class="fa-brands fa-tiktok"></i>
                            </a>
                        </div>
                        <marquee class="top-bar-marquee">FREE SHIPPING ON ORDERS ABOVE RS. 5000 | PAKISTAN'S PREMIUM LADIES BRAND</marquee>
                    </div>

                    <div class="right-top-bar flex-w h-full">
                        @guest
                            <a href="{{ route('login') }}" class="flex-c-m trans-04 p-lr-25" title="Login">
                                <i class="zmdi zmdi-account" style="font-size: 18px; margin-right: 5px;"></i>
                                <span>Login</span>
                            </a>
                        @else
                            @if (Auth::user()->type == 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="flex-c-m trans-04 p-lr-25"
                                    title="Admin Dashboard">
                                    <i class="zmdi zmdi-account" style="font-size: 18px; margin-right: 5px;"></i>
                                    <span>My Account</span>
                                </a>
                            @else
                                <a href="{{ route('home') }}" class="flex-c-m trans-04 p-lr-25" title="My Account">
                                    <i class="zmdi zmdi-account" style="font-size: 18px; margin-right: 5px;"></i>
                                    <span>My Account</span>
                                </a>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>

            <div class="wrap-menu-desktop">
                <nav class="limiter-menu-desktop container">

                    <!-- Hamburger desktop -->
                    <div class="btn-show-menu-mobile hamburger hamburger--squeeze desktop-hamburger">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </div>

                    <!-- Logo desktop -->
                    <a href="{{ route('index') }}" class="logo">
                        <img src="../../frontend/images/icons/zaylishlogo-1.png" alt="IMG-LOGO">
                    </a>

                    <!-- Menu desktop -->
                    <div class="nav-set d-flex align-items-center justify-content-between w-100">
                        <div class="menu-desktop">
                            <ul class="main-menu">
                                <li class="{{ request()->routeIs('index') ? 'active-menu' : '' }}">
                                    <a href="{{ route('index') }}">Home</a>
                                </li>

                                @php
                                    $isShopActive =
                                        (request()->routeIs('shop') ||
                                            request()->routeIs('tagShop') ||
                                            request()->routeIs('productDetail')) &&
                                        !request('sale') &&
                                        !request('tag') &&
                                        !request('categories');
                                    $isSaleActive = request()->routeIs('shop') && request('sale') == 'true';
                                    $isNewInActive = request()->routeIs('shop') && request('tag') == 'new_arrival';
                                    $isTrendingActive = request()->routeIs('shop') && request('tag') == 'trending';
                                    $isBestSellingActive =
                                        request()->routeIs('shop') && request('tag') == 'best_selling';
                                    $isCollectionsActive =
                                        (request()->routeIs('shop') || request()->routeIs('tagShop')) &&
                                        (request('tag') == 'new_arrival' ||
                                            request('tag') == 'trending' ||
                                            request('tag') == 'best_selling');
                                    $bagsCategory = \App\Models\Category::where(function ($q) {
                                        $q->where('name', 'LIKE', '%bag%')->orWhere('slug', 'LIKE', '%bag%');
                                    })
                                        ->active()
                                        ->first();
                                    $bagsCategoryId = $bagsCategory ? $bagsCategory->id : null;

                                    // SUMMER Collection category (replaces Eid Collection)
                                    $summerCategory = \App\Models\Category::where(function ($q) {
                                        $q->where('name', 'LIKE', '%summer%')
                                            ->orWhere('slug', 'LIKE', '%summer%')
                                            ->orWhere('name', 'LIKE', '%seasonal%');
                                    })
                                        ->active()
                                        ->first();
                                    $summerCategoryId = $summerCategory ? $summerCategory->id : null;

                                    // Casual category (if exists)
                                    $casualCategory = \App\Models\Category::where(function ($q) {
                                        $q->where('name', 'LIKE', '%casual%')->orWhere('slug', 'LIKE', '%casual%');
                                    })
                                        ->active()
                                        ->first();
                                    $casualCategoryId = $casualCategory ? $casualCategory->id : null;

                                    // Formal category (if exists)
                                    $formalCategory = \App\Models\Category::where(function ($q) {
                                        $q->where('name', 'LIKE', '%formal%')->orWhere('slug', 'LIKE', '%formal%');
                                    })
                                        ->active()
                                        ->first();
                                    $formalCategoryId = $formalCategory ? $formalCategory->id : null;

                                    $isBagsActive =
                                        (request()->routeIs('shop') || request()->routeIs('tagShop')) &&
                                        request('categories') &&
                                        is_array(request('categories')) &&
                                        $bagsCategoryId &&
                                        in_array($bagsCategoryId, request('categories'));

                                    $isSummerActive =
                                        (request()->routeIs('shop') || request()->routeIs('tagShop')) &&
                                        request('categories') &&
                                        is_array(request('categories')) &&
                                        $summerCategoryId &&
                                        in_array($summerCategoryId, request('categories'));

                                    $isCasualActive =
                                        (request()->routeIs('shop') || request()->routeIs('tagShop')) &&
                                        request('categories') &&
                                        is_array(request('categories')) &&
                                        $casualCategoryId &&
                                        in_array($casualCategoryId, request('categories'));

                                    $isFormalActive =
                                        (request()->routeIs('shop') || request()->routeIs('tagShop')) &&
                                        request('categories') &&
                                        is_array(request('categories')) &&
                                        $formalCategoryId &&
                                        in_array($formalCategoryId, request('categories'));
                                @endphp

                                <li class="label1 {{ $isNewInActive ? 'active-menu' : '' }}">
                                    <a href="{{ route('shop', ['tag' => 'new_arrival']) }}">New Arrival</a>
                                </li>

                                @if ($casualCategoryId)
                                    <li class="{{ $isCasualActive ? 'active-menu' : '' }}">
                                        <a href="{{ route('shop', ['categories' => [$casualCategoryId]]) }}">Casual</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('shop', ['categories' => [$casualCategoryId]]) }}">Summer</a></li>
                                            <li><a href="{{ route('shop', ['categories' => [$casualCategoryId]]) }}">Winter</a></li>
                                            <li><a href="{{ route('shop', ['categories' => [$casualCategoryId]]) }}">Spring</a></li>
                                        </ul>
                                    </li>
                                @endif

                                @if ($formalCategoryId)
                                    <li class="{{ $isFormalActive ? 'active-menu' : '' }}">
                                        <a href="{{ route('shop', ['categories' => [$formalCategoryId]]) }}">Semi Formal</a>
                                    </li>
                                @endif

                                @if ($bagsCategoryId)
                                    <li class="{{ $isBagsActive ? 'active-menu' : '' }}">
                                        <a href="{{ route('shop', ['categories' => [$bagsCategoryId]]) }}">Kids</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('shop', ['categories' => [$bagsCategoryId]]) }}">Summer</a></li>
                                            <li><a href="{{ route('shop', ['categories' => [$bagsCategoryId]]) }}">Winter</a></li>
                                            <li><a href="{{ route('shop', ['categories' => [$bagsCategoryId]]) }}">Spring</a></li>
                                        </ul>
                                    </li>
                                @endif

                                <li class="{{ request()->routeIs('shop') && request('sale') == 'true' ? 'active-menu' : '' }}">
                                    <a href="{{ route('shop', ['sale' => 'true']) }}">Sale</a>
                                </li>

                            </ul>
                        </div>

                        <!-- Icon header -->
                        <div class="wrap-icon-header flex-w flex-r-m">
                            <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                                <i class="zmdi zmdi-search"></i>
                            </div>

                            <a href="{{ route('cart') }}"
                                class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
                                data-notify="{{ $cartCount ?? 0 }}" title="View Cart">
                                <i class="zmdi zmdi-shopping-cart"></i>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header Mobile -->
        <div class="wrap-header-mobile">
            <!-- Logo moblie -->
            <div class="logo-mobile">
                <a href="{{ route('index') }}"><img src="../../frontend/images/icons/zaylishlogo-1.png"
                        alt="IMG-LOGO"></a>
            </div>

            <!-- Icon header -->
            <div class="wrap-icon-header flex-w flex-r-m m-r-15">

                <!--Search.icon-->
                <div class="icon-header-item-s cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                    <i class="zmdi zmdi-search"></i>
                </div>
                <a href="{{ route('cart') }}"
                    class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
                    data-notify="{{ $cartCount ?? 0 }}" title="View Cart">
                    <i class="zmdi zmdi-shopping-cart"></i>
                </a>
            </div>

            <!-- Button show menu -->
            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div class="menu-mobile-overlay"></div>

        <!-- Mobile Menu -->
        <div class="menu-mobile">
            <ul class="main-menu-m">
                <li>
                    <a href="{{ route('index') }}" class="{{ request()->routeIs('index') ? 'active' : '' }}">
                        Home
                    </a>
                </li>

                <li>
                    <a href="{{ route('shop', ['tag' => 'new_arrival']) }}"
                        class="{{ request()->routeIs('shop') && request('tag') == 'new_arrival' ? 'active' : '' }}">
                        New Arrival
                    </a>
                </li>

                @if ($casualCategoryId)
                    <li class="has-submenu">
                        <a href="{{ route('shop', ['categories' => [$casualCategoryId]]) }}"
                            class="{{ $isCasualActive ? 'active' : '' }}">
                            Casual
                            <span class="arrow-main-menu-m">
                                <i class="fa fa-plus"></i>
                            </span>
                        </a>
                        <ul class="sub-menu-m">
                            <li><a href="{{ route('shop', ['categories' => [$casualCategoryId]]) }}">Summer</a></li>
                            <li><a href="{{ route('shop', ['categories' => [$casualCategoryId]]) }}">Winter</a></li>
                            <li><a href="{{ route('shop', ['categories' => [$casualCategoryId]]) }}">Spring</a></li>
                        </ul>
                    </li>
                @endif

                @if ($formalCategoryId)
                    <li>
                        <a href="{{ route('shop', ['categories' => [$formalCategoryId]]) }}"
                            class="{{ $isFormalActive ? 'active' : '' }}">
                            Semi Formal
                        </a>
                    </li>
                @endif

                @if ($bagsCategoryId)
                    <li class="has-submenu">
                        <a href="{{ route('shop', ['categories' => [$bagsCategoryId]]) }}"
                            class="{{ $isBagsActive ? 'active' : '' }}">
                            Kids
                            <span class="arrow-main-menu-m">
                                <i class="fa fa-plus"></i>
                            </span>
                        </a>
                        <ul class="sub-menu-m">
                            <li><a href="{{ route('shop', ['categories' => [$bagsCategoryId]]) }}">Summer</a></li>
                            <li><a href="{{ route('shop', ['categories' => [$bagsCategoryId]]) }}">Winter</a></li>
                            <li><a href="{{ route('shop', ['categories' => [$bagsCategoryId]]) }}">Spring</a></li>
                        </ul>
                    </li>
                @endif

                <li>
                    <a href="{{ route('shop', ['sale' => 'true']) }}"
                        class="{{ request()->routeIs('shop') && request('sale') == 'true' ? 'active' : '' }}">
                        Sale
                        {{-- <span class="label-hot">Hot</span> --}}
                    </a>
                </li>

                @guest
                    <li>
                        <a href="{{ route('login') }}">
                            <i class="zmdi zmdi-account m-r-10"></i>Login
                        </a>
                    </li>
                @else
                    <li>
                        @if (Auth::user()->type == 'admin')
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="zmdi zmdi-account m-r-10"></i>My Account
                            </a>
                        @else
                            <a href="{{ route('home') }}">
                                <i class="zmdi zmdi-account m-r-10"></i>My Account
                            </a>
                        @endif
                    </li>
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="zmdi zmdi-power m-r-10"></i>Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>

        <!-- Modal Search -->
        @include('frontend.partials.search-modal')
    </header>
    <main>

        @yield('content')

        <!-- Product -->

    </main>

    <!-- Footer -->
    <footer class="bg3 p-t-75 p-b-32">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3 p-b-50 footerSection">
                    <h4 class="stext-301 cl0 p-b-30">
                        Collection
                    </h4>

                    <ul class="footer-list">
                        <li class="p-b-10">
                            <a href="{{ route('shop', ['tag' => 'new_arrival']) }}"
                                class="stext-107 cl7 hov-cl1 trans-04">
                                New Arrivals
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="{{ route('shop', ['tag' => 'trending']) }}"
                                class="stext-107 cl7 hov-cl1 trans-04">
                                Trending
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="{{ route('shop', ['tag' => 'best_selling']) }}"
                                class="stext-107 cl7 hov-cl1 trans-04">
                                Best Selling
                            </a>
                        </li>



                        <li class="p-b-10">
                            <a href="{{ route('contact') }}" class="stext-107 cl7 hov-cl1 trans-04">
                                Contact Us
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50 footerSection">
                    <h4 class="stext-301 cl0 p-b-30">
                        Help
                    </h4>

                    <ul class="footer-list">
                        <li class="p-b-10">
                            <a href="{{ route('order.lookup') }}" target="blank"
                                class="stext-107 cl7 hov-cl1 trans-04">
                                Track Order
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="{{ route('blogs') }}" target="blank" class="stext-107 cl7 hov-cl1 trans-04">
                                Blogs
                            </a>
                        </li>
                        <li class="p-b-10">
                            <a href="{{ route('terms') }}" target="blank" class="stext-107 cl7 hov-cl1 trans-04">
                                Terms & Conditions
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="{{ route('privacy') }}" target="blank" class="stext-107 cl7 hov-cl1 trans-04">
                                Privacy Policy
                            </a>
                        </li>


                        {{-- <li class="p-b-10">
                            <a href="{{ route('about') }}" target="blank" class="stext-107 cl7 hov-cl1 trans-04">
                                About Us
                            </a>
                        </li> --}}
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50 footerSectionTwo">
                    <h4 class="stext-301 cl0 p-b-30">
                        GET IN TOUCH
                    </h4>

                    <p class="stext-107 cl7 size-201">
                        Any questions about our products or orders? Our customer support team is always available to
                        assist you. Call us at <a href="tel:+923144707099">+923224741317</a>

                    </p>

                    <div class="p-t-27">
                        <a href="#" target="blank"
                            class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-facebook"></i>
                        </a>

                        <a href="#" target="blank"
                            class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-instagram"></i>
                        </a>

                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16"
                            target="blank">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50 footerSectionTwo">
                    <h4 class="stext-301 cl0 p-b-30">
                        Newsletter
                    </h4>

                    <form>
                        <div class="wrap-input1 w-full p-b-4">
                            <input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email"
                                placeholder="email@example.com">
                            <div class="focus-input1 trans-04"></div>
                        </div>

                        <div class="p-t-18">
                            <button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                                Subscribe
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            <p class="stext-107 cl6 txt-center">
                Copyright &copy; {{ date('Y') }} Batool Pret - The Pure One. All rights reserved.
            </p>
        </div>
        </div>
    </footer>


    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top"
            style="
        text-align: center;
        width: 100%;
        font-size: 32px;
        color: white; ">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/923224741317?text={{ urlencode('Hi! I would like to know more about your products.') }}"
        target="_blank" class="whatsapp-float" title="Contact us on WhatsApp">
        <i class="fa fa-whatsapp"></i>
    </a>

    <!--===============================================================================================-->
    <!-- Critical Scripts - Load First -->
    <script src="{{ asset('frontend/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <!-- Animsition - Disabled for faster page load -->
    {{-- <script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}" defer></script> --}}
    <!--===============================================================================================-->
    <!-- Non-Critical Scripts - Load Conditionally -->
    @if (request()->routeIs('productDetail') || request()->routeIs('shop'))
        <script src="{{ asset('frontend/vendor/select2/select2.min.js') }}" defer></script>
    @endif
    @if (request()->routeIs('productDetail') || request()->routeIs('shop'))
        <script>
            $(document).ready(function() {
                $(".js-select2").each(function() {
                    $(this).select2({
                        minimumResultsForSearch: 20,
                        dropdownParent: $(this).next('.dropDownSelect2')
                    });
                });
            });
        </script>
    @endif

    <script>
        // Product Attribute Selection Handler (Vanilla JavaScript)
        document.addEventListener('DOMContentLoaded', function() {
            // Main product - Size selection
            document.querySelectorAll('input[name="product-size"]').forEach(function(input) {
                input.addEventListener('change', function() {
                    document.querySelectorAll('input[name="product-size"]').forEach(i =>
                        document.querySelector('label[for="' + i.id + '"]').classList.remove(
                            'active')
                    );
                    document.querySelector('label[for="' + this.id + '"]').classList.add('active');
                });
            });

            // Modal - Size selection
            document.querySelectorAll('input[name="modal-product-size"]').forEach(function(input) {
                input.addEventListener('change', function() {
                    document.querySelectorAll('input[name="modal-product-size"]').forEach(i =>
                        document.querySelector('label[for="' + i.id + '"]').classList.remove(
                            'active')
                    );
                    document.querySelector('label[for="' + this.id + '"]').classList.add('active');
                });
            });

            // Related products - Size selection
            document.querySelectorAll('input[name="product-size-related"]').forEach(function(input) {
                input.addEventListener('change', function() {
                    document.querySelectorAll('input[name="product-size-related"]').forEach(i =>
                        document.querySelector('label[for="' + i.id + '"]').classList.remove(
                            'active')
                    );
                    document.querySelector('label[for="' + this.id + '"]').classList.add('active');
                });
            });

            // Fabric selection
            document.querySelectorAll('input[name="product-fabric"]').forEach(function(input) {
                input.addEventListener('change', function() {
                    document.querySelectorAll('input[name="product-fabric"]').forEach(i =>
                        document.querySelector('label[for="' + i.id + '"]').classList.remove(
                            'active')
                    );
                    document.querySelector('label[for="' + this.id + '"]').classList.add('active');
                });
            });

            // Main product - Color selection
            document.querySelectorAll('input[name="product-color"]').forEach(function(input) {
                input.addEventListener('change', function() {
                    document.querySelectorAll('input[name="product-color"]').forEach(i =>
                        document.querySelector('label[for="' + i.id + '"]').classList.remove(
                            'active')
                    );
                    document.querySelector('label[for="' + this.id + '"]').classList.add('active');
                });
            });

            // Related products - Color selection
            document.querySelectorAll('input[name="product-color-related"]').forEach(function(input) {
                input.addEventListener('change', function() {
                    document.querySelectorAll('input[name="product-color-related"]').forEach(i =>
                        document.querySelector('label[for="' + i.id + '"]').classList.remove(
                            'active')
                    );
                    document.querySelector('label[for="' + this.id + '"]').classList.add('active');
                });
            });

            // Set first fabric option as default
            var firstFabric = document.getElementById('fabric-khaddar');
            if (firstFabric && !firstFabric.checked) {
                firstFabric.checked = true;
                document.querySelector('label[for="fabric-khaddar"]').classList.add('active');
            }
        });

        // Remove all Select2 initialization since we're using native buttons
        // Keep jQuery available but don't initialize Select2 on product size/color/fabric
        if (typeof jQuery !== 'undefined') {
            jQuery(function($) {
                $(".js-select2:not([name*='size']):not([name*='color']):not([name*='fabric'])").each(function() {
                    if ($(this).closest('.product-attribute-section').length === 0) {
                        $(this).select2({
                            minimumResultsForSearch: 20,
                            dropdownParent: $(this).next('.dropDownSelect2')
                        });
                    }
                });
            });
        }
    </script>

    <!--===============================================================================================-->
    <!-- Slider Scripts - Defer for faster initial load -->
    <script src="{{ asset('frontend/vendor/slick/slick.min.js') }}" defer></script>
    <script src="{{ asset('frontend/js/custom.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            $('.slick1').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 6000,
                arrows: true,
                dots: true,
                fade: true,
                adaptiveHeight: false
            });

            // Simple layer animation support (mimics original template behaviour)
            $('.slick1').on('init afterChange', function(event, slick, current) {
                var idx = (typeof current === 'number') ? current : 0;
                var $slide = $(slick.$slides.get(idx));
                // remove classes from all layers
                $(slick.$slides).find('.layer-slick1').each(function() {
                    $(this).removeClass($(this).data('appear') + ' visible-true');
                });
                // add classes for current slide with delays
                $slide.find('.layer-slick1').each(function(i, el) {
                    var delay = parseInt($(el).data('delay')) || 0;
                    var appear = $(el).data('appear') || '';
                    setTimeout(function() {
                        $(el).addClass(appear + ' visible-true');
                    }, delay);
                });
            });

            // trigger init to animate first slide
            $('.slick1').slick('setPosition');
        });
    </script>
    <!--===============================================================================================-->
    <!-- Gallery Lightbox - Only load on product detail pages -->
    @if (request()->routeIs('productDetail'))
        <script src="{{ asset('frontend/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}" defer></script>
        <script>
            $(document).ready(function() {
                $('.gallery-lb').each(function() {
                    $(this).magnificPopup({
                        delegate: 'a',
                        type: 'image',
                        gallery: {
                            enabled: true
                        },
                        mainClass: 'mfp-fade'
                    });
                });
            });
        </script>
    @endif
    <!--===============================================================================================-->
    <!-- Isotope - Only load on shop/filter pages -->
    @if (request()->routeIs('shop') || request()->routeIs('tagShop'))
        <script src="{{ asset('frontend/vendor/isotope/isotope.pkgd.min.js') }}" defer></script>
    @endif
    <!--===============================================================================================-->
    <!-- SweetAlert - Defer for faster load -->
    <script src="{{ asset('frontend/vendor/sweetalert/sweetalert.min.js') }}" defer></script>

    <!--===============================================================================================-->
    <!-- Perfect Scrollbar - Only load once, defer for faster load -->
    <script src="{{ asset('frontend/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            $('.js-pscroll').each(function() {
                if (typeof PerfectScrollbar !== 'undefined') {
                    $(this).css('position', 'relative');
                    $(this).css('overflow', 'hidden');
                    var ps = new PerfectScrollbar(this, {
                        wheelSpeed: 1,
                        scrollingThreshold: 1000,
                        wheelPropagation: false,
                    });

                    $(window).on('resize', function() {
                        ps.update();
                    });
                }
            });
        });
    </script>
    <!--===============================================================================================-->
    <!-- Main JS - Defer for faster load -->
    <script src="{{ asset('frontend/js/main.js') }}" defer></script>
    <script src="{{ asset('frontend/js/navbar-premium.js') }}" defer></script>
    <script src="{{ asset('frontend/js/mobile-menu.js') }}" defer></script>
    <script src="{{ asset('frontend/js/trending-carousel.js') }}" defer></script>


    <!-- Search Functionality - Ensure it works with deferred scripts -->
    <script>
        function initSearchFunctionality() {
            // Show / hide modal search
            $('.js-show-modal-search').off('click').on('click', function() {
                $('.modal-search-header').addClass('show-modal-search');
                $(this).css('opacity', '0');
                $('.search-input').focus();
            });

            $('.js-hide-modal-search').off('click').on('click', function() {
                $('.modal-search-header').removeClass('show-modal-search');
                $('.js-show-modal-search').css('opacity', '1');
                $('.search-input').val('');
                $('#searchResults').html(
                    '<div class="search-no-results">Start typing to search for products...</div>').removeClass(
                    'show');
            });

            $('.container-search-header').off('click').on('click', function(e) {
                e.stopPropagation();
            });

            // Close modal when clicking outside
            $('.modal-search-header').off('click').on('click', function(e) {
                if (e.target === this) {
                    $('.js-hide-modal-search').click();
                }
            });

            // Search input functionality with AJAX
            let searchTimeout;
            let isSearching = false;

            $('#search-input').off('keyup').on('keyup', function() {
                clearTimeout(searchTimeout);
                let searchTerm = $(this).val().trim();

                if (searchTerm.length === 0) {
                    $('#searchResults').html(
                            '<div class="search-no-results">Start typing to search for products...</div>')
                        .removeClass('show');
                    return;
                }

                if (searchTerm.length < 2) {
                    $('#searchResults').html(
                            '<div class="search-no-results">Please enter at least 2 characters...</div>')
                        .removeClass('show');
                    return;
                }

                // Debounce search - wait 300ms after user stops typing
                searchTimeout = setTimeout(function() {
                    if (!isSearching) {
                        performSearch(searchTerm);
                    }
                }, 300);
            });

            function performSearch(searchTerm) {
                isSearching = true;
                $('#searchResults').html('<div class="search-loading">Searching...</div>').addClass('show');

                $.ajax({
                    url: '/search/products',
                    method: 'GET',
                    data: {
                        q: searchTerm
                    },
                    success: function(response) {
                        isSearching = false;
                        if (response.success && response.products.length > 0) {
                            displaySearchResults(response.products);
                        } else {
                            $('#searchResults').html(
                                '<div class="search-no-results">No products found matching "' + searchTerm +
                                '"</div>').addClass('show');
                        }
                    },
                    error: function(xhr) {
                        isSearching = false;
                        $('#searchResults').html(
                            '<div class="search-no-results">Error searching products. Please try again.</div>'
                        ).addClass('show');
                    }
                });
            }

            function displaySearchResults(products) {
                let html = '<div class="search-results-list">';

                products.forEach(function(product) {
                    let price = product.discount_price ? product.discount_price : product.price;
                    let originalPrice = product.discount_price && product.discount_price < product.price ?
                        '<span class="search-product-original-price">Rs. ' + parseInt(product.price)
                        .toLocaleString() + '</span>' :
                        '';

                    html += '<a href="' + product.url + '" class="search-result-item">';
                    html += '<div class="search-result-image">';
                    html += '<img src="' + product.image + '" alt="' + product.name + '" loading="lazy">';
                    html += '</div>';
                    html += '<div class="search-result-info">';
                    html += '<div class="search-result-name">' + product.name + '</div>';
                    html += '<div class="search-result-price">Rs. ' + parseInt(price).toLocaleString() + ' ' +
                        originalPrice + '</div>';
                    html += '</div>';
                    html += '</a>';
                });

                html += '</div>';
                $('#searchResults').html(html).addClass('show');
            }
        }

        // Initialize search on document ready
        $(document).ready(function() {
            initSearchFunctionality();
        });

        // Also initialize after a slight delay to handle deferred script loading
        setTimeout(function() {
            if ($('.js-show-modal-search').length > 0) {
                initSearchFunctionality();
            }
        }, 500);
    </script>


    <!-- Swiper - Load on product detail (gallery, related) and index (testimonials) -->
    @if (request()->routeIs('productDetail') || request()->routeIs('index'))
        <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js" defer></script>
    @endif
    @if (request()->routeIs('productDetail'))
        <script src="{{ asset('frontend/js/swiper-custom.js') }}" defer></script>
        <script>
            // Product Gallery with Thumbnails - Only on product detail page
            $(document).ready(function() {
                var mainSwiper = null;
                var modalSwiper = null;

                // Initialize product galleries
                function initGallery(container) {
                    var $container = $(container);
                    var $wrapper = $container.find('.wrap-slick3-main');
                    var $swiper = $container.find('.slick3-main');
                    var $items = $container.find('.item-slick3-main');
                    var $thumbnails = $container.find('.thumbnail-item');

                    if ($swiper.length && $wrapper.length) {
                        $wrapper.addClass('swiper');
                        $swiper.addClass('swiper-wrapper');
                        $items.addClass('swiper-slide');

                        // Destroy existing swiper if any
                        if ($wrapper[0].swiper) {
                            $wrapper[0].swiper.destroy(true, true);
                        }

                        var swiperInstance = new Swiper($wrapper[0], {
                            slidesPerView: 1,
                            spaceBetween: 0,
                            loop: $items.length > 1,
                            effect: 'fade',
                            fadeEffect: {
                                crossFade: true
                            },
                            navigation: {
                                nextEl: $container.find('.next-slick3-main')[0],
                                prevEl: $container.find('.prev-slick3-main')[0],
                            },
                            on: {
                                slideChange: function() {
                                    // Use realIndex for looped sliders, activeIndex for non-looped
                                    var activeIndex = this.params.loop ? this.realIndex : this.activeIndex;
                                    updateActiveThumbnail($container, activeIndex);
                                }
                            }
                        });

                        // Thumbnail click handler for this gallery
                        $thumbnails.off('click.gallery').on('click.gallery', function() {
                            var index = $(this).data('index');
                            // slideTo handles loop mode automatically
                            if (swiperInstance.params.loop) {
                                swiperInstance.slideToLoop(index);
                            } else {
                                swiperInstance.slideTo(index);
                            }
                            updateActiveThumbnail($container, index);
                        });

                        // Set initial active thumbnail
                        updateActiveThumbnail($container, 0);

                        return swiperInstance;
                    }
                    return null;
                }

                // Update active thumbnail
                function updateActiveThumbnail(container, index) {
                    $(container).find('.thumbnail-item').removeClass('active');
                    $(container).find('.thumbnail-item[data-index="' + index + '"]').addClass('active');
                }

                // Initialize main gallery (non-modal)
                $('.product-gallery-wrapper').not('.wrap-modal1 .product-gallery-wrapper').each(function() {
                    mainSwiper = initGallery(this);
                });

                // Initialize Related Products Slider
                var relatedProductsSwiper = new Swiper('.related-products-swiper', {
                    slidesPerView: 2,
                    slidesPerGroup: 2,
                    spaceBetween: 15,
                    loop: false,
                    navigation: {
                        nextEl: '.related-products-next',
                        prevEl: '.related-products-prev',
                    },
                    breakpoints: {
                        320: {
                            slidesPerView: 2,
                            slidesPerGroup: 2,
                            spaceBetween: 10
                        },
                        480: {
                            slidesPerView: 2,
                            slidesPerGroup: 2,
                            spaceBetween: 12
                        },
                        768: {
                            slidesPerView: 3,
                            slidesPerGroup: 3,
                            spaceBetween: 15
                        },
                        1024: {
                            slidesPerView: 4,
                            slidesPerGroup: 4,
                            spaceBetween: 20
                        }
                    }
                });

                // Add to Cart Button Shake Animation every 5 seconds
                setInterval(function() {
                    $('.js-addcart-detail').each(function() {
                        var $button = $(this);
                        $button.removeClass('shake');
                        // Trigger reflow to restart animation
                        void $button[0].offsetWidth;
                        $button.addClass('shake');
                    });
                }, 5000);

                // Modal gallery initialization removed - handled in quick view script below

                // Save button handler (optional - you can add functionality here)
                $('.product-save-btn').on('click', function(e) {
                    e.preventDefault();
                    // Add your save functionality here
                    console.log('Save button clicked');
                });

                // Ensure related products slider initializes correctly
                setTimeout(function() {
                    if (typeof Swiper !== 'undefined') {
                        $('.wrap-slick2').each(function() {
                            if (!$(this).hasClass('swiper-initialized')) {
                                // Force re-initialization if needed
                                var swiper = new Swiper(this, {
                                    wrapperClass: 'slick2 swiper-wrapper',
                                    slideClass: 'item-slick2 swiper-slide',
                                    slidesPerView: 4,
                                    slidesPerGroup: 1,
                                    spaceBetween: 20,
                                    loop: false,
                                    navigation: {
                                        nextEl: $(this).find('.next-slick2')[0],
                                        prevEl: $(this).find('.prev-slick2')[0],
                                    },
                                    breakpoints: {
                                        1200: {
                                            slidesPerView: 4,
                                            slidesPerGroup: 1,
                                            spaceBetween: 20
                                        },
                                        992: {
                                            slidesPerView: 3,
                                            slidesPerGroup: 1,
                                            spaceBetween: 20
                                        },
                                        768: {
                                            slidesPerView: 2,
                                            slidesPerGroup: 1,
                                            spaceBetween: 15
                                        },
                                        576: {
                                            slidesPerView: 1,
                                            slidesPerGroup: 1,
                                            spaceBetween: 10
                                        }
                                    }
                                });
                                swiper.update();
                            }
                        });
                    }
                }, 500);
            });
        </script>
    @endif

    <!-- Checkout JS - Only load on checkout page -->
    @if (request()->routeIs('checkout'))
        <script src="{{ asset('frontend/js/checkout.js') }}" defer></script>
    @endif
    <!-- Bottom Navigation Mobile -->
    {{-- <nav class="bottom-nav-mobile">
        @php
            $isHomeActive = request()->routeIs('index');
            $isShopActiveMobile = (request()->routeIs('shop') || request()->routeIs('tagShop') || request()->routeIs('productDetail')) && !request('sale') && !request('tag');
            $isSaleActiveMobile = request()->routeIs('shop') && request('sale') == 'true';
            $isContactActive = request()->routeIs('contact');
            $isSummerActiveMobile = request()->routeIs('shop') && request('categories') && is_array(request('categories')) && $summerCategoryId && in_array($summerCategoryId, request('categories'));
        @endphp

        <a href="{{ route('index') }}" class="bottom-nav-item {{ $isHomeActive ? 'active' : '' }}">
            <i class="zmdi zmdi-home"></i>
            <span class="bottom-nav-label">Home</span>
        </a>

        @if ($summerCategoryId)
            <a href="{{ route('shop', ['categories' => [$summerCategoryId]]) }}"
                class="bottom-nav-item {{ $isSummerActiveMobile ? 'active' : '' }}">
                <i class="zmdi zmdi-star"></i>
                <span class="bottom-nav-label">Summer</span>
            </a>
        @endif

        <a href="{{ route('shop') }}" class="bottom-nav-item {{ $isCollectionsActive ? 'active' : '' }}">
            <i class="zmdi zmdi-local-offer"></i>
            <span class="bottom-nav-label">All Products</span>
        </a>

        @if ($bagsCategoryId)
            <a href="{{ route('shop', ['categories' => [$bagsCategoryId]]) }}"
                class="bottom-nav-item {{ $isBagsActive ? 'active' : '' }}">
                <i class="zmdi zmdi-shopping-basket"></i>
                <span class="bottom-nav-label">Bags</span>
            </a>
        @else
            <a href="{{ route('contact') }}" class="bottom-nav-item {{ $isContactActive ? 'active' : '' }}">
                <i class="zmdi zmdi-email"></i>
                <span class="bottom-nav-label">Contact</span>
            </a>
        @endif
    </nav> --}}

    <!-- Page-specific scripts -->
    @stack('scripts')

    <!-- Firebase Cloud Messaging -->
    <script type="module">
        // Import Firebase modules
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/12.7.0/firebase-app.js";
        import {
            getMessaging,
            getToken,
            onMessage
        } from "https://www.gstatic.com/firebasejs/12.7.0/firebase-messaging.js";

        // Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyAKvYZRyQtyxa7j3rSWGF1jliF4QTh7y2E",
            authDomain: "zaylish-56f79.firebaseapp.com",
            projectId: "zaylish-56f79",
            storageBucket: "zaylish-56f79.firebasestorage.app",
            messagingSenderId: "844375879908",
            appId: "1:844375879908:web:ad0784e22383426f46fcf1",
            measurementId: "G-B871GGYC5P"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        let messaging = null;

        // Check if browser supports service workers and notifications
        if ('serviceWorker' in navigator && 'Notification' in window) {
            // Request notification permission
            async function requestNotificationPermission() {
                try {
                    const permission = await Notification.requestPermission();
                    if (permission === 'granted') {
                        console.log('Notification permission granted');
                        initializeMessaging();
                    } else {
                        console.log('Notification permission denied');
                    }
                } catch (error) {
                    console.error('Error requesting notification permission:', error);
                }
            }

            // Initialize Firebase Messaging
            async function initializeMessaging() {
                try {
                    // Register service worker
                    const registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');
                    console.log('Service Worker registered:', registration);

                    // Wait for service worker to be activated and ready
                    if (registration.installing) {
                        await new Promise((resolve) => {
                            registration.installing.addEventListener('statechange', function() {
                                if (this.state === 'activated') {
                                    resolve();
                                }
                            });
                        });
                    } else if (registration.waiting) {
                        await new Promise((resolve) => {
                            registration.waiting.addEventListener('statechange', function() {
                                if (this.state === 'activated') {
                                    resolve();
                                }
                            });
                        });
                    }

                    // Ensure service worker is active and has pushManager
                    if (!registration.active || !registration.pushManager) {
                        console.warn('Service worker not fully ready, waiting...');
                        await new Promise(resolve => setTimeout(resolve, 1000));
                    }

                    // Initialize messaging
                    messaging = getMessaging(app);

                    // Get FCM token with VAPID key
                    const vapidKey = '{{ config('services.firebase.vapid_key') }}';
                    const token = await getToken(messaging, {
                        vapidKey: vapidKey,
                        serviceWorkerRegistration: registration
                    });

                    if (token) {
                        console.log('FCM Token:', token);
                        sendTokenToServer(token);
                    } else {
                        console.log('No registration token available.');
                    }

                    // Handle foreground messages
                    onMessage(messaging, (payload) => {
                        console.log('Message received in foreground:', payload);
                        showNotification(payload);
                    });
                } catch (error) {
                    console.error('Error initializing messaging:', error);
                    // Log more details for debugging
                    if (error.code) {
                        console.error('Error code:', error.code);
                    }
                    if (error.message) {
                        console.error('Error message:', error.message);
                    }
                }
            }

            // Send token to server
            async function sendTokenToServer(token) {
                try {
                    const userAgent = navigator.userAgent;
                    const browser = getBrowserName(userAgent);
                    const platform = navigator.platform;
                    const device = /Mobile|Android|iPhone|iPad/.test(userAgent) ? 'Mobile' : 'Desktop';

                    const formData = new FormData();
                    formData.append('token', token);
                    formData.append('browser', browser);
                    formData.append('device', device);
                    formData.append('platform', platform);
                    formData.append('_token', '{{ csrf_token() }}');

                    const response = await fetch('{{ route('notifications.storeToken') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const result = await response.json();
                    if (response.ok) {
                        console.log('Token stored successfully:', result);
                    } else {
                        console.error('Error storing token:', result);
                    }
                } catch (error) {
                    console.error('Error storing token:', error);
                }
            }

            // Show notification when app is in foreground
            function showNotification(payload) {
                const title = payload.notification?.title || 'New Notification';
                const options = {
                    body: payload.notification?.body || '',
                    icon: payload.notification?.icon || '{{ asset('frontend/images/icons/favicon.png') }}',
                    badge: '{{ asset('frontend/images/icons/favicon.png') }}',
                    tag: payload.data?.product_id || 'notification',
                    data: payload.data || {},
                };

                if ('Notification' in window && Notification.permission === 'granted') {
                    const notification = new Notification(title, options);

                    notification.onclick = function(event) {
                        event.preventDefault();
                        const url = payload.data?.url || payload.data?.click_action || '/';
                        window.open(url, '_blank');
                        notification.close();
                    };
                }
            }

            // Get browser name from user agent
            function getBrowserName(userAgent) {
                if (userAgent.indexOf('Chrome') > -1) return 'Chrome';
                if (userAgent.indexOf('Firefox') > -1) return 'Firefox';
                if (userAgent.indexOf('Safari') > -1) return 'Safari';
                if (userAgent.indexOf('Edge') > -1) return 'Edge';
                if (userAgent.indexOf('Opera') > -1) return 'Opera';
                return 'Unknown';
            }

            // Check current permission status
            if (Notification.permission === 'default') {
                // Request permission after a short delay to avoid blocking page load
                setTimeout(() => {
                    requestNotificationPermission();
                }, 2000);
            } else if (Notification.permission === 'granted') {
                // Already granted, initialize messaging
                initializeMessaging();
            }
        } else {
            console.log('This browser does not support notifications or service workers');
        }
    </script>

    <!-- Service Worker for Image Caching -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('Image Cache Service Worker registered successfully:', registration.scope);
                    })
                    .catch(error => {
                        console.log('Image Cache Service Worker registration failed:', error);
                    });
            });
        }
    </script>
</body>

</html>
