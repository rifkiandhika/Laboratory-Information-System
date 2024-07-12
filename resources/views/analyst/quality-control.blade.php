@extends('master')
@section('title', 'Quality Control')

@section('content')
<div class="content" id="scroll-content">
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="d-sm-flex  mt-3">
        <h1 class="h3 mb-0 text-gray-600">Quality Control</h1>
      </div>

      <!-- Content Row -->
      <div class="row mt-2">
        <div class="col-xl-2 col-lg-2">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Menu QC</h6>
            </div>
            <div class="card-body">
              <div class="menu">
                <div class="itemed">
                  <a href="#" class="sub-menu">Hematologi<i class="bx bxs-chevron-down dropdon"></i></a>
                  <div class="sub">
                    <a href="#" class="sub-itemed">Zybio Z3</a>
                    <a href="#" class="sub-itemed">Mindray BC30</a>
                  </div>
                </div>
                <div class="itemed">
                  <a href="#" class="sub-menu">Kimia Klinik<i class="bx bxs-chevron-down dropdon"></i></a>
                  <div class="sub">
                    <a href="#" class="sub-itemed more-sub">Zybio EXC200<i class="bx bxs-chevron-down dropdon"></i></a>
                    <div class="more-sub-1">
                      <a href="#" class="sub-itemed-1">Glucose</a>
                      <a href="#" class="sub-itemed-1">Cholesterol</a>
                    </div>
                    <a href="#" class="sub-iteme more-sub">Roche Cobas C111<i class="bx bxs-chevron-down dropdon"></i></a>
                    <div class="more-sub-1">
                      <a href="#" class="sub-itemed-1">Glucose</a>
                      <a href="#" class="sub-itemed-1">Cholesterol</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-4 col-lg-4">
          <div class="card shadow mb-4">
            <div class="card-body p-3">
              <div class="tabs">
                <h6>Low</h6>
                <h6 class="active-tabs">Normal</h6>
                <h6>High</h6>
              </div>
              <div class="d-flex justify-content-end" style="margin-bottom: -15px;">
                <button class="btn btn-xs btn-outline-primary mr-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah QC</button>
                <a href="/history-qc" class="btn btn-xs btn-outline-warning">History QC</a>
              </div>
              <div class="tabs-content">
                <div class="content-load">
                  <h6></h6>
                  <p>
                    <div class="d-flex">
                      <div class="d-flex flex-column">
                        <p class="h6 font-weight-bold m-0 ">No Lot</p>
                        <p class="h6 font-weight-bold m-0 ">Control</p>
                        <p class="h6 font-weight-bold m-0">Tanggal</p>
                      </div>
                      <div class="d-flex flex-column ml-3">
                        <p class="h6 font-weight-normal m-0 ">55555</p>
                        <p class="h6 font-weight-normal m-0 ">Zybio QC</p>
                        <p class="h6 font-weight-normal m-0">25-12-23</p>
                      </div>
                    </div>
                    <div class="table-scroll table-pasien" style="overflow-y: scroll; max-height: 620px;">
                      <table class="table tabel-pasien mt-2" style="font-size: 8px;">
                        <thead>
                          <tr>
                            <th scope="col">Parameter</th>
                            <th scope="col" class="text-center">Hasil</th>
                            <th scope="col" class="text-center">Mean</th>
                            <th scope="col" class="text-center">Range</th>
                            <th scope="col" class="text-center">Batas Atas</th>
                            <th scope="col" class="text-center">Batas Bawah</th>
                            <th scope="col" class="text-center">Standart</th>
                          </tr>
                        </thead>
                        <tbody style="font-size: 10px;">
                          <tr>
                            <th scope="row">RBC</th>
                            <td class="text-center">0,13</td>
                            <td class="text-center">0,43</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">0,41</td>
                            <td class="text-center">1,25</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">Lym#</th>
                            <td class="text-center">1,23</td>
                            <td class="text-center">1,23</td>
                            <td class="text-center">0,28</td>
                            <td class="text-center">1,31</td>
                            <td class="text-center">1,15</td>
                            <td class="text-center">0,9</td>
                          </tr>
                          <tr>
                            <th scope="row">Mid%</th>
                            <td class="text-center">1,13</td>
                            <td class="text-center">1,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">1,41</td>
                            <td class="text-center">1,15</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">Gran</th>
                            <td class="text-center">1,13</td>
                            <td class="text-center">1,22</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">1,11</td>
                            <td class="text-center">1,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">Lym#</th>
                            <td class="text-center">1,13</td>
                            <td class="text-center">1,22</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">1,11</td>
                            <td class="text-center">1,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">Mid%</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">Gran</th>
                            <td class="text-center">1,23</td>
                            <td class="text-center">1,23</td>
                            <td class="text-center">0,28</td>
                            <td class="text-center">1,31</td>
                            <td class="text-center">1,15</td>
                            <td class="text-center">0,9</td>
                          </tr>
                          <tr>
                            <th scope="row">WBC</th>
                            <td class="text-center">1,23</td>
                            <td class="text-center">1,31</td>
                            <td class="text-center">1,23</td>
                            <td class="text-center">0,28</td>
                            <td class="text-center">1,15</td>
                            <td class="text-center">0,9</td>
                          </tr>
                          <tr>
                            <th scope="row">HGB</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">0,09</td>
                            <td class="text-center">2,05</td>
                          </tr>
                          <tr>
                            <th scope="row">HCT</th>
                            <td class="text-center">0,28</td>
                            <td class="text-center">1,23</td>
                            <td class="text-center">1,31</td>
                            <td class="text-center">1,15</td>
                            <td class="text-center">1,23</td>
                            <td class="text-center">0,9</td>
                          </tr>
                          <tr>
                            <th scope="row">MCV</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                            <td class="text-center">0,18</td>
                          </tr>
                          <tr>
                            <th scope="row">MCH</th>
                            <td class="text-center">1,23</td>
                            <td class="text-center">1,23</td>
                            <td class="text-center">0,9</td>
                            <td class="text-center">1,15</td>
                            <td class="text-center">1,31</td>
                            <td class="text-center">0,28</td>
                          </tr>
                          <tr>
                            <th scope="row">MCHC</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">RDW-CV</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">RDW-SD</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">PLT</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">MPV</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">PDW</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">PCT</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">P-LCR</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">P-LCC</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
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
                      <div class="d-flex flex-column">
                        <p class="h6 font-weight-bold m-0 ">No Lot</p>
                        <p class="h6 font-weight-bold m-0 ">Control</p>
                        <p class="h6 font-weight-bold m-0">Tanggal</p>
                      </div>
                      <div class="d-flex flex-column ml-3">
                        <p class="h6 font-weight-normal m-0 ">12345</p>
                        <p class="h6 font-weight-normal m-0 ">Zybio QC</p>
                        <p class="h6 font-weight-normal m-0">25-12-23</p>
                      </div>
                    </div>
                    <div class="table-scroll table-pasien" style="overflow-y: scroll; max-height: 620px;">
                      <table class="table tabel-pasien mt-2" style="font-size: 8px;">
                      <thead>
                        <tr>
                          <th scope="col">Parameter</th>
                          <th scope="col" class="text-center">Hasil</th>
                          <th scope="col" class="text-center">Mean</th>
                          <th scope="col" class="text-center">Range</th>
                          <th scope="col" class="text-center">Batas Atas</th>
                          <th scope="col" class="text-center">Batas Bawah</th>
                          <th scope="col" class="text-center">Standart</th>
                        </tr>
                      </thead>
                      <tbody style="font-size: 10px;">
                        <tr>
                          <th scope="row">RBC</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">Lym#</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">Mid%</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">Gran</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">Lym#</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">Mid%</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">Gran</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">WBC</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">HGB</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">HCT</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">MCV</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">MCH</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">MCHC</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">RDW-CV</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">RDW-SD</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">PLT</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">MPV</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">PDW</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">PCT</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">P-LCR</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
                        </tr>
                        <tr>
                          <th scope="row">P-LCC</th>
                          <td class="text-center">2,23</td>
                          <td class="text-center">2,23</td>
                          <td class="text-center">0,18</td>
                          <td class="text-center">2,41</td>
                          <td class="text-center">2,05</td>
                          <td class="text-center">0,09</td>
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
                      <div class="d-flex flex-column">
                        <p class="h6 font-weight-bold m-0 ">No Lot</p>
                        <p class="h6 font-weight-bold m-0 ">Control</p>
                        <p class="h6 font-weight-bold m-0">Tanggal</p>
                      </div>
                      <div class="d-flex flex-column ml-3">
                        <p class="h6 font-weight-normal m-0 ">03412</p>
                        <p class="h6 font-weight-normal m-0 ">Zybio QC</p>
                        <p class="h6 font-weight-normal m-0">25-12-23</p>
                      </div>
                    </div>
                    <div class="table-scroll table-pasien" style="overflow-y: scroll; max-height: 620px;">
                      <table class="table tabel-pasien mt-2" style="font-size: 8px;">
                        <thead>
                          <tr>
                            <th scope="col">Parameter</th>
                            <th scope="col" class="text-center">Hasil</th>
                            <th scope="col" class="text-center">Mean</th>
                            <th scope="col" class="text-center">Range</th>
                            <th scope="col" class="text-center">Batas Atas</th>
                            <th scope="col" class="text-center">Batas Bawah</th>
                            <th scope="col" class="text-center">Standart</th>
                          </tr>
                        </thead>
                        <tbody style="font-size: 10px;">
                          <tr>
                            <th scope="row">RBC</th>
                            <td class="text-center">5,23</td>
                            <td class="text-center">5,23</td>
                            <td class="text-center">2,18</td>
                            <td class="text-center">3,41</td>
                            <td class="text-center">3,05</td>
                            <td class="text-center">1,09</td>
                          </tr>
                          <tr>
                            <th scope="row">Lym#</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">Mid%</th>
                            <td class="text-center">1,53</td>
                            <td class="text-center">4,23</td>
                            <td class="text-center">2,68</td>
                            <td class="text-center">2,51</td>
                            <td class="text-center">3,55</td>
                            <td class="text-center">1,19</td>
                          </tr>
                          <tr>
                            <th scope="row">Gran</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">Lym#</th>
                            <td class="text-center">1,53</td>
                            <td class="text-center">3,55</td>
                            <td class="text-center">2,51</td>
                            <td class="text-center">4,23</td>
                            <td class="text-center">1,19</td>
                            <td class="text-center">2,68</td>
                          </tr>
                          <tr>
                            <th scope="row">Mid%</th>
                            <td class="text-center">2,18</td>
                            <td class="text-center">5,23</td>
                            <td class="text-center">1,09</td>
                            <td class="text-center">5,23</td>
                            <td class="text-center">3,05</td>
                            <td class="text-center">3,41</td>
                          </tr>
                          <tr>
                            <th scope="row">Gran</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">WBC</th>
                            <td class="text-center">5,23</td>
                            <td class="text-center">5,23</td>
                            <td class="text-center">2,18</td>
                            <td class="text-center">3,41</td>
                            <td class="text-center">3,05</td>
                            <td class="text-center">1,09</td>
                          </tr>
                          <tr>
                            <th scope="row">HGB</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">HCT</th>
                            <td class="text-center">1,19</td>
                            <td class="text-center">1,53</td>
                            <td class="text-center">3,55</td>
                            <td class="text-center">4,23</td>
                            <td class="text-center">2,51</td>
                            <td class="text-center">2,68</td>
                          </tr>
                          <tr>
                            <th scope="row">MCV</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">MCH</th>
                            <td class="text-center">1,53</td>
                            <td class="text-center">3,55</td>
                            <td class="text-center">2,51</td>
                            <td class="text-center">4,23</td>
                            <td class="text-center">1,19</td>
                            <td class="text-center">2,68</td>
                          </tr>
                          <tr>
                            <th scope="row">MCHC</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">RDW-CV</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">RDW-SD</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">PLT</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">MPV</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">PDW</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">PCT</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">P-LCR</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
                          </tr>
                          <tr>
                            <th scope="row">P-LCC</th>
                            <td class="text-center">2,23</td>
                            <td class="text-center">2,23</td>
                            <td class="text-center">0,18</td>
                            <td class="text-center">2,41</td>
                            <td class="text-center">2,05</td>
                            <td class="text-center">0,09</td>
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

        <!-- Content Row -->
          <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold" style="color: #96B6C5;">Grafik QC</h6>
                </div>
                <div class="card-body table-pasien" style="overflow-y: scroll; max-height: 752px;">
                  <p class="h6 font-weight-normal text-center">Grafik RBC</p>
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
                  <p class="h6 font-weight-normal text-center">Grafik Lym#</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-1" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">Grafik Mid%</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-2" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">Gran</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-3" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">Grafik Lym#</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-4" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">Grafik Mid%</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-5" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">Gran</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-6" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">WBC</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-7" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">HGB</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-8" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">HCT</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-9" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">MCV</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-10" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">MCH</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-11" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">MCHC</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-12" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">RDW-CV</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-13" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">RDW-SD</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-14" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">PLT</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-15" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">MPV</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-16" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">PDW</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-17" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">PCT</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-18" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">P-LCR</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-19" width="100%" height="40"></canvas>
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
                  <p class="h6 font-weight-normal text-center">P-LCC</p>
                  <div class="d-flex">
                    <div class="chart-area">
                      <canvas id="myAreaChart-20" width="100%" height="40"></canvas>
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
                </div>
            </div>
          </div>
      </div>
        <!-- Content Row -->
    </div>
  </div>

  {{-- core plugin --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('js/grafik-qc.js') }}"></script>

  <script src="{{ asset('../bootstrap/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
  <script src="{{ asset('../bootstrap/vendor/jquery/jquery.min.js')}}"></script>


  {{-- js --}}
  <script>
    $(document).ready(function(){
      // jquerry for toggle sub menus
      $('.sub-menu').click(function(){
        $(this).next('.sub').slideToggle();
        $(this).find('.dropdon').toggleClass('rotate');
      });
      $('.more-sub').click(function(){
        $(this).next('.more-sub-1').slideToggle();
        $(this).find('.dropdon').toggleClass('rotate');
      });
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
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Quality Control</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body py-0" style="max-height: 700px; overflow-y: auto;">
          <form action="data-qc.html" class="mt-2">
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
              <label class="col-sm-4 col-form-label">Last QC</label>
              <div class="col-sm-8">
                <input type="date" class="form-control" value="2024-02-11">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
            <!-- <button type="button" href="" class="btn btn-primary">Save</button> -->
            <a type="button" href="/analyst/daftar-qc" class="btn btn-primary">Save</a>
          </div>
      </div>
    </div>
  </div>
@endsection
