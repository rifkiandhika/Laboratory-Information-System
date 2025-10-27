<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
  data-assets-path="{{ asset('assets/') }}" data-template="vertical-menu-template" data-style="light">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('image/icon.png') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com/" />
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap"
    rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/tabler-icons.css') }}" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('/assets/vendor/css/rtl/core.css') }}" />
  <link rel="stylesheet" href="{{ asset('/assets/vendor/css/rtl/theme-default.css') }}" />
  <link rel="stylesheet" href="{{ asset('/assets/css/demo.css') }}" />
  <link rel="stylesheet" href="{{ asset('/assets/vendor/css/pages/page-auth.css') }}" />

  <script src="{{ asset('/assets/vendor/js/template-customizer.js') }}"></script>
  <script src="{{ asset('/assets/js/config.js') }}"></script>

  <style>
    .gps-status-box {
      transition: all 0.3s ease;
      margin-bottom: 1rem;
    }

    .gps-loading {
      animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse {
      0%, 100% {
        opacity: 1;
      }

      50% {
        opacity: .5;
      }
    }

    .gps-success {
      background: #d4edda;
      border: 1px solid #c3e6cb;
      color: #155724;
    }

    .gps-error {
      background: #f8d7da;
      border: 1px solid #f5c6cb;
      color: #721c24;
    }

    .gps-warning {
      background: #fff3cd;
      border: 1px solid #ffeeba;
      color: #856404;
    }

    .spinner-border-sm {
      width: 1rem;
      height: 1rem;
      border-width: 0.15em;
    }
  </style>
</head>

<body>
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-6">
        <div class="card">
          <div class="card-body">
            <div class="app-brand justify-content-center">
              <img src="{{ asset('image/erecord.png') }}" class="w-25" alt="">
            </div>

            <h5 class="mb-1">Welcome to Laboratory Information System Management! 👋</h5>
            <p class="mb-6">Please sign-in to your account...</p>

            <!-- GPS Status -->
            <div id="gpsStatusBox" class="gps-status-box" style="display: none;">
              <div id="gpsAlert" class="alert d-flex align-items-center" role="alert">
                <span id="gpsIcon" class="me-2"></span>
                <div class="flex-grow-1">
                  <strong id="gpsTitle"></strong>
                  <div id="gpsMessage" class="small"></div>
                </div>
              </div>
            </div>

            <form id="formAuthentication" class="mb-4" action="{{ route('login.proses') }}" method="POST">
              @csrf

              <input type="hidden" name="latitude" id="latitude">
              <input type="hidden" name="longitude" id="longitude">
              <input type="hidden" name="accuracy" id="accuracy">

              <div class="mb-6">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                  placeholder="Enter your username" autofocus>
              </div>

              <div class="mb-6 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password"
                    placeholder="••••••••••" />
                  <span id="togglePassword" class="input-group-text cursor-pointer">
                    <i id="toggleIcon" class="ti ti-eye-off"></i>
                  </span>
                </div>
              </div>

              <div class="mb-6">
                <button class="btn btn-primary d-grid w-100" type="submit" id="loginBtn" disabled>
                  <span id="loginBtnText">
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Menunggu GPS...
                  </span>
                </button>
              </div>

              <div class="text-center">
                <small class="text-muted">
                  <i class="ti ti-map-pin"></i> Pastikan GPS aktif dan izinkan akses lokasi
                </small>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    let userLocation = null;
    let locationVerified = false;

    document.addEventListener("DOMContentLoaded", function () {
      const togglePassword = document.getElementById("togglePassword");
      const passwordInput = document.getElementById("password");
      const toggleIcon = document.getElementById("toggleIcon");

      togglePassword.addEventListener("click", function () {
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);
        toggleIcon.classList.toggle("ti-eye-off");
        toggleIcon.classList.toggle("ti-eye");
      });

      checkGPSLocation();
    });

    function checkGPSLocation() {
      if (!navigator.geolocation) {
        showGPSStatus('error', 'Browser Tidak Support GPS', 'Gunakan browser modern seperti Chrome atau Firefox');
        return;
      }

      showGPSStatus('loading', 'Mengakses GPS...', 'Mohon izinkan akses lokasi pada browser Anda');

      const options = { enableHighAccuracy: true, timeout: 20000, maximumAge: 0 };
      navigator.geolocation.getCurrentPosition(onLocationSuccess, onLocationError, options);
    }

    function onLocationSuccess(position) {
      userLocation = {
        latitude: position.coords.latitude,
        longitude: position.coords.longitude,
        accuracy: position.coords.accuracy
      };

      document.getElementById('latitude').value = userLocation.latitude;
      document.getElementById('longitude').value = userLocation.longitude;
      document.getElementById('accuracy').value = userLocation.accuracy;

      verifyLocationWithServer();
    }

    function onLocationError(error) {
      let title = '', message = '';
      switch (error.code) {
        case error.PERMISSION_DENIED:
          title = 'Akses Lokasi Ditolak';
          message = 'Klik icon gembok di address bar, lalu izinkan akses lokasi.';
          break;
        case error.POSITION_UNAVAILABLE:
          title = 'Lokasi Tidak Tersedia';
          message = 'Pastikan GPS aktif di perangkat Anda.';
          break;
        case error.TIMEOUT:
          title = 'Request Timeout';
          message = 'Tidak dapat mendapatkan lokasi. Coba refresh halaman.';
          break;
        default:
          title = 'Error GPS';
          message = 'Terjadi kesalahan saat mendapatkan lokasi.';
      }
      showGPSStatus('error', title, message);
    }

    function verifyLocationWithServer() {
      showGPSStatus('loading', 'Memverifikasi Lokasi...', 'Mengecek jarak ke klinik...');
      fetch('{{ route("verifylocation") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(userLocation)
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            locationVerified = true;
            const distance = Math.round(data.data.distance);
            const clinicName = data.data.clinic_name || 'Klinik';
            showGPSStatus('success', 'Lokasi Valid ✓',
              `${clinicName} - Jarak: ${distance}m (Akurasi GPS: ±${Math.round(data.data.accuracy)}m)`);
            enableLoginButton();
          } else {
            locationVerified = false;
            showGPSStatus('error', 'Lokasi Tidak Valid ✗', data.message);
          }
        })
        .catch(() => {
          showGPSStatus('error', 'Gagal Verifikasi', 'Tidak dapat menghubungi server.');
        });
    }

    function enableLoginButton() {
      const btn = document.getElementById('loginBtn');
      const btnText = document.getElementById('loginBtnText');
      btn.disabled = false;
      btnText.innerHTML = '<i class="ti ti-login me-2"></i>Login';
    }

    function showGPSStatus(type, title, message) {
      const box = document.getElementById('gpsStatusBox');
      const alert = document.getElementById('gpsAlert');
      const icon = document.getElementById('gpsIcon');
      const titleEl = document.getElementById('gpsTitle');
      const messageEl = document.getElementById('gpsMessage');

      box.style.display = 'block';
      alert.className = 'alert d-flex align-items-center';

      if (type === 'loading') {
        alert.classList.add('gps-warning', 'gps-loading');
        icon.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
      } else if (type === 'success') {
        alert.classList.add('gps-success');
        icon.innerHTML = '<i class="ti ti-check fs-4"></i>';
      } else if (type === 'error') {
        alert.classList.add('gps-error');
        icon.innerHTML = '<i class="ti ti-x fs-4"></i>';
      }

      titleEl.textContent = title;
      messageEl.textContent = message;
    }

    document.getElementById('formAuthentication').addEventListener('submit', function (e) {
      if (!locationVerified) {
        e.preventDefault();
        alert('⚠️ Lokasi belum terverifikasi! Mohon tunggu hingga GPS selesai diverifikasi.');
        return false;
      }
    });
  </script>
</body>
</html>
