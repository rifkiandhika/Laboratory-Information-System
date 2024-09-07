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
      href="https://demos.pixinvent.com/vuexy-html-admin-template/assets/img/favicon/favicon.ico"
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

  <body>
    <div class="authentication-wrapper authentication-cover">
      <!-- Logo -->
      {{-- <a href="index-2.html" class="app-brand auth-cover-brand">
        <img src="{{ asset('image/logo-rs.png') }}" width="75px" alt="">
        <span class="app-brand-text demo text-heading text-white fw-bold">Laboratory Information System Management</span>
      </a> --}}
      <!-- /Logo -->
      <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-8 p-0 bg-primary">
          <img style="filter: blur(2px);"
              src="{{ asset('image/national-cancer-institute-oCLuFi9GYNA-unsplash.jpg') }}" width="1025px"
              alt="auth-login-cover"
            />
          <div
            class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center"
          >
            
          </div>
        </div>

        <div
          class="d-flex col-12 col-lg-4 align-items-center authentication-bg p-sm-12 p-6 shadow-lg"
        >
          <div class="w-px-400 mx-auto mt-12 pt-5">
            <h4 class="mb-1">Welcome to Laboratory Information System Management! 👋</h4>
            <p class="mb-6">
              Please sign-in to your account...
            </p>

            <form class="forms_form" action="{{ route('login.proses') }}" method="POST">
                @csrf
              <div class="mb-6">
                <label for="email" class="form-label">Email or Username</label>
                <input
                  type="text"
                  class="form-control"
                  name="username"
                  placeholder="Enter username"
                  autofocus
                />
              </div>
              <div class="mb-6 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password"
                  />
                  <span class="input-group-text cursor-pointer"
                    ><i class="ti ti-eye-off"></i
                  ></span>
                </div>
              </div>
              <div class="my-8">
                <div class="d-flex justify-content-between">
                  <div class="form-check mb-0 ms-2">
                    {{-- <input
                      class="form-check-input"
                      type="checkbox"
                      id="remember-me"
                    />
                    <label class="form-check-label" for="remember-me">
                      Remember Me
                    </label> --}}
                  </div>
                  <a href="auth-forgot-password-cover.html">
                    <p class="mb-0">Forgot Password?</p>
                  </a>
                </div>
              </div>
              <button type="submit" class="btn btn-primary d-grid w-100">Sign in</button>
            </form>
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('/assets/vendor/libs/jquery/jquery.js') }}"></script>
    {{-- <script src="{{ asset('/assets/vendor/libs/popper/popper.js') }}"></script> --}}
    <script src="{{ asset('/assets/vendor/js/bootstrap.js') }}"></script>
    {{-- <script src="{{ asset('/assets/vendor/libs/node-waves/node-waves.js') }}"></script> --}}
    {{-- <script src="{{ asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script> --}}
    {{-- <script src="{{ asset('/assets/vendor/libs/hammer/hammer.js') }}"></script> --}}
    <script src="{{ asset('/assets/vendor/libs/i18n/i18n.js') }}"></script>
    {{-- <script src="{{ asset('/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script> --}}
    <script src="{{ asset('/assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    {{-- <script src="{{ asset('/assets/vendor/libs/%40form-validation/popular.js') }}"></script> --}}
    <script src="{{ asset('/assets/vendor/libs/%40form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/%40form-validation/auto-focus.js') }}"></script>

    <!-- Main JS -->
    {{-- <script src="{{ asset('/assets/js/main.js') }}"></script> --}}

    <!-- Page JS -->
    <script src="{{ asset('/assets/js/pages-auth.js') }}"></script>
  </body>

  <!-- Mirrored from demos.pixinvent.com/vuexy-html-admin-template/html/vertical-menu-template/auth-login-cover.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Aug 2024 08:47:50 GMT -->
</html>

<!-- beautify ignore:end -->
