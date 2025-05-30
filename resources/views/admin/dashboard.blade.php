@extends('layouts.admin')

@section('title')
Dashboard|Admin
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      
            <!-- Content Row -->
            <div class="row mt-3">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Number of incoming patients (Daily)</div>
                                    <div class="h3 mt-3 font-weight-bold text-gray-600">{{ $ph }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bx bx-chart fa-3x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card card-border-shadow-warning h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Total User</div>
                                    <div class="h3 mt-3 font-weight-bold text-gray-600">{{ $tu }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bx bx-info-circle fa-3x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card card-border-shadow-success h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Request Parameter
                                    </div>
                                    <div class="h3 mt-3 font-weight-bold text-gray-600">0</div>
                                    <!-- <div class="row no-gutters align-items-center">
                                                                                                                                                                                <div class="col-auto">
                                                                                                                                                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                                                                                                                                                                </div>
                                                                                                                                                                                <div class="col">
                                                                                                                                                                                    <div class="progress progress-sm mr-2">
                                                                                                                                                                                        <div class="progress-bar bg-info" role="progressbar"
                                                                                                                                                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                                                                                                                                                            aria-valuemax="100"></div>
                                                                                                                                                                                    </div>
                                                                                                                                                                                </div>
                                                                                                                                                                            </div> -->
                                </div>
                                <div class="col-auto">
                                    <i class="bx bxs-user-check fa-3x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card card-border-shadow-info h-100">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <div class="row no-gutters">
                                <p class="h1 font-weight-bold text-gray-800 mt-3" id="waktu">00:00:00</p>
                                <span id="timeformat" class="text-gray-500 ml-2">AM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Content Row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">New User</h6>
                                <a href="/demo/adminlist" class="btn btn-xs btn-primary">view all</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-scroll table-pasien" style="width: 100%;  max-height: 550px;">
                                <table class="table table-striped table-bordered w-100 d-block d-md-table" id="myTable">
                                    <thead style="font-size: 12px;">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Access</th>
                                            <th scope="col">Joined At</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 14px">
                                        @foreach ($users as $User)
                                            <tr>
                                                <th scope="row">{{ $User->id }}</th>
                                                <td>{{ $User->name }}</td>
                                                <td>{{ $User->username }}</td>
                                                <td>{{ $User->email }}</td>
                                                <td>{{ $User->role }}</td>
                                                <td>
                                                    <span class="badge bg-info">admin</span>
                                                    <span class="badge bg-primary">loket</span>
                                                    <span class="badge bg-warning">lab</span>
                                                    <span class="badge bg-success">dokter</span>
                                                </td>
                                                <td>{{ $User->created_at }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
  </div>
@endsection

@push('script')
<script src="{{ asset('js/time.js') }}"></script>
@endpush
