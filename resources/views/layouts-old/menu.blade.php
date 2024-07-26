<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">
            <h4>Menu</h4>
        </li>

        <li class="sidebar-item {{ Request::is('dashboard') ? 'active' : '' }} ">
            <a href="{{ url('/dashboard') }}" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>

        </li>
        {{-- Loket --}}
        <li
            class="sidebar-item has-sub {{ Request::is('loket/pasien', 'loket/data-pasien', 'loket/report') ? 'active' : '' }}">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-person-badge"></i>
                <span>Locket</span>
            </a>
            <ul class="submenu ">
                <li class="submenu-item {{ Request::is('loket/pasien') ? 'active' : '' }} ">

                    <a href="{{ route('pasien.index') }}" class="submenu-link"><i class="bi bi-grid-fill"></i>
                        Dashboard</a>
                </li>
                <li class="submenu-item {{ Request::is('loket/data-pasien') ? 'active' : '' }}">
                    <a href="{{ route('data-pasien.index') }}" class="submenu-link"><i class="bi bi-clipboard-plus"></i>
                        Patient Data</a>
                </li>
                <li class="submenu-item {{ Request::is('loket/report') ? 'active' : '' }} ">
                    <a href="{{ route('report.index') }}" class="submenu-link"><i class="bi bi-clipboard2-pulse"></i>
                        Report</a>
                </li>
            </ul>
        </li>
        {{-- Loket --}}

        {{-- Laboratorium --}}
        <li class="sidebar-item has-sub {{ Request::is('analyst/analyst') ? 'active' : '' }}">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-droplet-half"></i>
                <span>Laboratory</span>
            </a>
            <ul class="submenu ">
                <li class="submenu-item {{ Request::is('analyst/analyst') ? 'active' : '' }} ">

                    <a href="{{ route('analyst.index') }}" class="submenu-link"><i class="bi bi-grid-fill"></i>
                        Dashboard</a>
                </li>
                <li class="submenu-item {{ Request::is('loket/data-pasien') ? 'active' : '' }}">
                    <a href="{{ route('data-pasien.index') }}" class="submenu-link"><i
                            class="bi bi-clipboard-plus"></i>
                        Spesiment</a>
                </li>
                <li class="submenu-item {{ Request::is('loket/report') ? 'active' : '' }} ">
                    <a href="{{ route('report.index') }}" class="submenu-link"><i class="bi bi-clipboard2-pulse"></i>
                        Worklist</a>
                </li>
                <li class="submenu-item {{ Request::is('loket/report') ? 'active' : '' }} ">
                    <a href="{{ route('report.index') }}" class="submenu-link"><i class="bi bi-clipboard2-pulse"></i>
                        Result Review</a>
                </li>
                <li class="submenu-item {{ Request::is('loket/report') ? 'active' : '' }} ">
                    <a href="{{ route('report.index') }}" class="submenu-link"><i class="bi bi-clipboard2-pulse"></i>
                        QC</a>
                </li>
                <li class="submenu-item {{ Request::is('loket/report') ? 'active' : '' }} ">
                    <a href="{{ route('report.index') }}" class="submenu-link"><i class="bi bi-clipboard2-pulse"></i>
                        List QC</a>
                </li>
            </ul>
        </li>

        <li class="sidebar-item {{ Request::is('') ? 'active' : '' }} ">
            <a href="{{ url('/dashboard') }}" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Doctor</span>
            </a>

        </li>
        {{-- Laboratorium --}}

        {{-- Setting --}}
        <li
            class="sidebar-item has-sub {{ Request::is('dokter', 'poli', 'department', 'pemeriksaan') ? 'active' : '' }}">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-gear"></i>
                <span>Setting</span>
            </a>
            <ul class="submenu ">
                <li class="submenu-item {{ Request::is('department') ? 'active' : '' }} ">

                    <a href="{{ route('department.index') }}" class="submenu-link"><i class="bi bi-hospital"></i>
                        Department</a>
                </li>
                <li class="submenu-item {{ Request::is('dokter') ? 'active' : '' }}">
                    <a href="{{ route('dokter.index') }}" class="submenu-link"><i class="bi bi-heart-pulse"></i>
                        Doctor</a>
                </li>
                <li class="submenu-item {{ Request::is('poli') ? 'active' : '' }} ">
                    <a href="{{ route('poli.index') }}" class="submenu-link"><i class="bi bi-tag"></i>
                        Poli</a>
                </li>
        </li>
        {{-- Setting --}}

        {{-- <li class="submenu-item {{ Request::is('parameter') ? 'active' : '' }} ">
            <a href="" class="submenu-link"><i class="bi bi-activity"></i>
                Parameter</a>
        </li> --}}
        <li class="submenu-item {{ Request::is('pemeriksaan') ? 'active' : '' }} ">
            <a href="{{ route('pemeriksaan.index') }}" class="submenu-link"><i class="bi bi-clipboard-data"></i>
                Inspection</a>
        </li>
        {{-- Setting --}}

    </ul>

    <li class="sidebar-item has-sub {{ Request::is('role', 'permission') ? 'active' : '' }}">
        <a href="#" class='sidebar-link'>
            <i class="bi bi-person-gear"></i>
            <span>Role Permission</span>
        </a>
        <ul class="submenu ">
            <li class="submenu-item {{ Request::is('role') ? 'active' : '' }} ">

                <a href="{{ route('role.index') }}" class="submenu-link"><i class="bi bi-person-lock"></i>
                    Role</a>
            </li>
            <li class="submenu-item {{ Request::is('permission') ? 'active' : '' }}">
                <a href="{{ route('permission.index') }}" class="submenu-link"><i class="bi bi-person-check"></i>
                    Permission</a>
            </li>
            <li class="submenu-item {{ Request::is('user') ? 'active' : '' }} ">
                <a href="" class="submenu-link"><i class="bi bi-people"></i>
                    User</a>
            </li>
        </ul>
    </li>

    </ul>

</div>
