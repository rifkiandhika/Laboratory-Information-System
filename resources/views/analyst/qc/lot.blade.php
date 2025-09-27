@extends('layouts.admin')
<title>Lots</title>
@section('content')
<style>
    .card-header {
        background-color: #f8f9fc !important;
        border-bottom: 0.5px solid lightgray;
    }
    
    .lot-container {
        border: 2px solid #007bff;
        border-radius: 8px;
        padding: 0;
        margin-bottom: 20px;
        background: white;
        overflow: hidden;
    }
    
    .lot-header {
        background: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .lot-info-summary {
        display: flex;
        gap: 30px;
        align-items: center;
        font-size: 14px;
    }
    
    .lot-info-item {
        display: flex;
        flex-direction: column;
    }
    
    .lot-info-label {
        font-weight: 600;
        color: #495057;
        font-size: 12px;
        margin-bottom: 2px;
    }
    
    .lot-info-value {
        color: #212529;
        font-weight: 500;
    }
    
    .btn-action {
        margin-right: 5px;
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 4px;
    }
    
    .btn-submit-main {
        background: #28a745;
        border: none;
        color: white;
        padding: 8px 20px;
        border-radius: 4px;
        font-weight: 600;
    }
    
    .btn-submit-main:hover {
        background: #218838;
        color: white;
    }
    
    .parameter-table-container {
        padding: 0;
    }
    
    .parameter-table {
        margin: 0;
        font-size: 13px;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .parameter-table th {
        background-color: #e9ecef;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
        padding: 12px 8px;
        border: 1px solid #dee2e6;
        font-size: 12px;
    }
    
    .parameter-table td {
        text-align: center;
        vertical-align: middle;
        padding: 8px;
        border: 1px solid #dee2e6;
        font-size: 12px;
    }
    
    .parameter-table .lot-info-cell {
        background-color: #f8f9fa;
        font-weight: 500;
        color: #495057;
    }
    
    .parameter-input {
        width: 80px;
        font-size: 11px;
        padding: 4px 6px;
        text-align: center;
        border: 1px solid #ced4da;
        border-radius: 3px;
    }
    
    .parameter-input:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        outline: 0;
    }
    
    .no-lots-message {
        text-align: center;
        color: #6c757d;
        font-style: italic;
        margin: 50px 0;
        padding: 40px;
    }
    
    .first-row-cells {
        writing-mode: vertical-lr;
        text-orientation: mixed;
        background-color: #f8f9fa !important;
        font-weight: 600;
    }
    
    .parameter-name {
        font-weight: 500;
        color: #495057;
        text-align: left !important;
        padding-left: 12px !important;
    }
    
    .parameter-controls {
        display: flex;
        gap: 5px;
        align-items: center;
    }
    
    .add-param-btn {
        background: #007bff;
        border: none;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 10px;
        cursor: pointer;
    }
    
    .remove-param-btn {
        background: #dc3545;
        border: none;
        color: white;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 10px;
        cursor: pointer;
    }
    
    .edit-lot-container {
        border: 2px solid #ffc107 !important;
    }
    
    .edit-lot-header {
        background: #fff3cd !important;
    }
    
    .edit-indicator {
        background: #ffc107;
        color: #856404;
        padding: 2px 8px;
        border-radius: 3px;
        font-size: 10px;
        font-weight: bold;
    }
    /* Tambahkan CSS ini ke dalam <style> tag di view */

.editable-field {
    transition: all 0.3s ease;
}

.editable-field:not([readonly]):not([disabled]) {
    background-color: #fff3cd !important;
    border: 1px solid #ffeaa7 !important;
}

.editable-field:focus {
    outline: none;
    border-color: #fdcb6e !important;
    box-shadow: 0 0 0 0.2rem rgba(253, 203, 110, 0.25);
    background-color: white !important;
}

.edit-indicator {
    background: #ffc107;
    color: #856404;
    padding: 2px 8px;
    border-radius: 3px;
    font-size: 10px;
    font-weight: bold;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

/* Styling khusus untuk mode edit */
.edit-lot-container .editable-field:not([readonly]):not([disabled]) {
    border-radius: 4px;
    padding: 2px 6px;
}

/* Hover effect pada field yang bisa diedit */
.edit-lot-container .editable-field:not([readonly]):not([disabled]):hover {
    border-color: #e67e22;
    background-color: #ffeaa7;
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid">
    <div class="d-sm-flex my-3">
        <h1 class="h3 mb-0 text-gray-600 text-center w-100">Data LOT</h1>
    </div>

    <div class="row mt-2">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header p-3 fw-bold">Data LOT</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mt-2">
                        <div>
                        <a href="{{ route('Qc.index') }}" class="btn btn-outline-primary btn-sm" title="Back To Qc"><i class="ti ti-arrow-left"></i></a>
                            <button class="btn btn-sm btn-outline-success" id="loadExistingLots">
                               Load LOT Existing <i class="ti ti-history ml-1"></i>
                            </button>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addLotModal">
                               Add LOT <i class="ti ti-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Container untuk menampilkan LOT yang sudah ditambahkan -->
                    <div id="lotContainer" class="mt-4">
                        <div class="no-lots-message" id="noLotsMessage">
                            <i class="bi bi-inbox" style="font-size: 48px; opacity: 0.5;"></i>
                            <div class="mt-3">
                                <h5>Belum ada LOT yang ditampilkan</h5>
                                <p class="mb-0">Klik "Tambah LOT Baru" untuk membuat LOT baru atau "Load LOT Existing" untuk mengedit LOT yang sudah ada</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit LOT -->
<div class="modal fade" id="addLotModal" tabindex="-1" aria-labelledby="addLotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLotModalLabel">Add Quality Control</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr>
            <div class="modal-body py-0" style="max-height: 700px; overflow-y: auto;">
                <form id="addLotForm" class="mt-2">
                    <div class="form-group row mb-3">
                        <label class="col-sm-4 col-form-label">No Lot</label>
                        <div class="col-sm-8">
                            <input required type="text" name="no_lot" id="no_lot" class="form-control" placeholder="No Lot">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4 col-form-label">Nama Control</label>
                        <div class="col-sm-8">
                            <input required type="text" name="name_control" id="name_control" class="form-control" placeholder="Nama Control">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4 col-form-label">Level</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="level" id="level" required>
                                <option value="">Pilih Level</option>
                                <option value="Low">Low</option>
                                <option value="Normal">Normal</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4 col-form-label">Department</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="department_id" id="department_id" required>
                                <option value="">Pilih Department</option>
                                @foreach($department as $dept)
                                    <option value="{{ $dept->id }}" data-name="{{ $dept->nama_department }}">{{ $dept->nama_department }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4 col-form-label">Exp Date</label>
                        <div class="col-sm-8">
                            <input required type="date" class="form-control" name="exp_date" id="exp_date">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4 col-form-label">Use QC</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="use_qc" id="use_qc">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4 col-form-label">Last QC</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="last_qc" id="last_qc">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary" id="saveLotBtn">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Load Existing LOT -->
<div class="modal fade" id="loadLotModal" tabindex="-1" aria-labelledby="loadLotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loadLotModalLabel">Load LOT Existing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Department</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="filter_department_id">
                            <option value="">Pilih Department</option>
                            @foreach($department as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->nama_department }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">No Lot</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="filter_no_lot">
                            <option value="">Pilih No Lot</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary" id="loadLotBtn">Load LOT</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Parameter -->
<div class="modal fade" id="addParameterModal" tabindex="-1" aria-labelledby="addParameterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addParameterModalLabel">Tambah Parameter Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Parameter</label>
                    <input type="text" class="form-control" id="newParameterName" placeholder="Masukkan nama parameter">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-outline-primary" id="addParameterBtn">Tambah</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    // Data parameter hematologi default
    const hematologyParameters = [
        'WBC', 'Lym#', 'Mid#', 'Gran#', 'Lym%', 'Mid%', 'Gran%', 
        'RBC', 'HGB', 'HCT', 'MCV', 'MCH', 'MCHC', 'RDW-CV', 
        'RDW-SD', 'PLT', 'MPV', 'PDW', 'PCT', 'P-LCR', 'P-LCC'
    ];

    let lotCounter = 0;
    let lots = [];
    let currentEditLotId = null;
    let currentLotParameters = [];

    // Function untuk format tanggal
    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        });
    }

    // Function untuk cek apakah department adalah hematologi
    function isHematologyDepartment(departmentName) {
        return departmentName && departmentName.toLowerCase().includes('hematologi');
    }

    // Function untuk membuat row parameter baru
    function createParameterRow(param, index, totalParams, lotData, existingData = null) {
        return `
            <tr data-param="${param}">
                ${index === 0 ? `<td rowspan="${totalParams}" class="first-row-cells lot-info-cell">
                    <span class="table-no-lot">${lotData.no_lot}</span>
                </td>` : ''}
                ${index === 0 ? `<td rowspan="${totalParams}" class="first-row-cells lot-info-cell">
                    <span class="table-name-control">${lotData.name_control}</span>
                </td>` : ''}
                <td class="parameter-name">
                    <div class="parameter-controls">
                        <span>${param}</span>
                        ${!isHematologyDepartment(lotData.department_name) ? 
                            `<button type="button" class="remove-param-btn" onclick="removeParameter('${param}')" title="Hapus Parameter">×</button>` : 
                            ''
                        }
                    </div>
                </td>
                <td><input type="number" step="0.01" class="form-control parameter-input" data-field="mean" placeholder="0.00" value="${existingData?.mean || ''}"></td>
                <td><input type="number" step="0.01" class="form-control parameter-input" data-field="range" placeholder="0.00" value="${existingData?.range || ''}"></td>
                <td><input type="number" step="0.01" class="form-control parameter-input" data-field="bts_ats" placeholder="0.00" value="${existingData?.bts_atas || ''}"></td>
                <td><input type="number" step="0.01" class="form-control parameter-input" data-field="bts_bwh" placeholder="0.00" value="${existingData?.bts_bawah || ''}"></td>
                <td><input type="number" step="0.01" class="form-control parameter-input" data-field="standart" placeholder="0.00" value="${existingData?.standart || ''}"></td>
            </tr>
        `;
    }

    // Function untuk membuat LOT element
    function createLotElement(lotData, isEdit = false, existingParameters = []) {
        const lotId = isEdit ? `edit_lot_${lotData.id}` : `lot_${lotCounter++}`;
        const editClass = isEdit ? 'edit-lot-container' : '';
        const editHeaderClass = isEdit ? 'edit-lot-header' : '';
        const editIndicator = isEdit ? '<span class="edit-indicator">EDIT MODE</span>' : '';
        
        // Tentukan parameter yang akan digunakan
        let parameters = [];
        if (isEdit && existingParameters.length > 0) {
            parameters = existingParameters.map(p => p.parameter);
            currentLotParameters = [...parameters];
        } else if (isHematologyDepartment(lotData.department_name)) {
            parameters = [...hematologyParameters];
            currentLotParameters = [...parameters];
        } else {
            parameters = [];
            currentLotParameters = [];
        }
        
        const parametersHtml = parameters.map((param, index) => {
            const existingData = existingParameters.find(p => p.parameter === param);
            return createParameterRow(param, index, parameters.length, lotData, existingData);
        }).join('');

        const addParameterButton = !isHematologyDepartment(lotData.department_name) ? 
            `<button class="btn btn-sm btn-outline-primary mt-2" onclick="showAddParameterModal('${lotId}')">
                <i class="bi bi-plus"></i> Tambah Parameter
            </button>` : '';
        
        const lotHtml = `
            <div class="lot-container ${editClass}" id="${lotId}" data-lot-data='${JSON.stringify(lotData)}' data-is-edit='${isEdit}'>
                <div class="lot-header ${editHeaderClass}">
                    <div class="d-flex gap-2 align-items-center">
                        ${editIndicator}
                        {{-- <button class="btn btn-info btn-action" onclick="editLot('${lotId}')">
                            Edit
                        </button> --}}
                        <button class="btn btn-warning btn-action" onclick="printLot('${lotId}')">
                            Print  
                        </button>
                        <button class="btn btn-danger btn-action" onclick="deleteLot('${lotId}')">
                            Delete
                        </button>
                    </div>
                    <div class="lot-info-summary">
                        <div class="lot-info-item">
                            <div class="lot-info-label">No Lot:</div>
                            <div class="lot-info-value">
                                <input type="text" class="editable-field" 
                                    data-field="no_lot" 
                                    value="${lotData.no_lot}"
                                    style="border: none; background: transparent; font-weight: 500; width: 100px;"
                                    ${!isEdit ? 'readonly' : ''}>
                            </div>
                        </div>
                        <div class="lot-info-item">
                            <div class="lot-info-label">Nama Control:</div>
                            <div class="lot-info-value">
                                <input type="text" class="editable-field" 
                                    data-field="name_control" 
                                    value="${lotData.name_control}"
                                    style="border: none; background: transparent; font-weight: 500; width: 150px;"
                                    ${!isEdit ? 'readonly' : ''}>
                            </div>
                        </div>
                        <div class="lot-info-item">
                            <div class="lot-info-label">Level:</div>
                            <div class="lot-info-value">
                                <select class="editable-field" 
                                        data-field="level" 
                                        style="border: none; background: transparent; font-weight: 500; width: 80px;"
                                        ${!isEdit ? 'disabled' : ''}>
                                    <option value="Low" ${lotData.level === 'Low' ? 'selected' : ''}>Low</option>
                                    <option value="Normal" ${lotData.level === 'Normal' ? 'selected' : ''}>Normal</option>
                                    <option value="High" ${lotData.level === 'High' ? 'selected' : ''}>High</option>
                                </select>
                            </div>
                        </div>
                        <div class="lot-info-item">
                            <div class="lot-info-label">Department:</div>
                            <div class="lot-info-value">${lotData.department_name}</div>
                        </div>
                        <div class="lot-info-item">
                            <div class="lot-info-label">Exp Date:</div>
                            <div class="lot-info-value">
                                <input type="date" class="editable-field" 
                                    data-field="exp_date" 
                                    value="${lotData.exp_date}"
                                    style="border: none; background: transparent; font-weight: 500; width: 120px;"
                                    ${!isEdit ? 'readonly' : ''}>
                            </div>
                        </div>
                        <div class="lot-info-item">
                            <div class="lot-info-label">Use QC:</div>
                            <div class="lot-info-value">
                                <input type="date" class="editable-field" 
                                    data-field="use_qc" 
                                    value="${lotData.use_qc || ''}"
                                    style="border: none; background: transparent; font-weight: 500; width: 120px;"
                                    ${!isEdit ? 'readonly' : ''}>
                            </div>
                        </div>
                        <div class="lot-info-item">
                            <div class="lot-info-label">Last QC:</div>
                            <div class="lot-info-value">
                                <input type="date" class="editable-field" 
                                    data-field="last_qc" 
                                    value="${lotData.last_qc || ''}"
                                    style="border: none; background: transparent; font-weight: 500; width: 120px;"
                                    ${!isEdit ? 'readonly' : ''}>
                            </div>
                        </div>
                        <button class="btn btn-submit-main" onclick="submitAllData('${lotId}')">
                            ${isEdit ? 'Update' : 'Submit'}
                        </button>
                    </div>
                </div>
                
                <div class="parameter-table-container">
                    ${parameters.length > 0 ? `
                        <table class="table table-bordered parameter-table mb-0">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="min-width: 100px;">NO LOT</th>
                                    <th rowspan="2" style="min-width: 120px;">NAMA CONTROL</th>
                                    <th rowspan="2" style="min-width: 100px;">PARAMETER</th>
                                    <th rowspan="2" style="min-width: 80px;">MEAN</th>
                                    <th rowspan="2" style="min-width: 80px;">RANGE</th>
                                    <th rowspan="2" style="min-width: 80px;">BTS ATS</th>
                                    <th rowspan="2" style="min-width: 80px;">BTS BWH</th>
                                    <th rowspan="2" style="min-width: 80px;">STANDART</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${parametersHtml}
                            </tbody>
                        </table>
                    ` : `
                        <div class="text-center p-4">
                            <p class="mb-3">Belum ada parameter yang ditambahkan</p>
                        </div>
                    `}
                    ${addParameterButton}
                </div>
            </div>
        `;
        
        return lotHtml;
    }

    // Function untuk menampilkan modal add parameter
    function showAddParameterModal(lotId) {
        currentEditLotId = lotId;
        const modal = new bootstrap.Modal(document.getElementById('addParameterModal'));
        modal.show();
    }

    // Function untuk menambah parameter baru
    function addNewParameter() {
        const parameterName = document.getElementById('newParameterName').value.trim();
        
        if (!parameterName) {
            Swal.fire({
                icon: 'warning',
                title: 'Nama Parameter Kosong!',
                text: 'Mohon masukkan nama parameter',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        if (currentLotParameters.includes(parameterName)) {
            Swal.fire({
                icon: 'warning',
                title: 'Parameter Sudah Ada!',
                text: 'Parameter dengan nama ini sudah ditambahkan',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        // Tambah parameter ke array
        currentLotParameters.push(parameterName);
        
        // Rebuild table
        rebuildParameterTable(currentEditLotId);
        
        // Reset form dan tutup modal
        document.getElementById('newParameterName').value = '';
        const modal = bootstrap.Modal.getInstance(document.getElementById('addParameterModal'));
        modal.hide();
        
        Swal.fire({
            icon: 'success',
            title: 'Parameter Ditambahkan!',
            text: `Parameter "${parameterName}" berhasil ditambahkan`,
            confirmButtonColor: '#28a745',
            timer: 2000
        });
    }

    // Function untuk menghapus parameter
    function removeParameter(paramName) {
        Swal.fire({
            icon: 'warning',
            title: 'Hapus Parameter?',
            text: `Apakah Anda yakin ingin menghapus parameter "${paramName}"?`,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Hapus dari array
                const index = currentLotParameters.indexOf(paramName);
                if (index > -1) {
                    currentLotParameters.splice(index, 1);
                }
                
                // Rebuild table
                rebuildParameterTable(currentEditLotId);
                
                Swal.fire({
                    icon: 'success',
                    title: 'Parameter Dihapus!',
                    text: `Parameter "${paramName}" berhasil dihapus`,
                    confirmButtonColor: '#28a745',
                    timer: 2000
                });
            }
        });
    }

    // Function untuk rebuild parameter table
    function rebuildParameterTable(lotId) {
        const lotElement = document.getElementById(lotId);
        const lotDataStr = lotElement.getAttribute('data-lot-data');
        const lotData = JSON.parse(lotDataStr);
        
        const tableContainer = lotElement.querySelector('.parameter-table-container');
        
        if (currentLotParameters.length > 0) {
            const parametersHtml = currentLotParameters.map((param, index) => {
                return createParameterRow(param, index, currentLotParameters.length, lotData);
            }).join('');
            
            tableContainer.innerHTML = `
                <table class="table table-bordered parameter-table mb-0">
                    <thead>
                        <tr>
                            <th rowspan="2" style="min-width: 100px;">NO LOT</th>
                            <th rowspan="2" style="min-width: 120px;">NAMA CONTROL</th>
                            <th rowspan="2" style="min-width: 100px;">PARAMETER</th>
                            <th rowspan="2" style="min-width: 80px;">MEAN</th>
                            <th rowspan="2" style="min-width: 80px;">RANGE</th>
                            <th rowspan="2" style="min-width: 80px;">BTS ATS</th>
                            <th rowspan="2" style="min-width: 80px;">BTS BWH</th>
                            <th rowspan="2" style="min-width: 80px;">STANDART</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${parametersHtml}
                    </tbody>
                </table>
                ${!isHematologyDepartment(lotData.department_name) ? 
                    `<button class="btn btn-sm btn-outline-primary mt-2" onclick="showAddParameterModal('${lotId}')">
                        <i class="bi bi-plus"></i> Tambah Parameter
                    </button>` : 
                    ''
                }
            `;
        } else {
            tableContainer.innerHTML = `
                <div class="text-center p-4">
                    <p class="mb-3">Belum ada parameter yang ditambahkan</p>
                    <button class="btn btn-sm btn-outline-primary" onclick="showAddParameterModal('${lotId}')">
                        <i class="bi bi-plus"></i> Tambah Parameter
                    </button>
                </div>
            `;
        }
    }

    // Function untuk menambah LOT baru
    async function addLot() {
        const form = document.getElementById('addLotForm');
        const formData = new FormData(form);
        
        // Get department name
        const departmentSelect = document.getElementById('department_id');
        const selectedOption = departmentSelect.options[departmentSelect.selectedIndex];
        const departmentName = selectedOption.getAttribute('data-name') || '';
        
        const lotData = {
            no_lot: formData.get('no_lot'),
            name_control: formData.get('name_control'),
            level: formData.get('level'),
            exp_date: formData.get('exp_date'),
            use_qc: formData.get('use_qc'),
            last_qc: formData.get('last_qc'),
            department_id: formData.get('department_id'),
            department_name: departmentName
        };

        // Validasi form
        if (!lotData.no_lot || !lotData.name_control || !lotData.level || !lotData.exp_date || !lotData.department_id) {
            await Swal.fire({
                icon: 'error',
                title: 'Form Tidak Lengkap!',
                text: 'Mohon isi semua field yang wajib diisi',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        // Simpan data LOT di client-side saja
        lots.push(lotData);

        // Buat elemen LOT baru
        const lotContainer = document.getElementById('lotContainer');
        const noLotsMessage = document.getElementById('noLotsMessage');
        
        // Sembunyikan pesan "tidak ada LOT"
        if (noLotsMessage) {
            noLotsMessage.style.display = 'none';
        }

        // Tambahkan LOT baru
        const lotElement = document.createElement('div');
        lotElement.innerHTML = createLotElement(lotData);
        lotContainer.appendChild(lotElement.firstElementChild);

        // Reset form dan tutup modal
        form.reset();
        const modal = bootstrap.Modal.getInstance(document.getElementById('addLotModal'));
        modal.hide();

        // SweetAlert konfirmasi LOT berhasil ditambahkan
        await Swal.fire({
            icon: 'success',
            title: 'LOT Berhasil Ditambahkan!',
            text: 'LOT telah ditambahkan ke daftar. Jangan lupa klik "Submit" untuk menyimpan ke database.',
            confirmButtonColor: '#28a745',
            timer: 3000,
            timerProgressBar: true
        });
    }

    // Function untuk load existing LOTs
    async function loadExistingLots() {
        const modal = new bootstrap.Modal(document.getElementById('loadLotModal'));
        modal.show();
    }

    // Function untuk load LOTs by department
    async function loadLotsByDepartment(departmentId) {
        try {
            const response = await fetch(`/analyst/get-lots-by-department/${departmentId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                const data = await response.json();
                const noLotSelect = document.getElementById('filter_no_lot');
                noLotSelect.innerHTML = '<option value="">Pilih No Lot</option>';
                
                data.forEach(lot => {
                    const option = document.createElement('option');
                    option.value = lot.id;
                    // Tampilkan no_lot, name_control, dan level
                    option.textContent = `${lot.no_lot} - ${lot.name_control} (${lot.level})`;
                    noLotSelect.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error loading lots:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Gagal memuat data LOT',
                confirmButtonColor: '#d33'
            });
        }
    }

    // Function untuk load LOT detail
    async function loadLotDetail() {
        const lotId = document.getElementById('filter_no_lot').value;
        
        if (!lotId) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih LOT!',
                text: 'Mohon pilih No LOT terlebih dahulu',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        try {
            Swal.fire({
                title: 'Loading...',
                html: 'Memuat data LOT',
                allowEscapeKey: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const response = await fetch(`/analyst/get-lot-detail/${lotId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                const data = await response.json();
                Swal.close();
                
                // Clear existing lots
                const lotContainer = document.getElementById('lotContainer');
                lotContainer.innerHTML = '';
                
                // Hide no lots message
                const noLotsMessage = document.getElementById('noLotsMessage');
                if (noLotsMessage) {
                    noLotsMessage.style.display = 'none';
                }
                
                // Create lot element with existing data
                const lotElement = document.createElement('div');
                lotElement.innerHTML = createLotElement(data.lot, true, data.parameters);
                lotContainer.appendChild(lotElement.firstElementChild);
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('loadLotModal'));
                modal.hide();
                
                Swal.fire({
                    icon: 'success',
                    title: 'LOT Berhasil Dimuat!',
                    text: 'Data LOT siap untuk diedit',
                    confirmButtonColor: '#28a745',
                    timer: 2000
                });
                
            } else {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Gagal memuat detail LOT',
                    confirmButtonColor: '#d33'
                });
            }
        } catch (error) {
            Swal.close();
            console.error('Error loading lot detail:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat memuat data LOT',
                confirmButtonColor: '#d33'
            });
        }
    }

    // Function untuk submit semua data
    async function submitAllData(lotId) {
        // Loading SweetAlert
        Swal.fire({
            title: 'Menyimpan Data...',
            html: 'Sedang memproses data LOT dan Parameter',
            allowEscapeKey: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const lotElement = document.getElementById(lotId);
        const isEdit = lotElement.getAttribute('data-is-edit') === 'true';
        
        // Ambil data lot dari input yang bisa diedit
        const editableFields = lotElement.querySelectorAll('.editable-field');
        const lotData = JSON.parse(lotElement.getAttribute('data-lot-data'));
        
        // Update lot data dengan nilai dari input
        editableFields.forEach(field => {
            const fieldName = field.dataset.field;
            lotData[fieldName] = field.value;
        });
        
        // Kumpulkan data parameter
        const parameterData = {};
        currentLotParameters.forEach(param => {
            const row = lotElement.querySelector(`tr[data-param="${param}"]`);
            if (row) {
                const inputs = row.querySelectorAll('.parameter-input');
                parameterData[param] = {};
                
                inputs.forEach(input => {
                    const field = input.dataset.field;
                    parameterData[param][field] = input.value || '0';
                });
            }
        });

        // Data lengkap untuk dikirim ke server
        const completeData = {
            lot: lotData,
            parameters: parameterData,
            department_id: lotData.department_id,
            is_edit: isEdit
        };

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            Swal.close();
            await Swal.fire({
                icon: 'error',
                title: 'Error CSRF!',
                text: 'CSRF token tidak ditemukan! Refresh halaman dan coba lagi.',
                confirmButtonColor: '#d33'
            });
            return;
        }

        try {
            const url = isEdit ? `/analyst/update-complete-qc/${lotData.id}` : "/analyst/store-complete-qc";
            const method = isEdit ? 'PUT' : 'POST';
            
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(completeData)
            });

            // Cek apakah response adalah JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const textResponse = await response.text();
                console.error('Response bukan JSON:', textResponse);
                
                Swal.close();
                await Swal.fire({
                    icon: 'error',
                    title: 'Server Error!',
                    text: 'Server mengembalikan response yang tidak valid.',
                    footer: 'Cek console browser untuk detail error',
                    confirmButtonColor: '#d33'
                });
                return;
            }

            const result = await response.json();
            
            Swal.close(); // Tutup loading

            if (response.ok && result.success) {
                // Update tampilan tabel dengan data yang baru
                updateTableDisplay(lotElement, lotData);
                
                // SweetAlert sukses dengan animasi
                await Swal.fire({
                    icon: 'success',
                    title: isEdit ? 'Data Berhasil Diupdate!' : 'Berhasil!',
                    text: isEdit ? 'Data LOT dan Parameter berhasil diupdate!' : 'Data LOT dan Parameter berhasil disimpan ke database!',
                    confirmButtonColor: '#28a745',
                    timer: 2000,
                    timerProgressBar: true,
                    showClass: {
                        popup: 'animate__animated animate__fadeInUp'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutDown'
                    }
                });
                
                // Ubah warna tombol submit menjadi sukses
                const submitBtn = lotElement.querySelector('.btn-submit-main');
                submitBtn.innerHTML = isEdit ? '<i class="bi bi-check2-circle"></i> Terupdate' : '<i class="bi bi-check2-circle"></i> Tersimpan';
                submitBtn.classList.remove('btn-submit-main');
                submitBtn.classList.add('btn', 'btn-success');
                submitBtn.disabled = true;
                
            } else {
                console.error('Server error:', result);
                
                // SweetAlert error dengan detail
                let errorMessage = result.message || 'Unknown error';
                if (result.errors) {
                    errorMessage += '\n\nDetail Error:\n';
                    Object.entries(result.errors).forEach(([field, messages]) => {
                        errorMessage += `• ${field}: ${messages.join(', ')}\n`;
                    });
                }
                
                await Swal.fire({
                    icon: 'error',
                    title: isEdit ? 'Gagal Update!' : 'Gagal Menyimpan!',
                    text: errorMessage,
                    confirmButtonColor: '#d33',
                    footer: result.errors ? 'Perbaiki data dan coba lagi' : null
                });
            }
        } catch (error) {
            console.error('Network/JavaScript error:', error);
            
            Swal.close();
            await Swal.fire({
                icon: 'error',
                title: 'Error Jaringan!',
                text: `Terjadi kesalahan: ${error.message}`,
                confirmButtonColor: '#d33',
                footer: 'Periksa koneksi internet Anda'
            });
        }
    }

    function updateTableDisplay(lotElement, newLotData) {
        // Update nilai di tabel parameter
        const tableNoLot = lotElement.querySelector('.table-no-lot');
        const tableNameControl = lotElement.querySelector('.table-name-control');
        
        if (tableNoLot) {
            tableNoLot.textContent = newLotData.no_lot;
        }
        if (tableNameControl) {
            tableNameControl.textContent = newLotData.name_control;
        }
    }

    // Function edit dengan SweetAlert
    function editLot(lotId) {
        const lotElement = document.getElementById(lotId);
        const editableFields = lotElement.querySelectorAll('.editable-field');
        const isCurrentlyEdit = lotElement.getAttribute('data-is-edit') === 'true';
        
        if (!isCurrentlyEdit) {
            // Enable edit mode
            editableFields.forEach(field => {
                if (field.type === 'text' || field.type === 'date') {
                    field.readOnly = false;
                    field.style.border = '1px solid #ced4da';
                    field.style.borderRadius = '4px';
                    field.style.padding = '2px 6px';
                } else if (field.tagName === 'SELECT') {
                    field.disabled = false;
                    field.style.border = '1px solid #ced4da';
                    field.style.borderRadius = '4px';
                }
            });
            
            lotElement.setAttribute('data-is-edit', 'true');
            lotElement.classList.add('edit-lot-container');
            lotElement.querySelector('.lot-header').classList.add('edit-lot-header');
            
            // Tambah edit indicator jika belum ada
            const existingIndicator = lotElement.querySelector('.edit-indicator');
            if (!existingIndicator) {
                const indicatorHtml = '<span class="edit-indicator">EDIT MODE</span>';
                const buttonContainer = lotElement.querySelector('.d-flex.gap-2.align-items-center');
                buttonContainer.insertAdjacentHTML('afterbegin', indicatorHtml);
            }
            
            Swal.fire({
                icon: 'info',
                title: 'Mode Edit Aktif',
                text: 'Sekarang Anda bisa mengedit semua field LOT. Klik "Update" untuk menyimpan perubahan.',
                confirmButtonColor: '#3085d6'
            });
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Sudah dalam Mode Edit',
                text: 'LOT sudah dalam mode edit. Ubah data lalu klik "Update" untuk menyimpan perubahan.',
                confirmButtonColor: '#3085d6'
            });
        }
    }

    // Function print
    function printLot(lotId) {
        window.print();
    }

    // Function delete dengan SweetAlert konfirmasi
    async function deleteLot(lotId) {
        const result = await Swal.fire({
            icon: 'warning',
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus LOT ini?',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        });

        if (result.isConfirmed) {
            const lotElement = document.getElementById(lotId);
            lotElement.remove();
            
            const lotContainer = document.getElementById('lotContainer');
            const remainingLots = lotContainer.querySelectorAll('.lot-container');
            
            if (remainingLots.length === 0) {
                document.getElementById('noLotsMessage').style.display = 'block';
            }

            // SweetAlert konfirmasi penghapusan
            await Swal.fire({
                icon: 'success',
                title: 'Terhapus!',
                text: 'LOT berhasil dihapus.',
                confirmButtonColor: '#28a745',
                timer: 1500,
                timerProgressBar: true
            });
        }
    }

    // Event listeners
    document.getElementById('saveLotBtn').addEventListener('click', addLot);
    document.getElementById('loadExistingLots').addEventListener('click', loadExistingLots);
    document.getElementById('loadLotBtn').addEventListener('click', loadLotDetail);
    document.getElementById('addParameterBtn').addEventListener('click', addNewParameter);

    // Event listener untuk department filter
    document.getElementById('filter_department_id').addEventListener('change', function() {
        const departmentId = this.value;
        if (departmentId) {
            loadLotsByDepartment(departmentId);
        } else {
            document.getElementById('filter_no_lot').innerHTML = '<option value="">Pilih No Lot</option>';
        }
    });

    // Auto-fill tanggal hari ini untuk use_qc dan last_qc
    document.getElementById('use_qc').addEventListener('focus', function() {
        if (!this.value) {
            const today = new Date().toISOString().split('T')[0];
            this.value = today;
        }
    });

    document.getElementById('last_qc').addEventListener('focus', function() {
        if (!this.value) {
            const today = new Date().toISOString().split('T')[0];
            this.value = today;
        }
    });

    // Custom styling untuk SweetAlert
    const style = document.createElement('style');
    style.textContent = `
        .swal2-popup {
            border-radius: 15px !important;
        }
        .swal2-title {
            font-size: 1.5rem !important;
        }
        .swal2-content {
            font-size: 1rem !important;
        }
        .animate__animated {
            animation-duration: 0.5s;
        }
        .animate__fadeInUp {
            animation-name: fadeInUp;
        }
        .animate__fadeOutDown {
            animation-name: fadeOutDown;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 100%, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        @keyframes fadeOutDown {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
                transform: translate3d(0, 100%, 0);
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush