<title>Report</title>
@extends('layouts.admin')

@section('title', 'Report')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex  my-3">
                <h1 class="h3 mb-0 text-gray-600">Report</h1>
            </div>
            <!-- Content Row -->
            <!-- Area chart example-->
            <div class="col-12 mb-6">
                <div class="card">
                  <div
                    class="card-header d-flex justify-content-between align-items-md-center align-items-start"
                  >
                    <h5 class="card-title mb-0">Pendapatan Lab Pertahun</h5>
                    <div class="dropdown">
                      <button
                        type="button"
                        class="btn dropdown-toggle p-0"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        <i class="ti ti-calendar"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                          <a
                            href="javascript:void(0);"
                            class="dropdown-item d-flex align-items-center"
                            >Today</a
                          >
                        </li>
                        <li>
                          <a
                            href="javascript:void(0);"
                            class="dropdown-item d-flex align-items-center"
                            >Yesterday</a
                          >
                        </li>
                        <li>
                          <a
                            href="javascript:void(0);"
                            class="dropdown-item d-flex align-items-center"
                            >Last 7 Days</a
                          >
                        </li>
                        <li>
                          <a
                            href="javascript:void(0);"
                            class="dropdown-item d-flex align-items-center"
                            >Last 30 Days</a
                          >
                        </li>
                        <li>
                          <hr class="dropdown-divider" />
                        </li>
                        <li>
                          <a
                            href="javascript:void(0);"
                            class="dropdown-item d-flex align-items-center"
                            >Current Month</a
                          >
                        </li>
                        <li>
                          <a
                            href="javascript:void(0);"
                            class="dropdown-item d-flex align-items-center"
                            >Last Month</a
                          >
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="card-body">
                    <div id="barChart"></div>
                  </div>
                </div>
              </div>

            <div class="row">
                <div class="col-lg-6">
                    <!-- Bar chart example-->
                    <div class="card mb-4">
                        <div class="card-header">Total Pemasukan Example</div>
                        <div class="card-body">
                            <div class="chart-bar"><canvas id="myBarChart" width="100%" height="50"></canvas></div>
                        </div>
                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- Pie chart example-->
                    <div class="card mb-4">
                        <div class="card-header">Diagram Pemeriksaan Example</div>
                        <div class="card-body">
                            <div class="chart-pie"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
                        </div>
                        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                    </div>
                </div>
            </div>

            <!-- Form Area -->
        </div>

        <!-- Page level plugins -->
        <script src="{{ asset('bootstrap/vendor/chart.js/Chart.min.js') }}"></script>

        <!-- Page level custom scripts -->
        <script src="{{ asset('bootstrap/js/demo/chart-area-demo.js') }}"></script>
        <script src="{{ asset('bootstrap/js/demo/chart-pie-demo.js') }}"></script>
        <script src="{{ asset('bootstrap/js/demo/chart-bar-demo.js') }}"></script>
    @endsection
