@extends('layouts.admin')
<title>MCU | Create</title>
@section('content')
<section>
    <div class="content" id="scroll-content">
        <div class="container-fluid">
            <div class="d-sm-flex mb-3">
                <h1 class="h3 mb-0 text-gray-600">Create MCU Package</h1>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Package Information</h6>
                        </div>
                        <form action="{{ route('mcu.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_paket">Package Name</label>
                                            <input type="text" class="form-control @error('nama_paket') is-invalid @enderror" 
                                                   id="nama_paket" name="nama_paket" value="{{ old('nama_paket') }}" required>
                                            @error('nama_paket')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="diskon">Discount (%)</label>
                                            <input type="number" step="0.01" min="0" max="100" 
                                                   class="form-control @error('diskon') is-invalid @enderror" 
                                                   id="diskon" name="diskon" value="{{ old('diskon', 0) }}" required
                                                   onchange="calculatePrice()">
                                            @error('diskon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-select @error('status') is-invalid @enderror" 
                                                    id="status" name="status" required>
                                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="deskripsi">Description</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                              id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <hr>
                                <h6 class="font-weight-bold text-primary">Select Examinations</h6>
                                
                                <div class="row" id="inspectionList">
                                    @foreach ($departments as $department)
                                        <div class="col-xl-3 inspection-item">
                                            <div class="parent-pemeriksaan">
                                                <div class="heading heading-color btn-block mb-3">
                                                    <strong>{{ $department->nama_department }}</strong>
                                                </div>
                                                
                                                @foreach ($department->detailDepartments as $x => $pemeriksaan)
                                                    @if ($pemeriksaan->status === 'active')
                                                        <div class="form-check">
                                                            <input style="cursor: pointer" 
                                                                   class="form-check-input child-pemeriksaan"
                                                                   type="checkbox" name="pemeriksaan[]"
                                                                   value="{{ $pemeriksaan->id }}"
                                                                   id="{{ $pemeriksaan->id_departement . '-' . $x }}"
                                                                   data-harga="{{ $pemeriksaan->harga }}"
                                                                   onchange="calculatePrice()">
                                                            <label class="form-check-label" for="{{ $pemeriksaan->id_departement . '-' . $x }}">
                                                                {{ $pemeriksaan->nama_pemeriksaan }}
                                                                Rp.{{ number_format($pemeriksaan->harga, 0, ',', '.') }}
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <hr>
                                        </div>
                                    @endforeach
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="alert alert-info">
                                            <strong>Normal Price: Rp.<span id="normalPrice">0</span></strong>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="alert alert-warning">
                                            <strong>Discount Amount: Rp.<span id="discountAmount">0</span></strong>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="alert alert-success">
                                            <strong>Final Price: Rp.<span id="finalPrice">0</span></strong>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                    <h6 class="font-weight-bold text-primary">Biaya Jasa</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Jasa Sarana:</label>
                                            <input type="number" name="jasa_sarana" value="{{ old('jasa_sarana', 0) }}" class="form-control" onchange="calculatePrice()">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Jasa Pelayanan:</label>
                                            <input type="number" name="jasa_pelayanan" value="{{ old('jasa_pelayanan', 0) }}" class="form-control" onchange="calculatePrice()">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Jasa Dokter:</label>
                                            <input type="number" name="jasa_dokter" value="{{ old('jasa_dokter', 0) }}" class="form-control" onchange="calculatePrice()">
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label>Jasa Bidan:</label>
                                            <input type="number" name="jasa_bidan" value="{{ old('jasa_bidan', 0) }}" class="form-control" onchange="calculatePrice()">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Jasa Perawat:</label>
                                            <input type="number" name="jasa_perawat" value="{{ old('jasa_perawat', 0) }}" class="form-control" onchange="calculatePrice()">
                                        </div>
                                    </div>
                            </div>
                            
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save Package</button>
                                <a href="{{ route('mcu.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
function calculatePrice() {
    let totalNormal = 0;
    const checkboxes = document.querySelectorAll('input[name="pemeriksaan[]"]:checked');
    
    checkboxes.forEach(checkbox => {
        totalNormal += parseInt(checkbox.getAttribute('data-harga'));
    });
    
    const diskonPersen = parseFloat(document.getElementById('diskon').value) || 0;
    const diskonAmount = (diskonPersen / 100) * totalNormal;
    const finalPrice = totalNormal - diskonAmount;
    
    document.getElementById('normalPrice').textContent = totalNormal.toLocaleString('id-ID');
    document.getElementById('discountAmount').textContent = diskonAmount.toLocaleString('id-ID');
    document.getElementById('finalPrice').textContent = finalPrice.toLocaleString('id-ID');
}

// function calculatePrice() {
//     let totalNormal = 0;

//     // Hitung harga pemeriksaan
//     const checkboxes = document.querySelectorAll('input[name="pemeriksaan[]"]:checked');
//     checkboxes.forEach(checkbox => {
//         totalNormal += parseInt(checkbox.getAttribute('data-harga'));
//     });

//     // Tambahkan jasa
//     const jasaFields = ['jasa_sarana','jasa_pelayanan','jasa_dokter','jasa_bidan','jasa_perawat'];
//     jasaFields.forEach(field => {
//         const val = parseInt(document.querySelector(`input[name="${field}"]`).value) || 0;
//         totalNormal += val;
//     });

//     const diskonPersen = parseFloat(document.getElementById('diskon').value) || 0;
//     const diskonAmount = (diskonPersen / 100) * totalNormal;
//     const finalPrice = totalNormal - diskonAmount;

//     document.getElementById('normalPrice').textContent = totalNormal.toLocaleString('id-ID');
//     document.getElementById('discountAmount').textContent = diskonAmount.toLocaleString('id-ID');
//     document.getElementById('finalPrice').textContent = finalPrice.toLocaleString('id-ID');
// }
</script>
@endpush