@extends('layouts.admin')
@section('title', 'Result Review')
@section('content')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
<div class="content" id="scroll-content">
    <div class="container-fluid">
        <div class="d-sm-flex mt-3">
            <h1 class="h3 mb-0 text-gray-600">Result Review</h1>
        </div>

        <div class="card">
            <div class="card-header">
                <form id="filterForm" method="POST">
                    @csrf
                    <div class="row g-2">
                        <div class="col-12 col-md-6 col-lg-2">
                            <label for="tanggal_awal"><b>Tanggal Awal</b><strong class="text-danger"> *</strong></label>
                            <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control">
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <label for="tanggal_akhir"><b>Tanggal Akhir</b><strong class="text-danger"> *</strong></label>
                            <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control">
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <label for="department"><b>Department</b><strong class="text-danger"> *</strong></label>
                            <select id="department" class="form-control select2" multiple>
                                <option value="All">All</option>
                                <option value="1">Hematologi</option>
                                <option value="2">Kimia Klinik</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2 pl-2">
                            <label for="payment"><b>Payment Method</b><strong class="text-danger"> *</strong></label>
                            <select id="payment" class="form-control select2" multiple>
                                <option value="all">All</option>
                                <option value="bpjs">BPJS</option>
                                <option value="asuransi">Asuransi</option>
                                <option value="umum">Umum</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-12 col-lg-3 d-flex align-items-end">
                            <div class="d-flex w-100 flex-wrap gap-2">
                                <button type="submit" class="btn btn-info flex-grow-1">Show Me</button>
                                <button type="reset" class="btn btn-secondary flex-grow-1">Reset Filter</button>
                                <button type="button" id="btnPrint" class="btn btn-primary flex-grow-1">Print/Download</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body">
                <table class="table report-table table-responsive table-striped table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2">Report data</th>
                            <th class="payment-header" colspan="3" data-type="BPJS">BPJS</th>
                            <th class="payment-header" colspan="3" data-type="ASURANSI">ASURANSI</th>
                            <th class="payment-header" colspan="3" data-type="UMUM">UMUM</th>
                        </tr>
                        <tr>
                            <th class="sub-header" data-type="BPJS">Qty</th>
                            <th class="sub-header" data-type="BPJS">Price</th>
                            <th class="sub-header" data-type="BPJS">Total</th>
                            <th class="sub-header" data-type="ASURANSI">Qty</th>
                            <th class="sub-header" data-type="ASURANSI">Price</th>
                            <th class="sub-header" data-type="ASURANSI">Total</th>
                            <th class="sub-header" data-type="UMUM">Qty</th>
                            <th class="sub-header" data-type="UMUM">Price</th>
                            <th class="sub-header" data-type="UMUM">Total</th>
                        </tr>
                    </thead>
                    <tbody id="reportTableBody">
                        {{-- <tr><td colspan="10" class="text-center">Memuat...</td></tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
$(document).ready(function () {
    $('#department, #payment').select2({ placeholder: 'Choose...', allowClear: true });

    loadReportData();

    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        loadReportData();
    });

    $('#filterForm').on('reset', function () {
        setTimeout(() => {
            $('#department, #payment').val(null).trigger('change');
            $('#tanggal_awal').val(firstDay.toISOString().split('T')[0]);
            $('#tanggal_akhir').val(today.toISOString().split('T')[0]);
            loadReportData();
        }, 100);
    });
});

function loadReportData() {
    const selectedPayments = ($('#payment').val() || []).map(p => p.toLowerCase());
    const allSelected = selectedPayments.includes('all');

    togglePaymentColumns(selectedPayments, allSelected);

    const formData = {
        tanggal_awal: $('#tanggal_awal').val(),
        tanggal_akhir: $('#tanggal_akhir').val(),
        department: $('#department').val(),
        payment_method: selectedPayments,
        _token: '{{ csrf_token() }}'
    };

    $('#reportTableBody').html('<tr><td colspan="10" class="text-center">No data available....</td></tr>');

    $.ajax({
        url: '{{ route("result.data") }}',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                renderReportTable(response.data, selectedPayments, allSelected);
            } else {
                $('#reportTableBody').html('<tr><td colspan="10" class="text-center text-danger">Error: ' + response.message + '</td></tr>');
            }
        }
    });
}

function togglePaymentColumns(selectedPayments, allSelected) {
    const types = ['bpjs', 'asuransi', 'umum'];
    types.forEach(type => {
        const show = allSelected || selectedPayments.includes(type);
        $(`.payment-header[data-type="${type.toUpperCase()}"]`).toggle(show);
        $(`.sub-header[data-type="${type.toUpperCase()}"]`).toggle(show);
    });
}

function renderReportTable(data, selectedPayments, allSelected) {
    let tableHTML = '';
    let total = {
        BPJS: { qty: 0, total: 0 },
        ASURANSI: { qty: 0, total: 0 },
        UMUM: { qty: 0, total: 0 }
    };

    // Pisahkan data biasa dan data total
    const regularData = data.filter(row => row.test_name !== 'TOTAL');
    const totalData = data.find(row => row.test_name === 'TOTAL');

    // Render data biasa
    regularData.forEach(row => {
        tableHTML += '<tr>';

        let testNameClass = '';
        let testNameStyle = '';
        const isHematologi = row.department_id == 1;

        if (row.is_department_header) {
            testNameClass = 'department-header';
            testNameStyle = 'font-weight: bold; background-color: #e9ecef;';
        } else if (row.is_subheader) {
            testNameClass = 'sub-header';
            testNameStyle = 'padding-left: 10px;';
        }

        const testNameContent = isHematologi ? `<strong>${row.test_name}</strong>` : `${row.test_name}`;
        tableHTML += `<td class="${testNameClass}" style="${testNameStyle}">${testNameContent}</td>`;

        ['bpjs', 'asuransi', 'umum'].forEach(type => {
            const show = allSelected || selectedPayments.includes(type);
            if (show) {
                const qty = row[`${type}_qty`] || 0;
                const price = row[`${type}_price`] ?? null;  // Jangan pakai fallback 0 agar bisa sembunyikan jika null
                const totalValue = row[`${type}_total`] || 0;

                let cellStyle = '';
                if (row.is_department_header) {
                    cellStyle = 'font-weight: bold; background-color: #e9ecef;';
                }

                // Tampilkan hanya jika price tersedia
                const priceHTML = price && price > 0 ? formatCurrency(price) : '-';

                tableHTML += `<td style="${cellStyle}">${formatNumber(qty)}</td>`;
                tableHTML += `<td style="${cellStyle}">${priceHTML}</td>`;
                tableHTML += `<td style="${cellStyle}"><strong>${formatCurrency(totalValue)}</strong></td>`;

                if (!row.is_department_header) {
                    total[type.toUpperCase()].qty += parseInt(qty);
                    total[type.toUpperCase()].total += parseFloat(totalValue);
                }
            }
        });

        tableHTML += '</tr>';
    });

    // Tambahkan baris TOTAL dengan style bold dan background berbeda
    if (totalData) {
        tableHTML += '<tr style="font-weight: bold; background-color: #f8f9fa; border-top: 2px solid #dee2e6;">';
        tableHTML += '<td style="font-weight: bold; text-transform: uppercase; padding: 12px;"><strong>TOTAL</strong></td>';

        ['bpjs', 'asuransi', 'umum'].forEach(type => {
            const show = allSelected || selectedPayments.includes(type);
            if (show) {
                const qty = totalData[`${type}_qty`] || 0;
                const totalValue = totalData[`${type}_total`] || 0;

                tableHTML += `<td style="padding: 12px;"></td>`;
                tableHTML += `<td style="padding: 12px;"></td>`;
                tableHTML += `<td style="font-weight: bold; padding: 12px;"><strong>${formatCurrency(totalValue)}</strong></td>`;
            }
        });

        tableHTML += '</tr>';
    }

    $('#reportTableBody').html(tableHTML);
}


function formatNumber(num) {
    if (num == 0) return '-';
    return new Intl.NumberFormat('id-ID').format(num);
}

function formatCurrency(amount) {
    if (amount == 0) return '-';
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
}
</script>

<script>
$('#btnPrint').on('click', function() {
    showPrintModal();
});

function showPrintModal() {
    const modalHTML = `
        <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="printModalLabel">Print/Download Options</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="printTitle" class="form-label">Report Title:</label>
                                <input type="text" class="form-control" id="printTitle" value="Result Review Report">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Choose Action:</label>
                                <div class="btn-group w-100" role="group">
                                    <button type="button" class="btn btn-outline-primary" onclick="printReport()">
                                        <i class="fas fa-print"></i> Print
                                    </button>
                                    <button type="button" class="btn btn-outline-success" onclick="downloadExcel()">
                                        <i class="fas fa-file-excel"></i> Download Excel
                                    </button>
                                    {{-- 
                                        <button type="button" class="btn btn-outline-danger" onclick="downloadPDF()">
                                        <i class="fas fa-file-pdf"></i> Download PDF
                                    </button>
                                    --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    $('#printModal').remove();
    
    // Add modal to body
    $('body').append(modalHTML);
    
    // Show modal
    $('#printModal').modal('show');
}

// Function untuk print langsung
function printReport() {
    const title = $('#printTitle').val() || 'Result Review Report';
    const dateRange = getDateRangeText();
    const filters = getFilterText();
    
    // Get table content with proper formatting
    const tableContent = getFormattedTableForPrint();
    
    // Create print window
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>${title}</title>
            <style>
                body { 
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
                    margin: 20px;
                    font-size: 12px;
                    color: #333;
                }
                .header { 
                    text-align: center; 
                    margin-bottom: 30px;
                    border-bottom: 2px solid #333;
                    padding-bottom: 15px;
                }
                .header h1 { 
                    margin: 0; 
                    font-size: 20px;
                    color: #333;
                    font-weight: 600;
                }
                .header h2 { 
                    margin: 8px 0; 
                    font-size: 14px;
                    color: #666;
                    font-weight: 400;
                }
                .filters {
                    margin-bottom: 20px;
                    padding: 12px;
                    background-color: #f8f9fa;
                    border-radius: 6px;
                    border: 1px solid #e9ecef;
                }
                .filters strong {
                    color: #333;
                }
                .report-table { 
                    width: 100%; 
                    border-collapse: collapse; 
                    font-size: 11px;
                    margin-bottom: 20px;
                }
                .report-table th, .report-table td { 
                    border: 1px solid #dee2e6; 
                    padding: 12px 8px; 
                    text-align: center;
                }
                .report-table th { 
                    background-color: #f8f9fa; 
                    font-weight: 600;
                    font-size: 12px;
                    color: #495057;
                    text-transform: uppercase;
                }
                .report-table td:first-child {
                    text-align: left;
                    font-weight: 500;
                }
                .report-table .department-header {
                    background-color: #e9ecef !important;
                    font-weight: 600;
                    color: #495057;
                }
                .report-table .sub-test {
                    padding-left: 30px;
                    font-weight: 400;
                }
                .report-table .total-row {
                    font-weight: 700;
                    background-color: #f1f3f4;
                    border-top: 2px solid #6c757d;
                    text-transform: uppercase;
                }
                .report-table .total-row td {
                    padding: 14px 8px;
                    font-size: 12px;
                }
                .report-table .payment-group {
                    border-left: 3px solid #007bff;
                    border-right: 3px solid #007bff;
                }
                .report-table .empty-cell {
                    color: #6c757d;
                    font-style: italic;
                }
                .footer {
                    margin-top: 30px;
                    text-align: right;
                    font-size: 10px;
                    color: #6c757d;
                    border-top: 1px solid #dee2e6;
                    padding-top: 10px;
                }
                @media print {
                    body { margin: 0; }
                    .header { page-break-inside: avoid; }
                    .report-table { page-break-inside: auto; }
                    .report-table tr { page-break-inside: avoid; }
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>${title}</h1>
                <h2>${dateRange}</h2>
            </div>
            <div class="filters">
                ${filters}
            </div>
            ${tableContent}
            <div class="footer">
                <p>Generated on: ${new Date().toLocaleDateString('id-ID', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                })}</p>
            </div>
        </body>
        </html>
    `);
    
    printWindow.document.close();
    printWindow.focus();
    
    // Close modal
    $('#printModal').modal('hide');
    
    // Print after a short delay to ensure content is loaded
    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 250);
}

// Function untuk download Excel
function downloadExcel() {
    const title = $('#printTitle').val() || 'Result Review Report';
    const dateRange = getDateRangeText();
    const selectedPayments = ($('#payment').val() || []).map(p => p.toLowerCase());
    const allSelected = selectedPayments.includes('all');
    
    // Create workbook
    const wb = XLSX.utils.book_new();
    
    // Prepare data array
    const data = [];
    
    // Add header info
    data.push([title]);
    data.push([dateRange]);
    data.push(['']);
    data.push(['Filters:']);
    data.push([getFilterText().replace(/<[^>]*>/g, '').replace(/&nbsp;/g, ' ')]);
    data.push(['']);
    
    // Add table headers
    const headerRow1 = ['REPORT DATA'];
    const headerRow2 = [''];
    
    // Build headers based on selected payments
    if (allSelected || selectedPayments.includes('bpjs')) {
        headerRow1.push('BPJS', '', '');
        headerRow2.push('QTY', 'PRICE', 'TOTAL');
    }
    if (allSelected || selectedPayments.includes('asuransi')) {
        headerRow1.push('ASURANSI', '', '');
        headerRow2.push('QTY', 'PRICE', 'TOTAL');
    }
    if (allSelected || selectedPayments.includes('umum')) {
        headerRow1.push('UMUM', '', '');
        headerRow2.push('QTY', 'PRICE', 'TOTAL');
    }
    
    data.push(headerRow1);
    data.push(headerRow2);
    
    // Add table data
    $('#reportTableBody tr').each(function() {
        const $row = $(this);
        const $firstCell = $row.find('td:first');
        const testName = $firstCell.text().trim();
        
        if (testName === 'No data available....') {
            return;
        }
        
        const row = [testName];
        
        // Data columns
        $row.find('td').slice(1).each(function() {
            const $cell = $(this);
            if ($cell.is(':visible')) {
                let cellValue = $cell.text().trim();
                
                // Convert currency to number for Excel
                if (cellValue.includes('Rp ')) {
                    cellValue = cellValue.replace('Rp ', '').replace(/\./g, '');
                    if (cellValue !== '-' && cellValue !== '') {
                        cellValue = parseInt(cellValue);
                    }
                }
                
                row.push(cellValue);
            }
        });
        
        data.push(row);
    });
    
    // Create worksheet
    const ws = XLSX.utils.aoa_to_sheet(data);
    
    // Style the worksheet
    const range = XLSX.utils.decode_range(ws['!ref']);
    
    // Set column widths
    const colWidths = [{ wch: 25 }]; // First column wider
    for (let i = 1; i <= range.e.c; i++) {
        colWidths.push({ wch: 12 });
    }
    ws['!cols'] = colWidths;
    
    // Merge cells for headers
    if (!ws['!merges']) ws['!merges'] = [];
    
    // Merge payment method headers
    let colIndex = 1;
    if (allSelected || selectedPayments.includes('bpjs')) {
        ws['!merges'].push({
            s: { r: 6, c: colIndex },
            e: { r: 6, c: colIndex + 2 }
        });
        colIndex += 3;
    }
    if (allSelected || selectedPayments.includes('asuransi')) {
        ws['!merges'].push({
            s: { r: 6, c: colIndex },
            e: { r: 6, c: colIndex + 2 }
        });
        colIndex += 3;
    }
    if (allSelected || selectedPayments.includes('umum')) {
        ws['!merges'].push({
            s: { r: 6, c: colIndex },
            e: { r: 6, c: colIndex + 2 }
        });
    }
    
    // Add worksheet to workbook
    XLSX.utils.book_append_sheet(wb, ws, 'Result Review');
    
    // Generate filename
    const filename = `${title.replace(/\s+/g, '_')}_${new Date().toISOString().slice(0, 10)}.xlsx`;
    
    // Save file
    XLSX.writeFile(wb, filename);
    
    // Close modal
    $('#printModal').modal('hide');
}

// Function untuk download PDF
function downloadPDF() {
    const title = $('#printTitle').val() || 'Result Review Report';
    const dateRange = getDateRangeText();
    const filters = getFilterText();
    
    // Create PDF using jsPDF
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'mm', 'a4'); // landscape orientation
    
    // Add title
    doc.setFontSize(16);
    doc.setFont(undefined, 'bold');
    doc.text(title, doc.internal.pageSize.width / 2, 20, { align: 'center' });
    
    // Add date range
    doc.setFontSize(12);
    doc.setFont(undefined, 'normal');
    doc.text(dateRange, doc.internal.pageSize.width / 2, 30, { align: 'center' });
    
    // Add filters
    doc.setFontSize(10);
    const filterText = filters.replace(/<[^>]*>/g, '').replace(/&nbsp;/g, ' ');
    doc.text(filterText, 20, 45);
    
    // Prepare table data
    const { headers, body } = prepareDataForPDF();
    
    // Add table
    doc.autoTable({
        head: headers,
        body: body,
        startY: 55,
        styles: {
            fontSize: 9,
            cellPadding: 3,
            lineColor: [222, 226, 230],
            lineWidth: 0.1,
            textColor: [51, 51, 51]
        },
        headStyles: {
            fillColor: [248, 249, 250],
            textColor: [73, 80, 87],
            fontStyle: 'bold',
            fontSize: 9
        },
        columnStyles: {
            0: { 
                cellWidth: 40,
                halign: 'left',
                fontStyle: 'normal'
            }
        },
        didParseCell: function(data) {
            // Style department headers
            if (data.row.index >= 0 && data.column.index === 0) {
                const cellText = data.cell.text[0];
                if (cellText && (cellText === 'Hematologi' || cellText === 'Kimia Klinik')) {
                    data.cell.styles.fillColor = [233, 236, 239];
                    data.cell.styles.fontStyle = 'bold';
                }
                // Style sub-tests
                if (cellText && cellText.startsWith('    ')) {
                    data.cell.styles.cellPadding = { left: 8, right: 3, top: 3, bottom: 3 };
                }
                // Style total row
                if (cellText && cellText.toUpperCase() === 'TOTAL') {
                    data.cell.styles.fillColor = [241, 243, 244];
                    data.cell.styles.fontStyle = 'bold';
                    data.cell.styles.fontSize = 10;
                }
            }
            
            // Style empty cells
            if (data.cell.text[0] === '-' || data.cell.text[0] === '') {
                data.cell.styles.textColor = [108, 117, 125];
                data.cell.styles.fontStyle = 'italic';
            }
        }
    });
    
    // Add footer
    const pageCount = doc.internal.getNumberOfPages();
    for (let i = 1; i <= pageCount; i++) {
        doc.setPage(i);
        doc.setFontSize(8);
        doc.setTextColor(108, 117, 125);
        doc.text(
            `Generated on: ${new Date().toLocaleDateString('id-ID', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            })}`,
            20,
            doc.internal.pageSize.height - 10
        );
        doc.text(
            `Page ${i} of ${pageCount}`,
            doc.internal.pageSize.width - 20,
            doc.internal.pageSize.height - 10,
            { align: 'right' }
        );
    }
    
    // Generate filename
    const filename = `${title.replace(/\s+/g, '_')}_${new Date().toISOString().slice(0, 10)}.pdf`;
    
    // Save file
    doc.save(filename);
    
    // Close modal
    $('#printModal').modal('hide');
}

// Helper functions
function getDateRangeText() {
    const startDate = $('#tanggal_awal').val();
    const endDate = $('#tanggal_akhir').val();
    
    if (startDate && endDate) {
        const start = new Date(startDate).toLocaleDateString('id-ID');
        const end = new Date(endDate).toLocaleDateString('id-ID');
        return `Period: ${start} - ${end}`;
    }
    return 'Period: All Time';
}

function getFilterText() {
    const departments = $('#department').val();
    const payments = $('#payment').val();
    
    let filterText = '<div style="font-size:14px; margin: 10px 0;">';
    filterText += '<strong>Applied Filters:</strong>';

    if (departments && departments.length > 0) {
        const deptNames = departments.map(d => {
            if (d === 'All') return 'All Departments';
            if (d === '1') return 'Hematologi';
            if (d === '2') return 'Kimia Klinik';
            return d;
        });
        filterText += `<span style="margin-left: 15px; margin-right: 25px;"><strong>Department:</strong> ${deptNames.join(', ')}</span>`;
    }
    
    if (payments && payments.length > 0) {
        const paymentNames = payments.map(p => p.toUpperCase());
        filterText += `<span style="margin-right: 15px;"><strong>Payment Method:</strong> ${paymentNames.join(', ')}</span>`;
    }

    filterText += '</div>';
    return filterText;
}


function getFormattedTableForPrint() {
    const selectedPayments = ($('#payment').val() || []).map(p => p.toLowerCase());
    const allSelected = selectedPayments.includes('all');
    
    let tableHTML = '<table class="report-table">';
    
    // Build header
    tableHTML += '<thead>';
    tableHTML += '<tr>';
    tableHTML += '<th rowspan="2" style="vertical-align: middle; min-width: 150px;">REPORT DATA</th>';
    
    // Payment method headers
    if (allSelected || selectedPayments.includes('bpjs')) {
        tableHTML += '<th colspan="3" style="background-color: #e3f2fd; border-left: 3px solid #2196f3;">BPJS</th>';
    }
    if (allSelected || selectedPayments.includes('asuransi')) {
        tableHTML += '<th colspan="3" style="background-color: #f3e5f5; border-left: 3px solid #9c27b0;">ASURANSI</th>';
    }
    if (allSelected || selectedPayments.includes('umum')) {
        tableHTML += '<th colspan="3" style="background-color: #e8f5e8; border-left: 3px solid #4caf50;">UMUM</th>';
    }
    
    tableHTML += '</tr>';
    tableHTML += '<tr>';
    
    // Sub headers
    if (allSelected || selectedPayments.includes('bpjs')) {
        tableHTML += '<th style="background-color: #e3f2fd;">QTY</th>';
        tableHTML += '<th style="background-color: #e3f2fd;">PRICE</th>';
        tableHTML += '<th style="background-color: #e3f2fd;">TOTAL</th>';
    }
    if (allSelected || selectedPayments.includes('asuransi')) {
        tableHTML += '<th style="background-color: #f3e5f5;">QTY</th>';
        tableHTML += '<th style="background-color: #f3e5f5;">PRICE</th>';
        tableHTML += '<th style="background-color: #f3e5f5;">TOTAL</th>';
    }
    if (allSelected || selectedPayments.includes('umum')) {
        tableHTML += '<th style="background-color: #e8f5e8;">QTY</th>';
        tableHTML += '<th style="background-color: #e8f5e8;">PRICE</th>';
        tableHTML += '<th style="background-color: #e8f5e8;">TOTAL</th>';
    }
    
    tableHTML += '</tr>';
    tableHTML += '</thead>';
    
    // Build body
    tableHTML += '<tbody>';
    
    $('#reportTableBody tr').each(function() {
        const $row = $(this);
        const $firstCell = $row.find('td:first');
        const testName = $firstCell.text().trim();
        
        if (testName === 'No data available....') {
            return;
        }
        
        tableHTML += '<tr';
        
        // Apply row classes
        if ($firstCell.hasClass('department-header')) {
            tableHTML += ' class="department-header"';
        } else if (testName.toUpperCase() === 'TOTAL') {
            tableHTML += ' class="total-row"';
        }
        
        tableHTML += '>';
        
        // First column (test name)
        let cellClass = '';
        if ($firstCell.hasClass('department-header')) {
            cellClass = 'department-header';
        } else if ($firstCell.hasClass('sub-header') || testName.includes('    ')) {
            cellClass = 'sub-test';
        }
        
        tableHTML += `<td class="${cellClass}">${testName}</td>`;
        
        // Data columns
        $row.find('td').slice(1).each(function() {
            const $cell = $(this);
            if ($cell.is(':visible')) {
                const cellValue = $cell.text().trim();
                const cellClass = (cellValue === '-' || cellValue === '') ? 'empty-cell' : '';
                tableHTML += `<td class="${cellClass}">${cellValue}</td>`;
            }
        });
        
        tableHTML += '</tr>';
    });
    
    tableHTML += '</tbody>';
    tableHTML += '</table>';
    
    return tableHTML;
}

function prepareDataForPDF() {
    const selectedPayments = ($('#payment').val() || []).map(p => p.toLowerCase());
    const allSelected = selectedPayments.includes('all');
    
    // Build headers
    const headers = [
        [
            { content: 'REPORT DATA', rowSpan: 2, styles: { halign: 'center', valign: 'middle', fontStyle: 'bold' } }
        ]
    ];
    
    const secondHeaderRow = [];
    
    // Add payment method headers
    if (allSelected || selectedPayments.includes('bpjs')) {
        headers[0].push(
            { content: 'BPJS', colSpan: 3, styles: { halign: 'center', fontStyle: 'bold', fillColor: [227, 242, 253] } }
        );
        secondHeaderRow.push(
            { content: 'QTY', styles: { halign: 'center', fontStyle: 'bold', fillColor: [227, 242, 253] } },
            { content: 'PRICE', styles: { halign: 'center', fontStyle: 'bold', fillColor: [227, 242, 253] } },
            { content: 'TOTAL', styles: { halign: 'center', fontStyle: 'bold', fillColor: [227, 242, 253] } }
        );
    }
    
    if (allSelected || selectedPayments.includes('asuransi')) {
        headers[0].push(
            { content: 'ASURANSI', colSpan: 3, styles: { halign: 'center', fontStyle: 'bold', fillColor: [243, 229, 245] } }
        );
        secondHeaderRow.push(
            { content: 'QTY', styles: { halign: 'center', fontStyle: 'bold', fillColor: [243, 229, 245] } },
            { content: 'PRICE', styles: { halign: 'center', fontStyle: 'bold', fillColor: [243, 229, 245] } },
            { content: 'TOTAL', styles: { halign: 'center', fontStyle: 'bold', fillColor: [243, 229, 245] } }
        );
    }
    
    if (allSelected || selectedPayments.includes('umum')) {
        headers[0].push(
            { content: 'UMUM', colSpan: 3, styles: { halign: 'center', fontStyle: 'bold', fillColor: [232, 245, 232] } }
        );
        secondHeaderRow.push(
            { content: 'QTY', styles: { halign: 'center', fontStyle: 'bold', fillColor: [232, 245, 232] } },
            { content: 'PRICE', styles: { halign: 'center', fontStyle: 'bold', fillColor: [232, 245, 232] } },
            { content: 'TOTAL', styles: { halign: 'center', fontStyle: 'bold', fillColor: [232, 245, 232] } }
        );
    }
    
    headers.push(secondHeaderRow);
    
    // Build body data
    const body = [];
    
    $('#reportTableBody tr').each(function() {
        const $row = $(this);
        const $firstCell = $row.find('td:first');
        const testName = $firstCell.text().trim();
        
        if (testName === 'No data available....') {
            return;
        }
        
        const row = [];
        
        // First column (test name)
        row.push(testName);
        
        // Data columns
        $row.find('td').slice(1).each(function() {
            const $cell = $(this);
            if ($cell.is(':visible')) {
                const cellValue = $cell.text().trim();
                row.push(cellValue);
            }
        });
        
        body.push(row);
    });
    
    return { headers, body };
}

// Initialize date inputs with default values
const today = new Date();
const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);

$(document).ready(function() {
    // Set default dates if empty
    if (!$('#tanggal_awal').val()) {
        $('#tanggal_awal').val(firstDay.toISOString().split('T')[0]);
    }
    if (!$('#tanggal_akhir').val()) {
        $('#tanggal_akhir').val(today.toISOString().split('T')[0]);
    }
    
    // Add loading indicator for download functions
    $('body').on('click', '[onclick*="download"]', function() {
        const $btn = $(this);
        const originalText = $btn.html();
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        $btn.prop('disabled', true);
        
        // Re-enable button after processing
        setTimeout(() => {
            $btn.html(originalText);
            $btn.prop('disabled', false);
        }, 2000);
    });
    
    // Keyboard shortcut for print (Ctrl+P)
    $(document).keydown(function(e) {
        if (e.ctrlKey && e.which === 80) {
            e.preventDefault();
            showPrintModal();
        }
    });
    
    // Auto-close modal on successful action
    $('#printModal').on('hidden.bs.modal', function() {
        $(this).remove();
    });
});

// Error handling wrapper
function handleError(func) {
    return function() {
        try {
            return func.apply(this, arguments);
        } catch (error) {
            console.error('Error in function:', error);
            alert('An error occurred. Please try again.');
        }
    };
}

// Wrap functions with error handling
const originalPrintReport = printReport;
const originalDownloadExcel = downloadExcel;
const originalDownloadPDF = downloadPDF;

printReport = handleError(originalPrintReport);
downloadExcel = handleError(originalDownloadExcel);
downloadPDF = handleError(originalDownloadPDF);

// Add CSS for modal animations
const modalStyles = `
<style>
.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
    transform: translate(0, -50px);
}
.modal.show .modal-dialog {
    transform: none;
}
.btn-group .btn {
    transition: all 0.2s ease;
}
.btn-group .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
`;

$(document).ready(function() {
    $('head').append(modalStyles);
});
</script>
<!-- For Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<!-- For PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

@endpush
