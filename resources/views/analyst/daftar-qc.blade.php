{{-- @extends('layouts.admin')
@section('content')
<style>
/* Styling for the dropdown text */
.drop-text {
    background-color: transparent;
    color: #333;
    padding: 16px;
    font-size: 16px;
    cursor: pointer;
    border-bottom: 1px solid #ddd;
}

/* Container for dropdown */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown content, initially hidden */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    overflow: hidden;
    max-height: 0;
    transition: max-height 0.4s ease-out;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

/* Hover effect for dropdown items */
.dropdown-content a:hover {
    background-color: #f1f1f1;
}

/* When dropdown is active, expand */
.dropdown-content.show {
    display: block;
    max-height: 200px; /* Adjust based on your content */
    transition: max-height 0.4s ease-in;
}

.nav-tabs .nav-item {
    flex: 1 1 auto; /* Make each tab take an equal portion of the available space */
    text-align: center; /* Center align the text */
}

.nav-tabs .nav-link {
    width: 100%;
}


</style>
   <div class="container-fluid">
      {{-- Judul --}}
      

      @extends('layouts.admin')
      @section('content')
        <div class="container-fluid">
          <div class="d-sm-flex  my-3">
            <h1 class="h3 mb-0 text-gray-600">List Quality Control</h1>
         </div>
      
            <div class="row mt-2">
                <div class="col-xl-3 col-lg-3">
                  <div class="card shadow mb-4">
                      <div class="card-header p-3 fw-bold" style="background-color: #f8f9fc; border-bottom: 0.5px solid lightgray">Data LOT</div>
                      <div class="card-body">
                        <div class="d-flex justify-content-end mt-2">
                          <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="ti ti-plus"></i></button> <span> </span>
                          <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal1" data-bs-target="#parameter"><i class="ti ti-adjustments-horizontal"></i></button>
                        </div>
                       <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Add Quality Control</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                              <hr>
                              <div class="modal-body py-0" style="max-height: 700px; overflow-y: auto;">
                                <form action="/analyst/insert_qc" method="POST" class="mt-2">
                                  @csrf
                                    <div class="form-group row">
                                      <label class="col-sm-4 col-form-label mb-3">No Lot</label>
                                      <div class="col-sm-8">
                                        <input required type="text" name="no_lot" class="form-control" placeholder="No Lot">
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="col-sm-4 col-form-label mb-3">Nama Control</label>
                                      <div class="col-sm-8">
                                        <input required type="text" name="name_control" class="form-control" placeholder="Nama Control">
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="col-sm-4 col-form-label mb-3">Level</label>
                                      <div class="col-sm-8">
                                        <select class="form-control" name="level" id="dropdown">
                                          <option selected>Pilih Level</option>
                                          <option value="Low">Low</option>
                                          <option value="Normal">Normal</option>
                                          <option value="High">High</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="col-sm-4 col-form-label mb-3">Department</label>
                                      <div class="col-sm-8">
                                        <select class="form-control" name="department_id" id="dropdown">
                                          <option selected>Choose Department</option>
                                          @foreach ($department as $departments)
                                          <option value="{{ $departments->id	}}">{{ $departments->nama_department	}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="col-sm-4 col-form-label mb-3">Exp Date</label>
                                      <div class="col-sm-8">
                                        <input required type="date" class="form-control" name="exp_date" >
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="col-sm-4 col-form-label mb-3">Use QC</label>
                                      <div class="col-sm-8">
                                        <input required type="date" class="form-control" name="use_qc" >
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="col-sm-4 col-form-label mb-3">Last QC</label>
                                      <div class="col-sm-8">
                                        <input required type="date" class="form-control" name="last_qc">
                                      </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-outline-primary">Save</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <div class="accordion accordion-custom-button mt-4" id="accordionCustom">
                          <div class="accordion-item">
                             @php
                                 $groupedQCs = $qcs->groupBy('department_id');
                             @endphp
                             
                             @foreach($groupedQCs as $departmentId => $qcGroup)
                                 <div class="accordion-item">
                                     <h2 class="accordion-header" id="headingCustom{{ $departmentId }}">
                                         <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionCustom{{ $departmentId }}" aria-expanded="false" aria-controls="accordionCustom{{ $departmentId }}">
                                             {{ $qcGroup->first()->department->nama_department }}
                                         </button>
                                     </h2>
                             
                                     <div id="accordionCustom{{ $departmentId }}" class="accordion-collapse collapse" aria-labelledby="headingCustom{{ $departmentId }}" data-bs-parent="#accordionCustom">
                                         <div class="accordion-body">
                                             <!-- Tampilkan name_control terkait department ini sebagai sub-accordion -->
                                             <div class="accordion" id="accordionSub{{ $departmentId }}">
                                                 @foreach($qcGroup->groupBy('name_control') as $nameControl => $qcLevels)
                                                     <div class="accordion-item">
                                                         <h2 class="accordion-header" id="headingSub{{ $loop->index }}">
                                                             <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseSub{{ $loop->index }}" aria-expanded="false" aria-controls="collapseSub{{ $loop->index }}">
                                                                 {{ $nameControl }}
                                                             </button>
                                                         </h2>
                                                         <div id="collapseSub{{ $loop->index }}" class="accordion-collapse collapse" aria-labelledby="headingSub{{ $loop->index }}" data-bs-parent="#accordionSub{{ $departmentId }}">
                                                             <div class="accordion-body">
                                                                 <!-- Tampilkan level di dalam sub-accordion -->
                                                                 <ul class="list-group">
                                                                    @foreach($qcLevels as $qc)
                                                                        <li class="list-group-item qc-level-item text-primary" 
                                                                            style="cursor: pointer">
                                                                            Level: {{ ucfirst($qc->level) }}
                                                                            <div class="menu-container mt-2" style="display: none;">
                                                                                <button class="btn btn-outline-primary btn-menu data-parameter mb-2 w-100" data-menu="menu1" data-id="{{ $qc->id }}" data-level="{{ $qc->level }}">Menu 1</button>
                                                                                <button class="btn btn-outline-primary btn-menu mb-2 w-100 data-level" data-id="{{ $qc->id }}" data-menu="menu2">Menu 2</button>
                                                                            </div>
                                                                            <div class="menu-data mt-2" style="display: none;">
                                                                                <!-- Tempat menampilkan data sesuai dengan pilihan menu -->
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                              </ul>                                                    
                                                             </div>
                                                         </div>
                                                     </div>
                                                 @endforeach
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             @endforeach
                       
                       
                          </div>
                      </div>
                    </div>
                    
                  </div>
                  </div>
      
              <div class="col-xl-9 col-lg-9">
                <div class="card shadow mb-4">
                  <div class="card-header p-3 fw-bold" style="background-color: #f8f9fc; border-bottom: 0.5px solid lightgray">Data LOT</div>
                  <div class="card-body">
                    <div class="row mt-3" id="previewData">
                      <div style="background-color: #F5F7F8" class="text-center bg-body-tertiary"><p>Pilih Level</p></div>
                    </div>
                </div>
              </div>
            </div>
        </div>
      @endsection
      
@push('script')
<script>
  $(document).ready(function() {
    // Ketika item level diklik, munculkan tombol menu
    $('.qc-level-item').click(function() {
        // Hide all other menu containers
        $('.menu-container').hide();
        $('.menu-data').hide();

        // Show the menu container pada item yang diklik
        $(this).find('.menu-container').toggle();
    });

    // Ketika menu dipilih
    $('.btn-menu').click(function() {
        // Dapatkan menu yang dipilih
        var selectedMenu = $(this).data('menu');
        
        // Dapatkan container data dari item yang diklik
        var dataContainer = $(this).closest('.qc-level-item').find('.menu-data');
        
        // Bersihkan data sebelumnya
        dataContainer.html('');

        // Tentukan data yang akan ditampilkan berdasarkan menu yang dipilih
        if (selectedMenu === 'menu1') {
            dataContainer.html('<p>Data untuk Menu 1: Informasi penting terkait Menu 1.</p>');
        } else if (selectedMenu === 'menu2') {
            dataContainer.html('<p>Data untuk Menu 2: Informasi tambahan untuk Menu 2.</p>');
        }

        // Tampilkan data yang sesuai
        dataContainer.show();
    });
});
</script>
<script>
  document.addEventListener('DOMContentLoaded', function(){
      $(function(){
          $('.data-parameter').on('click', function(event){
              event.preventDefault();
              const id = this.getAttribute('data-id');
              const previewData = document.getElementById('previewData');

              fetch(`/api/get-data-qc/${id}`)
              .then(response => {
                  if (!response.ok) {
                      throw new Error("HTTP error " + response.status);
                  }
                  return response.json();
              })
              .then(res => {
                  if (res.status === 'success'){
                      const data_qc = res.data;

                      let detailContent = '<div class="row mt-3">';

                          detailContent += `
                                  <div class="col-3">
                        <h6 class="mb-0 fw-bold">Control</h6>
                        <input type="text" class="form-control" value="${data_qc.name_control}" disabled>
                      </div>
                      <div class="col-3">
                        <h6 class="mb-0 fw-bold">No Lot</h6>
                        <input type="text" class="form-control" value="${data_qc.no_lot}" disabled>
                      </div>
                      <div class="col-3">
                        <h6 class="mb-0 fw-bold">Tanggal</h6>
                        <select class="form-control" name="level" id="dropdown">
                                      <option selected hidden>Pilih Tanggal</option>
                                      <option data-id="${data_qc.id}" value="${data_qc.use_qc}">${data_qc.use_qc}</option>
                        </select>
                      </div>
                      <div class="col-3">
                        <h6 class="mb-0 fw-bold">Level</h6>
                        <input type="text" class="form-control" value="${data_qc.level}" disabled>
                      </div>
                      <div id="qcDisplay" class="row mt-4">
                      <div class="col-3 mt-4">
                        <table>
                          <tbody>
                            <tr>
                              <th>Exp Date</th>
                              <td> : <span>${data_qc.exp_date}</span></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-3 mt-4">
                        <table>
                          <tbody>
                            <tr>
                              <th>Use QC</th>
                              <td> : <span>${data_qc.use_qc}</span></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-3 mt-4">
                        <table>
                          <tbody>
                            <tr>
                              <th>Last QC</th>
                              <td> : <span>${data_qc.last_qc}</span></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                        </div>
                    </div>
                    <div class="text-end">
                      <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editedModal"><i class="ti ti-pencil"></i></button>
                      <button class="btn btn-sm btn-outline-primary"><i class="ti ti-printer"></i></button>
                    </div>
                    <div class="modal fade" id="editedModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Quality Control</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                            <hr>
                            <div class="modal-body py-0" style="max-height: 700px; overflow-y: auto;">
                              <form action="/analyst/insert_qc" method="POST" class="mt-2">
                                @csrf
                                <div class="form-group row">
                                  <label class="col-sm-4 col-form-label mb-3">No Lot</label>
                                  <div class="col-sm-8">
                                    <input required type="text" name="no_lot" class="form-control" placeholder="No Lot">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-4 col-form-label mb-3">Nama Control</label>
                                  <div class="col-sm-8">
                                    <input required type="text" name="name_control" class="form-control" placeholder="Nama Control">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-4 col-form-label mb-3">Level</label>
                                  <div class="col-sm-8">
                                    <select class="form-control" name="level" id="dropdown">
                                      <option selected>Pilih Level</option>
                                      <option value="low">Low</option>
                                      <option value="normal">Normal</option>
                                      <option value="high">High</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-4 col-form-label mb-3">Department</label>
                                  <div class="col-sm-8">
                                    <select class="form-control" name="department_id" id="dropdown">
                                      <option selected>Choose Department</option>
                                      @foreach ($department as $departments)
                                      <option value="{{ $departments->id	}}">{{ $departments->nama_department	}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-4 col-form-label mb-3">Exp Date</label>
                                  <div class="col-sm-8">
                                    <input required type="date" class="form-control" name="exp_date" >
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-4 col-form-label mb-3">Use QC</label>
                                  <div class="col-sm-8">
                                    <input required type="date" class="form-control" name="use_qc" >
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-4 col-form-label mb-3">Last QC</label>
                                  <div class="col-sm-8">
                                    <input required type="date" class="form-control" name="last_qc">
                                  </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Save</button>
                            </div>
                        </form>
                          </div>
                        </div>
                      </div>

                    <div class="table-responsive mt-6">
                      <table>
                        <table class="table table-striped" id="qcTable">
                          <thead>
                            <tr>
                              <th>Parameter</th>
                              <th>Hasil</th>
                              <th>Mean</th>
                              <th>Range</th>
                              <th>Batas Atas</th>
                              <th>Batas Bawah</th>
                              <th>Standart</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody style="font-size: 12px" align="center">
                            <tr>
                              <td>RBC</td>
                              <td>8.3</td>
                              <td>3</td>
                              <td>2</td>
                              <td>3</td>
                              <td>2</td>
                              <td>4</td>
                              <td>
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahModal"><i class=" ti ti-plus"></i></button>
                                <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#editModal"><i class=" ti ti-pencil"></i></button>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </table>
                    </div>
                    <div class="modal fade col-5" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Quality Control</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                            <hr>
                            <div class="modal-body py-0" style="max-height: 700px; overflow-y: auto;">
                              <form action="#" method="POST" class="mt-2">
                                @csrf
                                <div class="form-group row">
                                  <label class="col-sm-4 col-form-label mb-3">Mean</label>
                                  <div class="col-sm-8">
                                    <input required type="text" name="no_lot" class="form-control" placeholder="Mean">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-4 col-form-label mb-3">Range</label>
                                  <div class="col-sm-8">
                                    <input required type="text" name="name_control" class="form-control" placeholder="Range">
                                  </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Save</button>
                            </div>
                        </form>
                          </div>
                        </div>
                      </div>

                    <div class="modal fade col-5" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Quality Control</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                            <hr>
                            <div class="modal-body py-0" style="max-height: 700px; overflow-y: auto;">
                              <form action="#" method="POST" class="mt-2">
                                @csrf
                                <div class="form-group row">
                                  <label class="col-sm-4 col-form-label mb-3">Mean</label>
                                  <div class="col-sm-8">
                                    <input required type="text" name="no_lot" class="form-control" placeholder="Mean">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-4 col-form-label mb-3">Range</label>
                                  <div class="col-sm-8">
                                    <input required type="text" name="name_control" class="form-control" placeholder="Range">
                                  </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Save</button>
                            </div>
                        </form>
                          </div>
                        </div>
                      </div>
                  
                          `;
                          detailContent += `
                                  </div>
                          `;
                          previewData.innerHTML = detailContent;
                  }
              })
          });
      });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function(){
      $(function(){
          $('.data-level').on('click', function(event){
              event.preventDefault();
              const id = this.getAttribute('data-id');
              const previewData = document.getElementById('previewData');

              fetch(`/api/get-data-qc/${id}`)
              .then(response => {
                  if (!response.ok) {
                      throw new Error("HTTP error " + response.status);
                  }
                  return response.json();
              })
              .then(res => {
                  if (res.status === 'success'){
                      const data_qc = res.data;

                      let detailContent = '<div class="row mt-3">';

                          detailContent += `
                    <div class="table-responsive mt-6">
                      <table>
                        <table class="table table-striped" id="qcTable">
                          <thead>
                            <tr class="text-center">
                              <th>Lot</th>
                              <th>Mode</th>
                              <th>Level</th>
                              <th>Qc Type</th>
                              <th>Valid Date</th>
                              <th>QC ID</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody style="font-size: 12px" align="center">
                            <tr>
                              <td>6666</td>
                              <td>RBC-WBC</td>
                              <td>Normal</td>
                              <td></td>
                              <td>2024-05-05</td>
                              <td>5</td>
                              <td>
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahModal"><i class=" ti ti-eye"></i></button>
                                <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#editModal"><i class=" ti ti-pencil"></i></button>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </table>
                    </div>
                    <div class="modal fade col-5" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Quality Control</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                            <hr>
                            <div class="modal-body py-0" style="max-height: 700px; overflow-y: auto;">
                              <form action="#" method="POST" class="mt-2">
                                @csrf
                                <div class="form-group row">
                                  <label class="col-sm-4 col-form-label mb-3">Mean</label>
                                  <div class="col-sm-8">
                                    <input required type="text" name="no_lot" class="form-control" placeholder="Mean">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-4 col-form-label mb-3">Range</label>
                                  <div class="col-sm-8">
                                    <input required type="text" name="name_control" class="form-control" placeholder="Range">
                                  </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Save</button>
                            </div>
                        </form>
                          </div>
                        </div>
                      </div>

                    <div class="modal fade col-5" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Quality Control</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                            <hr>
                            <div class="modal-body py-0" style="max-height: 700px; overflow-y: auto;">
                              <form action="#" method="POST" class="mt-2">
                                @csrf
                                <div class="form-group row">
                                  <label class="col-sm-4 col-form-label mb-3">Mean</label>
                                  <div class="col-sm-8">
                                    <input required type="text" name="no_lot" class="form-control" placeholder="Mean">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-4 col-form-label mb-3">Range</label>
                                  <div class="col-sm-8">
                                    <input required type="text" name="name_control" class="form-control" placeholder="Range">
                                  </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Save</button>
                            </div>
                        </form>
                          </div>
                        </div>
                      </div>
                  
                          `;
                          detailContent += `
                                  </div>
                          `;
                          previewData.innerHTML = detailContent;
                  }
              })
          });
      });
  });
</script>
@endpush