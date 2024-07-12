@extends('master')
@section('title', 'History QC')

@section('content')
{{-- CDN --}}


<div class="content" id="scroll-content">
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="d-sm-flex  mt-3">
        <h1 class="h3 mb-0 text-gray-600">History Quality Control</h1>
      </div>

      <!-- Content Row -->
      <div class="row mt-3">

      </div>
      <!-- Content Row -->
      <div class="row">
          <div class="col-12">
              <div class="card shadow mb-4">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">History Quality Control</h6>
                  </div>
                  <div class="card-body">
                      <div class="tabs">
                          <h6>Low</h6>
                          <h6 class="active-tabs">Normal</h6>
                          <h6>High</h6>
                      </div>
                      <div class="tabs-content">
                          <div class="content-load">
                            <h6></h6>
                            <p>
                              <div class="d-flex">
                                <div class="col-xl-1 col-lg-2 col-md-2 col-sm-2 px-0">
                                  <div class="d-flex flex-column my-0">
                                    <p class="h6 font-weight-bold my-0">No Lot</p>
                                    <p class="h6 font-weight-bold my-0">Control</p>
                                    <p class="h6 font-weight-bold my-0">Tanggal</p>
                                    <p class="h6 font-weight-bold my-0">Mean</p>
                                    <p class="h6 font-weight-bold my-0">Range</p>
                                  </div>
                                </div>
                                <div class="col-sm-0">
                                  <div class="d-flex flex-column my-0">
                                    <p class="h6 font-weight-normal my-0">:</p>
                                    <p class="h6 font-weight-normal my-0">:</p>
                                    <p class="h6 font-weight-normal my-0">:</p>
                                    <p class="h6 font-weight-normal my-0">:</p>
                                    <p class="h6 font-weight-normal my-0">:</p>
                                  </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-2 col-sm-2">
                                  <div class="d-flex flex-column">
                                    <p class="h6 font-weight-normal my-0">55555</p>
                                    <p class="h6 font-weight-normal my-0">Zybio QC</p>
                                    <p class="h6 font-weight-normal my-0">25-12-23</p>
                                    <p class="h6 font-weight-normal my-0">0.89</p>
                                    <p class="h6 font-weight-normal my-0">0.78</p>
                                  </div>
                                </div>
                              </div>
                              <hr>
                              <p class="h6 font-weight-normal">Pilih Bulan History</p>
                              <input type="text" class="form-control mb-1" name="datepicker" id="datepicker" style="width: 8%;"/>
                              <div class="table-scroll table-pasien" style="overflow-y: scroll; max-height: 420px;">
                                <table class="table tabel-pasien mt-2" style="font-size: 10px;">
                                  <thead style="position: sticky; top: 0; background-color: #fff;">
                                    <tr>
                                      <th scope="col">Tanggal</th>
                                      <th scope="col" class="text-center">WBC</th>
                                      <th scope="col" class="text-center">RBC</th>
                                      <th scope="col" class="text-center">Lym#</th>
                                      <th scope="col" class="text-center">Mid%</th>
                                      <th scope="col" class="text-center">Gran</th>
                                      <th scope="col" class="text-center">Lym#</th>
                                      <th scope="col" class="text-center">Mid%</th>
                                      <th scope="col" class="text-center">Gran</th>
                                      <th scope="col" class="text-center">HGB</th>
                                      <th scope="col" class="text-center">HCT</th>
                                      <th scope="col" class="text-center">MCV</th>
                                      <th scope="col" class="text-center">MCH</th>
                                      <th scope="col" class="text-center">MCHC</th>
                                      <th scope="col" class="text-center">RDW-CV</th>
                                      <th scope="col" class="text-center">RDW-SD</th>
                                      <th scope="col" class="text-center">PLT</th>
                                      <th scope="col" class="text-center">MPV</th>
                                      <th scope="col" class="text-center">PDW</th>
                                      <th scope="col" class="text-center">PCT</th>
                                      <th scope="col" class="text-center">P-LCR</th>
                                      <th scope="col" class="text-center">P-LCC</th>
                                    </tr>
                                  </thead>
                                  <tbody style="font-size: 10px;">
                                    <tr style="position: sticky; top: 50px; background-color: #fff;">
                                      <th scope="row">Graph</th>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                    </tr>
                                    <tr>
                                      <th scope="row">01-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">02-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">03-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">04-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">05-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">06-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">07-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">08-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">09-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">09-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </p>
                          </div>
                          <div class="content-load active-tabs">
                            <h6></h6>
                            <p>
                              <div class="d-flex">
                                <div class="col-xl-1 col-lg-2 col-md-2 col-sm-2 px-0">
                                  <div class="d-flex flex-column my-0">
                                    <p class="h6 font-weight-bold my-0">No Lot</p>
                                    <p class="h6 font-weight-bold my-0">Control</p>
                                    <p class="h6 font-weight-bold my-0">Tanggal</p>
                                    <p class="h6 font-weight-bold my-0">Mean</p>
                                    <p class="h6 font-weight-bold my-0">Range</p>
                                  </div>
                                </div>
                                <div class="col-sm-0">
                                  <div class="d-flex flex-column my-0">
                                    <p class="h6 font-weight-normal my-0">:</p>
                                    <p class="h6 font-weight-normal my-0">:</p>
                                    <p class="h6 font-weight-normal my-0">:</p>
                                    <p class="h6 font-weight-normal my-0">:</p>
                                    <p class="h6 font-weight-normal my-0">:</p>
                                  </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-2 col-sm-2">
                                  <div class="d-flex flex-column">
                                    <p class="h6 font-weight-normal my-0">66666</p>
                                    <p class="h6 font-weight-normal my-0">Zybio QC</p>
                                    <p class="h6 font-weight-normal my-0">25-12-23</p>
                                    <p class="h6 font-weight-normal my-0">0.9</p>
                                    <p class="h6 font-weight-normal my-0">0.8</p>
                                  </div>
                                </div>
                              </div>
                              <hr>
                              <p class="h6 font-weight-normal">Pilih Bulan History</p>
                              <input type="text" class="form-control mb-1" name="datepicker" id="datepicker" style="width: 8%;"/>
                              <div class="table-scroll table-pasien" style="overflow-y: scroll; max-height: 420px;">
                                <table class="table tabel-pasien mt-2" style="font-size: 10px;">
                                  <thead style="position: sticky; top: 0; background-color: #fff;">
                                    <tr>
                                      <th scope="col">Tanggal</th>
                                      <th scope="col" class="text-center">WBC</th>
                                      <th scope="col" class="text-center">RBC</th>
                                      <th scope="col" class="text-center">Lym#</th>
                                      <th scope="col" class="text-center">Mid%</th>
                                      <th scope="col" class="text-center">Gran</th>
                                      <th scope="col" class="text-center">Lym#</th>
                                      <th scope="col" class="text-center">Mid%</th>
                                      <th scope="col" class="text-center">Gran</th>
                                      <th scope="col" class="text-center">HGB</th>
                                      <th scope="col" class="text-center">HCT</th>
                                      <th scope="col" class="text-center">MCV</th>
                                      <th scope="col" class="text-center">MCH</th>
                                      <th scope="col" class="text-center">MCHC</th>
                                      <th scope="col" class="text-center">RDW-CV</th>
                                      <th scope="col" class="text-center">RDW-SD</th>
                                      <th scope="col" class="text-center">PLT</th>
                                      <th scope="col" class="text-center">MPV</th>
                                      <th scope="col" class="text-center">PDW</th>
                                      <th scope="col" class="text-center">PCT</th>
                                      <th scope="col" class="text-center">P-LCR</th>
                                      <th scope="col" class="text-center">P-LCC</th>
                                    </tr>
                                  </thead>
                                  <tbody style="font-size: 10px;">
                                    <tr style="position: sticky; top: 50px; background-color: #fff;">
                                      <th scope="row">Graph</th>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                    </tr>
                                    <tr>
                                      <th scope="row">01-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">02-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">03-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">04-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">05-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">06-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">07-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">08-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">09-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">09-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </p>
                          </div>
                          <div class="content-load">
                            <h6></h6>
                            <p>
                              <div class="d-flex">
                                <div class="col-xl-1 col-lg-2 col-md-2 col-sm-2 px-0">
                                  <div class="d-flex flex-column my-0">
                                    <p class="h6 font-weight-bold my-0">No Lot</p>
                                    <p class="h6 font-weight-bold my-0">Control</p>
                                    <p class="h6 font-weight-bold my-0">Tanggal</p>
                                    <p class="h6 font-weight-bold my-0">Mean</p>
                                    <p class="h6 font-weight-bold my-0">Range</p>
                                  </div>
                                </div>
                                <div class="col-sm-0">
                                  <div class="d-flex flex-column my-0">
                                    <p class="h6 font-weight-normal my-0">:</p>
                                    <p class="h6 font-weight-normal my-0">:</p>
                                    <p class="h6 font-weight-normal my-0">:</p>
                                    <p class="h6 font-weight-normal my-0">:</p>
                                    <p class="h6 font-weight-normal my-0">:</p>
                                  </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-2 col-sm-2">
                                  <div class="d-flex flex-column">
                                    <p class="h6 font-weight-normal my-0">45454</p>
                                    <p class="h6 font-weight-normal my-0">Zybio QC</p>
                                    <p class="h6 font-weight-normal my-0">25-12-23</p>
                                    <p class="h6 font-weight-normal my-0">1.9</p>
                                    <p class="h6 font-weight-normal my-0">1.8</p>
                                  </div>
                                </div>
                              </div>
                              <hr>
                              <p class="h6 font-weight-normal">Pilih Bulan History</p>
                              <input type="text" class="form-control mb-1" name="datepicker" id="datepicker" style="width: 8%;"/>
                              <div class="table-scroll table-pasien" style="overflow-y: scroll; max-height: 420px;">
                                <table class="table tabel-pasien mt-2" style="font-size: 10px;">
                                  <thead style="position: sticky; top: 0; background-color: #fff;">
                                    <tr>
                                      <th scope="col">Tanggal</th>
                                      <th scope="col" class="text-center">WBC</th>
                                      <th scope="col" class="text-center">RBC</th>
                                      <th scope="col" class="text-center">Lym#</th>
                                      <th scope="col" class="text-center">Mid%</th>
                                      <th scope="col" class="text-center">Gran</th>
                                      <th scope="col" class="text-center">Lym#</th>
                                      <th scope="col" class="text-center">Mid%</th>
                                      <th scope="col" class="text-center">Gran</th>
                                      <th scope="col" class="text-center">HGB</th>
                                      <th scope="col" class="text-center">HCT</th>
                                      <th scope="col" class="text-center">MCV</th>
                                      <th scope="col" class="text-center">MCH</th>
                                      <th scope="col" class="text-center">MCHC</th>
                                      <th scope="col" class="text-center">RDW-CV</th>
                                      <th scope="col" class="text-center">RDW-SD</th>
                                      <th scope="col" class="text-center">PLT</th>
                                      <th scope="col" class="text-center">MPV</th>
                                      <th scope="col" class="text-center">PDW</th>
                                      <th scope="col" class="text-center">PCT</th>
                                      <th scope="col" class="text-center">P-LCR</th>
                                      <th scope="col" class="text-center">P-LCC</th>
                                    </tr>
                                  </thead>
                                  <tbody style="font-size: 10px;">
                                    <tr style="position: sticky; top: 50px; background-color: #fff;">
                                      <th scope="row">Graph</th>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                      <td class="text-center"><button class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModal">view</button></td>
                                    </tr>
                                    <tr>
                                      <th scope="row">01-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">02-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">03-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">04-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">05-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">06-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">07-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">08-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">09-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                    <tr>
                                      <th scope="row">09-12-23</th>
                                      <td class="text-center">0.2</td>
                                      <td class="text-center">0.4</td>
                                      <td class="text-center">1.0</td>
                                      <td class="text-center">1.8</td>
                                      <td class="text-center">0.1</td>
                                      <td class="text-center">0.8</td>
                                      <td class="text-center">0.3</td>
                                      <td class="text-center">0.6</td>
                                      <td class="text-center">1.2</td>
                                      <td class="text-center">1.4</td>
                                      <td class="text-center">1.1</td>
                                      <td class="text-center">1.5</td>
                                      <td class="text-center">1.3</td>
                                      <td class="text-center">0.5</td>
                                      <td class="text-center">0.7</td>
                                      <td class="text-center">1.7</td>
                                      <td class="text-center">1.6</td>
                                      <td class="text-center">0.9</td>
                                      <td class="text-center">1.9</td>
                                      <td class="text-center">2.0</td>
                                      <td class="text-center">0.4</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </p>
                          </div>
                        </div>
                  </div>
              </div>
          </div>
      </div>

  </div>

{{-- core plugin --}}
{{-- <script src="{{ asset('../bootstrap/vendor/jquery-easing/jquery.easing.min.js')}}"></script> --}}
<script src="{{ asset('../bootstrap/vendor/jquery/jquery.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
$("#datepicker").datepicker( {
    format: "mm-yyyy",
    startView: "months",
    minViewMode: "months"
});
</script>

<script>
    let tabs = document.querySelectorAll('.tabs h6');
    let tabContents = document.querySelectorAll('.content-load');

    tabs.forEach((tab, index) => {
      tab.addEventListener('click', () => {
        tabContents.forEach(content => {
          content.classList.remove('active-tabs');
          });
          tabs.forEach(tab => {
            tab.classList.remove('active-tabs');
          });
          tabContents[index].classList.add('active-tabs');
          tabs[index].classList.add('active-tabs');
       });
    });
  </script>
@endsection


@section('modal')
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">History Sampling</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body py-0" style="max-height: 700px; overflow-y: auto;">
          <p class="h6 font-weight-normal text-center mt-2">Grafik RBC</p>
          <div class="d-flex">
            <div class="chart-area">
              <canvas id="myAreaChart" width="100%" height="40"></canvas>
            </div>
            <div class="d-flex flex-column mt-2" style="margin-left: -9px;">
              <span class="ket-sd" style="border-color: #82A0D8; color: #82A0D8;">+3SD</span>
              <span class="ket-sd" style="border-color: #F9B572; color: #F9B572;">+2SD</span>
              <span class="ket-sd" style="border-color: #9BABB8; color: #9BABB8;">+1SD</span>
              <span class="ket-sd text-center" style="border-color: #FF8080; color: #FF8080;">x</span>
              <span class="ket-sd" style="border-color: #88AB8E; color: #88AB8E;">-1SD</span>
              <span class="ket-sd" style="border-color: #8EACCD; color: #8EACCD;">-2SD</span>
              <span class="ket-sd" style="border-color: #DBCC95; color: #DBCC95;">-3SD</span>
            </div>
          </div>
          <hr>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



<script>
    // rbc graph
    // Area Chart Example
var xtc = document.getElementById("myAreaChart");
var myLineChart = new Chart(xtc, {
  type: 'line',
  data: {
    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    datasets: [
      {
        label: 'Data QC',
        data: [227, 219, 219, 215, 232, 225, 230, 216, 221, 229, 228, 218, 232, 224, 227, 226, 219, 217, 223, 232, 216, 228, 220, 232, 215, 218, 231, 230, 219, 223, 221],
        borderWidth: 2,
        pointRadius: 2,
        lineTension: 0.4,
        backgroundColor: '#00ba94',
        borderColor: '#00ba94',
      },
      {
        label: 'x-3SD',
        data: [191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191, 191],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#DBCC95',
        borderColor: '#DBCC95',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-2SD',
        data: [201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201, 201],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#8EACCD',
        borderColor: '#8EACCD',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x-1SD',
        data: [211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211, 211],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#88AB8E',
        borderColor: '#88AB8E',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x',
        data: [221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221, 221],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#FF8080',
        borderColor: '#FF8080',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+1SD',
        data: [231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231, 231],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#9BABB8',
        borderColor: '#9BABB8',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+2SD',
        data: [241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241, 241],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#F9B572',
        borderColor: '#F9B572',
        tooltips: {
          enabled: false
        }
      },
      {
        label: 'x+3SD',
        data: [252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252, 252],
        borderWidth: 1,
        pointRadius: 0,
        backgroundColor: '#82A0D8',
        borderColor: '#82A0D8',
        tooltips: {
          enabled: false
        }
      },
    ]
  },
  options: {
    responsive: true, // Aktifkan responsif
    maintainAspectRatio: false, // Nonaktifkan rasio aspek agar grafik dapat meregang
    plugins: {
        legend: {
          display: false,
          position: 'bottom',
          align: 'center',
          labels: {
            font: {
              size: 10,
              color: '#000000'
            },
            //atur jarak antar label
          }
        }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 185,
        max: 255,
        ticks: {
        stepSize: 10, // Nilai langkah antar label pada sumbu Y
      }
      }
    }
  }
});
</script>
@endsection
