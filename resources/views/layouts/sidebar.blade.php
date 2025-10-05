{{-- Dashboard --}}
@can('read_dashboard')
<li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
    <a href="{{ url('/dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-smart-home"></i>
        <div data-i18n="Dashboard">Dashboard</div>
    </a>
</li>
@endcan

{{-- Loket Section --}}
@canany(['read_loket-pasien','create_loket-pasien','update_loket-pasien','delete_loket-pasien',
         'read_loket-data-pasien','create_loket-data-pasien','update_loket-data-pasien','delete_loket-data-pasien',
         'read_loket-report','create_loket-report','update_loket-report','delete_loket-report'])
    <li class="menu-item {{ Request::is('loket/pasien', 'loket/data-pasien', 'loket/report', 'loket/pasien/create') ? 'open active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-user-square"></i>
            <div data-i18n="Locket">Locket</div>
        </a>
        <ul class="menu-sub">
            @canany(['read_loket-pasien','create_loket-pasien','update_loket-pasien','delete_loket-pasien'])
                <li class="menu-item {{ Request::is('loket/pasien') ? 'active' : '' }}">
                    <a href="{{ route('pasien.index') }}" class="menu-link">
                        <div data-i18n="Dashboard">Dashboard</div>
                    </a>
                </li>
            @endcanany

            @canany(['read_loket-data-pasien','create_loket-data-pasien','update_loket-data-pasien','delete_loket-data-pasien'])
                <li class="menu-item {{ Request::is('loket/data-pasien') ? 'active' : '' }}">
                    <a href="{{ route('data-pasien.index') }}" class="menu-link">
                        <div data-i18n="Patient Data">Patient Data</div>
                    </a>
                </li>
            @endcanany

            @canany(['read_loket-report','create_loket-report','update_loket-report','delete_loket-report'])
                <li class="menu-item {{ Request::is('loket/report') ? 'active' : '' }}">
                    <a href="{{ route('report.index') }}" class="menu-link">
                        <div data-i18n="Report">Report</div>
                    </a>
                </li>
            @endcanany
        </ul>
    </li>
@endcanany

{{-- Laboratory Section --}}
@canany(['read_analyst-collection','create_analyst-collection','update_analyst-collection','delete_analyst-collection',
         'read_analyst-spesiment','create_analyst-spesiment','update_analyst-spesiment','delete_analyst-spesiment',
         'read_analyst-worklist','create_analyst-worklist','update_analyst-worklist','delete_analyst-worklist',
         'read_analyst-result','create_analyst-result','update_analyst-result','delete_analyst-result',
         'read_analyst-qc','create_analyst-qc','update_analyst-qc','delete_analyst-qc'])
    <li class="menu-item {{ Request::is('analyst/analyst', 'analyst/spesiment', 'analyst/worklist', 'analyst/result', 'analyst/Qc', 'analyst/report') ? 'open active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-flask"></i>
            <div data-i18n="Laboratory">Laboratory</div>
        </a>
        <ul class="menu-sub">
            @canany(['read_analyst-collection','create_analyst-collection','update_analyst-collection','delete_analyst-collection'])
                <li class="menu-item {{ Request::is('analyst/analyst') ? 'active' : '' }}">
                    <a href="{{ route('analyst.index') }}" class="menu-link">
                        <div data-i18n="Spesiment Collection">Spesiment Collection</div>
                    </a>
                </li>
            @endcanany

            @canany(['read_analyst-spesiment','create_analyst-spesiment','update_analyst-spesiment','delete_analyst-spesiment'])
                <li class="menu-item {{ Request::is('analyst/spesiment') ? 'active' : '' }}">
                    <a href="{{ route('spesiment.index') }}" class="menu-link">
                        <div data-i18n="Spesiment Handlings">Spesiment Handlings</div>
                    </a>
                </li>
            @endcanany

            @canany(['read_analyst-worklist','create_analyst-worklist','update_analyst-worklist','delete_analyst-worklist'])
                <li class="menu-item {{ Request::is('analyst/worklist') ? 'active' : '' }}">
                    <a href="{{ route('worklist.index') }}" class="menu-link">
                        <div data-i18n="Worklist">Worklist</div>
                    </a>
                </li>
            @endcanany

            @canany(['read_analyst-result','create_analyst-result','update_analyst-result','delete_analyst-result'])
                <li class="menu-item {{ Request::is('analyst/result') ? 'active' : '' }}">
                    <a href="{{ route('result.index') }}" class="menu-link">
                        <div data-i18n="Result Review">Result Review</div>
                    </a>
                </li>
            @endcanany

            @canany(['read_analyst-qc','create_analyst-qc','update_analyst-qc','delete_analyst-qc'])
                <li class="menu-item {{ Request::is('analyst/Qc') ? 'active' : '' }}">
                    <a href="{{ route('Qc.index') }}" class="menu-link">
                        <div data-i18n="QC">QC</div>
                    </a>
                </li>
            @endcanany

            {{-- @canany(['read_analyst-list-qc','create_analyst-list-qc','update_analyst-list-qc','delete_analyst-list-qc'])
                <li class="menu-item {{ Request::is('analyst/report') ? 'active' : '' }}">
                    <a href="{{ route('Dqc.index') }}" class="menu-link">
                        <div data-i18n="List QC">List QC</div>
                    </a>
                </li>
            @endcanany --}}
        </ul>
    </li>
@endcanany

{{-- Doctor Section --}}
@canany(['read_doctor','create_doctor','update_doctor','delete_doctor'])
    <li class="menu-item {{ Request::is('vdokter') ? 'active' : '' }}">
        <a href="{{ route('vdokter.index') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-stethoscope"></i>
            <div data-i18n="Doctor">Doctor</div>
        </a>
    </li>
@endcanany

{{-- Setting Section --}}
@canany(['read_department','create_department','update_department','delete_department',
         'read_spesiments','create_spesiments','update_spesiments','delete_spesiments',
         'read_mcu','create_mcu','update_mcu','delete_mcu',
         'read_dokter','create_dokter','update_dokter','delete_dokter',
         'read_poli','create_poli','update_poli','delete_poli'])
    <li class="menu-item {{ Request::is('dokter', 'poli', 'department', 'pemeriksaan', 'spesiments', 'detailspesiments', 'mcu') ? 'open active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-settings"></i>
            <div data-i18n="Setting">Setting</div>
        </a>
        <ul class="menu-sub">
            @canany(['read_department','create_department','update_department','delete_department'])
                <li class="menu-item {{ Request::is('department') ? 'active' : '' }}">
                    <a href="{{ route('department.index') }}" class="menu-link">
                        <div data-i18n="Department">Department</div>
                    </a>
                </li>
            @endcanany

            @canany(['read_spesiments','create_spesiments','update_spesiments','delete_spesiments'])
                <li class="menu-item {{ Request::is('spesiments') ? 'active' : '' }}">
                    <a href="{{ route('spesiments.index') }}" class="menu-link">
                        <div data-i18n="Spesiment">Spesiment</div>
                    </a>
                </li>
            @endcanany

            @canany(['read_mcu','create_mcu','update_mcu','delete_mcu'])
                <li class="menu-item {{ Request::is('mcu') ? 'active' : '' }}">
                    <a href="{{ route('mcu.index') }}" class="menu-link">
                        <div data-i18n="MCU">MCU</div>
                    </a>
                </li>
            @endcanany

            @canany(['read_dokter','create_dokter','update_dokter','delete_dokter'])
                <li class="menu-item {{ Request::is('dokter') ? 'active' : '' }}">
                    <a href="{{ route('dokter.index') }}" class="menu-link">
                        <div data-i18n="Doctor">Doctor / Send</div>
                    </a>
                </li>
            @endcanany

            @canany(['read_poli','create_poli','update_poli','delete_poli'])
                <li class="menu-item {{ Request::is('poli') ? 'active' : '' }}">
                    <a href="{{ route('poli.index') }}" class="menu-link">
                        <div data-i18n="Poli">Poli</div>
                    </a>
                </li>
            @endcanany
        </ul>
    </li>
@endcanany

{{-- Role Permission Section --}}
@canany(['read_role-permissions','create_role-permissions','update_role-permissions','delete_role-permissions'])
    <li class="menu-item {{ Request::is('role-permissions', 'user') ? 'open active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-user-cog"></i>
            <div data-i18n="Role Permission">Role Permission</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ Request::is('user') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" class="menu-link">
                    <div data-i18n="User">User</div>
                </a>
            </li>

            <li class="menu-item {{ Request::is('role-permissions') ? 'active' : '' }}">
                <a href="{{ route('role-permissions.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-lock"></i>
                    <div class="text-truncate" data-i18n="Role Permission">Role Permission</div>
                </a>
            </li>
        </ul>
    </li>
@endcanany
