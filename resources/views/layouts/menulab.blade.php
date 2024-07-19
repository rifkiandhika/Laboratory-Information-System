<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">
            <h4>Menu</h4>
        </li>

        <li class="sidebar-item {{ Request::is('analyst/analyst') ? 'active' : '' }} ">
            <a href="{{ url('/analyst/analyst') }}" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>

        </li>

        {{-- Laboratorium --}}
        <li class="sidebar-item has-sub {{ Request::is('') ? 'active' : '' }}">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-droplet-half"></i>
                <span>Laboratory</span>
            </a>
            <ul class="submenu ">
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
    </ul>

</div>
