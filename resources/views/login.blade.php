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
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/tabler-icons.css') }}" />

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

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/pages/page-auth.css') }}" />

    {{-- <script src="{{ asset('/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('/assets/vendor/js/template-customizer.js') }}"></script> --}}
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
        0%, 100% { opacity: 1; }
        50% { opacity: .5; }
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
      #debugInfo {
        font-size: 11px;
        background: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
        max-height: 200px;
        overflow-y: auto;
      }
      .debug-line {
        padding: 2px 0;
        border-bottom: 1px solid #e9ecef;
      }
    </style>
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

              <!-- GPS Status Alert -->
              <div id="gpsStatusBox" class="gps-status-box" style="display: none;">
                <div id="gpsAlert" class="alert d-flex align-items-center" role="alert">
                  <span id="gpsIcon" class="me-2"></span>
                  <div class="flex-grow-1">
                    <strong id="gpsTitle"></strong>
                    <div id="gpsMessage" class="small"></div>
                  </div>
                </div>
              </div>

              <!-- DEBUG INFO -->
              <div class="alert gps-info">
                <strong>🔍 Debug Mode Aktif</strong>
                <div id="debugInfo" class="mt-2"></div>
              </div>

              <form id="formAuthentication" class="mb-4 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('login.proses') }}" method="POST" novalidate="novalidate">
                @csrf
                
                <!-- Hidden GPS Inputs -->
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <input type="hidden" name="accuracy" id="accuracy">

                <div class="mb-6 form-control-validation fv-plugins-icon-container">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autofocus="">
                  <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                </div>
                
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
                      <i id="toggleIcon" class="ti ti-eye-off"></i>
                    </span>
                  </div>
                </div>
                
                <div class="mb-6">
                  <button class="btn btn-primary d-grid w-100 waves-effect waves-light" type="submit" id="loginBtn" disabled>
                    <span id="loginBtnText">
                      <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                      Menunggu GPS...
                    </span>
                  </button>
                </div>

                <!-- Manual Test Buttons -->
                <div class="d-grid gap-2 mb-3">
                  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="checkGPSLocation()">
                    🔄 Retry GPS
                  </button>
                  <button type="button" class="btn btn-outline-info btn-sm" onclick="testRoute()">
                    🧪 Test Route
                  </button>
                </div>

                <!-- Info GPS -->
                <div class="text-center">
                  <small class="text-muted">
                    <i class="ti ti-map-pin"></i> Pastikan GPS aktif dan izinkan akses lokasi
                  </small>
                </div>
              </form>
            </div>
          </div>
          <!-- /Login -->
        </div>
      </div>
    </div>

    <script>
      let userLocation = null;
      let locationVerified = false;
      const debugLog = [];

      function addDebugLog(message, type = 'info') {
        const timestamp = new Date().toLocaleTimeString();
        const icon = type === 'error' ? '❌' : type === 'success' ? '✅' : type === 'warning' ? '⚠️' : 'ℹ️';
        debugLog.push(`[${timestamp}] ${icon} ${message}`);
        updateDebugDisplay();
        console.log(`[DEBUG] ${message}`);
      }

      function updateDebugDisplay() {
        const debugDiv = document.getElementById('debugInfo');
        debugDiv.innerHTML = debugLog.slice(-10).reverse().map(log => 
          `<div class="debug-line">${log}</div>`
        ).join('');
      }

      // Test Route Function
      function testRoute() {
        addDebugLog('Testing route availability...');
        
        const testUrl = '{{ route("login.verify-location") }}';
        addDebugLog(`Route URL: ${testUrl}`);

        fetch(testUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
            latitude: -6.2088,
            longitude: 106.8456,
            accuracy: 10
          })
        })
        .then(response => {
          addDebugLog(`Response status: ${response.status}`, response.ok ? 'success' : 'error');
          return response.json();
        })
        .then(data => {
          addDebugLog(`Server response: ${JSON.stringify(data)}`, 'success');
        })
        .catch(error => {
          addDebugLog(`Route test failed: ${error.message}`, 'error');
        });
      }

      // Toggle password visibility
      document.addEventListener("DOMContentLoaded", function () {
        addDebugLog('Page loaded successfully');
        addDebugLog(`CSRF Token: ${document.querySelector('meta[name="csrf-token"]')?.content ? 'Found' : 'NOT FOUND'}`);

        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");
        const toggleIcon = document.getElementById("toggleIcon");

        togglePassword.addEventListener("click", function () {
          const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
          passwordInput.setAttribute("type", type);

          if (type === "text") {
            toggleIcon.classList.remove("ti-eye-off");
            toggleIcon.classList.add("ti-eye");
          } else {
            toggleIcon.classList.remove("ti-eye");
            toggleIcon.classList.add("ti-eye-off");
          }
        });

        // Start GPS check saat halaman load
        addDebugLog('Starting GPS check...');
        checkGPSLocation();
      });

      // Request GPS Permission
      function checkGPSLocation() {
        addDebugLog('Checking geolocation support...');
        
        if (!navigator.geolocation) {
          addDebugLog('Geolocation NOT supported!', 'error');
          showGPSStatus('error', 'Browser Tidak Support GPS', 'Gunakan browser modern seperti Chrome atau Firefox');
          return;
        }

        addDebugLog('Geolocation supported ✓', 'success');
        showGPSStatus('loading', 'Mengakses GPS...', 'Mohon izinkan akses lokasi pada browser Anda');

        const options = {
          enableHighAccuracy: true,
          timeout: 15000,
          maximumAge: 0
        };

        addDebugLog('Requesting GPS position...');
        
        navigator.geolocation.getCurrentPosition(
          onLocationSuccess,
          onLocationError,
          options
        );
      }

      // Callback: Berhasil dapat lokasi
      function onLocationSuccess(position) {
        addDebugLog('GPS position received!', 'success');
        
        userLocation = {
          latitude: position.coords.latitude,
          longitude: position.coords.longitude,
          accuracy: position.coords.accuracy
        };

        addDebugLog(`Lat: ${userLocation.latitude.toFixed(6)}, Lon: ${userLocation.longitude.toFixed(6)}`, 'success');
        addDebugLog(`GPS Accuracy: ±${Math.round(userLocation.accuracy)}m`);

        // Isi hidden input
        document.getElementById('latitude').value = userLocation.latitude;
        document.getElementById('longitude').value = userLocation.longitude;
        document.getElementById('accuracy').value = userLocation.accuracy;

        // Verifikasi ke server
        addDebugLog('Sending location to server...');
        verifyLocationWithServer();
      }

      // Callback: Gagal dapat lokasi
      function onLocationError(error) {
        let title = '';
        let message = '';

        switch(error.code) {
          case error.PERMISSION_DENIED:
            title = 'Akses Lokasi Ditolak';
            message = 'Klik icon gembok/kunci di address bar browser, lalu izinkan akses lokasi';
            addDebugLog('GPS permission denied by user', 'error');
            break;
          case error.POSITION_UNAVAILABLE:
            title = 'Lokasi Tidak Tersedia';
            message = 'Pastikan GPS/Location Services aktif di perangkat Anda';
            addDebugLog('GPS position unavailable', 'error');
            break;
          case error.TIMEOUT:
            title = 'Request Timeout';
            message = 'Tidak dapat mendapatkan lokasi. Coba refresh halaman';
            addDebugLog('GPS request timeout', 'error');
            break;
          default:
            title = 'Error GPS';
            message = 'Terjadi kesalahan saat mendapatkan lokasi';
            addDebugLog(`GPS error: ${error.message}`, 'error');
        }

        showGPSStatus('error', title, message);
      }

      // Verifikasi lokasi dengan server
      function verifyLocationWithServer() {
        showGPSStatus('loading', 'Memverifikasi Lokasi...', 'Mengecek jarak ke klinik...');
        
        const verifyUrl = '{{ route("login.verify-location") }}';
        addDebugLog(`Verify URL: ${verifyUrl}`);

        fetch(verifyUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify(userLocation)
        })
        .then(response => {
          addDebugLog(`Server responded with status: ${response.status}`);
          
          if (!response.ok) {
            addDebugLog(`HTTP Error: ${response.statusText}`, 'error');
          }
          
          return response.json();
        })
        .then(data => {
          addDebugLog(`Server data: ${JSON.stringify(data)}`);
          
          if (data.success) {
            locationVerified = true;
            const distance = Math.round(data.data.distance);
            const clinicName = data.data.clinic_name || 'Klinik';
            
            addDebugLog(`Location verified! Distance: ${distance}m`, 'success');
            
            showGPSStatus('success', 'Lokasi Valid ✓', 
              `${clinicName} - Jarak: ${distance}m (Akurasi GPS: ±${Math.round(data.data.accuracy)}m)`);
            enableLoginButton();
          } else {
            locationVerified = false;
            addDebugLog(`Location verification failed: ${data.message}`, 'error');
            showGPSStatus('error', 'Lokasi Tidak Valid ✗', data.message);
          }
        })
        .catch(error => {
          addDebugLog(`Fetch error: ${error.message}`, 'error');
          console.error('Full error:', error);
          showGPSStatus('error', 'Gagal Verifikasi', 'Terjadi kesalahan koneksi ke server. Cek console (F12).');
        });
      }

      // Enable tombol login
      function enableLoginButton() {
        const btn = document.getElementById('loginBtn');
        const btnText = document.getElementById('loginBtnText');
        btn.disabled = false;
        btnText.innerHTML = '<i class="ti ti-login me-2"></i>Login';
        addDebugLog('Login button enabled', 'success');
      }

      // Show GPS status
      function showGPSStatus(type, title, message) {
        const statusBox = document.getElementById('gpsStatusBox');
        const alert = document.getElementById('gpsAlert');
        const icon = document.getElementById('gpsIcon');
        const titleEl = document.getElementById('gpsTitle');
        const messageEl = document.getElementById('gpsMessage');

        statusBox.style.display = 'block';
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

      // Handle form submit
      document.getElementById('formAuthentication').addEventListener('submit', function(e) {
        if (!locationVerified) {
          e.preventDefault();
          addDebugLog('Login blocked: Location not verified', 'warning');
          alert('⚠️ Lokasi belum terverifikasi! Mohon tunggu hingga GPS selesai diverifikasi.');
          return false;
        }

        addDebugLog('Submitting login form...');
        const btn = document.getElementById('loginBtn');
        const btnText = document.getElementById('loginBtnText');
        
        btn.disabled = true;
        btnText.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
      });
    </script>
  </body>
</html>