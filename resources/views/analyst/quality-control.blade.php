@extends('layouts.admin')
@section('title', 'Quality Control')
@section('content')

<link rel="stylesheet" href="{{ asset('css/timeline.css') }}">
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
      <div class="d-sm-flex  my-3">
         <h1 class="h3 mb-0 text-gray-600">Quality Control</h1>
      </div>
      <div class="row mt-2">
         {{-- Menu Qc --}}
         <div class="col-xl-3 col-lg-3">
             <div class="card shadow mb-4">
                 <div class="card-header p-3 fw-bold" style="background-color: #f8f9fc; border-bottom: 0.5px solid lightgray">Qc Menu</div>
                 <div class="card-body">
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
                                                                        <li class="list-group-item qc-level-item text-primary data-level" style="cursor: pointer" data-id="{{ $qc->id }}" data-level="{{ $qc->level }}">
                                                                            Level: {{ ucfirst($qc->level) }} 
                                                                            {{-- (Exp. Date: {{ $qc->exp_date }}) --}}
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
                     {{-- <div class="accordion accordion-custom-button mt-4" id="accordionCustomTwo">
                         <div class="accordion-item">
                             <h2 class="accordion-header" id="headingCustom">
                                 <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionCustom" aria-expanded="false" aria-controls="accordionCustom">
                                     Kimia Klinik
                                 </button>
                             </h2>
                             <div id="accordionCustom" class="accordion-collapse collapse" aria-labelledby="headingCustomOne" data-bs-parent="#accordionCustomTwo">
                                 <div class="accordion-body">
                                     <div class="sub">
                                         <a href="#" class="sub-item">Zybio Z3</a>
                                         <a href="#" class="sub-item">Mindray BC30</a>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div> --}}
                 </div>
             </div>
         </div>
     
         <!-- Menu Control -->
         <div class="col-xl-4 col-lg-4">
            <div class="col-xxl-12">
                <div class="nav-align-top nav-tabs-shadow mb-6">
                    {{-- <ul class="nav nav-tabs justify-content-between" role="tablist">
                        <li class="nav-item" role="presentation" style="text-align: left">
                              <button type="button" class="nav-link waves-effect active fw-bold" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true" >Pilih level</button>
                        </li>
                     </ul> --}}
                     <div class="tab-content shadow-lg" style="border-radius: 3px" id="previewLevel">  
                        {{-- <div id="previewLevel"> --}}
                            <!-- tampilan data pasien-->
                            <div style="background-color: #F5F7F8" class="text-center bg-body-tertiary"><p>Pilih Level</p></div>
                        {{-- </div> --}}
                     </div>
                </div>   
            </div>
         </div>
         {{-- Menu Grafik --}}
         <div class="col-xl-5 col-lg-5">
            <div class="card">
               <div class="card-header fw-bold" style="background-color: #f8f9fc; border-bottom: 0.5px solid lightgray">QC Chart</div>
               <div class="card-body"></div>
            </div>
     </div>
     
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        $(function(){
            $('.data-level').on('click', function(event){
                event.preventDefault();
                const id = this.getAttribute('data-id');
                const previewLevel = document.getElementById('previewLevel');

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

                        let detailContent = '<div class="row">';

                            detailContent += `
                                    <ul class="nav nav-tabs justify-content-between" role="tablist">
                                        <li class="nav-item" role="presentation" style="text-align: left">
                                            <button type="button" class="nav-link waves-effect active fw-bold" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true" >${data_qc.level}</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="navs-top-home" role="tabpanel">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <th class="fw-bold">No Lot</th>
                                                <td> : <span>${data_qc.no_lot}</span></td>
                                            </tr>
                                            <tr>
                                                <th class="fw-bold">Control</th>
                                                <td> : <span>${data_qc.name_control}</span></td>
                                            </tr>
                                            <tr>
                                                <th class="fw-bold">Date</th>
                                                <td> : <span>${data_qc.use_qc}</span></td>
                                            </tr>
                                            </tbody>  
                                        </table>
                                        
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Parameter</th>
                                                    <th>Hasil</th>
                                                    <th>Mean</th>
                                                    <th>Range</th>
                                                    <th>Batas Atas</th>
                                                    <th>Batas Bawah</th>
                                                    <th>Standart</th>
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
                                                </tr>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                            `;
                            detailContent += `
                                    </div>
                            `;
                            previewLevel.innerHTML = detailContent;
                    }
                })
            });
        });
    });
</script>
@endpush