@extends('master')
@section('title', 'Data User')

@section('content')
<script src="https://unpkg.com/feather-icons"></script>

<link href="{{ asset('../bootstrap/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<div class="content" id="scroll-content">
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="d-sm-flex justify-content-between mt-3">
        <h1 class="h3 mb-2 text-gray-600">Data User</h1>
        <a href="/demo/tambah" class="button-tmbh-user" style="position: sticky; top: 75px; z-index: 100;">
          <i class="mr-1 feather-16" data-feather="user-plus"></i>
           Add New User
        </a>
      </div>

      <!-- Content Row -->
      <div class="row mt-2">
          <div class="col-xl-12">

              <!-- DataTales Example -->
              <div class="card shadow mb-4">
                  <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Data Keseluruhan User</h6>
                  </div>
                  <div class="card-body">
                      <div class="input-group mb-3">
                          <input type="text" class="form-control" placeholder="Search user..." aria-label="Cari" aria-describedby="button-addon2">
                          <div class="input-group-append">
                            <button class="btn btn-outline-teal" type="button" id="button-addon2">Search</button>
                          </div>
                      </div>
                      <div class="table-responsive">
                          <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                              <thead>
                                  <tr>
                                      <th>No</th>
                                      <th>Nama</th>
                                      <th>Username</th>
                                      <th>Email</th>
                                      <th>Role</th>
                                      <th>Akses</th>
                                      <th>Joined At</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tfoot class="mb-2">
                                  <tr>
                                      <th>No</th>
                                      <th>Nama</th>
                                      <th>Username</th>
                                      <th>Email</th>
                                      <th>Role</th>
                                      <th>Akses</th>
                                      <th>Joined At</th>
                                      <th>Action</th>
                                  </tr>
                              </tfoot>
                              <tbody>
                                  <tr>
                                      <th scope="row">1</th>
                                      <td>
                                          <div class="d-flex align-items-center">
                                              <div class="avatar mr-3"><img class="avatar-img img-fluid" src="{{ asset('../image/Gambar WhatsApp 2024-02-21 pukul 22.51.27_01f70494.jpg')}}" /></div>
                                              John Doe
                                          </div>
                                      </td>
                                      <td>johndoe</td>
                                      <td>johndoe@example.com</td>
                                      <td>Admin</td>
                                      <td>
                                      <span class="badge badge-info">admin</span>
                                      <span class="badge badge-primary">loket</span>
                                      <span class="badge " style="background-color: #f9bc22; color: #fff;">lab</span>
                                      <span class="badge" style="background-color: #30e591; color: #fff;">dokter</span>
                                      </td>
                                      <td>2023-11-07</td>
                                      <td>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="/demo/edit-user"><i data-feather="edit" class="mt-2"></i></a>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">2</th>
                                      <td>
                                          <div class="d-flex align-items-center">
                                              <div class="avatar mr-3"><img class="avatar-img img-fluid" src="{{ asset('../image/Gambar WhatsApp 2024-02-21 pukul 22.51.27_b9c38f10.jpg')}}" /></div>
                                              Jane Smith
                                          </div>
                                      </td>
                                      <td>janesmith</td>
                                      <td>janesmith@example.com</td>
                                      <td>User</td>
                                      <td>
                                          <span class="badge badge-primary">loket</span>
                                      </td>
                                      <td>2023-11-06</td>
                                      <td>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="/demo/edit-user"><i data-feather="edit" class="mt-2"></i></a>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">3</th>
                                      <td>
                                          <div class="d-flex align-items-center">
                                              <div class="avatar mr-3"><img class="avatar-img img-fluid" src="{{ asset('../image/Gambar WhatsApp 2024-02-21 pukul 22.51.27_b9c38f10.jpg')}}" /></div>
                                              Alice Johnson
                                          </div>
                                      </td>
                                      <td>alicej</td>
                                      <td>alice@example.com</td>
                                      <td>User</td>
                                      <td>
                                          <span class="badge badge-primary">loket</span>
                                      </td>
                                      <td>2023-11-05</td>
                                      <td>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="/demo/edit-user"><i data-feather="edit" class="mt-2"></i></a>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  <tr>
                                      <th scope="row">4</th>
                                      <td>
                                          <div class="d-flex align-items-center">
                                              <div class="avatar mr-3"><img class="avatar-img img-fluid" src="{{ asset('../image/Gambar WhatsApp 2024-02-21 pukul 22.51.27_01f70494.jpg')}}" /></div>
                                              Bob Williams
                                          </div>
                                      </td>
                                      <td>bobw</td>
                                      <td>bob@example.com</td>
                                      <td>User</td>
                                      <td>
                                          <span class="badge " style="background-color: #f9bc22; color: #fff;">lab</span>
                                      </td>
                                      <td>2023-11-04</td>
                                      <td>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="/demo/edit-user"><i data-feather="edit" class="mt-2"></i></a>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">5</th>
                                      <td>
                                          <div class="d-flex align-items-center">
                                              <div class="avatar mr-3"><img class="avatar-img img-fluid" src="{{ asset('../image/Gambar WhatsApp 2024-02-21 pukul 22.51.27_b9c38f10.jpg')}}" /></div>
                                              Emily Brown
                                          </div>
                                      </td>
                                      <td>emilyb</td>
                                      <td>emily@example.com</td>
                                      <td>User</td>
                                      <td>
                                          <span class="badge " style="background-color: #f9bc22; color: #fff;">lab</span>
                                          <span class="badge" style="background-color: #30e591; color: #fff;">dokter</span>
                                      </td>
                                      <td>2023-11-03</td>
                                      <td>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="/demo/edit-user"><i data-feather="edit" class="mt-2"></i></a>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">6</th>
                                      <td>
                                          <div class="d-flex align-items-center">
                                              <div class="avatar mr-3"><img class="avatar-img img-fluid" src="{{ asset('../image/Gambar WhatsApp 2024-02-21 pukul 22.51.27_01f70494.jpg')}}" /></div>
                                              David Miller
                                          </div>
                                      </td>
                                      <td>davidm</td>
                                      <td>david@example.com</td>
                                      <td>User</td>
                                      <td>
                                          <span class="badge" style="background-color: #30e591; color: #fff;">dokter</span>
                                      </td>
                                      <td>2023-11-02</td>
                                      <td>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="/demo/edit-user"><i data-feather="edit" class="mt-2"></i></a>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">7</th>
                                      <td>
                                          <div class="d-flex align-items-center">
                                              <div class="avatar mr-3"><img class="avatar-img img-fluid" src="{{ asset('../image/Gambar WhatsApp 2024-02-21 pukul 22.51.27_b9c38f10.jpg')}}" /></div>
                                              Sarah Wills
                                          </div>
                                      </td>
                                      <td>sarahw</td>
                                      <td>sarah@example.com</td>
                                      <td>User</td>
                                      <td>
                                          <span class="badge badge-primary">loket</span>
                                      </td>
                                      <td>2023-11-01</td>
                                      <td>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="/demo/edit-user"><i data-feather="edit" class="mt-2"></i></a>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">8</th>
                                      <td>
                                          <div class="d-flex align-items-center">
                                              <div class="avatar mr-3"><img class="avatar-img img-fluid" src="{{ asset('../image/Gambar WhatsApp 2024-02-21 pukul 22.51.27_01f70494.jpg')}}" /></div>
                                              Michael Johnson
                                          </div>
                                      </td>
                                      <td>michaelj</td>
                                      <td>michael@example.com</td>
                                      <td>User</td>
                                      <td>
                                          <span class="badge " style="background-color: #f9bc22; color: #fff;">lab</span>
                                      </td>
                                      <td>2023-10-31</td>
                                      <td>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="/demo/edit-user"><i data-feather="edit" class="mt-2"></i></a>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">9</th>
                                      <td>
                                          <div class="d-flex align-items-center">
                                              <div class="avatar mr-3"><img class="avatar-img img-fluid" src="{{ asset('../image/Gambar WhatsApp 2024-02-21 pukul 22.51.27_01f70494.jpg')}}" /></div>
                                              Emma Taylor
                                          </div>
                                      </td>
                                      <td>emmat</td>
                                      <td>emma@example.com</td>
                                      <td>User</td>
                                      <td>
                                          <span class="badge " style="background-color: #f9bc22; color: #fff;">lab</span>
                                      </td>
                                      <td>2023-10-30</td>
                                      <td>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="/demo/edit-user"><i data-feather="edit" class="mt-2"></i></a>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">10</th>
                                      <td>
                                          <div class="d-flex align-items-center">
                                              <div class="avatar mr-3"><img class="avatar-img img-fluid" src="{{ asset('../image/Gambar WhatsApp 2024-02-21 pukul 22.51.27_b9c38f10.jpg')}}" /></div>
                                              James Brown
                                          </div>
                                      </td>
                                      <td>jamesb</td>
                                      <td>james@example.com</td>
                                      <td>User</td>
                                      <td>
                                          <span class="badge " style="background-color: #f9bc22; color: #fff;">lab</span>
                                          <span class="badge" style="background-color: #30e591; color: #fff;">dokter</span>
                                      </td>
                                      <td>2023-10-29</td>
                                      <td>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="/demo/edit-user"><i data-feather="edit" class="mt-2"></i></a>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">11</th>
                                      <td>
                                          <div class="d-flex align-items-center">
                                              <div class="avatar mr-3"><img class="avatar-img img-fluid" src="{{ asset('../image/Gambar WhatsApp 2024-02-21 pukul 22.51.27_01f70494.jpg')}}" /></div>
                                              Olivia Smith
                                          </div>
                                      </td>
                                      <td>olivias</td>
                                      <td>olivuassss@example.com</td>
                                      <td>User</td>
                                      <td>
                                          <span class="badge " style="background-color: #f9bc22; color: #fff;">lab</span>
                                          <span class="badge" style="background-color: #30e591; color: #fff;">dokter</span>
                                      </td>
                                      <td>2023-10-29</td>
                                      <td>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="/demo/edit-user"><i data-feather="edit" class="mt-2"></i></a>
                                          <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>

      </div>
      <!-- /.container-fluid -->

  </div>


  <script>
    feather.replace();
  </script>

<script src="{{ asset('../bootstrap/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('../bootstrap/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('../bootstrap/js/demo/datatables-demo.js') }}"></script>

@endsection

@section('modal')

@endsection
