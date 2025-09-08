@extends('layouts.admin')
<title>Qc</title>
<style>
    .subheader {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        height: 25px;
    }

    .subheader h2 {
        font-size: 14px;
        color: #9ca3af;
        font-weight: normal;
        margin: 0;
    }

    .chart-wrapper {
        padding: 20px;
        position: relative;
        height: 450px;
    }

    .chart-canvas {
        width: 100% !important;
        height: 100% !important;
    }

    .card-body {
        overflow-x: auto;
    }

    .result-input {
        width: 80px;
        font-size: 12px;
        text-align: center;
    }

    .parameter-row:hover {
        background-color: #f8f9fa;
    }

    .flag-cell {
        text-align: center;
        font-weight: bold;
    }

    .flag-normal { color: #28a745; }
    .flag-low { color: #dc3545; }
    .flag-high { color: #007bff; }
    .flag-critical { color: #fd7e14; }

    .btn-action {
        padding: 4px 8px;
        font-size: 12px;
        margin: 1px;
    }

    .loading {
        opacity: 0.7;
        pointer-events: none;
    }

    /* Chart Modal Styles */
    .chart-modal .modal-dialog {
        max-width: 90%;
        width: 1200px;
    }

    .chart-modal .modal-body {
        padding: 0;
    }

    .chart-modal .chart-wrapper {
        height: 500px;
        padding: 20px;
    }

    /* Chart Button Styles */
    .btn-chart {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-chart:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    /* Styling untuk header duplo */
    .duplo-header {
        min-width: 80px;
        text-align: center;
        position: sticky;
        right: 0;
        background-color: #f8f9fa;
        z-index: 1;
    }

    .duplo-cell {
        min-width: 80px;
        text-align: center;
    }

    .parameter-cell {
        position: sticky;
        left: 0;
        background-color: white;
        z-index: 2;
        min-width: 200px;
    }

    .flag-cell {
        position: sticky;
        right: 0;
        background-color: white;
        z-index: 2;
        min-width: 100px;
    }

    .table-container {
        overflow-x: auto;
        max-width: 100%;
    }

    /* Sticky header */
    .table thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 3;
    }
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 10px 0;
        gap: 10px;
    }
    
    .page-btn {
        width: 30px;
        height: 30px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        border: 1px solid #dee2e6;
        background: white;
        cursor: pointer;
    }
    
    .page-btn.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }
    
    .page-btn:hover:not(.active) {
        background-color: #e9ecef;
    }
    
    .page-info {
        font-size: 14px;
        color: #6c757d;
        margin: 0 10px;
    }
    
    .nav-btn {
        padding: 4px 8px;
        border: 1px solid #dee2e6;
        background: white;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .nav-btn:hover:not(:disabled) {
        background-color: #e9ecef;
    }
    
    .nav-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Scroll horizontal untuk duplo */
    .duplo-scroll-container {
        overflow-x: auto;
        max-width: calc(80px * 7); /* Maksimal 7 duplo yang terlihat */
    }

    /* Manual parameter input */
    .manual-param-input {
        width: 150px;
        display: inline-block;
        margin-right: 5px;
    }

    /* Hidden elements */
    .initially-hidden {
        display: none;
    }
</style>

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3 class="fw-bold text-center w-100">Department {{ $departments->nama_department }}</h3>
    </div>

    <!-- Department ID (hidden) -->
    <input type="hidden" id="departmentId" value="{{ $departments->id }}">
    <input type="hidden" id="departmentName" value="{{ $departments->nama_department }}">

    <!-- Filter Row -->
    <div class="row mb-3">
        <div class="col-md-3">
            <select class="form-control" id="levelFilter" onchange="loadQCData()">
                <option value="" selected hidden>Pilih Level</option>
                <option value="Normal">Normal</option>
                <option value="Low">Low</option>
                <option value="High">High</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-control" id="lotFilter" onchange="loadQCData()" disabled>
                <option value="" selected hidden>Pilih LOT</option>
            </select>
        </div>
        <div class="col-md-2">
            <a href="{{ route('qh.index') }}" class="btn btn-outline-primary w-100">History</a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('qc.lot.create') }}" class="btn btn-outline-secondary w-100">Lot</a>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-info w-100" onclick="showChartModal()">
                <i class="bi bi-graph-up me-2"></i>Show Chart
            </button>
        </div>
    </div>

    <!-- Main Content - Full Width QC Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Action buttons (initially hidden) -->
                    <div id="actionButtons" class="d-flex gap-3 mb-3 initially-hidden w-100 text-end">
                        <a href="{{ route('Qc.index') }}" class="btn btn-outline-primary" title="Back To Qc"><i class="ti ti-arrow-left"></i></a>
                        <button class="btn btn-outline-success btn-sm" onclick="saveResults()">Save</button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="duplicateResults()">Duplo</button>
                        <button class="btn btn-outline-danger btn-sm" onclick="cancelResults()">Cancel</button>
                        <div class="d-flex align-items-center ms-auto">
                            <label class="me-2 small">Test Date:</label>
                            <input type="date" id="testDate" class="form-control form-control-sm" style="width: 140px;">
                            <button class="btn btn-outline-info btn-sm ms-2" onclick="useTodayDate()" title="Use Today">
                                <i class="ti ti-calendar"></i>
                            </button>
                        </div>
                        <div id="manualParamContainer"></div>
                    </div>

                    <!-- QC Info Display (initially hidden) -->
                    <div id="qcInfo" class="mb-3 p-2 bg-light rounded initially-hidden">
                        <div class="row">
                            <div class="col-3">
                                <small><strong>Control:</strong> <span id="controlName">-</span></small>
                            </div>
                            <div class="col-3">
                                <small><strong>LOT:</strong> <span id="lotNumber">-</span></small>
                            </div>
                            <div class="col-3">
                                <small><strong>Level:</strong> <span id="controlLevel">-</span></small>
                            </div>
                            <div class="col-3">
                                <small><strong>Date:</strong> <span id="qcDate">-</span></small>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination Controls (initially hidden) -->
                    <div id="paginationControls" class="pagination-container initially-hidden">
                        <button class="nav-btn" onclick="changeDuploPage(currentPage - 1)" id="prevPageBtn">
                            <i class="ti ti-chevron-left"></i>
                        </button>
                        <div id="pageNumbers" class="d-flex gap-1"></div>
                        <span class="page-info" id="pageInfo"></span>
                        <button class="nav-btn" onclick="changeDuploPage(currentPage + 1)" id="nextPageBtn">
                            <i class="ti ti-chevron-right"></i>
                        </button>
                    </div>

                    <div class="table-container">
                        <table class="table table-sm align-middle" id="parametersTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="parameter-cell">Parameter</th>
                                    <th width="12%">Hasil</th>
                                    <th class="switch-header" style="min-width: 50px; text-align: center;">Switch</th>
                                    <!-- Duplo headers akan ditambahkan secara dinamis -->
                                    <th class="flag-cell">Flag</th>
                                </tr>
                            </thead>
                            <tbody id="parametersBody">
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        Pilih Level dan LOT untuk memulai
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Modal -->
<div class="modal fade chart-modal" id="chartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Quality Control Chart</h5>
                <div class="d-flex gap-2 me-3">
                    <select id="parameterSelector" class="form-select form-select-sm" onchange="changeParameter()" style="width: 200px;">
                        <option value="">Pilih Parameter</option>
                    </select>
                    <button class="btn btn-sm btn-outline-secondary" onclick="refreshChart()" title="Refresh">
                        <i class="ti ti-rotate-clockwise"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary" onclick="exportChart()" title="Export">
                        <i class="ti ti-download"></i>
                    </button>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <!-- Chart Subheader -->
            <div class="subheader border-bottom">
                <h2 id="chartParameterName">Pilih Parameter</h2>
                <div class="text-muted small">
                    <span id="chartInfo">Select a parameter to view trend data</span>
                </div>
            </div>
            
            <div class="modal-body">
                <!-- Chart -->
                <div class="chart-wrapper">
                    <canvas id="qcChart" class="chart-canvas"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<script>
// ================== PARAMETER HEMATOLOGI ==================
const hematologiParams = [
    { nama: 'WBC', display_name: 'Leukosit', satuan: '10³/µL' },
    { nama: 'LYM#', display_name: 'LYM#', satuan: '10³/µL' },
    { nama: 'MID#', display_name: 'MID#', satuan: '10³/µL' },
    { nama: 'GRAN#', display_name: 'GRAN#', satuan: '10³/µL' },
    { nama: 'LYM%', display_name: 'Limfosit', satuan: '%' },
    { nama: 'MID%', display_name: 'Monosit', satuan: '%' },
    { nama: 'GRAN%', display_name: 'Granulosit', satuan: '%' },
    { nama: 'RBC', display_name: 'Eritrosit', satuan: 'Juta/mm³' },
    { nama: 'HGB', display_name: 'Hemoglobin', satuan: 'g/dL' },
    { nama: 'HCT', display_name: 'Hematokrit', satuan: '%' },
    { nama: 'MCV', display_name: 'MCV', satuan: 'fL' },
    { nama: 'MCH', display_name: 'MCH', satuan: 'pg' },
    { nama: 'MCHC', display_name: 'MCHC', satuan: 'g/dL' },
    { nama: 'RDW-CV', display_name: 'RDW-CV', satuan: '%' },
    { nama: 'RDW-SD', display_name: 'RDW-SD', satuan: 'fL' },
    { nama: 'PLT', display_name: 'Trombosit', satuan: '10³/µL' },
    { nama: 'MPV', display_name: 'MPV', satuan: 'fL' },
    { nama: 'PDW', display_name: 'PDW', satuan: 'fL' },
    { nama: 'PCT', display_name: 'PCT', satuan: '%' },
    { nama: 'P-LCC', display_name: 'P-LCC', satuan: '10³/µL' },
    { nama: 'P-LCR', display_name: 'P-LCR', satuan: '%' }
];

// ================== GLOBAL VARIABEL ==================
let currentQcData = null;
let currentResults = [];
let qcChart = null;
let selectedParameter = '';
let isLoading = false;
let currentParameters = [];
let duploCount = 0;
let currentPage = 1;
const MAX_DUPLO_PER_PAGE = 7;
let isHematology = false;

// ================== FUNGSI UNTUK MENAMPILKAN ELEMEN ==================
function showElements() {
    document.getElementById('actionButtons').style.display = 'flex';
    document.getElementById('qcInfo').style.display = 'block';
    document.getElementById('paginationControls').style.display = 'flex';
}

function hideElements() {
    document.getElementById('actionButtons').style.display = 'none';
    document.getElementById('qcInfo').style.display = 'none';
    document.getElementById('paginationControls').style.display = 'none';
}

// ================== INISIALISASI DEPARTMENT ==================
function initDepartment() {
    const departmentId = document.getElementById('departmentId').value;
    const departmentName = document.getElementById('departmentName').value.toLowerCase();
    
    isHematology = departmentName.includes('hematologi');
    
    // Sembunyikan elemen sampai level dan LOT dipilih
    hideElements();
    
    if (isHematology) {
        currentParameters = hematologiParams.map(p => ({ parameter: p.nama }));
    } else {
        // Untuk department lain, kita akan memuat parameter dari server
        loadParametersFromServer(departmentId);
    }
}

// Memuat parameter dari server untuk department non-hematologi
async function loadParametersFromServer(departmentId) {
    try {
        const response = await fetch(`/api/get-parameters/${departmentId}`);
        const data = await response.json();
        
        if (data.success && data.parameters && data.parameters.length > 0) {
            currentParameters = data.parameters;
        } else {
            // Jika tidak ada parameter, izinkan input manual
            currentParameters = [];
            enableManualParameterInput();
        }
    } catch (error) {
        console.error('Error loading parameters:', error);
        currentParameters = [];
        enableManualParameterInput();
    }
}

// Mengizinkan input manual parameter untuk department non-hematologi
function enableManualParameterInput() {
    const container = document.getElementById('manualParamContainer');
    container.innerHTML = `
        <div class="d-flex align-items-center">
            <input type="text" id="newParamName" class="form-control form-control-sm manual-param-input" placeholder="Nama parameter">
            <button class="btn btn-primary btn-sm" onclick="addManualParameter()" title="Tambah parameter">
                <i class="ti ti-plus"></i>
            </button>
        </div>
    `;
}

// Menambah parameter manual
function addManualParameter() {
    const paramName = document.getElementById('newParamName').value.trim();
    if (paramName) {
        currentParameters.push({ parameter: paramName });
        document.getElementById('newParamName').value = '';
        displayParameters();
    } else {
        alert('Silakan masukkan nama parameter');
    }
}

function getMeta(parameter) {
    // Cari di parameter hematologi terlebih dahulu
    const hematologyParam = hematologiParams.find(p => p.nama === parameter);
    if (hematologyParam) return hematologyParam;
    
    // Untuk parameter non-hematologi, kembalikan objek dasar
    return {
        nama: parameter,
        display_name: parameter,
        satuan: '',
        normal_min_l: 0,
        normal_max_l: 100
    };
}

function getFlag(value, meta) {
    if (!value || !meta) return "-";
    let min = meta.normal_min_l || 0; 
    let max = meta.normal_max_l || 100; 
    if (value < min) return "↓ Low";
    if (value > max) return "↑ High";
    return "✓ Normal";
}

// ================== FUNGSI DUPLO DENGAN PAGINATION ==================
function duplicateResults() {
    duploCount++;
    updatePagination();
    displayParameters();
}

function cancelResults() {
    if (duploCount > 0) {
        duploCount--;
        updatePagination();
        displayParameters();
    }
}

// ================== PAGINATION FUNCTIONS ==================
function updatePagination() {
    const totalPages = Math.ceil(duploCount / MAX_DUPLO_PER_PAGE);
    const paginationControls = document.getElementById('paginationControls');
    const pageNumbers = document.getElementById('pageNumbers');
    const pageInfo = document.getElementById('pageInfo');
    const prevPageBtn = document.getElementById('prevPageBtn');
    const nextPageBtn = document.getElementById('nextPageBtn');

    // Tampilkan atau sembunyikan pagination controls
    if (duploCount > MAX_DUPLO_PER_PAGE) {
        paginationControls.style.display = 'flex';
    } else {
        paginationControls.style.display = 'none';
        currentPage = 1;
        return;
    }

    // Update status tombol navigasi
    prevPageBtn.disabled = currentPage === 1;
    nextPageBtn.disabled = currentPage === totalPages;

    // Generate page numbers
    pageNumbers.innerHTML = '';
    const startPage = Math.max(1, currentPage - 2);
    const endPage = Math.min(totalPages, startPage + 4);

    for (let i = startPage; i <= endPage; i++) {
        const pageBtn = document.createElement('button');
        pageBtn.className = `page-btn ${i === currentPage ? 'active' : ''}`;
        pageBtn.textContent = i;
        pageBtn.onclick = () => changeDuploPage(i);
        pageNumbers.appendChild(pageBtn);
    }

    // Update page info
    pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
}

function changeDuploPage(page) {
    const totalPages = Math.ceil(duploCount / MAX_DUPLO_PER_PAGE);
    if (page < 1 || page > totalPages) return;
    
    currentPage = page;
    updatePagination();
    displayParameters();
}

function getVisibleDuploRange() {
    const startIndex = (currentPage - 1) * MAX_DUPLO_PER_PAGE;
    const endIndex = Math.min(startIndex + MAX_DUPLO_PER_PAGE, duploCount);
    return { start: startIndex, end: endIndex };
}

// ================== FUNGSI SWITCH ==================
function rotateValues(parameter) {
    const result = currentResults.find(r => r.parameter === parameter);
    if (!result) return;
    
    const values = [result.result || ''];
    if (result.duplo) {
        for (let i = 0; i < duploCount; i++) {
            values.push(result.duplo[i] || '');
        }
    } else {
        for (let i = 0; i < duploCount; i++) {
            values.push('');
        }
    }
    
    if (values.length <= 1) return;
    
    const firstValue = values.shift();
    values.push(firstValue);
    
    result.result = values[0];
    if (!result.duplo) result.duplo = [];
    for (let i = 1; i < values.length; i++) {
        result.duplo[i - 1] = values[i];
    }
    
    displayParameters();
}

// ================= Update Data =================
function updateResult(parameter, value, index) {
    let result = currentResults.find(r => r.parameter === parameter);
    if (!result) {
        result = { parameter };
        currentResults.push(result);
    }
    
    if (index === 0) {
        result.result = value;
    } else {
        if (!result.duplo) result.duplo = [];
        result.duplo[index - 1] = value;
    }
    
    // Hitung rata-rata jika ada duplo
    if (result.duplo && result.duplo.length > 0) {
        const validValues = result.duplo.filter(val => val !== '' && !isNaN(parseFloat(val)));
        if (validValues.length > 0) {
            const sum = validValues.reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
            result.result = (sum / validValues.length).toFixed(2);
        }
    }
    
    displayParameters();
}

// ================== HELPER ==================
function getDisplayName(parameter) {
    // Cari di parameter hematologi terlebih dahulu
    const hematologyParam = hematologiParams.find(p => p.nama === parameter);
    if (hematologyParam) return hematologyParam.display_name;
    
    // Untuk parameter non-hematologi, gunakan nama asli
    return parameter;
}

// ================== CHART MODAL ==================
function showChartModal() {
    if (!currentQcData) {
        alert('Silakan pilih Level dan LOT terlebih dahulu');
        return;
    }
    
    updateParameterSelector();
    const modal = new bootstrap.Modal(document.getElementById('chartModal'));
    modal.show();
    
    setTimeout(() => {
        if (!qcChart) {
            initChart();
        }
        loadChartData();
    }, 300);
}

// ================== INIT ==================
document.addEventListener('DOMContentLoaded', function() {
    initDepartment();
    loadLevels();
    setDefaultDate();
    setupEventListeners();
});

// ================== FUNGSI TANGGAL ==================
function useTodayDate() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('testDate').value = today;
}

function setDefaultDate() {
    const today = new Date().toISOString().split('T')[0];
    const testDateElement = document.getElementById('testDate');
    if (testDateElement) {
        testDateElement.value = today;
    }
}

document.getElementById("testDate").addEventListener("change", function() {
    if (currentQcData && currentQcData.id) {
        loadQCDetails(currentQcData.id);
    }
});


function mapApiResultsToHematology(apiResults) {
    const mappedResults = [];

    hematologiParams.forEach(param => {
        const match = apiResults.find(r => r.identifier_name === param.nama);
        if (match) {
            // Ambil min/max dari identifier_range kalau ada (contoh "4.5-5.9")
            let min = null, max = null;
            if (match.identifier_range && match.identifier_range.includes("-")) {
                const [low, high] = match.identifier_range.split("-").map(v => parseFloat(v));
                min = low;
                max = high;
            }

            mappedResults.push({
                parameter: param.nama,
                result: match.identifier_value,
                unit: match.identifier_unit || param.satuan,
                range: match.identifier_range,
                flag: match.identifier_flags,
                normal_min_l: min,
                normal_max_l: max
            });
        } else {
            mappedResults.push({
                parameter: param.nama,
                result: null,
                unit: param.satuan,
                range: null,
                flag: null,
                normal_min_l: null,
                normal_max_l: null
            });
        }
    });

    return mappedResults;
}



function setupEventListeners() {
    const lotFilter = document.getElementById('lotFilter');
    lotFilter.onchange = null;
    lotFilter.addEventListener('change', function() {
        const selectedLot = this.value;
        if (selectedLot) {
            loadQCDetails(selectedLot);
        } else {
            clearQCData();
        }
    });
}

// ================== LEVEL & LOT ==================
async function loadLevels() {
    try {
        const departmentId = document.getElementById('departmentId').value;
        const response = await fetch(`/analyst/api/get-qc-levels?department_id=${departmentId}`);
        const data = await response.json();
        const levelSelect = document.getElementById('levelFilter');
        levelSelect.innerHTML = '<option value="" selected hidden>Pilih Level</option>';
        if (data.success && data.levels) {
            data.levels.forEach(level => {
                levelSelect.innerHTML += `<option value="${level}">${level}</option>`;
            });
        }
    } catch (error) {
        console.error('Error loading levels:', error);
    }
}

async function loadQCData() {
    const level = document.getElementById('levelFilter').value;
    const departmentId = document.getElementById('departmentId').value;
    const lotSelect = document.getElementById('lotFilter');
    const previouslySelectedLot = lotSelect.value;
    
    lotSelect.innerHTML = '<option value="" selected hidden>Pilih LOT</option>';
    lotSelect.disabled = true;

    if (!level) {
        clearQCData();
        return;
    }
    
    try {
        const response = await fetch(`/analyst/api/get-qc-by-level/${level}?department_id=${departmentId}`);
        const data = await response.json();
        if (data.success && data.qcs) {
            data.qcs.forEach(qc => {
                const option = document.createElement('option');
                option.value = qc.id;
                option.textContent = `${qc.no_lot} - ${qc.name_control}`;
                
                if (qc.id == previouslySelectedLot) {
                    option.selected = true;
                }
                
                lotSelect.appendChild(option);
            });
            lotSelect.disabled = false;
            
            if (lotSelect.value) {
                loadQCDetails(lotSelect.value);
            } else {
                clearQCData();
            }
        }
    } catch (error) {
        console.error('Error loading QC data:', error);
    }
}

// Ambil data QC detail dari API /api/qc/{id}
async function loadQCDetails(qcId) {
    if (!qcId) {
        clearQCData();
        return;
    }

    try {
        isLoading = true;
        const tbody = document.getElementById('parametersBody');
        tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">Loading...</td></tr>';

        const response = await fetch(`/api/qc/${qcId}`);
        const data = await response.json();

        if (data.status === "success" && data.data) {
            const qc = data.data.qc;
            const results = data.data.results || [];
            const source = data.data.source;
            currentQcData = qc;

            // 🔹 Ambil test date dari input (yyyy-mm-dd)
            const testDateInput = document.getElementById("testDate").value;
            const selectedDate = testDateInput ? testDateInput : null;

            // 🔹 Filter berdasarkan tanggal
            let filteredResults = results;
            if (selectedDate && source !== 'alat') {
                // Untuk data manual, gunakan test_date
                filteredResults = results.filter(r => {
                    if (!r.test_date) return false;
                    
                    // Handle berbagai format tanggal
                    let resultDate;
                    if (r.test_date.includes(' ')) {
                        // Format: YYYY-MM-DD HH:mm:ss
                        resultDate = r.test_date.split(' ')[0];
                    } else if (r.test_date.includes('T')) {
                        // Format: YYYY-MM-DDTHH:mm:ss
                        resultDate = r.test_date.split('T')[0];
                    } else {
                        // Format: YYYY-MM-DD
                        resultDate = r.test_date;
                    }
                    
                    console.log(`Comparing: ${resultDate} === ${selectedDate}`);
                    return resultDate === selectedDate;
                });
            } else if (selectedDate && source === 'alat') {
                // Untuk data dari alat, gunakan tanggal
                filteredResults = results.filter(r => {
                    if (!r.tanggal) return false;
                    const resultDate = r.tanggal.substring(0, 10);
                    return resultDate === selectedDate;
                });
            }

            console.log('Source:', source);
            console.log('All results:', results);
            console.log('Filtered results:', filteredResults);

            if (isHematology) {
                currentResults = mapApiResultsToHematology(filteredResults);
                currentParameters = hematologiParams.map(p => ({ parameter: p.nama }));
            } else {
                // 🔹 Untuk data manual
                if (source === 'manual') {
                    currentResults = filteredResults || [];
                    
                    // Ambil parameter dari DetailLot
                    if (data.data.parameters && data.data.parameters.length > 0) {
                        currentParameters = data.data.parameters.map(p => ({ parameter: p.parameter }));
                    } else {
                        // Fallback: ambil parameter unik dari results
                        const uniqueParams = [...new Set(filteredResults.map(r => r.parameter))];
                        currentParameters = uniqueParams.map(param => ({ parameter: param }));
                    }
                } else {
                    // 🔹 Untuk data dari alat
                    currentResults = filteredResults || [];
                    const uniqueParams = [...new Set(filteredResults.map(r => r.identifier_name))];
                    currentParameters = uniqueParams.map(param => ({ parameter: param }));
                }
            }

            console.log('Current Parameters:', currentParameters);
            console.log('Current Results:', currentResults);

            displayQCInfo();
            displayParameters();
            updateParameterSelector();
            showElements();
        } else {
            console.error('Failed to load QC details:', data.msg);
            clearQCData();
        }
    } catch (error) {
        console.error('Error loading QC details:', error);
        clearQCData();
    } finally {
        isLoading = false;
    }
}



function clearQCData() {
    document.getElementById('parametersBody').innerHTML = `
        <tr><td colspan="8" class="text-center text-muted">Pilih Level dan LOT untuk memulai</td></tr>`;
    document.getElementById('parameterSelector').innerHTML = '<option value="">Pilih Parameter</option>';
    document.getElementById('chartParameterName').textContent = 'Pilih Parameter';
    
    if (qcChart) {
        qcChart.data.labels = [];
        qcChart.data.datasets[0].data = [];
        qcChart.update();
    }
    
    currentQcData = null;
    currentResults = [];
    selectedParameter = '';
    duploCount = 0;
    currentPage = 1;
    
    // Sembunyikan elemen saat data di-clear
    hideElements();
}

function displayQCInfo() {
    if (!currentQcData) return;
    document.getElementById('controlName').textContent = currentQcData.name_control || '-';
    document.getElementById('lotNumber').textContent = currentQcData.no_lot || '-';
    document.getElementById('controlLevel').textContent = currentQcData.level || '-';
    document.getElementById('qcDate').textContent = currentQcData.use_qc || '-';
}

// ================== PARAMETER TABLE ==================
function displayParameters() {
    const tbody = document.getElementById('parametersBody');
    const thead = document.querySelector('#parametersTable thead tr');
    
    tbody.innerHTML = '';
    
    // Bersihkan header duplo sebelumnya
    const existingDuploHeaders = thead.querySelectorAll('.duplo-header');
    existingDuploHeaders.forEach(header => header.remove());
    
    // Dapatkan range duplo yang terlihat
    const { start: startIndex, end: endIndex } = getVisibleDuploRange();
    const visibleDuploCount = endIndex - startIndex;
    
    // Tambahkan header duplo untuk yang terlihat
    for (let i = startIndex; i < endIndex; i++) {
        const th = document.createElement('th');
        th.className = 'duplo-header';
        th.textContent = `D${i + 1}`;
        th.style.minWidth = '80px';
        th.style.textAlign = 'center';
        
        // Sisipkan sebelum kolom flag
        const flagCell = thead.querySelector('.flag-cell');
        thead.insertBefore(th, flagCell);
    }
    
    // Isi data parameter
    if (currentParameters && currentParameters.length > 0) {
        currentParameters.forEach(param => {
            const result = currentResults.find(r => r.parameter === param.parameter) || {};
            const meta = getMeta(param.parameter);
            
            const row = document.createElement('tr');
            row.className = 'parameter-row';
            
            // Kolom Parameter
            const paramCell = document.createElement('td');
            paramCell.className = 'parameter-cell';
            paramCell.innerHTML = `<strong>${getDisplayName(param.parameter)}</strong>`;
            row.appendChild(paramCell);
            
            // Kolom Hasil
            const resultCell = document.createElement('td');
            resultCell.innerHTML = `
                <input type="number" step="0.01" 
                    value="${result.result || ''}" 
                    class="form-control form-control-sm text-center result-input"
                    name="result"
                    onchange="updateResult('${param.parameter}', this.value, 0)" />
            `;
            row.appendChild(resultCell);
            
            // Kolom Switch Button
            const switchCell = document.createElement('td');
            switchCell.className = 'switch-cell';
            switchCell.innerHTML = `
                <div class="switch-container">
                    <button class="btn btn-outline-secondary switch-btn" onclick="rotateValues('${param.parameter}')">
                        <i class="ti ti-switch-2"></i>
                    </button>
                </div>
            `;
            row.appendChild(switchCell);
            
            // Kolom Duplo (hanya yang terlihat)
            for (let i = startIndex; i < endIndex; i++) {
                const duploCell = document.createElement('td');
                duploCell.className = 'duplo-cell';
                duploCell.innerHTML = `
                    <input type="number" step="0.01"
                        value="${result.duplo && result.duplo[i] ? result.duplo[i] : ''}"
                        class="form-control form-control-sm text-center result-input"
                        onchange="updateResult('${param.parameter}', this.value, ${i + 1})" />
                `;
                row.appendChild(duploCell);
            }
            
            // Kolom Flag
            const flagCell = document.createElement('td');
            flagCell.className = 'flag-cell';
            const flagValue = result.result ? parseFloat(result.result) : null;
            const flag = getFlag(flagValue, meta);
            flagCell.innerHTML = flag;
            
            if (flag === "✓ Normal") flagCell.classList.add('flag-normal');
            else if (flag === "↓ Low") flagCell.classList.add('flag-low');
            else if (flag === "↑ High") flagCell.classList.add('flag-high');
            
            row.appendChild(flagCell);
            tbody.appendChild(row);
        });
    } else {
        tbody.innerHTML = `
            <tr><td colspan="${4 + visibleDuploCount}" class="text-center text-muted">Tidak ada parameter tersedia</td></tr>
        `;
    }
    
    // Update pagination
    updatePagination();
}

function updateParameterSelector() {
    const selector = document.getElementById('parameterSelector');
    selector.innerHTML = '<option value="">Pilih Parameter</option>';
    
    if (currentParameters && currentParameters.length > 0) {
        currentParameters.forEach(param => {
            const displayName = getDisplayName(param.parameter);
            selector.innerHTML += `<option value="${param.parameter}">${displayName}</option>`;
        });
    }
}

// ================== CHART ==================
function initChart() {
    const ctx = document.getElementById('qcChart').getContext('2d');
    qcChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'QC Results',
                data: [],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
                fill: false,
                tension: 0.1,
                yAxisID: 'y',
                zIndex: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 70,
                    right: 70,
                    top: 30,
                    bottom: 30
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: { 
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    callbacks: {
                        title: (ctx) => 'Date: ' + (ctx[0] ? ctx[0].label : ''),
                        label: function(ctx) {
                            // Tampilkan nilai asli dari originalData
                            if (qcChart && qcChart.originalData && qcChart.originalData[ctx.dataIndex] !== null && qcChart.originalData[ctx.dataIndex] !== undefined) {
                                const originalValue = qcChart.originalData[ctx.dataIndex];
                                return 'Value: ' + Number(originalValue).toFixed(2);
                            }
                            return 'Value: N/A';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { 
                        color: 'rgba(0,0,0,0.08)', 
                        drawBorder: false,
                        lineWidth: 0.5
                    },
                    ticks: { 
                        color: '#666', 
                        maxRotation: 45,
                        font: {
                            size: 11
                        }
                    }
                },
                y: {
                    type: 'linear',
                    position: 'left',
                    min: -1,
                    max: 11,
                    grid: { 
                        color: 'rgba(0,0,0,0.08)', 
                        drawBorder: false,
                        lineWidth: 0.5
                    },
                    ticks: {
                        stepSize: 2,
                        callback: function(value) {
                            const labels = {
                                11: '+3SD',
                                9: '+2SD', 
                                7: '+1SD',
                                5: 'Normal', // Changed from 'Normal' to 'Mean'
                                3: '-1SD',
                                1: '-2SD',
                                '-1': '-3SD'
                            };
                            return labels[value] || '';
                        },
                        color: '#666',
                        font: {
                            size: 11,
                            weight: 'bold'
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    position: 'right',
                    min: -1,
                    max: 11,
                    grid: { drawOnChartArea: false },
                    ticks: {
                        stepSize: 2,
                        color: '#333',
                        font: {
                            size: 10
                        },
                        callback: function(value) {
                            if (qcChart && qcChart.controlLimits) {
                                const L = qcChart.controlLimits;
                                const mapping = {
                                    11: L.plus3sd,
                                    9: L.plus2sd,
                                    7: L.plus1sd,
                                    5: L.mean, // Changed from L.standard to L.mean
                                    3: L.minus1sd,
                                    1: L.minus2sd,
                                    '-1': L.minus3sd
                                };
                                const numValue = mapping[value];
                                return (numValue !== undefined && numValue !== null && isFinite(numValue)) ? numValue.toFixed(2) : '';
                            }
                            return '';
                        }
                    }
                }
            }
        },
        plugins: [{
            id: 'controlLimits',
            afterDraw: function(chart) {
                if (!chart.controlLimits) return;

                const ctx = chart.ctx;
                const area = chart.chartArea;
                const yScale = chart.scales.y;

                ctx.save();

                const staticPositions = {
                    '+3SD': { yPos: 11, color: '#dc2626', width: 2, dash: [] },
                    '+2SD': { yPos: 9, color: '#ea580c', width: 1, dash: [6,3] },
                    '+1SD': { yPos: 7, color: '#16a34a', width: 1, dash: [4,2] },
                    'Normal': { yPos: 5, color: '#16a34a', width: 2, dash: [] }, // Display as 'Normal'
                    '-1SD': { yPos: 3, color: '#16a34a', width: 1, dash: [4,2] },
                    '-2SD': { yPos: 1, color: '#ea580c', width: 1, dash: [6,3] },
                    '-3SD': { yPos: -1, color: '#dc2626', width: 2, dash: [] }
                };

                Object.entries(staticPositions).forEach(([label, config]) => {
                    const y = yScale.getPixelForValue(config.yPos);
                    
                    if (y >= area.top && y <= area.bottom) {
                        ctx.strokeStyle = config.color;
                        ctx.lineWidth = config.width;
                        ctx.setLineDash(config.dash);
                        ctx.beginPath();
                        ctx.moveTo(area.left, y);
                        ctx.lineTo(area.right, y);
                        ctx.stroke();
                        ctx.setLineDash([]);
                    }
                });

                ctx.restore();
            }
        }]
    });
}

async function loadChartData() {
    if (!selectedParameter || !currentQcData) {
        if (qcChart) {
            qcChart.data.labels = [];
            qcChart.data.datasets[0].data = [];
            qcChart.originalData = [];
            qcChart.controlLimits = null;
            qcChart.update();
        }
        return;
    }

    try {
        console.log(`Loading chart data for parameter: ${selectedParameter}, QC ID: ${currentQcData.id}`);
        
        const response = await fetch(`/analyst/api/get-chart-data/${currentQcData.id}/${selectedParameter}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('Chart data response:', data);

        if (!data.success || !qcChart) {
            console.warn('Chart data not successful or qcChart not initialized');
            return;
        }

        const controlResponse = await fetch(`/analyst/api/get-control-limits/${currentQcData.id}/${selectedParameter}`);
        if (!controlResponse.ok) {
            throw new Error(`Control limits HTTP error! status: ${controlResponse.status}`);
        }
        
        const controlData = await controlResponse.json();
        console.log('Control limits response:', controlData);

        const labels = data.labels || [];
        const values = (data.values || []).map(v => {
            if (v === null || v === undefined || v === '') return null;
            const num = Number(v);
            return isNaN(num) ? null : num;
        });

        console.log('Processed values:', values);
        console.log('Labels:', labels);

        // Validasi data
        if (labels.length === 0 && values.length === 0) {
            console.warn('No data available for this parameter');
            // Clear chart but don't return, still try to set up control limits
        }

        let controlLimits = null;

        if (controlData.success && controlData.limits) {
            const limits = controlData.limits;
            console.log('Raw control limits:', limits);
            
            const mean = parseFloat(limits.mean);
            const rangeRaw = parseFloat(limits.range);
            const standard = parseFloat(limits.standard);
            const btsAtas = parseFloat(limits.bts_atas);
            const btsBawah = parseFloat(limits.bts_bawah);

            // Use mean as the center point (changed from standard)
            let center = mean;
            if (!isFinite(center)) {
                center = standard; // Fallback to standard if mean is not available
            }
            if (!isFinite(center)) {
                // Calculate from data if both mean and standard are not available
                const validValues = values.filter(v => v !== null && isFinite(v));
                if (validValues.length > 0) {
                    center = validValues.reduce((a, b) => a + b, 0) / validValues.length;
                } else {
                    console.warn('No valid center point found, using 0');
                    center = 0;
                }
            }

            let sdRange = rangeRaw;
            if (!isFinite(sdRange) || sdRange <= 0) {
                const validValues = values.filter(v => v !== null && isFinite(v));
                if (validValues.length > 1) {
                    const variance = validValues.reduce((sum, val) => sum + Math.pow(val - center, 2), 0) / (validValues.length - 1);
                    sdRange = Math.sqrt(variance);
                    console.log('Calculated SD from data:', sdRange);
                } else {
                    sdRange = 1; // Default fallback
                    console.warn('Using default SD range of 1');
                }
            }

            controlLimits = {
                mean: center, // Use mean as the center
                standard: isFinite(standard) ? standard : center,
                range: sdRange,
                bts_atas: isFinite(btsAtas) ? btsAtas : null,
                bts_bawah: isFinite(btsBawah) ? btsBawah : null,
                plus3sd: center + (sdRange * 3),
                plus2sd: center + (sdRange * 2),
                plus1sd: center + (sdRange * 1),
                minus1sd: center - (sdRange * 1),
                minus2sd: center - (sdRange * 2),
                minus3sd: center - (sdRange * 3)
            };

            console.log('Final control limits:', controlLimits);
        } else {
            console.warn('No control limits data available');
        }

        // Convert values to chart positions
        let mappedValues = [];
        if (controlLimits && values.length > 0) {
            mappedValues = values.map(value => {
                if (value === null || value === undefined || !isFinite(value)) return null;
                
                const center = controlLimits.mean; // Use mean as center
                const sdRange = controlLimits.range;
                
                if (sdRange === 0) {
                    return 5; // Return center position if no variation
                }
                
                // Calculate SD position
                const sdPosition = (value - center) / sdRange;
                
                // Map to chart range (-1 to 11), where 5 is the mean
                const chartPosition = 5 + (sdPosition * 2);
                
                console.log(`Value ${value} -> SD pos ${sdPosition.toFixed(2)} -> Chart pos ${chartPosition.toFixed(2)}`);
                
                return chartPosition;
            });
        } else if (values.length > 0) {
            // If no control limits, map values directly but this shouldn't happen in normal cases
            console.warn('No control limits available, cannot map values properly');
            mappedValues = values.map(() => 5); // Put all at center
        }

        console.log('Mapped values:', mappedValues);

        // Update chart
        qcChart.originalData = values;
        qcChart.data.labels = labels;
        qcChart.data.datasets[0].data = mappedValues;
        qcChart.controlLimits = controlLimits;

        qcChart.update('none');
        console.log('Chart updated successfully');

    } catch (err) {
        console.error('Error loadChartData:', err);
        
        // Clear chart on error
        if (qcChart) {
            qcChart.data.labels = [];
            qcChart.data.datasets[0].data = [];
            qcChart.originalData = [];
            qcChart.controlLimits = null;
            qcChart.update();
        }
    }
}

function resizeChart() {
    if (qcChart) {
        qcChart.resize();
    }
}

window.addEventListener('resize', resizeChart);

function changeParameter() {
    selectedParameter = document.getElementById('parameterSelector').value;
    const displayName = getDisplayName(selectedParameter);
    document.getElementById('chartParameterName').textContent = displayName || 'Pilih Parameter';
    
    if (selectedParameter && currentQcData) {
        document.getElementById('chartInfo').textContent = `Trend data untuk ${displayName} - LOT: ${currentQcData.no_lot}`;
        console.log(`Parameter changed to: ${selectedParameter}`);
    } else {
        document.getElementById('chartInfo').textContent = 'Select a parameter to view trend data';
    }
    
    loadChartData();
}

function updateParameterSelector() {
    const selector = document.getElementById('parameterSelector');
    selector.innerHTML = '<option value="">Pilih Parameter</option>';
    
    if (currentParameters && currentParameters.length > 0) {
        currentParameters.forEach(param => {
            const displayName = getDisplayName(param.parameter);
            selector.innerHTML += `<option value="${param.parameter}">${displayName}</option>`;
        });
        console.log('Parameter selector updated with', currentParameters.length, 'parameters');
    } else {
        console.warn('No parameters available for selector');
    }
}

// Helper function to debug chart state
function debugChart() {
    console.log('=== CHART DEBUG INFO ===');
    console.log('qcChart exists:', !!qcChart);
    console.log('selectedParameter:', selectedParameter);
    console.log('currentQcData:', currentQcData);
    console.log('currentParameters:', currentParameters);
    if (qcChart) {
        console.log('Chart data:', qcChart.data);
        console.log('Original data:', qcChart.originalData);
        console.log('Control limits:', qcChart.controlLimits);
    }
    console.log('========================');
}


// ================== ADDITIONAL FUNCTIONS ==================
function refreshChart() {
    loadChartData();
}

function exportChart() {
    if (qcChart) {
        const url = qcChart.toBase64Image();
        const link = document.createElement('a');
        link.download = `qc-chart-${selectedParameter}.png`;
        link.href = url;
        link.click();
    }
}

// ================== SAVE RESULTS ==================
async function saveResults() {
    if (!currentResults || currentResults.length === 0) {
        Swal.fire({
            icon: "warning",
            title: "Tidak ada data",
            text: "⚠️ Belum ada data hasil yang dimasukkan.",
        });
        return;
    }

    if (!currentQcData || !currentQcData.id) {
        Swal.fire({
            icon: "error",
            title: "Data QC tidak valid",
            text: "❌ Silakan pilih Level dan LOT terlebih dahulu.",
        });
        return;
    }

    try {
        // Ambil tanggal dari input
        const testDateInput = document.getElementById("testDate");
        const testDate = testDateInput ? testDateInput.value : new Date().toISOString().split("T")[0];
        
        // Validasi tanggal
        if (!testDate) {
            Swal.fire({
                icon: "error",
                title: "Tanggal tidak valid",
                text: "❌ Silakan pilih tanggal test.",
            });
            return;
        }
        
        // Siapkan payload data
        const payload = {
            results: currentResults.map(r => {
                const duploArray = Array.isArray(r.duplo) ? r.duplo : [];

                return {
                    qc_id: currentQcData.id,
                    parameter: r.parameter,
                    test_date: testDate, // Gunakan tanggal dari input
                    result: r.result || null,
                    flag: getFlag(r.result, getMeta(r.parameter)),
                    d1: duploArray[0] || null,
                    d2: duploArray[1] || null,
                    d3: duploArray[2] || null,
                    d4: duploArray[3] || null,
                    d5: duploArray[4] || null,
                    notes: r.notes || null
                };
            })
        };

        console.log("Payload to send:", payload);

        const response = await fetch("/analyst/api/save-qc-results", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json"
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();
        console.log("Response from server:", data);

        if (response.ok && data.success) {
            Swal.fire({
                icon: "success",
                title: "Berhasil",
                text: `✅ ${data.message}`,
                showConfirmButton: false,
                timer: 2000
            });

            // Reload QC details
            if (currentQcData) {
                loadQCDetails(currentQcData.id);
            }

            // Reset hasil
            currentResults = [];
            duploCount = 0;
            updatePagination();

        } else {
            let errorMsg = "❌ Gagal menyimpan QC.";
            if (data.errors) {
                errorMsg += "\n" + Object.values(data.errors).flat().join("\n");
            } else if (data.message) {
                errorMsg += "\n" + data.message;
            }

            Swal.fire({
                icon: "error",
                title: "Gagal",
                text: errorMsg
            });
        }
    } catch (err) {
        console.error("Error saving:", err);
        Swal.fire({
            icon: "error",
            title: "Terjadi Kesalahan",
            text: "❌ Terjadi error saat menyimpan hasil QC: " + err.message,
        });
    }
}


function showHistory() {
    console.log('Showing history...');
}

// function showLotModal() {
//     console.log('Showing lot modal...');
// }
</script>
@endpush