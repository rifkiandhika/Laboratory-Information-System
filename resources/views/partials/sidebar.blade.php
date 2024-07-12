
<div class="side tutup">
    <div class="logo-details">
      <i class='bx bx-book-open'></i>
      <span class="logo_name">AirBookLab</span>
    </div>
    <ul class="nav-links">
    @php
        //mengubah auth role menjadi array
        $role = explode(',', Auth::user()->role);
    @endphp

    @foreach ($role as $r)
        @if ($r == 'loket')
            <li>
                <div class="iocn-link">
                <a href="#">
                    <i class='bx bx-desktop'></i>
                    <span class="link_name">Loket</span>
                </a>
                <i class='bx bxs-chevron-down arrow' ></i>
                </div>
                <ul class="sub-menu">
                <li><a class="link_name" href="#">Loket</a></li>
                <li><a href="{{ route('pasien.index') }}">Dashboard</a></li>
                <li><a href="{{ route('pasien.data') }}">Data Pasien</a></li>
                <li><a href="report-loket">Report</a></li>
                </ul>
            </li>
        @endif
        @if ($r == 'analyst')
            <li>
                <div class="iocn-link">
                <a href="#">
                    <i class='bx bxs-droplet' ></i>
                    <span class="link_name">Laboratorium</span>
                </a>
                <i class='bx bxs-chevron-down arrow' ></i>
                </div>
                <ul class="sub-menu">
                <li><a class="link_name" href="#">Laboratorium</a></li>
                <li><a href="{{ route('analyst.index') }}">Dashboard</a></li>
                <li><a href="{{ route('spesiment.index') }}">Spesiment</a></li>
                <li><a href="{{ route('worklist.index') }}">Worklist</a></li>
                <li><a href="result">Result Review</a></li>
                <li><a href="quality-control">QC</a></li>
                <li><a href="daftar-qc">Daftar QC</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="dashboard-dok">
                        <i class='bx bx-book-content' ></i>
                        <span class="link_name">Dokter</span>
                    </a>
                    <ul class="sub-menu">
                    <li><a class="link_name" href="dashboard-dok">Dokter</a></li>
                    </ul>
                </div>
            </li>
        @endif
    @endforeach

    {{-- <li>
    <div class="iocn-link">
        <a href="#">
        <i class='bx bx-user-plus'></i>
        <span class="link_name">Registrasi</span>
        </a>
        <ul class="sub-menu blank">
        <li><a class="link_name" href="#">Registrasi</a></li>
        </ul>
    </li>
    <li>
    <div class="iocn-link">
        <a href="#">
        <i class='bx bx-coffee' ></i>
        <span class="link_name">Workplace</span>
        </a>
        <i class='bx bxs-chevron-down arrow' ></i>
    </div>
    <ul class="sub-menu">
        <li><a class="link_name" href="#">Workplace</a></li>
        <li><a href="#">Preview</a></li>
        <li><a href="#">Result Review</a></li>
    </ul>
    </li>
    <li>
    <a href="#">
        <i class='bx bx-analyse'></i>
        <span class="link_name">QC</span>
    </a>
    <ul class="sub-menu blank">
        <li><a class="link_name" href="#">Quality Control</a></li>
    </ul>
    </li>
    <li>
    <a href="#">
        <i class='bx bxs-user-detail' ></i>
        <span class="link_name">User</span>
    </a>
    <ul class="sub-menu blank">
        <li><a class="link_name" href="#">Pengguna</a></li>
    </ul>
    </li>
    <li>
    <a href="#">
        <i class='bx bxs-report'></i>
        <span class="link_name">Report</span>
    </a>
    <ul class="sub-menu blank">
        <li><a class="link_name" href="#">Report</a></li>
    </ul>
    </li>
    <li>
    <div class="iocn-link">
        <a href="#">
        <i class='bx bx-credit-card'></i>
        <span class="link_name">Payment</span>
        </a>
        <i class='bx bxs-chevron-down arrow' ></i>
    </div>
    <ul class="sub-menu">
        <li><a class="link_name" href="#">Payment</a></li>
        <li><a href="#">Harga</a></li>
        <li><a href="#">Pembayaran</a></li>
    </ul>
    </li>
    <li>
    <a href="#">
        <i class='fas fa-cogs' ></i>
        <span class="link_name">Setting</span>
    </a>
    <ul class="sub-menu blank">
        <li><a class="link_name" href="#">Setting</a></li>
    </ul>
    </li>
    <li>
    <div class="iocn-link">
        <a href="#">
        <i class='bx bx-box' ></i>
        <span class="link_name">Supply</span>
        </a>
        <i class='bx bxs-chevron-down arrow' ></i>
    </div>
    <ul class="sub-menu">
        <li><a class="link_name" href="#">Supply</a></li>
        <li><a href="#">Logistik</a></li>
        <li><a href="#">Inventory</a></li>
    </ul>
    </li>
    <li>
    <div class="iocn-link">
        <a href="#">
        <i class='fas fa-hammer' ></i>
        <span class="link_name">Utility</span>
        </a>
        <i class='bx bxs-chevron-down arrow' ></i>
    </div>
    <ul class="sub-menu">
        <li><a class="link_name" href="#">Utility</a></li>
        <li><a href="#">Uji</a></li>
        <li><a href="#">Satuan</a></li>
        <li><a href="#">Spesimen</a></li>
        <li><a href="#">Peran</a></li>
        <li><a href="#">Inst Uji</a></li>
        <li><a href="#">Fasilitas</a></li>
        <li><a href="#">Bridging</a></li>
    </ul>
    </li> --}}
    <li>
    <div div class="profile-details">
        <div class="profile-content">
        <img src="{{ asset('image/1profile.png') }}" alt="1profile">
        </div>
        <div class="name-job">
        <div class="profile_name">
            @auth
                {{ Auth::user()->name }}
            @endauth
        </div>
        <div class="job">
            @auth
                {{ Auth::user()->title }}
            @endauth
        </div>
        </div>
        <a href="{{ route('logout') }}">
            <i class='bx bx-log-out' ></i>
        </a>
    </div>
    </li>
    </ul>
  </div>
