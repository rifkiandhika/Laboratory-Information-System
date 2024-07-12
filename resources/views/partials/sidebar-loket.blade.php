
<div class="side tutup">
    <div class="logo-details">
      <i class='bx bxs-vial'></i>
      <span class="logo_name">PremiereLab</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="{{ route('pasien.index') }}">
          <i class='bx bx-grid-alt' ></i>
          <span class="link_name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="{{ route('pasien.index') }}">Dashboard</a></li>
        </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="/data-pasien">
            <i class='bx bx-collection'></i>
            <span class="link_name">Data Pasien</span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="{{ route('pasien.data') }}">Data Pasien</a></li>
          </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="/report-loket">
            <i class='bx bxs-report'></i>
            <span class="link_name">Report</span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="/report-loket">Report</a></li>
          </ul>
      </li>
      <li>
        <div div class="profile-details">
          <div class="profile-content">
            <img src="{{ asset('image/1profile.png') }}" alt="1profile">
          </div>
          <div class="name-job">
            <div class="profile_name">Pramesty</div>
            <div class="job">Ui Designer</div>
          </div>
          <i class='bx bx-log-out' ></i>
        </div>
      </li>
    </ul>
  </div>
