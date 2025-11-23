@extends('layouts.admin')
@section('title', 'Laporan Pemeriksaan')
@section('content')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
<div class="content" id="scroll-content">
    <div class="container-fluid">
        <div class="d-sm-flex mt-3">
            <h1 class="h3 mb-0 text-gray-600">Laporan Pemeriksaan</h1>
        </div>

        <div class="card">
            <div class="card-header">
                <form id="filterForm" method="POST">
                    @csrf
                    <div class="row g-3">
                        <!-- Tanggal Awal -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="tanggal_awal" class="form-label">
                                <b>Tanggal Awal</b><span class="text-danger"> *</span>
                            </label>
                            <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control">
                        </div>

                        <!-- Tanggal Akhir -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="tanggal_akhir" class="form-label">
                                <b>Tanggal Akhir</b><span class="text-danger"> *</span>
                            </label>
                            <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control">
                        </div>

                        <!-- Department -->
                        <div class="col-12 col-md-6 col-lg-3 pt-1">
                           <label for="department"><b>Departemen</b><strong class="text-danger"> *</strong></label>
                            <select id="department" class="form-control select2" multiple>
                                <option value="All">Semua</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->nama_department }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Payment -->
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="payment" class="form-label">
                                <b>Metode Pembayaran</b><span class="text-danger"> *</span>
                            </label>
                            <select id="payment" name="payment[]" class="form-control select2" multiple>
                                <option value="all">Semua</option>
                                <option value="bpjs">BPJS</option>
                                <option value="asuransi">Asuransi</option>
                                <option value="umum">Umum</option>
                            </select>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-6 col-md-6 col-lg-6 d-flex align-items-end">
                            <div class="d-flex w-100 flex-wrap gap-2">
                                <button type="submit" class="btn btn-info flex-grow-1">Tampilkan</button>
                                <button type="reset" class="btn btn-secondary flex-grow-1">Reset</button>
                                <button type="button" id="btnPrint" class="btn btn-primary flex-grow-1">Cetak/Unduh</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body">
                <table class="table report-table table-responsive table-striped table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2">NAMA PEMERIKSAAN</th>
                            <th colspan="3" class="payment-header" data-type="BPJS">BPJS</th>
                            <th colspan="3" class="payment-header" data-type="ASURANSI">ASURANSI</th>
                            <th colspan="3" class="payment-header" data-type="UMUM">UMUM</th>
                        </tr>
                        <tr>
                            <th class="sub-header" data-type="BPJS">Qty</th>
                            <th class="sub-header" data-type="BPJS">Harga</th>
                            <th class="sub-header" data-type="BPJS">Total</th>
                            <th class="sub-header" data-type="ASURANSI">Qty</th>
                            <th class="sub-header" data-type="ASURANSI">Harga</th>
                            <th class="sub-header" data-type="ASURANSI">Total</th>
                            <th class="sub-header" data-type="UMUM">Qty</th>
                            <th class="sub-header" data-type="UMUM">Harga</th>
                            <th class="sub-header" data-type="UMUM">Total</th>
                        </tr>
                    </thead>
                    <tbody id="reportTableBody">
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                Silakan pilih filter dan tekan <strong>Tampilkan</strong> untuk menampilkan laporan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.payment-header[data-type="BPJS"],
.payment-header[data-type="ASURANSI"],
.payment-header[data-type="UMUM"] {
    display: none;
}

.sub-header[data-type="BPJS"],
.sub-header[data-type="ASURANSI"],
.sub-header[data-type="UMUM"] {
    display: none;
}

.cell-bpjs,
.cell-asuransi,
.cell-umum {
    display: none;
}

.payment-header[data-type="BPJS"].show,
.payment-header[data-type="ASURANSI"].show,
.payment-header[data-type="UMUM"].show {
    display: table-cell !important;
}

.sub-header[data-type="BPJS"].show,
.sub-header[data-type="ASURANSI"].show,
.sub-header[data-type="UMUM"].show {
    display: table-cell !important;
}

.cell-bpjs.show,
.cell-asuransi.show,
.cell-umum.show {
    display: table-cell !important;
}

.department-header {
    background-color: #e9ecef;
    font-weight: bold;
}

.mcu-package-header {
    background-color: #f8f9fa;
    font-weight: bold;
    border-left: 3px solid #007bff;
}

.mcu-parameter {
    background-color: #fdfdfd;
    font-style: italic;
    color: #666;
}
</style>

@endsection

@push('script')
<script>
$(document).ready(function () {
    $('#department, #payment').select2({ 
        placeholder: 'Pilih...', 
        allowClear: true 
    });

    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        muatDataLaporan();
    });

    $('#filterForm').on('reset', function () {
        setTimeout(() => {
            $('#department, #payment').val(null).trigger('change');
            $('#tanggal_awal').val(hariPertama.toISOString().split('T')[0]);
            $('#tanggal_akhir').val(hariIni.toISOString().split('T')[0]);
        }, 100);
    });
});

function muatDataLaporan() {
    const pilihanPembayaran = ($('#payment').val() || []).map(p => p.toLowerCase());
    const semuaTerpilih = pilihanPembayaran.includes('all');
    
    toggleKolomPembayaran(pilihanPembayaran, semuaTerpilih);

    const formData = {
        tanggal_awal: $('#tanggal_awal').val() || hariPertama.toISOString().split('T')[0],
        tanggal_akhir: $('#tanggal_akhir').val() || hariIni.toISOString().split('T')[0],
        department: $('#department').val(),
        payment_method: pilihanPembayaran,
        _token: $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}'
    };

    $('#reportTableBody').html('<tr><td colspan="10" class="text-center">Memuat data...</td></tr>');

    $.ajax({
        url: '{{ route("result.data.simple") }}',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                tampilkanTabelLaporan(response.data, pilihanPembayaran, semuaTerpilih);
            } else {
                $('#reportTableBody').html(
                    '<tr><td colspan="10" class="text-center text-danger">Error: ' + response.message + '</td></tr>'
                );
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX Error:', error);
            console.log('Response:', xhr.responseText);
            $('#reportTableBody').html(
                '<tr><td colspan="10" class="text-center text-danger">Error memuat data: ' + error + '</td></tr>'
            );
        }
    });
}

function toggleKolomPembayaran(pilihanPembayaran, semuaTerpilih) {
    const semuaJenis = ['bpjs', 'asuransi', 'umum'];

    semuaJenis.forEach(jenis => {
        const jenisUpper = jenis.toUpperCase();
        
        if (semuaTerpilih || pilihanPembayaran.includes(jenis)) {
            $(`.payment-header[data-type="${jenisUpper}"]`).addClass('show').show();
            $(`.sub-header[data-type="${jenisUpper}"]`).addClass('show').show();
            $(`.cell-${jenis}`).addClass('show').show();
        } else {
            $(`.payment-header[data-type="${jenisUpper}"]`).removeClass('show').hide();
            $(`.sub-header[data-type="${jenisUpper}"]`).removeClass('show').hide();
            $(`.cell-${jenis}`).removeClass('show').hide();
        }
    });
}

function tampilkanTabelLaporan(data, pilihanPembayaran, semuaTerpilih) {
    let tableHTML = '';

    const dataReguler = data.filter(row => row.test_name !== 'TOTAL');
    const dataTotal = data.find(row => row.test_name === 'TOTAL');

    dataReguler.forEach(row => {
        tableHTML += '<tr>';

        let testNameClass = '';
        let testNameStyle = '';
        const isHematologi = row.department_id == 1;

        if (row.is_department_header) {
            testNameClass = 'department-header';
            testNameStyle = 'font-weight: bold; background-color: #e9ecef; padding: 8px;';
        } else if (row.is_mcu_package) {
            testNameClass = 'mcu-package-header';
            testNameStyle = 'font-weight: bold; background-color: #f8f9fa; padding-left: 15px;';
        } else if (row.is_mcu_parameter) {
            testNameClass = 'mcu-parameter';
            testNameStyle = 'padding-left: 40px; font-style: italic; color: #666; background-color: #fdfdfd;';
        } else if (row.is_subheader) {
            testNameClass = 'sub-header';
            testNameStyle = 'padding-left: 20px; background-color: #fafafa;';
        }

        let namaTampilan = row.test_name;
        if (row.is_mcu_parameter && row.parameter_name) {
            namaTampilan = row.parameter_name;
        }

        const kontenNamaTes = isHematologi ? `<strong>${namaTampilan}</strong>` : namaTampilan;
        tableHTML += `<td class="${testNameClass}" style="${testNameStyle}">${kontenNamaTes}</td>`;

        ['bpjs', 'asuransi', 'umum'].forEach(jenis => {
            const qty = row[`${jenis}_qty`] || 0;
            const harga = row[`${jenis}_price`] || 0;
            const nilaiTotal = row[`${jenis}_total`] || 0;

            const tampilQty = qty > 0 ? formatAngka(qty) : '-';
            const tampilHarga = harga > 0 ? formatMataUang(harga) : '-';
            const tampilTotal = nilaiTotal > 0 ? formatMataUang(nilaiTotal) : '-';

            tableHTML += `<td class="cell-${jenis}" style="${testNameStyle}">${tampilQty}</td>`;
            tableHTML += `<td class="cell-${jenis}" style="${testNameStyle}">${tampilHarga}</td>`;
            tableHTML += `<td class="cell-${jenis}" style="${testNameStyle}"><strong>${tampilTotal}</strong></td>`;
        });

        tableHTML += '</tr>';
    });

    // TOTAL row
    if (dataTotal) {
        const styleTotal = 'font-weight: bold; background-color: #f8f9fa; border-top: 2px solid #dee2e6; padding: 10px;';

        tableHTML += `<tr style="${styleTotal}">`;
        tableHTML += `<td style="${styleTotal}"><strong>TOTAL</strong></td>`;

        ['bpjs', 'asuransi', 'umum'].forEach(jenis => {
            const nilaiTotal = dataTotal[`${jenis}_total`] || 0;

            tableHTML += `<td class="cell-${jenis}" style="${styleTotal}">-</td>`;
            tableHTML += `<td class="cell-${jenis}" style="${styleTotal}">-</td>`;
            tableHTML += `<td class="cell-${jenis}" style="${styleTotal}"><strong>${nilaiTotal > 0 ? formatMataUang(nilaiTotal) : '-'}</strong></td>`;
        });

        tableHTML += '</tr>';
    }

    $('#reportTableBody').html(tableHTML);
    toggleKolomPembayaran(pilihanPembayaran, semuaTerpilih);
}

function formatAngka(angka) {
    if (angka == 0) return '-';
    return new Intl.NumberFormat('id-ID').format(angka);
}

function formatMataUang(jumlah) {
    if (jumlah == 0) return '-';
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(jumlah);
}

// Print & Export Functions
$('#btnPrint').on('click', function() {
    tampilkanModalCetak();
});

function tampilkanModalCetak() {
    const modalHTML = `
        <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="printModalLabel">Opsi Cetak/Unduh</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="printTitle" class="form-label">Judul Laporan:</label>
                                <input type="text" class="form-control" id="printTitle" value="Laporan Pemeriksaan">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Pilih Aksi:</label>
                                <div class="btn-group w-100" role="group">
                                    <button type="button" class="btn btn-outline-primary" onclick="cetakLaporan()">
                                        <i class="fas fa-print"></i> Cetak
                                    </button>
                                    <button type="button" class="btn btn-outline-success" onclick="unduhExcel()">
                                        <i class="fas fa-file-excel"></i> Unduh Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('#printModal').remove();
    $('body').append(modalHTML);
    $('#printModal').modal('show');
}

function cetakLaporan() {
    const judul = $('#printTitle').val() || 'Laporan Pemeriksaan';
    const rentangTanggal = getRentangTanggalTeks();
    const filter = getTeksFilter();
    const kontenTabel = getTabelTerformatUntukCetak();
    
    const jendelaCetak = window.open('', '_blank');
    jendelaCetak.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>${judul}</title>
            <style>
                body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 20px; font-size: 10px; color: #333; }
                .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 15px; }
                .header h1 { margin: 0; font-size: 20px; color: #333; font-weight: 600; }
                .header h2 { margin: 8px 0; font-size: 14px; color: #666; font-weight: 400; }
                .filters { margin-bottom: 20px; padding: 12px; background-color: #f8f9fa; border-radius: 6px; border: 1px solid #e9ecef; }
                .report-table { width: 100%; border-collapse: collapse; font-size: 9px; margin-bottom: 20px; }
                .report-table th, .report-table td { border: 1px solid #dee2e6; padding: 6px 4px; text-align: center; }
                .report-table th { background-color: #f8f9fa; font-weight: 600; font-size: 10px; color: #495057; text-transform: uppercase; }
                .report-table td:first-child { text-align: left; font-weight: 500; }
                .report-table .department-header { background-color: #e9ecef !important; font-weight: 600; color: #495057; }
                .report-table .total-row { font-weight: 700; background-color: #f1f3f4; border-top: 2px solid #6c757d; text-transform: uppercase; }
                .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #6c757d; border-top: 1px solid #dee2e6; padding-top: 10px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>${judul}</h1>
                <h2>${rentangTanggal}</h2>
            </div>
            <div class="filters">${filter}</div>
            ${kontenTabel}
            <div class="footer">
                <p>Dibuat pada: ${new Date().toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</p>
            </div>
        </body>
        </html>
    `);
    
    jendelaCetak.document.close();
    jendelaCetak.focus();
    $('#printModal').modal('hide');
    setTimeout(() => { jendelaCetak.print(); jendelaCetak.close(); }, 250);
}

function unduhExcel() {
    try {
        const judul = $('#printTitle').val() || 'Laporan Pemeriksaan';
        const rentangTanggal = getRentangTanggalTeks();
        const pilihanPembayaran = ($('#payment').val() || []).map(p => String(p).toLowerCase());
        const semuaTerpilih = pilihanPembayaran.includes('all');
        const wb = XLSX.utils.book_new();
        const data = [];

        data.push([judul]);
        data.push([rentangTanggal]);
        data.push(['']);
        data.push(['Filter:']);
        data.push([getTeksFilter().replace(/<[^>]*>/g, '').replace(/&nbsp;/g, ' ')]);
        data.push(['']);

        const headerRow1 = ['NAMA PEMERIKSAAN'];
        const headerRow2 = [''];

        if (semuaTerpilih || pilihanPembayaran.includes('bpjs')) {
            headerRow1.push('BPJS', '', '');
            headerRow2.push('QTY', 'HARGA', 'TOTAL');
        }
        if (semuaTerpilih || pilihanPembayaran.includes('asuransi')) {
            headerRow1.push('ASURANSI', '', '');
            headerRow2.push('QTY', 'HARGA', 'TOTAL');
        }
        if (semuaTerpilih || pilihanPembayaran.includes('umum')) {
            headerRow1.push('UMUM', '', '');
            headerRow2.push('QTY', 'HARGA', 'TOTAL');
        }

        data.push(headerRow1);
        data.push(headerRow2);

        $('#reportTableBody tr').each(function() {
            const $row = $(this);
            const $cells = $row.find('td');
            
            if ($cells.length === 0) return;

            const row = [];

            $cells.each(function(index) {
                if ($(this).is(':visible')) {
                    let cellValue = '';
                    
                    try {
                        let rawText = String($(this).text().trim() || '');

                        if (rawText.includes('Rp ')) {
                            let numericValue = rawText.replace('Rp ', '').replace(/\./g, '').trim();
                            
                            if (numericValue === '-' || numericValue === '') {
                                cellValue = '';
                            } else {
                                const parsed = parseInt(numericValue);
                                cellValue = isNaN(parsed) ? '' : parsed;
                            }
                        } else {
                            cellValue = rawText;
                        }

                    } catch (error) {
                        console.warn('Error processing cell at index', index, ':', error);
                        cellValue = '';
                    }

                    row.push(cellValue);
                }
            });

            if (row.some(cell => cell !== '')) {
                data.push(row);
            }
        });

        const ws = XLSX.utils.aoa_to_sheet(data);
        
        ws['!cols'] = [
            { wch: 30 },
            { wch: 10 },
            { wch: 15 },
            { wch: 15 },
            { wch: 10 },
            { wch: 15 },
            { wch: 15 },
            { wch: 10 },
            { wch: 15 },
            { wch: 15 }
        ];

        XLSX.utils.book_append_sheet(wb, ws, 'Laporan Pemeriksaan');

        const safeJudul = judul.replace(/[^a-zA-Z0-9\s]/g, '').replace(/\s+/g, '_');
        const tanggal = new Date().toISOString().slice(0, 10);
        const namaFile = `${safeJudul}_${tanggal}.xlsx`;

        XLSX.writeFile(wb, namaFile);
        $('#printModal').modal('hide');

    } catch (error) {
        console.error('Error in unduhExcel:', error);
        alert('Terjadi kesalahan saat membuat file Excel. Silakan coba lagi.');
    }
}

function getRentangTanggalTeks() {
    const tanggalMulai = $('#tanggal_awal').val();
    const tanggalAkhir = $('#tanggal_akhir').val();
    if (tanggalMulai && tanggalAkhir) {
        const mulai = new Date(tanggalMulai).toLocaleDateString('id-ID');
        const akhir = new Date(tanggalAkhir).toLocaleDateString('id-ID');
        return `Periode: ${mulai} - ${akhir}`;
    }
    return 'Periode: Semua Waktu';
}

function getTeksFilter() {
    const departemen = $('#department').val();
    const pembayaran = $('#payment').val();
    let teksFilter = '<div style="font-size:14px; margin: 10px 0;"><strong>Filter yang Diterapkan:</strong>';
    if (departemen && departemen.length > 0) {
        const namaDept = departemen.map(d => {
            if (d === 'All') return 'Semua Departemen';
            if (d === '1') return 'Hematologi';
            if (d === '2') return 'Kimia Klinik';
            return d;
        });
        teksFilter += `<span style="margin-left: 15px; margin-right: 25px;"><strong>Departemen:</strong> ${namaDept.join(', ')}</span>`;
    }
    if (pembayaran && pembayaran.length > 0) {
        const namaPembayaran = pembayaran.map(p => p.toUpperCase());
        teksFilter += `<span style="margin-right: 15px;"><strong>Metode Pembayaran:</strong> ${namaPembayaran.join(', ')}</span>`;
    }
    teksFilter += '</div>';
    return teksFilter;
}

function getTabelTerformatUntukCetak() {
    const pilihanPembayaran = ($('#payment').val() || []).map(p => p.toLowerCase());
    const semuaTerpilih = pilihanPembayaran.includes('all');
    let tableHTML = '<table class="report-table"><thead><tr>';
    tableHTML += '<th rowspan="2">NAMA PEMERIKSAAN</th>';
    
    if (semuaTerpilih || pilihanPembayaran.includes('bpjs')) {
        tableHTML += '<th colspan="3">BPJS</th>';
    }
    if (semuaTerpilih || pilihanPembayaran.includes('asuransi')) {
        tableHTML += '<th colspan="3">ASURANSI</th>';
    }
    if (semuaTerpilih || pilihanPembayaran.includes('umum')) {
        tableHTML += '<th colspan="3">UMUM</th>';
    }
    tableHTML += '</tr><tr>';
    if (semuaTerpilih || pilihanPembayaran.includes('bpjs')) {
        tableHTML += '<th>QTY</th><th>HARGA</th><th>TOTAL</th>';
    }
    if (semuaTerpilih || pilihanPembayaran.includes('asuransi')) {
        tableHTML += '<th>QTY</th><th>HARGA</th><th>TOTAL</th>';
    }
    if (semuaTerpilih || pilihanPembayaran.includes('umum')) {
        tableHTML += '<th>QTY</th><th>HARGA</th><th>TOTAL</th>';
    }
    tableHTML += '</tr></thead><tbody>';
    
    $('#reportTableBody tr').each(function() {
        const $row = $(this);
        const $firstCell = $row.find('td:first');
        const namaTes = $firstCell.text().trim();
        if (namaTes === 'Tidak ada data tersedia....') return;
        
        let rowClass = '';
        if ($firstCell.hasClass('department-header')) rowClass = ' class="department-header"';
        else if (namaTes.toUpperCase() === 'TOTAL') rowClass = ' class="total-row"';
        
        tableHTML += `<tr${rowClass}>`;
        $row.find('td').each(function() {
            const $cell = $(this);
            if ($cell.is(':visible')) {
                let nilaiSel = $cell.text().trim();
                const classSel = (nilaiSel === '-' || nilaiSel === '') ? 'empty-cell' : '';
                tableHTML += `<td class="${classSel}">${nilaiSel}</td>`;
            }
        });
        tableHTML += '</tr>';
    });
    
    tableHTML += '</tbody></table>';
    return tableHTML;
}

const hariIni = new Date();
const hariPertama = new Date(hariIni.getFullYear(), hariIni.getMonth(), 1);
$(document).ready(function() {
    if (!$('#tanggal_awal').val()) $('#tanggal_awal').val(hariPertama.toISOString().split('T')[0]);
    if (!$('#tanggal_akhir').val()) $('#tanggal_akhir').val(hariIni.toISOString().split('T')[0]);
    $(document).keydown(function(e) { if (e.ctrlKey && e.which === 80) { e.preventDefault(); tampilkanModalCetak(); } });
    $('#printModal').on('hidden.bs.modal', function() { $(this).remove(); });
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

@endpush