@extends('layouts.admin')
@section('title', 'Laporan Data Pasien')
@section('content')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
<div class="content" id="scroll-content">
    <div class="container-fluid">
        <div class="d-sm-flex mt-3">
            <h1 class="h3 mb-0 text-gray-600">Laporan Data Pasien</h1>
        </div>

        <div class="card">
            <div class="card-header">
                <form id="filterForm" method="POST">
                    @csrf
                    <div class="row g-3">
                        <!-- Tanggal Awal -->
                        <div class="col-12 col-md-6 col-lg-2">
                            <label for="tanggal_awal" class="form-label">
                                <b>Tanggal Awal</b><span class="text-danger"> *</span>
                            </label>
                            <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control">
                        </div>

                        <!-- Tanggal Akhir -->
                        <div class="col-12 col-md-6 col-lg-2">
                            <label for="tanggal_akhir" class="form-label">
                                <b>Tanggal Akhir</b><span class="text-danger"> *</span>
                            </label>
                            <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control">
                        </div>

                        <!-- Department -->
                        <div class="col-12 col-md-6 col-lg-2 pt-1">
                           <label for="department"><b>Departemen</b><strong class="text-danger"> *</strong></label>
                            <select id="department" class="form-control select2" multiple>
                                <option value="All">Semua</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->nama_department }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Payment -->
                        <div class="col-12 col-md-6 col-lg-2">
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

                        <!-- Nama Pasien -->
                        <div class="col-12 col-md-6 col-lg-2">
                            <label for="nama_pasien" class="form-label">
                                <b>Nama Pasien</b>
                            </label>
                            <input type="text" id="nama_pasien" name="nama_pasien" class="form-control" placeholder="Cari nama pasien...">
                        </div>

                        <!-- No Lab -->
                        <div class="col-12 col-md-6 col-lg-2">
                            <label for="no_lab" class="form-label">
                                <b>No Lab</b>
                            </label>
                            <input type="text" id="no_lab" name="no_lab" class="form-control" placeholder="Cari no lab...">
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12 col-md-12 col-lg-12 d-flex align-items-end">
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
                <div class="table-responsive">
                    <table class="table report-table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>No Lab</th>
                                <th>Nama Pasien</th>
                                <th>Jenis Kelamin</th>
                                <th>Umur</th>
                                <th>Pemeriksaan</th>
                                <th>Departemen</th>
                                <th>Payment Method</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="reportTableBody">
                            <tr>
                                <td colspan="12" class="text-center text-muted">
                                    Silakan pilih filter dan tekan <strong>Tampilkan</strong> untuk menampilkan laporan.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table-responsive {
    overflow-x: auto;
}

.report-table {
    min-width: 1200px;
}

.report-table thead th {
    background-color: #f8f9fa;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #dee2e6;
    padding: 12px 8px;
}

.report-table tbody td {
    vertical-align: middle;
    border: 1px solid #dee2e6;
    padding: 8px;
}

.patient-header {
    background-color: #e7f3ff;
    font-weight: 600;
}

.total-row {
    background-color: #f8f9fa;
    font-weight: 700;
    border-top: 2px solid #6c757d;
}

.text-end {
    text-align: right;
}

.text-center {
    text-align: center;
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
            $('#nama_pasien').val('');
            $('#no_lab').val('');
            $('#tanggal_awal').val(hariPertama.toISOString().split('T')[0]);
            $('#tanggal_akhir').val(hariIni.toISOString().split('T')[0]);
        }, 100);
    });
});

function muatDataLaporan() {
    const formData = {
        tanggal_awal: $('#tanggal_awal').val() || hariPertama.toISOString().split('T')[0],
        tanggal_akhir: $('#tanggal_akhir').val() || hariIni.toISOString().split('T')[0],
        department: $('#department').val(),
        payment_method: ($('#payment').val() || []).map(p => p.toLowerCase()),
        nama_pasien: $('#nama_pasien').val(),
        no_lab: $('#no_lab').val(),
        _token: $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}'
    };

    $('#reportTableBody').html('<tr><td colspan="12" class="text-center">Memuat data...</td></tr>');

    $.ajax({
        url: '{{ route("patient.report.data") }}',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                tampilkanTabelLaporan(response.data);
            } else {
                $('#reportTableBody').html(
                    '<tr><td colspan="12" class="text-center text-danger">Error: ' + response.message + '</td></tr>'
                );
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX Error:', error);
            console.log('Response:', xhr.responseText);
            $('#reportTableBody').html(
                '<tr><td colspan="12" class="text-center text-danger">Error memuat data: ' + error + '</td></tr>'
            );
        }
    });
}

function tampilkanTabelLaporan(data) {
    let tableHTML = '';
    let no = 1;
    let grandTotal = 0;

    if (data.length === 0) {
        tableHTML = '<tr><td colspan="12" class="text-center text-muted">Tidak ada data yang ditemukan.</td></tr>';
    } else {
        data.forEach(row => {
            if (row.is_patient_header) {
                // Header Pasien
                tableHTML += `<tr class="patient-header">`;
                tableHTML += `<td colspan="12"><strong>No Lab: ${row.no_lab} | Pasien: ${row.nama_pasien} | Jenis Kelamin: ${row.jenis_kelamin} | Umur: ${row.umur} tahun | Tanggal: ${row.tanggal_formatted}</strong></td>`;
                tableHTML += `</tr>`;
            } else if (row.is_total_patient) {
                // Total per Pasien
                tableHTML += `<tr style="background-color: #f1f3f5;">`;
                tableHTML += `<td colspan="11" class="text-end"><strong>Total Pasien:</strong></td>`;
                tableHTML += `<td class="text-end"><strong>${formatMataUang(row.total_pasien)}</strong></td>`;
                tableHTML += `</tr>`;
            } else if (row.is_grand_total) {
                // Grand Total
                tableHTML += `<tr class="total-row">`;
                tableHTML += `<td colspan="11" class="text-end"><strong>GRAND TOTAL:</strong></td>`;
                tableHTML += `<td class="text-end"><strong>${formatMataUang(row.grand_total)}</strong></td>`;
                tableHTML += `</tr>`;
            } else {
                // Data Pemeriksaan
                tableHTML += `<tr>`;
                tableHTML += `<td class="text-center">${no++}</td>`;
                tableHTML += `<td class="text-center">${row.tanggal_formatted}</td>`;
                tableHTML += `<td>${row.no_lab}</td>`;
                tableHTML += `<td>${row.nama_pasien}</td>`;
                tableHTML += `<td class="text-center">${row.jenis_kelamin}</td>`;
                tableHTML += `<td class="text-center">${row.umur}</td>`;
                tableHTML += `<td>${row.nama_pemeriksaan}</td>`;
                tableHTML += `<td class="text-center">${row.department}</td>`;
                tableHTML += `<td class="text-center">${row.payment_method.toUpperCase()}</td>`;
                tableHTML += `<td class="text-center">${row.quantity}</td>`;
                tableHTML += `<td class="text-end">${formatMataUang(row.harga)}</td>`;
                tableHTML += `<td class="text-end"><strong>${formatMataUang(row.total)}</strong></td>`;
                tableHTML += `</tr>`;
                
                grandTotal += row.total;
            }
        });
    }

    $('#reportTableBody').html(tableHTML);
}

function formatMataUang(jumlah) {
    if (jumlah == 0 || jumlah == null) return 'Rp 0';
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(jumlah);
}

function formatAngka(angka) {
    if (angka == 0 || angka == null) return '0';
    return new Intl.NumberFormat('id-ID').format(angka);
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
                                <input type="text" class="form-control" id="printTitle" value="Laporan Data Pasien">
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
    const judul = $('#printTitle').val() || 'Laporan Data Pasien';
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
                body { font-family: Arial, sans-serif; margin: 20px; font-size: 10px; }
                .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
                .header h1 { margin: 0; font-size: 18px; }
                .header h2 { margin: 5px 0; font-size: 12px; color: #666; }
                .filters { margin-bottom: 15px; padding: 10px; background-color: #f8f9fa; border-radius: 4px; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                th, td { border: 1px solid #dee2e6; padding: 6px 4px; text-align: left; }
                th { background-color: #f8f9fa; font-weight: 600; text-align: center; }
                .text-center { text-align: center; }
                .text-end { text-align: right; }
                .patient-header { background-color: #e7f3ff; font-weight: 600; }
                .total-row { background-color: #f8f9fa; font-weight: 700; border-top: 2px solid #6c757d; }
                .footer { margin-top: 20px; text-align: right; font-size: 9px; color: #6c757d; }
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
                <p>Dicetak pada: ${new Date().toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</p>
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
        const judul = $('#printTitle').val() || 'Laporan Data Pasien';
        const rentangTanggal = getRentangTanggalTeks();
        const wb = XLSX.utils.book_new();
        const data = [];

        data.push([judul]);
        data.push([rentangTanggal]);
        data.push(['']);
        data.push(['Filter:']);
        data.push([getTeksFilter().replace(/<[^>]*>/g, '').replace(/&nbsp;/g, ' ')]);
        data.push(['']);

        const headerRow = ['No', 'Tanggal', 'No Lab', 'Nama Pasien', 'Jenis Kelamin', 'Umur', 'Pemeriksaan', 'Departemen', 'Payment Method', 'Qty', 'Harga', 'Total'];
        data.push(headerRow);

        let no = 1;
        $('#reportTableBody tr').each(function() {
            const $row = $(this);
            const $cells = $row.find('td');
            
            if ($cells.length === 0) return;
            
            if ($row.hasClass('patient-header')) {
                const headerText = $cells.first().text().trim();
                data.push([headerText]);
            } else if ($row.find('td').first().attr('colspan') === '11') {
                const totalText = $cells.first().text().trim();
                const totalValue = $cells.last().text().trim().replace('Rp ', '').replace(/\./g, '');
                data.push([totalText, '', '', '', '', '', '', '', '', '', '', parseInt(totalValue) || 0]);
            } else {
                const row = [];
                $cells.each(function(index) {
                    let cellValue = $(this).text().trim();
                    
                    if (cellValue.includes('Rp ')) {
                        cellValue = parseInt(cellValue.replace('Rp ', '').replace(/\./g, '')) || 0;
                    }
                    
                    row.push(cellValue);
                });
                
                if (row.length === 12) {
                    data.push(row);
                }
            }
        });

        const ws = XLSX.utils.aoa_to_sheet(data);
        
        ws['!cols'] = [
            { wch: 5 },
            { wch: 12 },
            { wch: 15 },
            { wch: 25 },
            { wch: 12 },
            { wch: 8 },
            { wch: 30 },
            { wch: 15 },
            { wch: 15 },
            { wch: 8 },
            { wch: 15 },
            { wch: 15 }
        ];

        XLSX.utils.book_append_sheet(wb, ws, 'Data Pasien');

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
    const namaPasien = $('#nama_pasien').val();
    const noLab = $('#no_lab').val();
    
    let teksFilter = '<div style="font-size:12px;"><strong>Filter:</strong>';
    
    if (departemen && departemen.length > 0) {
        const namaDept = departemen.map(d => {
            if (d === 'All') return 'Semua Departemen';
            if (d === '1') return 'Hematologi';
            if (d === '2') return 'Kimia Klinik';
            return d;
        });
        teksFilter += ` Departemen: ${namaDept.join(', ')} |`;
    }
    
    if (pembayaran && pembayaran.length > 0) {
        const namaPembayaran = pembayaran.map(p => p.toUpperCase());
        teksFilter += ` Payment: ${namaPembayaran.join(', ')} |`;
    }
    
    if (namaPasien) {
        teksFilter += ` Nama: ${namaPasien} |`;
    }
    
    if (noLab) {
        teksFilter += ` No Lab: ${noLab} |`;
    }
    
    teksFilter = teksFilter.replace(/\|$/, '');
    teksFilter += '</div>';
    return teksFilter;
}

function getTabelTerformatUntukCetak() {
    let tableHTML = '<table><thead><tr>';
    tableHTML += '<th>No</th><th>Tanggal</th><th>No Lab</th><th>Nama Pasien</th><th>JK</th><th>Umur</th>';
    tableHTML += '<th>Pemeriksaan</th><th>Departemen</th><th>Payment</th><th>Qty</th><th>Harga</th><th>Total</th>';
    tableHTML += '</tr></thead><tbody>';
    
    $('#reportTableBody tr').each(function() {
        const $row = $(this);
        
        if ($row.hasClass('patient-header')) {
            tableHTML += '<tr class="patient-header">';
            tableHTML += `<td colspan="12">${$row.find('td').first().html()}</td>`;
            tableHTML += '</tr>';
        } else if ($row.find('td').first().attr('colspan') === '11') {
            tableHTML += '<tr style="background-color: #f1f3f5;">';
            tableHTML += `<td colspan="11" class="text-end">${$row.find('td').first().html()}</td>`;
            tableHTML += `<td class="text-end">${$row.find('td').last().html()}</td>`;
            tableHTML += '</tr>';
        } else {
            tableHTML += '<tr>';
            $row.find('td').each(function() {
                tableHTML += `<td>${$(this).html()}</td>`;
            });
            tableHTML += '</tr>';
        }
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