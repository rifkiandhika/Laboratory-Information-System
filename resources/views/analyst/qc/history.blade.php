@extends('layouts.admin')
<title>QC History</title>
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

    .flag-cell {
        text-align: center;
        font-weight: bold;
    }

    .flag-normal { color: #28a745; }
    .flag-low { color: #dc3545; }
    .flag-high { color: #007bff; }
    .flag-critical { color: #fd7e14; }

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

    .parameter-cell {
        position: sticky;
        left: 0;
        background-color: white;
        z-index: 2;
        min-width: 200px;
    }

    /* History specific styles */
    .history-date-badge {
        background-color: #e3f2fd;
        color: #1976d2;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }

    .history-value {
        font-weight: 500;
    }

    .duplo-value {
        color: #666;
        font-size: 12px;
    }

    .no-data-message {
        color: #999;
        font-style: italic;
        text-align: center;
        padding: 40px 0;
    }

    .history-info-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: none;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }

    .info-label {
        font-weight: 600;
        color: #495057;
        min-width: 80px;
    }

    .info-value {
        color: #212529;
        font-weight: 500;
    }
</style>

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center my-3">
        <h3 class="fw-bold text-center w-100">QC History</h3>
    </div>

    <!-- Filter Row -->
    <div class="row mb-3">
        <div class="col-md-2">
            <select class="form-control" id="departmentFilter" onchange="loadLevels()">
                <option value="" selected hidden>Pilih Department</option>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-control" id="levelFilter" onchange="loadLots()" disabled>
                <option value="" selected hidden>Pilih Level</option>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-control" id="lotFilter" onchange="enableDateFilter()" disabled>
                <option value="" selected hidden>Pilih LOT</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" id="testDateFilter" class="form-control" onchange="enableSearch()" disabled>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100" onclick="loadHistoryData()" disabled id="searchBtn">
                <i class="ti ti-search me-2"></i>Search
            </button>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-info w-100" onclick="showChartModal()" disabled id="chartBtn">
                <i class="bi bi-graph-up me-2"></i>Show Chart
            </button>
        </div>
    </div>

    <!-- QC Info Display -->
    <div id="qcInfo" class="history-info-card" style="display: none;">
        <div class="row">
            <div class="col-3">
                <div class="info-item">
                    <span class="info-label">Control:</span>
                    <span class="info-value" id="controlName">-</span>
                </div>
            </div>
            <div class="col-3">
                <div class="info-item">
                    <span class="info-label">LOT:</span>
                    <span class="info-value" id="lotNumber">-</span>
                </div>
            </div>
            <div class="col-3">
                <div class="info-item">
                    <span class="info-label">Level:</span>
                    <span class="info-value" id="controlLevel">-</span>
                </div>
            </div>
            <div class="col-3">
                <div class="info-item">
                    <span class="info-label">Date:</span>
                    <span class="info-value" id="selectedDate">-</span>
                </div>
            </div>
        </div>
    </div>

    <!-- History Results -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-container">
                        <table class="table table-sm align-middle" id="historyTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="parameter-cell">Parameter</th>
                                    <th width="12%">Hasil</th>
                                    <th width="10%">D1</th>
                                    <th width="10%">D2</th>
                                    <th width="10%">D3</th>
                                    <th width="10%">D4</th>
                                    <th width="10%">D5</th>
                                    <th width="10%">Flag</th>
                                    <th width="15%">Created At</th>
                                </tr>
                            </thead>
                            <tbody id="historyBody">
                                <tr>
                                    <td colspan="9" class="text-center no-data-message">
                                        Pilih Department, Level, LOT, dan Tanggal untuk melihat history
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination untuk History -->
                    <div id="historyPagination" class="d-flex justify-content-center mt-3" style="display: none;">
                        <nav>
                            <ul class="pagination pagination-sm">
                                <!-- Pagination items akan dimuat secara dinamis -->
                            </ul>
                        </nav>
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
                <h5 class="modal-title">Quality Control Chart - History</h5>
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
                    <span id="chartInfo">Select a parameter to view historical trend data</span>
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
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
let currentHistoryResults = [];
let qcChart = null;
let selectedParameter = '';
let isLoading = false;
let currentParameters = [];
let isHematology = false;
let selectedDepartment = null;

// ================== INISIALISASI ==================
document.addEventListener('DOMContentLoaded', function() {
    loadDepartments();
    setDefaultDate();
});

function setDefaultDate() {
    const today = new Date().toISOString().split('T')[0];
    const testDateElement = document.getElementById('testDateFilter');
    if (testDateElement) {
        testDateElement.value = today;
    }
}

// ================== LOAD DEPARTMENTS ==================
async function loadDepartments() {
    try {
        const response = await fetch('/analyst/api/get-departments');
        const data = await response.json();
        const departmentSelect = document.getElementById('departmentFilter');
        
        departmentSelect.innerHTML = '<option value="" selected hidden>Pilih Department</option>';
        
        if (data.success && data.departments) {
            data.departments.forEach(dept => {
                departmentSelect.innerHTML += `<option value="${dept.id}">${dept.nama_department}</option>`;
            });
        }
    } catch (error) {
        console.error('Error loading departments:', error);
    }
}

// ================== LOAD LEVELS ==================
async function loadLevels() {
    const departmentId = document.getElementById('departmentFilter').value;
    const levelSelect = document.getElementById('levelFilter');
    const lotSelect = document.getElementById('lotFilter');
    const dateFilter = document.getElementById('testDateFilter');
    const searchBtn = document.getElementById('searchBtn');
    const chartBtn = document.getElementById('chartBtn');
    
    // Reset dependent filters
    levelSelect.innerHTML = '<option value="" selected hidden>Pilih Level</option>';
    levelSelect.disabled = true;
    lotSelect.innerHTML = '<option value="" selected hidden>Pilih LOT</option>';
    lotSelect.disabled = true;
    dateFilter.disabled = true;
    searchBtn.disabled = true;
    chartBtn.disabled = true;
    
    clearHistoryData();
    
    if (!departmentId) return;
    
    // Set department info
    selectedDepartment = await getDepartmentInfo(departmentId);
    
    try {
        const response = await fetch(`/analyst/api/get-qc-levels?department_id=${departmentId}`);
        const data = await response.json();
        
        if (data.success && data.levels) {
            data.levels.forEach(level => {
                levelSelect.innerHTML += `<option value="${level}">${level}</option>`;
            });
            levelSelect.disabled = false;
        }
    } catch (error) {
        console.error('Error loading levels:', error);
    }
}

// ================== LOAD LOTS ==================
async function loadLots() {
    const level = document.getElementById('levelFilter').value;
    const departmentId = document.getElementById('departmentFilter').value;
    const lotSelect = document.getElementById('lotFilter');
    const dateFilter = document.getElementById('testDateFilter');
    const searchBtn = document.getElementById('searchBtn');
    const chartBtn = document.getElementById('chartBtn');
    
    // Reset dependent filters
    lotSelect.innerHTML = '<option value="" selected hidden>Pilih LOT</option>';
    lotSelect.disabled = true;
    dateFilter.disabled = true;
    searchBtn.disabled = true;
    chartBtn.disabled = true;
    
    clearHistoryData();
    
    if (!level || !departmentId) return;
    
    try {
        const response = await fetch(`/analyst/api/get-qc-by-level/${level}?department_id=${departmentId}`);
        const data = await response.json();
        
        if (data.success && data.qcs) {
            data.qcs.forEach(qc => {
                const option = document.createElement('option');
                option.value = qc.id;
                option.textContent = `${qc.no_lot} - ${qc.name_control}`;
                lotSelect.appendChild(option);
            });
            lotSelect.disabled = false;
        }
    } catch (error) {
        console.error('Error loading lots:', error);
    }
}

// ================== ENABLE DATE FILTER ==================
async function enableDateFilter() {
    const lotId = document.getElementById('lotFilter').value;
    const dateFilter = document.getElementById('testDateFilter');
    const searchBtn = document.getElementById('searchBtn');
    
    clearHistoryData();
    
    if (lotId) {
        // Load QC details for info display
        await loadQCDetails(lotId);
        dateFilter.disabled = false;
        enableSearch();
    } else {
        dateFilter.disabled = true;
        searchBtn.disabled = true;
    }
}

// ================== ENABLE SEARCH ==================
function enableSearch() {
    const lotId = document.getElementById('lotFilter').value;
    const testDate = document.getElementById('testDateFilter').value;
    const searchBtn = document.getElementById('searchBtn');
    const chartBtn = document.getElementById('chartBtn');
    
    if (lotId && testDate) {
        searchBtn.disabled = false;
        chartBtn.disabled = false;
    } else {
        searchBtn.disabled = true;
        chartBtn.disabled = true;
    }
}

// ================== LOAD QC DETAILS ==================
async function loadQCDetails(qcId) {
    try {
        const response = await fetch(`/analyst/api/get-qc-details/${qcId}`);
        const data = await response.json();
        
        if (data.success) {
            currentQcData = data.qc;
            currentParameters = data.parameters || [];
            
            // Check if department is hematology
            if (selectedDepartment && selectedDepartment.nama_department.toLowerCase().includes('hematologi')) {
                isHematology = true;
                currentParameters = hematologiParams.map(p => ({ parameter: p.nama }));
            }
            
            displayQCInfo();
            updateParameterSelector();
        }
    } catch (error) {
        console.error('Error loading QC details:', error);
    }
}

// ================== LOAD HISTORY DATA ==================
async function loadHistoryData() {
    const lotId = document.getElementById('lotFilter').value;
    const testDate = document.getElementById('testDateFilter').value;
    
    if (!lotId || !testDate) {
        alert('Pilih LOT dan Tanggal terlebih dahulu');
        return;
    }
    
    try {
        isLoading = true;
        const tbody = document.getElementById('historyBody');
        tbody.innerHTML = '<tr><td colspan="9" class="text-center text-muted">Loading history data...</td></tr>';
        
        const response = await fetch(`/analyst/api/get-qc-history/${lotId}?test_date=${testDate}`);
        const data = await response.json();
        
        if (data.success) {
            currentHistoryResults = data.results || [];
            displayHistoryResults();
            document.getElementById('qcInfo').style.display = 'block';
            document.getElementById('selectedDate').textContent = testDate;
        } else {
            tbody.innerHTML = '<tr><td colspan="9" class="text-center no-data-message">Tidak ada data history untuk tanggal yang dipilih</td></tr>';
        }
    } catch (error) {
        console.error('Error loading history data:', error);
        document.getElementById('historyBody').innerHTML = '<tr><td colspan="9" class="text-center text-danger">Error loading history data</td></tr>';
    } finally {
        isLoading = false;
    }
}

// ================== DISPLAY FUNCTIONS ==================
function displayQCInfo() {
    if (!currentQcData) return;
    
    document.getElementById('controlName').textContent = currentQcData.name_control || '-';
    document.getElementById('lotNumber').textContent = currentQcData.no_lot || '-';
    document.getElementById('controlLevel').textContent = currentQcData.level || '-';
}

function displayHistoryResults() {
    const tbody = document.getElementById('historyBody');
    tbody.innerHTML = '';
    
    if (!currentHistoryResults || currentHistoryResults.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" class="text-center no-data-message">Tidak ada data history</td></tr>';
        return;
    }
    
    // Group results by parameter
    const groupedResults = {};
    currentHistoryResults.forEach(result => {
        if (!groupedResults[result.parameter]) {
            groupedResults[result.parameter] = [];
        }
        groupedResults[result.parameter].push(result);
    });
    
    // Display each parameter group
    Object.keys(groupedResults).forEach(parameter => {
        const results = groupedResults[parameter];
        const latestResult = results[0]; // Assuming sorted by date desc
        
        const row = document.createElement('tr');
        
        // Parameter name
        const paramCell = document.createElement('td');
        paramCell.className = 'parameter-cell';
        paramCell.innerHTML = `<strong>${getDisplayName(parameter)}</strong>`;
        row.appendChild(paramCell);
        
        // Result
        const resultCell = document.createElement('td');
        resultCell.className = 'text-center';
        resultCell.innerHTML = `<span class="history-value">${latestResult.result || '-'}</span>`;
        row.appendChild(resultCell);
        
        // Duplo values D1-D5
        for (let i = 1; i <= 5; i++) {
            const duploCell = document.createElement('td');
            duploCell.className = 'text-center';
            const duploValue = latestResult[`d${i}`];
            duploCell.innerHTML = `<span class="duplo-value">${duploValue || '-'}</span>`;
            row.appendChild(duploCell);
        }
        
        // Flag
        const flagCell = document.createElement('td');
        flagCell.className = 'flag-cell';
        const flag = latestResult.flag || '-';
        flagCell.innerHTML = flag;
        
        if (flag === "✓ Normal") flagCell.classList.add('flag-normal');
        else if (flag === "↓ Low") flagCell.classList.add('flag-low');
        else if (flag === "↑ High") flagCell.classList.add('flag-high');
        
        row.appendChild(flagCell);
        
        // Created At
        const createdCell = document.createElement('td');
        createdCell.className = 'text-center';
        const createdAt = latestResult.created_at ? new Date(latestResult.created_at).toLocaleDateString('id-ID') : '-';
        createdCell.innerHTML = `<span class="history-date-badge">${createdAt}</span>`;
        row.appendChild(createdCell);
        
        tbody.appendChild(row);
    });
}

// ================== HELPER FUNCTIONS ==================
async function getDepartmentInfo(departmentId) {
    try {
        const response = await fetch(`/analyst/api/get-department/${departmentId}`);
        const data = await response.json();
        return data.success ? data.department : null;
    } catch (error) {
        console.error('Error getting department info:', error);
        return null;
    }
}

function getDisplayName(parameter) {
    const hematologyParam = hematologiParams.find(p => p.nama === parameter);
    return hematologyParam ? hematologyParam.display_name : parameter;
}

function getMeta(parameter) {
    const hematologyParam = hematologiParams.find(p => p.nama === parameter);
    if (hematologyParam) return hematologyParam;
    
    return {
        nama: parameter,
        display_name: parameter,
        satuan: '',
        normal_min_l: 0,
        normal_max_l: 100
    };
}

function clearHistoryData() {
    document.getElementById('historyBody').innerHTML = `
        <tr><td colspan="9" class="text-center no-data-message">Pilih Department, Level, LOT, dan Tanggal untuk melihat history</td></tr>`;
    document.getElementById('qcInfo').style.display = 'none';
    document.getElementById('parameterSelector').innerHTML = '<option value="">Pilih Parameter</option>';
    
    currentQcData = null;
    currentHistoryResults = [];
    selectedParameter = '';
    
    if (qcChart) {
        qcChart.data.labels = [];
        qcChart.data.datasets[0].data = [];
        qcChart.update();
    }
}

// ================== CHART FUNCTIONS ==================
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

function initChart() {
    const ctx = document.getElementById('qcChart').getContext('2d');
    qcChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'QC Results History',
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
                            if (qcChart && qcChart.originalData && qcChart.originalData[ctx.dataIndex] !== null) {
                                return 'Value: ' + Number(qcChart.originalData[ctx.dataIndex]).toFixed(2);
                            }
                            return 'Value: ' + (ctx.parsed && ctx.parsed.y !== undefined ? Number(ctx.parsed.y).toFixed(2) : '');
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
                                5: 'Normal',
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
                                    5: L.standard,
                                    3: L.minus1sd,
                                    1: L.minus2sd,
                                    '-1': L.minus3sd
                                };
                                const numValue = mapping[value];
                                return (numValue !== undefined && numValue !== null) ? numValue.toFixed(1) : '';
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
                    'Normal': { yPos: 5, color: '#16a34a', width: 2, dash: [] },
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
            qcChart.controlLimits = null;
            qcChart.update();
        }
        return;
    }

    try {
        // Load chart data for historical trend (multiple dates)
        const response = await fetch(`/analyst/api/get-chart-data-history/${currentQcData.id}/${selectedParameter}`);
        const data = await response.json();

        if (!data.success || !qcChart) return;

        const controlResponse = await fetch(`/analyst/api/get-control-limits/${currentQcData.id}/${selectedParameter}`);
        const controlData = await controlResponse.json();

        const labels = data.labels || [];
        const values = (data.values || []).map(v => {
            if (v === null || v === undefined || v === '') return null;
            const num = Number(v);
            return isNaN(num) ? null : num;
        });

        let controlLimits = null;

        if (controlData.success && controlData.limits) {
            const limits = controlData.limits;
            
            const mean = parseFloat(limits.mean);
            const rangeRaw = parseFloat(limits.range);
            const standard = parseFloat(limits.standard);
            const btsAtas = parseFloat(limits.bts_atas);
            const btsBawah = parseFloat(limits.bts_bawah);

            let center = standard;
            if (!isFinite(center)) {
                center = mean;
            }
            if (!isFinite(center)) {
                console.warn('No valid center point found');
                return;
            }

            let sdRange = rangeRaw;
            if (!isFinite(sdRange) || sdRange <= 0) {
                const validValues = values.filter(v => v !== null && isFinite(v));
                if (validValues.length > 1) {
                    const meanVal = validValues.reduce((a, b) => a + b, 0) / validValues.length;
                    const variance = validValues.reduce((sum, val) => sum + Math.pow(val - meanVal, 2), 0) / (validValues.length - 1);
                    sdRange = Math.sqrt(variance);
                } else {
                    sdRange = 1;
                }
            }

            controlLimits = {
                mean: isFinite(mean) ? mean : center,
                standard: center,
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
        }

        // Map values to chart positions
        let mappedValues = values;
        if (controlLimits) {
            mappedValues = values.map(value => {
                if (value === null || !isFinite(value)) return null;
                
                const center = controlLimits.standard;
                const sdRange = controlLimits.range;
                const sdPosition = (value - center) / sdRange;
                const chartPosition = 5 + (sdPosition * 2);
                
                return chartPosition;
            });
        }

        qcChart.originalData = values;
        qcChart.data.labels = labels;
        qcChart.data.datasets[0].data = mappedValues;
        qcChart.controlLimits = controlLimits;

        qcChart.update('none');

    } catch (err) {
        console.error('Error loading chart data:', err);
    }
}

function changeParameter() {
    selectedParameter = document.getElementById('parameterSelector').value;
    const displayName = getDisplayName(selectedParameter);
    document.getElementById('chartParameterName').textContent = displayName || 'Pilih Parameter';
    
    if (selectedParameter && currentQcData) {
        document.getElementById('chartInfo').textContent = `Historical trend data untuk ${displayName} - LOT: ${currentQcData.no_lot}`;
    } else {
        document.getElementById('chartInfo').textContent = 'Select a parameter to view historical trend data';
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
    }
}

function refreshChart() {
    loadChartData();
}

function exportChart() {
    if (qcChart) {
        const url = qcChart.toBase64Image();
        const link = document.createElement('a');
        link.download = `qc-history-chart-${selectedParameter}.png`;
        link.href = url;
        link.click();
    }
}

function resizeChart() {
    if (qcChart) {
        qcChart.resize();
    }
}

window.addEventListener('resize', resizeChart);
</script>
@endpush