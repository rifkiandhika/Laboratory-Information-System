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

    .gps-info {
      background: #d1ecf1;
      border: 1px solid #bee5eb;
      color: #0c5460;
    }

    .spinner-border-sm {
      width: 1rem;
      height: 1rem;
      border-width: 0.15em;
    }

    .accuracy-badge {
      display: inline-block;
      padding: 0.25rem 0.5rem;
      border-radius: 0.25rem;
      font-size: 0.75rem;
      font-weight: 600;
      margin-left: 0.5rem;
    }

    .accuracy-excellent {
      background: #d4edda;
      color: #155724;
    }

    .accuracy-good {
      background: #d1ecf1;
      color: #0c5460;
    }

    .accuracy-fair {
      background: #fff3cd;
      color: #856404;
    }

    .accuracy-poor {
      background: #f8d7da;
      color: #721c24;
    }

    .retry-button {
      margin-top: 0.5rem;
      font-size: 0.875rem;
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
                  <button id="retryButton" class="btn btn-sm btn-outline-secondary retry-button" style="display: none;" onclick="retryGPS()">
                    <i class="ti ti-refresh me-1"></i>Coba Lagi
                  </button>
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
                  <i class="ti ti-map-pin"></i> Untuk akurasi terbaik, aktifkan GPS dan gunakan di area terbuka
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
    let watchId = null;
    let bestAccuracy = Infinity;
    let bestPosition = null;
    let gpsTimeout = null;
    let isGettingLocation = false;

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
      if (isGettingLocation) return;
      isGettingLocation = true;

      // Reset variables
      bestAccuracy = Infinity;
      bestPosition = null;
      
      if (!navigator.geolocation) {
        showGPSStatus('error', 'Browser Tidak Support GPS', 'Gunakan browser modern seperti Chrome atau Firefox');
        isGettingLocation = false;
        return;
      }

      showGPSStatus('loading', 'Mengakses GPS...', 'Mencari sinyal GPS terbaik. Ini mungkin memakan waktu 10-15 detik...');

      const options = { 
        enableHighAccuracy: true, 
        timeout: 30000,
        maximumAge: 0 
      };
      
      // Gunakan watchPosition untuk mendapatkan posisi terbaik
      watchId = navigator.geolocation.watchPosition(
        onLocationUpdate,
        onLocationError,
        options
      );

      // Set timeout 15 detik untuk menggunakan posisi terbaik yang tersedia
      gpsTimeout = setTimeout(() => {
        stopWatchingLocation();
        if (bestPosition) {
          onLocationSuccess(bestPosition);
        } else {
          showGPSStatus('error', 'GPS Timeout', 'Tidak dapat mendapatkan sinyal GPS yang cukup baik. Coba lagi.');
          isGettingLocation = false;
        }
      }, 15000);
    }

    function onLocationUpdate(position) {
      const currentAccuracy = position.coords.accuracy;
      
      // Update jika ini posisi dengan akurasi terbaik
      if (currentAccuracy < bestAccuracy) {
        bestAccuracy = currentAccuracy;
        bestPosition = position;
        
        const accuracyLabel = getAccuracyLabel(currentAccuracy);
        showGPSStatus('info', 'Mendapatkan GPS...', 
          `Akurasi saat ini: ±${Math.round(currentAccuracy)}m ${accuracyLabel}`);
        
        // Jika akurasi sudah sangat bagus (< 30m), langsung gunakan
        if (currentAccuracy < 30) {
          clearTimeout(gpsTimeout);
          stopWatchingLocation();
          onLocationSuccess(bestPosition);
        }
      }
    }

    function stopWatchingLocation() {
      if (watchId !== null) {
        navigator.geolocation.clearWatch(watchId);
        watchId = null;
      }
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

      // Beri peringatan jika akurasi rendah
      const accuracy = userLocation.accuracy;
      const accuracyLabel = getAccuracyLabel(accuracy);
      
      if (accuracy > 100) {
        showGPSStatus('warning', 'GPS Kurang Akurat ⚠️', 
          `Akurasi GPS: ±${Math.round(accuracy)}m ${accuracyLabel}. Hasil verifikasi mungkin tidak tepat. Disarankan ke area terbuka atau coba lagi.`);
        document.getElementById('retryButton').style.display = 'inline-block';
      } else if (accuracy > 50) {
        showGPSStatus('info', 'GPS Cukup Akurat', 
          `Akurasi GPS: ±${Math.round(accuracy)}m ${accuracyLabel}. Memverifikasi lokasi...`);
      }

      verifyLocationWithServer();
    }

    function onLocationError(error) {
      stopWatchingLocation();
      clearTimeout(gpsTimeout);
      isGettingLocation = false;

      let title = '', message = '';
      switch (error.code) {
        case error.PERMISSION_DENIED:
          title = 'Akses Lokasi Ditolak';
          message = 'Klik icon gembok di address bar, lalu izinkan akses lokasi. Refresh halaman setelah mengizinkan.';
          break;
        case error.POSITION_UNAVAILABLE:
          title = 'Lokasi Tidak Tersedia';
          message = 'Pastikan GPS aktif di perangkat Anda dan Anda berada di area terbuka.';
          break;
        case error.TIMEOUT:
          title = 'Request Timeout';
          message = 'Tidak dapat mendapatkan lokasi dalam waktu yang ditentukan. Pastikan GPS aktif.';
          break;
        default:
          title = 'Error GPS';
          message = 'Terjadi kesalahan saat mendapatkan lokasi.';
      }
      showGPSStatus('error', title, message);
      document.getElementById('retryButton').style.display = 'inline-block';
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
          isGettingLocation = false;
          
          if (data.success) {
            locationVerified = true;
            const distance = Math.round(data.data.distance);
            const clinicName = data.data.clinic_name || 'Klinik';
            const accuracy = Math.round(data.data.accuracy);
            const accuracyLabel = getAccuracyLabel(accuracy);
            
            showGPSStatus('success', 'Lokasi Valid ✓',
              `${clinicName} - Jarak: ${distance}m | Akurasi GPS: ±${accuracy}m ${accuracyLabel}`);
            enableLoginButton();
          } else {
            locationVerified = false;
            const message = data.message || 'Lokasi Anda terlalu jauh dari klinik.';
            showGPSStatus('error', 'Lokasi Tidak Valid ✗', message);
            document.getElementById('retryButton').style.display = 'inline-block';
          }
        })
        .catch(() => {
          isGettingLocation = false;
          showGPSStatus('error', 'Gagal Verifikasi', 'Tidak dapat menghubungi server. Cek koneksi internet Anda.');
          document.getElementById('retryButton').style.display = 'inline-block';
        });
    }

    function enableLoginButton() {
      const btn = document.getElementById('loginBtn');
      const btnText = document.getElementById('loginBtnText');
      btn.disabled = false;
      btnText.innerHTML = '<i class="ti ti-login me-2"></i>Login';
    }

    function getAccuracyLabel(accuracy) {
      let badge = '';
      if (accuracy < 30) {
        badge = '<span class="accuracy-badge accuracy-excellent">Sangat Baik</span>';
      } else if (accuracy < 50) {
        badge = '<span class="accuracy-badge accuracy-good">Baik</span>';
      } else if (accuracy < 100) {
        badge = '<span class="accuracy-badge accuracy-fair">Cukup</span>';
      } else {
        badge = '<span class="accuracy-badge accuracy-poor">Kurang</span>';
      }
      return badge;
    }

    function showGPSStatus(type, title, message) {
      const box = document.getElementById('gpsStatusBox');
      const alert = document.getElementById('gpsAlert');
      const icon = document.getElementById('gpsIcon');
      const titleEl = document.getElementById('gpsTitle');
      const messageEl = document.getElementById('gpsMessage');
      const retryBtn = document.getElementById('retryButton');

      box.style.display = 'block';
      alert.className = 'alert d-flex align-items-center';
      retryBtn.style.display = 'none';

      if (type === 'loading') {
        alert.classList.add('gps-warning', 'gps-loading');
        icon.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
      } else if (type === 'success') {
        alert.classList.add('gps-success');
        icon.innerHTML = '<i class="ti ti-check fs-4"></i>';
      } else if (type === 'error') {
        alert.classList.add('gps-error');
        icon.innerHTML = '<i class="ti ti-x fs-4"></i>';
      } else if (type === 'warning') {
        alert.classList.add('gps-warning');
        icon.innerHTML = '<i class="ti ti-alert-triangle fs-4"></i>';
      } else if (type === 'info') {
        alert.classList.add('gps-info');
        icon.innerHTML = '<i class="ti ti-info-circle fs-4"></i>';
      }

      titleEl.textContent = title;
      messageEl.innerHTML = message;
    }

    function retryGPS() {
      if (isGettingLocation) return;
      
      locationVerified = false;
      document.getElementById('loginBtn').disabled = true;
      document.getElementById('loginBtnText').innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menunggu GPS...';
      
      checkGPSLocation();
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