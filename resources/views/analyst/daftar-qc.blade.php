@extends('master')
@section('title', 'Daftar QC')

@section('content')
<div class="content" id="scroll-content">
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="d-sm-flex  mt-3">
        <h1 class="h3 mb-0 text-gray-600">Daftar Quality Control</h1>
      </div>
      <!-- Content Row -->
      <div class="row mt-3" style="margin-left: -20px;">
        <div class="col-xl-2 col-lg-2">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Data LOT</h6>
            </div>
            <div class="card-body">
              <p class="h6 font-weight-bold">Data Lot QC</p>
              <div class="d-flex flex-column justify-content-start">
                <button class="btn lot-btn">66666</button>
                <button class="btn lot-btn">55555</button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-10 col-lg-10">
          <div class="card shadow mb-4">
            <div class="card-body">
              <div class="d-flex">
                <div class="col-xl-1 col-lg-2 col-md-2 col-sm-2 px-0">
                  <div class="d-flex flex-column">
                    <p class="h6 font-weight-bold">No Lot</p>
                    <p class="h6 font-weight-bold">Control</p>
                    <p class="h6 font-weight-bold">Tanggal</p>
                    <p class="h6 font-weight-bold">Level</p>
                  </div>
                </div>
                <div class="col-sm-0">
                  <div class="d-flex flex-column">
                    <p class="h6 font-weight-normal">:</p>
                    <p class="h6 font-weight-normal">:</p>
                    <p class="h6 font-weight-normal">:</p>
                    <p class="h6 font-weight-normal">:</p>
                  </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                  <div class="d-flex flex-column">
                    <p class="h6 font-weight-normal">66666</p>
                    <p class="h6 font-weight-normal">Zybio QC</p>
                    <p class="h6 font-weight-normal">25-12-23</p>
                    <p class="h6 font-weight-normal">Normal</p>
                  </div>
                </div>
              </div>
              <div class="d-flex flex-row mt-2">
                <div class="col-xl-1 col-lg-1 col-md-2 col-sm-2 px-0">
                  <p class="h6 font-weight-normal">Exp Date</p>
                </div>
                <div class="col-sm-0">
                  <p class="h6 font-weight-normal">:</p>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                  <p class="h6 font-weight-normal">31-12-2024</p>
                </div>
                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1  px-0">
                  <p class="h6 font-weight-normal">Use QC</p>
                </div>
                <div class="col-sm-0">
                  <p class="h6 font-weight-normal">:</p>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                  <p class="h6 font-weight-normal">01-02-2024</p>
                </div>
                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1  px-0">
                  <p class="h6 font-weight-normal">Last QC</p>
                </div>
                <div class="col-sm-0">
                  <p class="h6 font-weight-normal">:</p>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                  <p class="h6 font-weight-normal">31-02-2024</p>
                </div>
              </div>
              <div class="d-flex justify-content-end mr-2">
                <button class="btn btn-outline-primary btn-xs mr-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit Lot</button>
                <button class="btn btn-outline-info btn-xs">Print Lot</button>
              </div>
              <div class="table-scroll table-pasien" style="overflow-y: scroll; max-height: 550px;">
                <table class="table tabel-pasien mt-2" style="font-size: 12px;">
                  <thead>
                    <tr>
                      <th scope="col">Parameter</th>
                      <th scope="col" class="text-center">Mean</th>
                      <th scope="col" class="text-center">Range</th>
                      <th scope="col" class="text-center">Batas Atas</th>
                      <th scope="col" class="text-center">Batas Bawah</th>
                      <th scope="col" class="text-center">Standart</th>
                      <th scope="col" class="text-center">Acton</th>
                    </tr>
                  </thead>
                  <tbody style="font-size: 12px;">
                    <tr>
                      <th scope="row">RBC</th>
                      <td class="text-center">0,43</td>
                      <td class="text-center">0,18</td>
                      <td class="text-center">0,41</td>
                      <td class="text-center">1,25</td>
                      <td class="text-center">0,09</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Lym#</th>
                      <td class="text-center">1,23</td>
                      <td class="text-center">0,28</td>
                      <td class="text-center">1,31</td>
                      <td class="text-center">1,15</td>
                      <td class="text-center">0,9</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Mid%</th>
                      <td class="text-center">1,23</td>
                      <td class="text-center">0,18</td>
                      <td class="text-center">1,41</td>
                      <td class="text-center">1,15</td>
                      <td class="text-center">0,09</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Gran</th>
                      <td class="text-center">1,22</td>
                      <td class="text-center">0,18</td>
                      <td class="text-center">1,11</td>
                      <td class="text-center">1,05</td>
                      <td class="text-center">0,09</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Lym#</th>
                      <td class="text-center">1,22</td>
                      <td class="text-center">0,18</td>
                      <td class="text-center">1,11</td>
                      <td class="text-center">1,05</td>
                      <td class="text-center">0,09</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Mid%</th>
                      <td class="text-center">2,23</td>
                      <td class="text-center">0,18</td>
                      <td class="text-center">2,41</td>
                      <td class="text-center">2,05</td>
                      <td class="text-center">0,09</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Gran</th>
                      <td class="text-center">1,23</td>
                      <td class="text-center">0,28</td>
                      <td class="text-center">1,31</td>
                      <td class="text-center">1,15</td>
                      <td class="text-center">0,9</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">WBC</th>
                      <td class="text-center">1,31</td>
                      <td class="text-center">1,23</td>
                      <td class="text-center">0,28</td>
                      <td class="text-center">1,15</td>
                      <td class="text-center">0,9</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">HGB</th>
                      <td class="text-center">2,41</td>
                      <td class="text-center">2,23</td>
                      <td class="text-center">0,18</td>
                      <td class="text-center">0,09</td>
                      <td class="text-center">2,05</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">HCT</th>
                      <td class="text-center">1,23</td>
                      <td class="text-center">1,31</td>
                      <td class="text-center">1,15</td>
                      <td class="text-center">1,23</td>
                      <td class="text-center">0,9</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">MCV</th>
                      <td class="text-center">2,41</td>
                      <td class="text-center">2,23</td>
                      <td class="text-center">2,05</td>
                      <td class="text-center">0,09</td>
                      <td class="text-center">0,18</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">MCH</th>
                      <td class="text-center">1,23</td>
                      <td class="text-center">0,9</td>
                      <td class="text-center">1,15</td>
                      <td class="text-center">1,31</td>
                      <td class="text-center">0,28</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">MCHC</th>
                      <td class="text-center">2,23</td>
                      <td class="text-center">0,18</td>
                      <td class="text-center">2,41</td>
                      <td class="text-center">2,05</td>
                      <td class="text-center">0,09</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">RDW-CV</th>
                      <td class="text-center">2,23</td>
                      <td class="text-center">0,18</td>
                      <td class="text-center">2,41</td>
                      <td class="text-center">2,05</td>
                      <td class="text-center">0,09</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">RDW-SD</th>
                      <td class="text-center">2,23</td>
                      <td class="text-center">0,18</td>
                      <td class="text-center">2,41</td>
                      <td class="text-center">2,05</td>
                      <td class="text-center">0,09</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">PLT</th>
                      <td class="text-center">2,23</td>
                      <td class="text-center">0,18</td>
                      <td class="text-center">2,41</td>
                      <td class="text-center">2,05</td>
                      <td class="text-center">0,09</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">MPV</th>
                      <td class="text-center">2,23</td>
                      <td class="text-center">0,18</td>
                      <td class="text-center">2,41</td>
                      <td class="text-center">2,05</td>
                      <td class="text-center">0,09</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">PDW</th>
                      <td class="text-center">2,23</td>
                      <td class="text-center">0,18</td>
                      <td class="text-center">2,41</td>
                      <td class="text-center">2,05</td>
                      <td class="text-center">0,09</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">PCT</th>
                      <td class="text-center">2,23</td>
                      <td class="text-center">0,18</td>
                      <td class="text-center">2,41</td>
                      <td class="text-center">2,05</td>
                      <td class="text-center">0,09</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">P-LCR</th>
                      <td class="text-center">2,23</td>
                      <td class="text-center">0,18</td>
                      <td class="text-center">2,41</td>
                      <td class="text-center">2,05</td>
                      <td class="text-center">0,09</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">P-LCC</th>
                      <td class="text-center">2,23</td>
                      <td class="text-center">0,18</td>
                      <td class="text-center">2,41</td>
                      <td class="text-center">2,05</td>
                      <td class="text-center">0,09</td>
                      <td class="text-center">
                        <a href="#" class="mr-2" data-toggle="modal" data-target="#exampleModalCenter" tooltip="Tambah Ranges"><i class="fas fa-plus" style="font-size: 16px;"></i></a>
                        <a href="#" tooltip="Edit" class="tombol-pen" data-toggle="modal" data-target="#exampleModalCenter-1"><i class="fas fa-pen" style="font-size: 16px;"></i></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      </div>
      <!-- Content Row -->
  </div>
@endsection

@section('modal')
<!-- modal 1 -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit LOT Quality Control</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body py-0" style="max-height: 700px; overflow-y: auto;">
          <form action="#" class="mt-2">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">No Lot</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="55555">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nama Control</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="Zybio Z3">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Level</label>
              <div class="col-sm-8">
                <select class="form-control" name="dropdown" id="dropdown">
                  <option selected>Pilih Level</option>
                  <option value="1">Low</option>
                  <option value="2">Normal</option>
                  <option value="3">High</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Exp Date</label>
              <div class="col-sm-8">
                <input type="date" class="form-control" value="2024-02-22">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Use QC</label>
              <div class="col-sm-8">
                <input type="date" class="form-control" value="2024-02-10">
              </div>
            </div>
            <div class="form-group row">
              <labe class="col-sm-4 col-form-label">Last QC</labe>
              <div class="col-sm-8">
                <input type="date" class="form-control" value="2024-02-11">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
            <!-- <button type="button" href="" class="btn btn-primary">Save</button> -->
            <a type="button" href="daftar-qc.html" class="btn btn-primary">Save</a>
          </div>
      </div>
    </div>
  </div>
  <!-- modal 2 -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Tambah Mean dan Range</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="#" class="mt-2">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nilai Mean</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="Masukan nilai mean">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nilai Range</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="Masukan nilai range">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <!-- modal 3 -->
  <div class="modal fade" id="exampleModalCenter-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Edit Mean dan Range</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="#" class="mt-2">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nilai Mean</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="Masukan nilai mean">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nilai Range</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="Masukan nilai range">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
@endsection
