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

        <li class="sidebar-item has-sub {{ Request::is('dokter') ? 'active' : '' }}">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-gear"></i>
                <span>Setting</span>
            </a>
            <ul class="submenu ">
                <li class="submenu-item {{ Request::is('department') ? 'active' : '' }} ">

                    <a href="component-accordion.html" class="submenu-link"><i class="bi bi-hospital"></i>
                        Department</a>
                </li>
                <li class="submenu-item {{ Request::is('dokter') ? 'active' : '' }}">
                    <a href="{{ route('dokter.index') }}" class="submenu-link"><i class="bi bi-heart-pulse"></i>
                        Dokter</a>
                </li>
                <li class="submenu-item {{ Request::is('parameter') ? 'active' : '' }} ">
                    <a href="" class="submenu-link"><i class="bi bi-activity"></i>
                        Parameter</a>
                </li>
                <li class="submenu-item {{ Request::is('pemeriksaan') ? 'active' : '' }} ">
                    <a href="" class="submenu-link"><i class="bi bi-clipboard-data"></i>
                        Pemeriksaan</a>
                </li>
                <li class="submenu-item {{ Request::is('user') ? 'active' : '' }} ">
                    <a href="" class="submenu-link"><i class="bi bi-people"></i>
                        User</a>
                </li>


            </ul>
    </ul>
</div>
