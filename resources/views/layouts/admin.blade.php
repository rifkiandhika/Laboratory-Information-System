<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets/') }}" data-template="vertical-menu-template" data-style="light">


<!-- Mirrored from demos.pixinvent.com/vuexy-html-admin-template/html/vertical-menu-template/layouts-collapsed-menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Aug 2024 08:42:13 GMT -->
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title')</title>
    <link
      rel="icon"
      type="image/x-icon"
      href="{{ asset('image/icon.png') }}"
    />


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;ampdisplay=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/tabler-icons.css') }}"/>

      {{-- Sweet alert --}}
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
    {{-- Data Table --}}
    <link rel="stylesheet" href="{{ asset('../css/datatable.min.css') }}">

    <!-- Core CSS -->

    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/select2/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    {{-- <link rel="stylesheet" href="{{ asset('bootstrap/css/sb-admin-2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'> --}}






    <!-- Page CSS -->
    {{-- Vendor JS --}}
    <script src="{{ asset('/assets/vendor/js/helpers.js') }}"></script>
    {{-- Config JS --}}
    <script src="{{ asset('/assets/js/config.js') }}"></script>
    <script src="{{ asset('/js/barcode.js') }}"></script>


    <!-- Helpers -->

  </head>

  <body>
  @include('sweetalert::alert')

  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo ">
              <a href="#" class="app-brand-link">
                <span class="app-brand-logo demo">
          <img src="{{ asset('image/erecord.png') }}" width="60px"  alt="">
          </span>
                <span class="app-brand-text demo menu-text fw-bold" style="font-size: 0.75rem; line-height: 1.3;">
                    Erecord Integrasi 
                    <br>
                    LIS
                </span>
              </a>

              <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
                <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
              </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                @include('layouts.sidebar')
            </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            @include('layouts.header')

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="flex-grow-1 container-p-y">
                    @yield('content')
                </div>
                <!-- / Content -->

                <!-- Footer -->
                {{-- @include('backend.layouts.footer') --}}
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
    <!-- Layout wrapper -->
{{-- <div class="layout-wrapper layout-content-navbar ">
  <div class="layout-container">
    <!-- Menu -->
    <div>
      @include('layouts.sidebar')
      <div class="layout-page">
          @include('layouts.header')
              @yield('content')
      </div>
          @include('layouts.footer')
    </div>
  </div>
</div> --}}
          <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    {{-- <script src="{{ asset('/assets/vendor/libs/jquery/jquery.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <!-- endbuild -->


    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    {{-- <script src="{{ asset('../js/dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/tables-datatables-advanced.js')}}"></script>

    {{-- <script>
    document.addEventListener('contextmenu', e => e.preventDefault());

    document.addEventListener('keydown', e => {
    if (e.key === 'F12') e.preventDefault();
    if (e.ctrlKey && e.shiftKey && ['I','J','C'].includes(e.key.toUpperCase())) e.preventDefault();
    if (e.ctrlKey && ['U','S'].includes(e.key.toUpperCase())) e.preventDefault();
    });

    setInterval(() => {
    if (window.outerWidth - window.innerWidth > 160 || window.outerHeight - window.innerHeight > 160) {
        alert('Developer Tools terdeteksi! Tutup dulu DevTools-nya.');
    }
    }, 1000);
    </script> --}}


    <script>
        $(document).ready(function() {
            $("#myTable").DataTable();

        })
    </script>

    <script>
        $(document).ready(function() {
            $("#qcTable").DataTable({
                paging:false,
                searching:false,
                info:false,
            });

        });
    </script>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

<script>
  function confirmVerify(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data akan dikirim kembali ke worklist?",
        icon: 'warning',
        input: 'textarea',
        inputPlaceholder: 'Tambahkan catatan di sini...',
        showCancelButton: true,
        confirmButtonText: 'Ya, Kirim!',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
          if (!value) {
                return 'Note wajib diisi!'; // Pesan kesalahan jika input kosong
            }
            return null;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            if (result.value) {
                let noteInput = document.createElement('input');
                noteInput.type = 'hidden';
                noteInput.name = 'note';
                noteInput.value = result.value;
                document.getElementById(`dokterForm-${id}`).appendChild(noteInput);
            }
            document.getElementById(`dokterForm-${id}`).submit();
        }
    });
}
</script>

<script>
  function confirmDokter(id) {
      Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Data akan diselesaikan!",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, selesaikan!',
          cancelButtonText: 'Batal'
      }).then((result) => {
          if (result.isConfirmed) {
              document.getElementById(`kirimForm-${id}`).submit();
          }
      });
  }
</script>
<script>
  function confirmDok(id) {
      Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Data akan dikirim ke dokter!",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, kirim!',
          cancelButtonText: 'Batal'
      }).then((result) => {
          if (result.isConfirmed) {
              document.getElementById(`kirimdok-${id}`).submit();
          }
      });
  }
</script>
<script>
  function confirmResult(id) {
      Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Data akan diselesaikan!",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, selesaikan!',
          cancelButtonText: 'Batal'
      }).then((result) => {
          if (result.isConfirmed) {
              document.getElementById(`kirimresult-` + id).submit();
          }
      });
  }
</script>
<script>
  function confirmDone(id) {
      Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Data akan diselesaikan!",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, kirim!',
          cancelButtonText: 'Batal'
      }).then((result) => {
          if (result.isConfirmed) {
              document.getElementById(`kirimdone-${id}`).submit();
          }
      });
  }
</script>
@if(session('swal'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: '{{ session('swal.title') }}',
        text: '{{ session('swal.text') }}',
        icon: '{{ session('swal.icon') }}',
        confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false
    });
});
</script>
@endif


    <!-- Vendors JS -->



    <!-- Main JS -->
    <script src="{{ asset('/assets/js/main.js') }}"></script>


  <script src="{{ asset('../js/ak.js') }}"></script>
  @stack('script')
  </body>


<!-- Mirrored from demos.pixinvent.com/vuexy-html-admin-template/html/vertical-menu-template/layouts-collapsed-menu.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Aug 2024 08:42:18 GMT -->
</html>

<!-- beautify ignore:end -->

