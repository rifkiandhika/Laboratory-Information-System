<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets/') }}"
  data-template="vertical-menu-template"
  data-style="light"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Login</title>

    <!-- Favicon -->
    <link
      rel="icon"
      type="image/x-icon"
      href="{{ asset('image/icon.png') }}"
    />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;ampdisplay=swap"
      rel="stylesheet"
    />

    <!-- Icons -->
    {{-- <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" /> --}}
    <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/tabler-icons.css') }}" />
    {{-- <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" /> --}}

    <!-- Core CSS -->

    <link
      rel="stylesheet"
      href="{{ asset('/assets/vendor/css/rtl/core.css') }}"
      class="template-customizer-core-css"
    />
    <link
      rel="stylesheet"
      href="{{ asset('/assets/vendor/css/rtl/theme-default.css') }}"
      class="template-customizer-theme-css"
    />

    <link rel="stylesheet" href="{{ asset('/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    {{-- <link
      rel="stylesheet"
      href="{{ asset('/assets/vendor/libs/node-waves/node-waves.css') }}"
    /> --}}

    {{-- <link
      rel="stylesheet"
      href="{{ asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"
    /> --}}
    {{-- <link
      rel="stylesheet"
      href="{{ asset('/assets/vendor/libs/typeahead-js/typeahead.css') }}"
    /> --}}
    <!-- Vendor -->
    {{-- <link
      rel="stylesheet"
      href="{{ asset('/assets/vendor/libs/%40form-validation/form-validation.css') }}"
    /> --}}

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    {{-- <script src="{{ asset('/assets/vendor/js/helpers.js') }}"></script> --}}
    <script src="{{ asset('/assets/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ asset('/assets/js/config.js') }}"></script>
  </head>

  <body style="--bs-scrollbar-width: 15px;">
    
      
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5J3LMKC" height="0" width="0" style="display: none; visibility: hidden"></iframe></noscript>
      
    
    <!-- Content -->
  
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-6">
        <!-- Login -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <img src="{{ asset('image/erecord.png') }}" class="w-25" alt="">
            </div>
            <!-- /Logo -->
            <h5 class="mb-1">Welcome to Laboratory Information System Management! 👋</h5>
            <p class="mb-6">Please sign-in to your account...</p>

            <form id="formAuthentication" class="mb-4 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('login.proses') }}" method="POST" novalidate="novalidate">
              @csrf
              <div class="mb-6 form-control-validation fv-plugins-icon-container">
                <label for="email" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autofocus="">
              <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
              <div class="mb-6 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="••••••••••"
                      aria-describedby="password"
                    />
                    <span id="togglePassword" class="input-group-text cursor-pointer">
                      <i class="ti ti-eye-off"></i>
                    </span>
                  </div>
                </div>
              <div class="mb-6">
                <button class="btn btn-primary d-grid w-100 waves-effect waves-light" type="submit">Login</button>
              </div>
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>
  </div>
      </body>

  <!-- Mirrored from demos.pixinvent.com/vuexy-html-admin-template/html/vertical-menu-template/auth-login-cover.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Aug 2024 08:47:50 GMT -->
</html>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");
    const toggleIcon = document.getElementById("toggleIcon");

    togglePassword.addEventListener("click", function () {
      const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);

      // Ganti icon jika ingin (opsional)
      if (type === "text") {
        toggleIcon.classList.remove("ti-eye-off");
        toggleIcon.classList.add("ti-eye");
      } else {
        toggleIcon.classList.remove("ti-eye");
        toggleIcon.classList.add("ti-eye-off");
      }
    });
  });
</script>


<!-- beautify ignore:end -->
