        <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="{{ url('/dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('loket/pasien', 'loket/data-pasien', 'loket/report', 'loket/pasien/create') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons ti ti-user-square"></i>
              <div data-i18n="Locket">Locket</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item {{ Request::is('loket/pasien') ? 'active' : '' }} ">
                <a href="{{ route('pasien.index') }}" class="menu-link">
                  <div data-i18n="Dashboard">
                    <i class="menu-icon tf-icons ti ti-user-square"></i>Dashboard</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('loket/data-pasien') ? 'active' : '' }}">
                <a href="{{ route('data-pasien.index') }}" class="menu-link">
                  <div data-i18n="Patient Data">Patient Data</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('loket/report') ? 'active' : '' }} ">
                <a href="{{ route('report.index') }}" class="menu-link">
                  <div data-i18n="Report">Report</div>
                </a>
              </li>
            </ul>
          </li>

          {{-- Laboratorium --}}
        <li class="menu-item {{ Request::is('analyst/analyst', 'analyst/spesiment', 'analyst/worklist') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons ti ti-flask"></i>
              <div data-i18n="Laboratory">Laboratory</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item {{ Request::is('analyst/analyst') ? 'active' : '' }}">
                <a href="{{ route('analyst.index') }}" class="menu-link">
                  <div data-i18n="Spesiment Collection">Spesiment Collection</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('analyst/spesiment') ? 'active' : '' }}">
                <a href="{{ route('spesiment.index') }}" class="menu-link">
                  <div data-i18n="Spesiment Handlings">Spesiment Handlings</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('analyst/worklist') ? 'active' : '' }} ">
                <a href="{{ route('worklist.index') }}" class="menu-link">
                  <div data-i18n="Worklist">Worklist</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('analyst/result') ? 'active' : '' }}">
                <a href="{{ route('result.index') }}" class="menu-link">
                  <div data-i18n="Result Review">Result Review</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('analyst/Qc') ? 'active' : '' }}">
                <a href="{{ route('Qc.index') }}" class="menu-link">
                  <div data-i18n="QC">QC</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('analyst/report') ? 'active' : '' }}">
                <a href="{{ route('Dqc.index') }}" class="menu-link">
                  <div data-i18n="List QC">List QC</div>
                </a>
              </li>
            </ul>
          </li>
          <li class="menu-item {{ Request::is('') ? 'active' : '' }} ">
            <a href="{{ route('vdokter.index') }}" class="menu-link">
              <i class="menu-icon tf-icons ti ti-stethoscope"></i>
              <div data-i18n="Doctor">Doctor</div>
            </a>
          </li>
          {{-- Setting --}}
          <li class="menu-item {{ Request::is('dokter', 'poli', 'department', 'pemeriksaan', 'spesiments', 'detailspesiments') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons ti ti-settings"></i>
              <div data-i18n="Setting">Setting</div>
            </a>
            <ul class="menu-sub {{ Request::is('department') ? 'active' : '' }}">
              <li class="menu-item">
                <a href="{{ route('department.index') }}" class="menu-link">
                  <div data-i18n="Department">Department</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('spesiments') ? 'active' : '' }}">
                <a href="{{ route('spesiments.index') }}" class="menu-link">
                  <div data-i18n="Spesiment">Spesiment</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('dokter') ? 'active' : '' }}">
                <a href="{{ route('dokter.index') }}" class="menu-link">
                  <div data-i18n="Doctor">Doctor</div>
                </a>
              </li>
              <li class="menu-item {{ Request::is('poli') ? 'active' : '' }}">
                <a href="{{ route('poli.index') }}" class="menu-link">
                  <div data-i18n="Poli">Poli</div>
                </a>
              </li>
            </ul>
          </li>
          {{-- Role Permission --}}
          {{-- <li class="menu-item {{ Request::is('role', 'permission', 'user') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons ti ti-user-cog"></i>
              <div data-i18n="Role Permission">Role Permission</div>
            </a>
            <ul class="menu-sub ">
              
              <li class="menu-item {{ Request::is('user') ? 'active' : '' }}">
                <a href="app-ecommerce-dashboard.html" class="menu-link">
                  <div data-i18n="User">User</div>
                </a>
              </li>
            </ul>
          </li> --}}