<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('image/icon.png') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com/" />
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/tabler-icons.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('/assets/vendor/css/rtl/core.css') }}" />
  <link rel="stylesheet" href="{{ asset('/assets/vendor/css/rtl/theme-default.css') }}" />
  <link rel="stylesheet" href="{{ asset('/assets/css/demo.css') }}" />
  <link rel="stylesheet" href="{{ asset('/assets/vendor/css/pages/page-auth.css') }}" />
  
  <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>

  <style>
    .device-status-box {
      transition: all 0.3s ease;
      margin-bottom: 1rem;
    }

    .status-loading {
      animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: .5; }
    }

    .status-success {
      background: #d4edda;
      border: 1px solid #c3e6cb;
      color: #155724;
    }

    .status-error {
      background: #f8d7da;
      border: 1px solid #f5c6cb;
      color: #721c24;
    }

    .status-warning {
      background: #fff3cd;
      border: 1px solid #ffeeba;
      color: #856404;
    }

    .status-info {
      background: #d1ecf1;
      border: 1px solid #bee5eb;
      color: #0c5460;
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

            <!-- Laravel Error Messages -->
            @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif

            @if (session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif

            <!-- Device Status -->
            <div id="deviceStatusBox" class="device-status-box" style="display: none;">
              <div id="deviceAlert" class="alert d-flex align-items-center" role="alert">
                <span id="deviceIcon" class="me-2"></span>
                <div class="flex-grow-1">
                  <strong id="deviceTitle"></strong>
                  <div id="deviceMessage" class="small"></div>
                  <button id="registerDeviceBtn" class="btn btn-sm btn-outline-primary mt-2" style="display: none;" onclick="registerDevice()">
                    <i class="ti ti-device-floppy me-1"></i>Daftarkan Device Ini
                  </button>
                </div>
              </div>
            </div>

            <form id="formAuthentication" class="mb-4" action="{{ route('login.proses') }}" method="POST">
              @csrf

              <input type="hidden" name="device_fingerprint" id="device_fingerprint">
              <input type="hidden" name="location_method" id="location_method" value="whitelist">

              <div class="mb-6">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                  placeholder="Enter your username" value="{{ old('username') }}" autofocus required>
              </div>

              <div class="mb-6 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password"
                    placeholder="••••••••••" required />
                  <span id="togglePassword" class="input-group-text cursor-pointer">
                    <i id="toggleIcon" class="ti ti-eye-off"></i>
                  </span>
                </div>
              </div>

              <div class="mb-6">
                <button class="btn btn-primary d-grid w-100" type="submit" id="loginBtn" disabled>
                  <span id="loginBtnText">
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Mengecek Device...
                  </span>
                </button>
              </div>

              <div class="text-center">
                <small class="text-muted" id="deviceInfo">
                  <i class="ti ti-device-desktop"></i> Mendeteksi device...
                </small>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    let deviceFingerprint = null;
    let deviceVerified = false;

    document.addEventListener("DOMContentLoaded", function () {
      // Toggle password visibility
      const togglePassword = document.getElementById("togglePassword");
      const passwordInput = document.getElementById("password");
      const toggleIcon = document.getElementById("toggleIcon");

      togglePassword.addEventListener("click", function () {
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);
        toggleIcon.classList.toggle("ti-eye-off");
        toggleIcon.classList.toggle("ti-eye");
      });

      // Initialize
      generateDeviceFingerprint();
      checkDeviceStatus();
    });

    function generateDeviceFingerprint() {
      // Generate unique fingerprint
      const canvas = document.createElement('canvas');
      const ctx = canvas.getContext('2d');
      ctx.textBaseline = 'top';
      ctx.font = '14px Arial';
      ctx.fillText('fingerprint', 2, 2);
      
      const fingerprint = {
        userAgent: navigator.userAgent,
        language: navigator.language,
        platform: navigator.platform,
        screenResolution: `${screen.width}x${screen.height}`,
        timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
        canvasFingerprint: canvas.toDataURL().substring(0, 50)
      };
      
      deviceFingerprint = btoa(JSON.stringify(fingerprint)).substring(0, 32);
      document.getElementById('device_fingerprint').value = deviceFingerprint;
      
      const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
      const deviceType = isMobile ? 'Mobile Device' : 'Desktop/Laptop';
      document.getElementById('deviceInfo').innerHTML = `<i class="ti ti-${isMobile ? 'device-mobile' : 'device-desktop'}"></i> ${deviceType}`;
    }

    function checkDeviceStatus() {
      showDeviceStatus('loading', 'Mengecek Device...', 'Memverifikasi apakah device ini sudah terdaftar...');
      
      fetch('{{ route("check.device") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
          device_fingerprint: deviceFingerprint
        })
      })
        .then(res => res.json())
        .then(data => {
          console.log('Check device response:', data);

          if (data.status === 'approved') {
            // Device SUDAH approved
            deviceVerified = true;
            showDeviceStatus('success', 'Device Terdaftar ✓', 
              `${data.clinic_location.name} - Device ini sudah terdaftar dan disetujui`);
            enableLoginButton();
          } else if (data.status === 'pending') {
            // Device SUDAH didaftarkan tapi masih pending
            deviceVerified = false;
            showDeviceStatus('warning', 'Device Pending ⏳', 
              'Device ini sudah didaftarkan dan sedang menunggu approval dari admin. Silakan hubungi admin.');
            enableLoginButton();
          } else if (data.status === 'rejected') {
            // Device SUDAH didaftarkan tapi ditolak
            deviceVerified = false;
            showDeviceStatus('error', 'Device Ditolak ✗', 
              'Device ini ditolak oleh admin. Silakan hubungi admin untuk informasi lebih lanjut.');
            enableLoginButton();
          } else {
            // Device BELUM terdaftar sama sekali (status: not_registered)
            deviceVerified = false;
            showDeviceStatus('info', 'Device Belum Terdaftar', 
              'Device ini belum terdaftar di sistem. Klik tombol di bawah untuk mendaftarkan.');
            document.getElementById('registerDeviceBtn').style.display = 'inline-block';
            enableLoginButton();
          }
        })
        .catch(error => {
          console.error('Error checking device:', error);
          deviceVerified = false;
          showDeviceStatus('warning', 'Tidak Dapat Mengecek Device', 
            'Terjadi kesalahan saat mengecek device. Anda tetap bisa mencoba login.');
          enableLoginButton();
        });
    }

    function registerDevice() {
      Swal.fire({
        title: 'Daftarkan device ini ke sistem?',
        html: 'Device ini akan didaftarkan untuk klinik berdasarkan <strong>IP address</strong> Anda saat ini.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          // User klik OK
          showDeviceStatus('loading', 'Mendaftarkan Device...', 'Mohon tunggu...');
          document.getElementById('registerDeviceBtn').style.display = 'none';
          
          fetch('{{ route("register.device") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
              device_fingerprint: deviceFingerprint
            })
          })
            .then(res => res.json())
            .then(data => {
              console.log('Register device response:', data);
              
              if (data.success) {
                // BERHASIL DIDAFTARKAN (pertama kali)
                deviceVerified = false;
                showDeviceStatus('warning', 'Device Terdaftar - Menunggu Approval ⏳', data.message);
                
                Swal.fire({
                  title: 'Berhasil!',
                  text: data.message,
                  icon: 'success',
                  confirmButtonText: 'OK'
                });
              } else {
                // GAGAL mendaftar
                if (data.already_registered) {
                  // Device SUDAH pernah didaftarkan sebelumnya
                  if (data.status === 'pending') {
                    deviceVerified = false;
                    showDeviceStatus('warning', 'Device Sudah Terdaftar - Pending ⏳', data.message);
                    
                    Swal.fire({
                      title: 'Device Sudah Terdaftar',
                      text: data.message,
                      icon: 'warning',
                      confirmButtonText: 'OK'
                    });
                  } else if (data.status === 'approved') {
                    deviceVerified = true;
                    showDeviceStatus('success', 'Device Sudah Approved ✓', data.message);
                    
                    Swal.fire({
                      title: 'Device Sudah Approved',
                      text: data.message,
                      icon: 'success',
                      confirmButtonText: 'OK'
                    });
                  } else if (data.status === 'rejected') {
                    deviceVerified = false;
                    showDeviceStatus('error', 'Device Ditolak ✗', data.message);
                    
                    Swal.fire({
                      title: 'Device Ditolak',
                      text: data.message,
                      icon: 'error',
                      confirmButtonText: 'OK'
                    });
                  }
                } else if (data.error_code === 'IP_NOT_ALLOWED') {
                  // IP tidak terdaftar di ClinicLocation
                  deviceVerified = false;
                  showDeviceStatus('error', 'IP Tidak Terdaftar ✗', data.message);
                  document.getElementById('registerDeviceBtn').style.display = 'inline-block';
                  
                  Swal.fire({
                    title: 'IP Tidak Terdaftar',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                  });
                } else {
                  // Error lainnya
                  deviceVerified = false;
                  showDeviceStatus('error', 'Gagal Mendaftar', data.message);
                  document.getElementById('registerDeviceBtn').style.display = 'inline-block';
                  
                  Swal.fire({
                    title: 'Gagal Mendaftar',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                  });
                }
              }
            })
            .catch(error => {
              console.error('Error registering device:', error);
              showDeviceStatus('error', 'Gagal Mendaftar', 
                'Terjadi kesalahan jaringan. Silakan coba lagi atau hubungi admin.');
              document.getElementById('registerDeviceBtn').style.display = 'inline-block';
              
              Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan jaringan. Silakan coba lagi atau hubungi admin.',
                icon: 'error',
                confirmButtonText: 'OK'
              });
            });
        }
        // Jika user klik Cancel, tidak ada action
      });
    }

    function enableLoginButton() {
      const btn = document.getElementById('loginBtn');
      const btnText = document.getElementById('loginBtnText');
      btn.disabled = false;
      btnText.innerHTML = '<i class="ti ti-login me-2"></i>Login';
    }

    function showDeviceStatus(type, title, message) {
      const box = document.getElementById('deviceStatusBox');
      const alert = document.getElementById('deviceAlert');
      const icon = document.getElementById('deviceIcon');
      const titleEl = document.getElementById('deviceTitle');
      const messageEl = document.getElementById('deviceMessage');

      box.style.display = 'block';
      alert.className = 'alert d-flex align-items-center';

      if (type === 'loading') {
        alert.classList.add('status-info', 'status-loading');
        icon.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span>';
      } else if (type === 'success') {
        alert.classList.add('status-success');
        icon.innerHTML = '<i class="ti ti-check fs-4"></i>';
      } else if (type === 'error') {
        alert.classList.add('status-error');
        icon.innerHTML = '<i class="ti ti-x fs-4"></i>';
      } else if (type === 'warning') {
        alert.classList.add('status-warning');
        icon.innerHTML = '<i class="ti ti-alert-triangle fs-4"></i>';
      } else if (type === 'info') {
        alert.classList.add('status-info');
        icon.innerHTML = '<i class="ti ti-info-circle fs-4"></i>';
      }

      titleEl.textContent = title;
      messageEl.textContent = message;
    }
  </script>
</body>
</html>