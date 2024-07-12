@extends('master')
@section('title', 'Data Parameter')

@section('content')
<script src="https://unpkg.com/feather-icons"></script>

<link href="{{ asset('../bootstrap/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<div class="content" id="scroll-content">
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="d-sm-flex justify-content-between mt-3">
        <h1 class="h3 mb-2 text-gray-600">Data Parameter</h1>
        <a class="button-tmbh-user" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal">
          <i class="mr-1 feather-16" data-feather="plus"></i>
           Add Parameter
        </a>
      </div>

      <!-- Content Row -->
      <div class="row mt-2">
          <div class="col-xl-12">

              <!-- DataTales Example -->
              <div class="card shadow mb-4">
                  <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Data Keseluruhan Parameter</h6>
                  </div>
                  <div class="card-body">
                      <div class="input-group mb-3">
                          <input type="text" class="form-control" placeholder="Search Parameter..." aria-label="Cari" aria-describedby="button-addon2">
                          <div class="input-group-append">
                            <button class="btn btn-outline-teal" type="button" id="button-addon2">Search</button>
                          </div>
                      </div>
                      <div class="table-responsive">
                          <table class="table table-striped" id="tabel-data" width="100%" cellspacing="0">
                              <thead>
                                  <tr>
                                      <th>No</th>
                                      <th>Departement</th>
                                      <th>Nama Parameter</th>
                                      <th>Deskripsi</th>
                                      <th>Harga</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tfoot class="mb-2">
                                  <tr>
                                      <th>No</th>
                                      <th>Departement</th>
                                      <th>Nama Parameter</th>
                                      <th>Deskripsi</th>
                                      <th>Harga</th>
                                      <th>Action</th>
                                  </tr>
                              </tfoot>
                              <tbody>
                                  <tr>
                                      <th scope="row" class="align-items-center">1</th>
                                      <td class="align-items-center">Hematologi</td>
                                      <td class="align-items-center">Darah Lengkap Cell Dyn</td>
                                      <td>Darah Lengkap Deskripsi</td>
                                      <td>Rp. 300.000</td>
                                      <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-1"><i data-feather="edit"></i></button>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row" class="align-items-center">2</th>
                                      <td class="align-items-center">Hematologi</td>
                                      <td class="align-items-center">Eosinofil</td>
                                      <td>Eosinofil Deskripsi</td>
                                      <td>Rp. 300.000</td>
                                      <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-1"><i data-feather="edit"></i></button>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row" class="align-items-center">3</th>
                                      <td class="align-items-center">Hematologi</td>
                                      <td class="align-items-center">Hematokrit</td>
                                      <td>Hematokrit Deskripsi</td>
                                      <td>Rp. 300.000</td>
                                      <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-1""><i data-feather="edit"></i></button>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row" class="align-items-center">4</th>
                                      <td class="align-items-center">Hematologi</td>
                                      <td class="align-items-center">Hemoglobin</td>
                                      <td>Hemoglobin Deskripsi</td>
                                      <td>Rp. 300.000</td>
                                      <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-1"><i data-feather="edit"></i></button>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row" class="align-items-center">5</th>
                                      <td class="align-items-center">Hematologi</td>
                                      <td class="align-items-center">Leukosit</td>
                                      <td>Leukosit Deskripsi</td>
                                      <td>Rp. 300.000</td>
                                      <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-1"><i data-feather="edit"></i></button>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row" class="align-items-center">6</th>
                                      <td class="align-items-center">Hematologi</td>
                                      <td class="align-items-center">PPT</td>
                                      <td>PPT Deskripsi</td>
                                      <td>Rp. 300.000</td>
                                      <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-1"><i data-feather="edit"></i></button>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row" class="align-items-center">7</th>
                                      <td class="align-items-center">Hematologi</td>
                                      <td class="align-items-center">KPPT</td>
                                      <td>KPPT Deskripsi</td>
                                      <td>Rp. 300.000</td>
                                      <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-1"><i data-feather="edit"></i></button>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row" class="align-items-center">8</th>
                                      <td class="align-items-center">Urine</td>
                                      <td class="align-items-center">UL</td>
                                      <td>UL Deskripsi</td>
                                      <td>Rp. 300.000</td>
                                      <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-1"><i data-feather="edit"></i></button>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row" class="align-items-center">9</th>
                                      <td class="align-items-center">Urine</td>
                                      <td class="align-items-center">Protein</td>
                                      <td>Protein Deskripsi</td>
                                      <td>Rp. 300.000</td>
                                      <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-1"><i data-feather="edit"></i></button>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row" class="align-items-center">10</th>
                                      <td class="align-items-center">Urine</td>
                                      <td class="align-items-center">Glukosa</td>
                                      <td>Glukosa Deskripsi</td>
                                      <td>Rp. 300.000</td>
                                      <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-1"><i data-feather="edit"></i></button>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row" class="align-items-center">10</th>
                                      <td class="align-items-center">Urine</td>
                                      <td class="align-items-center">Urobilin</td>
                                      <td>Urobilin Deskripsi</td>
                                      <td>Rp. 300.000</td>
                                      <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-1"><i data-feather="edit"></i></button>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row" class="align-items-center">11</th>
                                      <td class="align-items-center">Urine</td>
                                      <td class="align-items-center">Bilirubin</td>
                                      <td>Bilirubin Deskripsi</td>
                                      <td>Rp. 300.000</td>
                                      <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-1"><i data-feather="edit"></i></button>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row" class="align-items-center">12</th>
                                      <td class="align-items-center">Immunoserologi</td>
                                      <td class="align-items-center">Hbs Ag (Elisa)</td>
                                      <td>Hbs Ag (Ellisa) Deskripsi</td>
                                      <td>Rp. 300.000</td>
                                      <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-1"><i data-feather="edit"></i></button>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row" class="align-items-center">13</th>
                                      <td class="align-items-center">Immunoserologi</td>
                                      <td class="align-items-center">Anti HBs (Elisa)</td>
                                      <td>Anti HBs (Ellisa) Deskripsi</td>
                                      <td>Rp. 300.000</td>
                                      <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-1"><i data-feather="edit"></i></button>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row" class="align-items-center">14</th>
                                      <td class="align-items-center">Immunoserologi</td>
                                      <td class="align-items-center">Anti HBc</td>
                                      <td>Anti HBc Deskripsi</td>
                                      <td>Rp. 300.000</td>
                                      <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-1"><i data-feather="edit"></i></button>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!"><i data-feather="trash-2" class="mt-2"></i></a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row" class="align-items-center">15</th>
                                      <td class="align-items-center">Immunoserologi</td>
                                      <td class="align-items-center">Widal</td>
                                      <td>Widal Deskripsi</td>
                                      <td>Rp. 300.000</td>
                                      <td>
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-1"><i data-feather="edit"></i></button>
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
  <script src="{{ asset('../bootstrap/js/demo/tables-data.js') }}"></script>
@endsection

@section('modal')
<!-- Modal Tambah Parameter -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Data Parameter</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body py-0" style="max-height: 700px; overflow-y: auto;">
          <form action="#" class="mt-2">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Departement</label>
              <div class="col-sm-8">
                <select class="form-control" name="dropdown" id="dropdown">
                  <option selected>Pilih Departement</option>
                  <option value="1">Hematologi</option>
                  <option value="2">Urinalisa</option>
                  <option value="3">Immunoserologi</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nama Parameter</label>
              <div class="col-sm-8">
                <input type="text" class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Deskripsi</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="Deskripsi Parameter">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Harga</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="Harga Parameter">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
            <!-- <button type="button" href="" class="btn btn-primary">Save</button> -->
            <a type="button" href="#!" class="btn btn-primary">Tambah</a>
          </div>
      </div>
    </div>
  </div>
  <!-- End Modal Tambah Parameter -->

  <!-- Modal Edit Parameter -->
  <div class="modal fade" id="exampleModal-1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Data Parameter</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body py-0" style="max-height: 700px; overflow-y: auto;">
          <form action="#" class="mt-2">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Departement</label>
              <div class="col-sm-8">
                <select class="form-control" name="dropdown" id="dropdown">
                  <option value="">Pilih Departement</option>
                  <option selected>Hematologi</option>
                  <option value="2">Urinalisa</option>
                  <option value="3">Immunoserologi</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nama Parameter</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" value="Leukosit">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Deskripsi</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" value="Leukosit deskripsi....">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Harga</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" value="Rp. 300.000">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
            <!-- <button type="button" href="" class="btn btn-primary">Save</button> -->
            <a type="button" href="#!" class="btn btn-primary">Save</a>
          </div>
      </div>
    </div>
  </div>
@endsection
