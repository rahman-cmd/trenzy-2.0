<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    @if (url()->current() == route('front.index'))
        <title>@yield('hometitle')</title>
    @else
        <title>{{ $setting->title }} -@yield('title')</title>
    @endif

    <!-- SEO Meta Tags-->
    @yield('meta')
    <meta name="author" content="{{ $setting->title }}">
    <meta name="distribution" content="web">
    <!-- Mobile Specific Meta Tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Favicon Icons-->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/' . $setting->favicon) }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/' . $setting->favicon) }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/images/' . $setting->favicon) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/' . $setting->favicon) }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('assets/images/' . $setting->favicon) }}">
    <!-- Vendor Styles including: Bootstrap, Font Icons, Plugins, etc.-->
    <link rel="stylesheet" media="screen" href="{{ asset('assets/front/css/plugins.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    @yield('styleplugins')

    <link id="mainStyles" rel="stylesheet" media="screen" href="{{ asset('assets/front/css/styles.min.css') }}">

    <link id="mainStyles" rel="stylesheet" media="screen" href="{{ asset('assets/front/css/responsive.css') }}">
    <!-- Color css -->
    <link
        href="{{ asset('assets/front/css/color.php?primary_color=') . str_replace('#', '', $setting->primary_color) }}"
        rel="stylesheet">

    <!-- Modernizr-->
    <script src="{{ asset('assets/front/js/modernizr.min.js') }}"></script>

    @if (DB::table('languages')->where('is_default', 1)->first()->rtl == 1)
        <link rel="stylesheet" href="{{ asset('assets/front/css/rtl.css') }}">
    @endif
    <style>
        {{ $setting->custom_css }}
    </style>
    {{-- Google AdSense Start --}}
    @if ($setting->is_google_adsense == '1')
        {!! $setting->google_adsense !!}
    @endif
    {{-- Google AdSense End --}}

    {{-- Google AnalyTics Start --}}
    @if ($setting->is_google_analytics == '1')
        {!! $setting->google_analytics !!}
    @endif
    {{-- Google AnalyTics End --}}

    {{-- Facebook pixel  Start --}}
    @if ($setting->is_facebook_pixel == '1')
        {!! $setting->facebook_pixel !!}
    @endif
    {{-- Facebook pixel End --}}

</head>
<!-- Body-->

<body
    class="
@if ($setting->theme == 'theme1') body_theme1
@elseif($setting->theme == 'theme2')
body_theme2
@elseif($setting->theme == 'theme3')
body_theme3
@elseif($setting->theme == 'theme4')
body_theme4 @endif
">
    {{-- @if ($setting->is_loader == 1) --}}
    <!-- Preloader Start -->
    @if ($setting->is_loader == 1)
        <div id="preloader">
            <img src="{{ asset('assets/images/' . $setting->loader) }}" alt="{{ __('Loading...') }}">
        </div>
    @endif

    <!-- Preloader endif -->
    {{-- @endif --}}

    <!-- Header-->
    <header class="site-header navbar-sticky">
        <div class="menu-top-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="t-m-s-a">
                            <a class="track-order-link" href="{{ route('front.order.track') }}"><i
                                    class="icon-map-pin"></i>{{ __('Track Order') }}</a>
                            <a class="track-order-link compare-mobile d-lg-none"
                                href="{{ route('fornt.compare.index') }}">{{ __('Compare') }}</a>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="right-area">

                            <a class="track-order-link wishlist-mobile d-inline-block d-lg-none"
                                href="{{ route('user.wishlist.index') }}"><i
                                    class="icon-heart"></i>{{ __('Wishlist') }}</a>

                            <div class="t-h-dropdown ">
                                <a class="main-link" href="#">{{ __('Currency') }}<i
                                        class="icon-chevron-down"></i></a>
                                <div class="t-h-dropdown-menu">
                                    @foreach (DB::table('currencies')->get() as $currency)
                                        <a class="{{ Session::get('currency') == $currency->id ? 'active' : ($currency->is_default == 1 && !Session::has('currency') ? 'active' : '') }}"
                                            href="{{ route('front.currency.setup', $currency->id) }}"><i
                                                class="icon-chevron-right pr-2"></i>{{ $currency->name }}</a>
                                    @endforeach
                                </div>
                            </div>

                            <div class="login-register ">
                                @if (!Auth::user())
                                    <a class="track-order-link mr-0" href="{{ route('user.login') }}">
                                        {{ __('Login/Register') }}
                                    </a>
                                @else
                                    <div class="t-h-dropdown">
                                        <div class="main-link">
                                            <i class="icon-user pr-2"></i> <span
                                                class="text-label">{{ Auth::user()->first_name }}</span>
                                        </div>
                                        <div class="t-h-dropdown-menu">
                                            <a href="{{ route('user.dashboard') }}"><i
                                                    class="icon-chevron-right pr-2"></i>{{ __('Dashboard') }}</a>
                                            <a href="{{ route('user.logout') }}"><i
                                                    class="icon-chevron-right pr-2"></i>{{ __('Logout') }}</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topbar-->
        <div class="topbar">
            <div class="container-fluid">
                <div class="row pt-3 pb-3 align-items-center">
                    <!-- Categories Section -->
                    <div class="col-lg-3 col-4">
                        @include('includes.categories')
                    </div>

                    <!-- Logo Section -->
                    <div class="col-lg-6 col-4 text-center">
                        <a class="site-logo" href="{{ route('front.index') }}">
                            <img class="img-fluid" src="{{ asset('assets/images/' . $setting->logo) }}"
                                alt="{{ $setting->title }}" style="max-height: 50px;">
                        </a>
                    </div>

                    <!-- Toolbar Section -->
                    <div class="col-lg-3 col-4 text-end">
                        <div class="toolbar d-flex justify-content-end align-items-center gap-3">
                            <!-- Mobile Search Icon -->
                            <a href="#" class="text-dark d-lg-none">
                                <i class="icon-search fs-4 d-none"></i>
                            </a>

                            <!-- Mobile Menu Toggle -->
                            <a href="#" class="text-dark d-lg-none">
                                <i class="icon-menu fs-4 d-none"></i>
                            </a>

                            <!-- Compare Icon -->
                            {{-- <a href="{{ route('fornt.compare.index') }}" class="text-dark position-relative">
                                <i class="icon-repeat fs-4 d-lg-block d-none"></i>
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-circle d-lg-block  d-none">
                                    {{ Session::has('compare') ? count(Session::get('compare')) : '0' }}
                                </span>
                            </a> --}}

                            <!-- User Icon -->
                            @if (!Auth::user())
                                <a href="{{ route('user.login') }}" class="text-dark">
                                    <i class="icon-user fs-4"></i>
                                </a>
                            @else
                                <div class="dropdown">
                                    <a href="#" class="text-dark dropdown-toggle" id="userDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-user fs-4"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                                <i class="icon-chevron-right"></i> {{ __('Dashboard') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('user.logout') }}">
                                                <i class="icon-chevron-right"></i> {{ __('Logout') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            @endif



                            <!-- Search Icon -->
                            <a href="#" id="toggle-search" class="text-dark" data-bs-toggle="modal"
                                data-bs-target="#searchModal">
                                <i class="icon-search fs-4"></i>
                            </a>






                            <!-- Wishlist Icon -->
                            @if (Auth::check())
                                <a href="{{ route('user.wishlist.index') }}"
                                    class="text-dark position-relative d-lg-block d-none">
                                    <i class="icon-heart fs-4"></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-circle d-lg-block d-none">
                                        {{ Auth::user()->wishlists->count() }}
                                    </span>
                                </a>
                            @else
                                <a href="{{ route('user.wishlist.index') }}" class="text-dark d-lg-block d-none">
                                    <i class="icon-heart fs-4 "></i>
                                </a>
                            @endif

                            <!-- Cart Icon -->
                            <a href="{{ route('front.cart') }}" class="text-dark position-relative">
                                <i class="icon-shopping-cart fs-4"></i>
                                <span id="cart-count"
                                    class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-circle">
                                    {{ Session::has('cart') ? count(Session::get('cart')) : '0' }}
                                </span>
                            </a>


                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Section -->
            <div class="mobile-menu d-lg-none">
                <div class="mm-heading-area bg-dark text-white p-2">
                    <h4>{{ __('Navigation') }}</h4>
                    <a href="#" class="text-white">
                        <i class="icon-x"></i>
                    </a>
                </div>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <span class="nav-link active" id="mmenu-tab" data-bs-toggle="tab" data-bs-target="#mmenu"
                            role="tab" aria-controls="mmenu" aria-selected="true">
                            {{ __('Menu') }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link" id="mcat-tab" data-bs-toggle="tab" data-bs-target="#mcat"
                            role="tab" aria-controls="mcat" aria-selected="false">
                            {{ __('Category') }}
                        </span>
                    </li>
                </ul>
                <div class="tab-content p-2">
                    <div class="tab-pane fade show active" id="mmenu" role="tabpanel"
                        aria-labelledby="mmenu-tab">
                        <nav class="slideable-menu">
                            <ul class="list-unstyled">
                                <li class="{{ request()->routeIs('front.index') ? 'active' : '' }}">
                                    <a href="{{ route('front.index') }}">
                                        <i class="icon-chevron-right"></i> {{ __('Home') }}
                                    </a>
                                </li>
                                @if ($setting->is_shop == 1)
                                    <li class="{{ request()->routeIs('front.catalog*') ? 'active' : '' }}">
                                        <a href="{{ route('front.catalog') }}">
                                            <i class="icon-chevron-right"></i> {{ __('Shop') }}
                                        </a>
                                    </li>
                                @endif
                                @if ($setting->is_campaign == 1)
                                    <li class="{{ request()->routeIs('front.campaign') ? 'active' : '' }}">
                                        <a href="{{ route('front.campaign') }}">
                                            <i class="icon-chevron-right"></i> {{ __('Campaign') }}
                                        </a>
                                    </li>
                                @endif
                                @if ($setting->is_brands == 1)
                                    <li class="{{ request()->routeIs('front.brand') ? 'active' : '' }}">
                                        <a href="{{ route('front.brand') }}">
                                            <i class="icon-chevron-right"></i> {{ __('Brand') }}
                                        </a>
                                    </li>
                                @endif
                                @if ($setting->is_blog == 1)
                                    <li class="{{ request()->routeIs('front.blog*') ? 'active' : '' }}">
                                        <a href="{{ route('front.blog') }}">
                                            <i class="icon-chevron-right"></i> {{ __('Blog') }}
                                        </a>
                                    </li>
                                @endif
                                <li class="t-h-dropdown">
                                    <a href="#" class="d-flex justify-content-between">
                                        <span><i class="icon-chevron-right"></i> {{ __('Pages') }}</span>
                                        <i class="icon-chevron-down"></i>
                                    </a>
                                    <div class="t-h-dropdown-menu">
                                        @if ($setting->is_faq == 1)
                                            <a class="{{ request()->routeIs('front.faq*') ? 'active' : '' }}"
                                                href="{{ route('front.faq') }}">
                                                <i class="icon-chevron-right pr-2"></i> {{ __('Faq') }}
                                            </a>
                                        @endif
                                        @foreach (DB::table('pages')->wherePos(0)->orwhere('pos', 2)->get() as $page)
                                            <a class="{{ request()->url() == route('front.page', $page->slug) ? 'active' : '' }}"
                                                href="{{ route('front.page', $page->slug) }}">
                                                <i class="icon-chevron-right pr-2"></i> {{ $page->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                </li>
                                @if ($setting->is_contact == 1)
                                    <li class="{{ request()->routeIs('front.contact') ? 'active' : '' }}">
                                        <a href="{{ route('front.contact') }}">
                                            <i class="icon-chevron-right"></i> {{ __('Contact') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    <div class="tab-pane fade" id="mcat" role="tabpanel" aria-labelledby="mcat-tab">
                        <nav class="slideable-menu">
                            @include('includes.mobile-category')
                        </nav>
                    </div>
                </div>
            </div>
        </div>





    </header>

    <!-- Full-Screen Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">{{ __('Search') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="container">
                        <div class="row justify-content-center">
                            <!-- Search Box Wrapper -->
                            <div class="col-12 col-md-8">
                                <form class="input-group" id="header_search_form"
                                    action="{{ route('front.catalog') }}" method="get">
                                    <input type="hidden" name="category" value="" id="search__category">

                                    <!-- Search Button -->
                                    <span class="input-group-btn">
                                        <button type="submit"><i class="icon-search"></i></button>
                                    </span>

                                    <!-- Search Input -->
                                    <input class="form-control" type="text"
                                        data-target="{{ route('front.search.suggest') }}" id="__product__search"
                                        name="search" placeholder="{{ __('Search by product name') }}">

                                </form>

                                <div class="serch-result d-none mt-3">
                                    <!-- Results will populate here -->
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content-->
    @yield('content')

    <!--    announcement banner section start   -->
    <a class="announcement-banner" href="#announcement-modal"></a>
    <div id="announcement-modal" class="mfp-hide white-popup">
        @if ($setting->announcement_type == 'newletter')
            <div class="announcement-with-content">
                <div class="left-area">
                    <img src="{{ asset('assets/images/' . $setting->announcement) }}" alt="">
                </div>
                <div class="right-area">
                    <h3 class="">{{ $setting->announcement_title }}</h3>
                    <p>{{ $setting->announcement_details }}</p>
                    <form class="subscriber-form" action="{{ route('front.subscriber.submit') }}" method="post">
                        @csrf
                        <div class="input-group">
                            <input class="form-control" type="email" name="email"
                                placeholder="{{ __('Your e-mail') }}">
                            <span class="input-group-addon"><i class="icon-mail"></i></span>
                        </div>
                        <div aria-hidden="true">
                            <input type="hidden" name="b_c7103e2c981361a6639545bd5_1194bb7544" tabindex="-1">
                        </div>

                        <button class="btn btn-primary btn-block mt-2" type="submit">
                            <span>{{ __('Subscribe') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ $setting->announcement_link }}">
                <img src="{{ asset('assets/images/' . $setting->announcement) }}" alt="">
            </a>
        @endif


    </div>
    <!--    announcement banner section end   -->

    <!-- Site Footer-->
    <footer class="site-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <!-- Contact Info-->
                    <section class="widget widget-light-skin">
                        <h3 class="widget-title">{{ __('Get In Touch') }}</h3>
                        <p class="mb-1"><strong>{{ __('Address') }}: </strong> {{ $setting->footer_address }}</p>
                        <p class="mb-1"><strong>{{ __('Phone') }}: </strong> {{ $setting->footer_phone }}</p>
                        <p class="mb-3"><strong>{{ __('Email') }}: </strong> {{ $setting->footer_email }}</p>
                        {{-- <ul class="list-unstyled text-sm">
                            <li><span class=""><strong>{{ __('Monday-Friday') }}:
                                    </strong></span>{{ $setting->friday_start }} - {{ $setting->friday_end }}</li>
                            <li><span class=""><strong>{{ __('Saturday') }}:
                                    </strong></span>{{ $setting->satureday_start }} - {{ $setting->satureday_end }}
                            </li>
                        </ul> --}}
                        @php
                            $links = json_decode($setting->social_link, true)['links'];
                            $icons = json_decode($setting->social_link, true)['icons'];

                        @endphp
                        <div class="d-flex gap-2 mt-3">
                            @foreach ($links as $link_key => $link)
                                <a href="{{ $link }}"
                                    class=" d-flex align-items-center justify-content-center text-black"
                                    style="width: 45px; height: 45px; text-decoration: none;">
                                    <i class="{{ $icons[$link_key] }} "style="font-size: 27px;"></i>
                                </a>
                            @endforeach
                        </div>

                    </section>

                </div>
                <div class="col-lg-4 col-sm-6">
                    <!-- Customer Info-->
                    <div class="widget widget-links widget-light-skin">
                        <h3 class="widget-title">{{ __('Usefull Links') }}</h3>
                        <ul>
                            @if ($setting->is_faq == 1)
                                <li>
                                    <a class="" href="{{ route('front.faq') }}">{{ __('Faq') }}</a>
                                </li>
                            @endif
                            @foreach (DB::table('pages')->wherePos(2)->orwhere('pos', 1)->get() as $page)
                                <li><a href="{{ route('front.page', $page->slug) }}">{{ $page->title }}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Subscription-->
                    <section class="widget">
                        <h3 class="widget-title">{{ __('Newsletter') }}</h3>
                        <form class="row subscriber-form" action="{{ route('front.subscriber.submit') }}"
                            method="post">
                            @csrf
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <input class="form-control" type="email" name="email"
                                        placeholder="{{ __('Your e-mail') }}">
                                    <span class="input-group-addon"><i class="icon-mail"></i></span>
                                </div>
                                <div aria-hidden="true">
                                    <input type="hidden" name="b_c7103e2c981361a6639545bd5_1194bb7544"
                                        tabindex="-1">
                                </div>

                            </div>

                            <div class="col-sm-12">
                                <button class="btn btn-primary btn-block mt-2" type="submit">
                                    <span>{{ __('Subscribe') }}</span>
                                </button>
                            </div>
                            <div class="col-lg-12">
                                <p class="text-sm opacity-80 pt-2">
                                    {{ __('Subscribe to our Newsletter to receive early discount offers, latest news, sales and promo information.') }}
                                </p>
                            </div>
                        </form>
                        {{-- <div class="pt-3"><img class="d-block gateway_image"
                                src="{{ $setting->footer_gateway_img ? asset('assets/images/' . $setting->footer_gateway_img) : asset('system/resources/assets/images/placeholder.png') }}">
                        </div> --}}
                    </section>
                </div>
            </div>
            <!-- Copyright-->
            <p class="footer-copyright"> {{ $setting->copy_right }}</p>

            {{-- Made in Bangladesh, for the World 🌍 --}}
            <p class="text-center">Made in Bangladesh, for the World 🌍</p>
        </div>
    </footer>

    <!-- Back To Top Button-->
    <a class="scroll-to-top-btn" href="#">
        <i class="icon-chevron-up"></i>
    </a>
    <!-- Backdrop-->
    <div class="site-backdrop"></div>

    <!-- Cookie alert dialog  -->
    @if ($setting->is_cookie == 1)
        @include('cookie-consent::index')
    @endif
    <!-- Cookie alert dialog  -->


    @php
        $mainbs = [];
        $mainbs['is_announcement'] = $setting->is_announcement;
        $mainbs['announcement_delay'] = $setting->announcement_delay;
        $mainbs['overlay'] = $setting->overlay;
        $mainbs = json_encode($mainbs);
    @endphp

    <script>
        var mainbs = {!! $mainbs !!};
        var decimal_separator = '{!! $setting->decimal_separator !!}';
        var thousand_separator = '{!! $setting->thousand_separator !!}';
    </script>

    <script>
        let language = {
            Days: '{{ __('Days') }}',
            Hrs: '{{ __('Hrs') }}',
            Min: '{{ __('Min') }}',
            Sec: '{{ __('Sec') }}',
        }
    </script>



    <!-- JavaScript (jQuery) libraries, plugins and custom scripts-->
    <script type="text/javascript" src="{{ asset('assets/front/js/plugins.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/back/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('assets/front/js/scripts.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/front/js/lazy.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/front/js/lazy.plugin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/front/js/myscript.js') }}"></script>
    @yield('script')

    @if ($setting->is_facebook_messenger == '1')
        <!-- Messenger Chat Plugin Code -->
        <div id="fb-root"></div>

        <!-- Your Chat Plugin code -->
        <div id="fb-customer-chat" class="fb-customerchat">
        </div>

        <script>
            var chatbox = document.getElementById('fb-customer-chat');
            chatbox.setAttribute("page_id", "{{ $setting->facebook_messenger }}");
            chatbox.setAttribute("attribution", "biz_inbox");
            window.fbAsyncInit = function() {
                FB.init({
                    xfbml: true,
                    version: 'v11.0'
                });
            };

            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
    @endif



    <script type="text/javascript">
        let mainurl = '{{ route('front.index') }}';

        let view_extra_index = 0;
        // Notifications
        function SuccessNotification(title) {
            $.notify({
                title: ` <strong>${title}</strong>`,
                message: '',
                icon: 'fas fa-check-circle'
            }, {
                element: 'body',
                position: null,
                type: "success",
                allow_dismiss: true,
                newest_on_top: false,
                showProgressbar: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 5000,
                timer: 1000,
                url_target: '_blank',
                mouse_over: null,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class'
            });
        }

        function DangerNotification(title) {
            $.notify({
                // options
                title: ` <strong>${title}</strong>`,
                message: '',
                icon: 'fas fa-exclamation-triangle'
            }, {
                // settings
                element: 'body',
                position: null,
                type: "danger",
                allow_dismiss: true,
                newest_on_top: false,
                showProgressbar: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 5000,
                timer: 1000,
                url_target: '_blank',
                mouse_over: null,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class'
            });
        }
        // Notifications Ends
    </script>

    @if (Session::has('error'))
        <script>
            $(document).ready(function() {
                DangerNotification('{{ Session::get('error') }}')
            })
        </script>
    @endif
    @if (Session::has('success'))
        <script>
            $(document).ready(function() {
                SuccessNotification('{{ Session::get('success') }}');
            })
        </script>
    @endif

</body>

</html>
