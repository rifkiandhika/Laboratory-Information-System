<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed " dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template" data-style="light">

  
<!-- Mirrored from demos.pixinvent.com/vuexy-html-admin-template/html/vertical-menu-template/layouts-collapsed-menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Aug 2024 08:42:13 GMT -->
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title')</title>

    
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 5" />
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
    <!-- Canonical SEO -->
    {{-- <link rel="canonical" href="https://1.envato.market/vuexy_admin"> --}}
    
    
    <!-- ? PROD Only: Google Tag Manager (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
    {{-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      '../../../../www.googletagmanager.com/gtm5445.html?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-5J3LMKC');</script> --}}
    <!-- End Google Tag Manager -->
    
    <!-- Favicon -->
    {{-- <link rel="icon" type="image/x-icon" href="https://demos.pixinvent.com/vuexy-html-admin-template/assets/img/favicon/favicon.ico" /> --}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;ampdisplay=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/tabler-icons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/flag-icons.css') }}" />

      {{-- Sweet alert --}}
      <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">


    <!-- Core CSS -->
    
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    
    <link rel="stylesheet" href="{{ asset('/assets/css/demo.css') }}" />
    
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/node-waves/node-waves.css') }}" />
    
    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/typeahead-js/typeahead.css') }}" /> 
    <link rel="stylesheet" href="{{ asset('vendor/select2/select2.min.css') }}">

    

    <!-- Page CSS -->
    {{-- Vendor JS --}}
    <script src="{{ asset('/assets/vendor/js/helpers.js') }}"></script>
    {{-- Config JS --}}
    <script src="{{ asset('/assets/js/config.js') }}"></script>
    

    <!-- Helpers -->
    
  </head>

  <body>

    <!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar  ">
  <div class="layout-container">
    <!-- Menu -->
    <div id="app">
      @include('layouts.sidebar')
      <div class="layout-page">
          @include('layouts.header')
              @yield('content')
      </div>
          @include('layouts.footer')
    </div>

  </div>
</div>
          <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    
    <script src="{{ asset('/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <!-- endbuild -->
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>

    @include('sweetalert::alert')


    <!-- Vendors JS -->
    
    

    <!-- Main JS -->
    <script src="{{ asset('/assets/js/main.js') }}"></script>
    
    
  <script src="{{ asset('../js/ak.js') }}"></script>
  @stack('script')
  </body>


<!-- Mirrored from demos.pixinvent.com/vuexy-html-admin-template/html/vertical-menu-template/layouts-collapsed-menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Aug 2024 08:42:18 GMT -->
</html>

<!-- beautify ignore:end -->

