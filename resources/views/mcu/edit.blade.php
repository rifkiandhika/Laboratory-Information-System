@extends('layouts.admin')
<title>MCU | Edit</title>
@section('content')
<section>
    <div class="content" id="scroll-content">
        <div class="container-fluid">
            <div class="d-sm-flex mb-3">
                <h1 class="h3 mb-0 text-gray-600">Edit MCU Package</h1>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Package Information</h6>
                        </div>
                        <form action="{{ route('mcu.update', $mcuPackage->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_paket">Package Name</label>
                                            <input type="text" class="form-control @error('nama_paket') is-invalid @enderror" 
                                                   id="nama_paket" name="nama_paket" 
                                                   value="{{ old('nama_paket', $mcuPackage->nama_paket) }}" required>
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
                                                   id="diskon" name="diskon" 
                                                   value="{{ old('diskon', $mcuPackage->diskon) }}" required
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
                                                    <option value="active" {{ old('status', $mcuPackage->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ old('status', $mcuPackage->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                                              id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $mcuPackage->deskripsi) }}</textarea>
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
                                                                   onchange="calculatePrice()"
                                                                   {{ in_array($pemeriksaan->id, old('pemeriksaan', $selectedPemeriksaan)) ? 'checked' : '' }}>
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
                                            <strong>Normal Price: Rp.<span id="normalPrice">{{ number_format($mcuPackage->harga_normal, 0, ',', '.') }}</span></strong>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="alert alert-warning">
                                            <strong>Discount Amount: Rp.<span id="discountAmount">{{ number_format(($mcuPackage->diskon/100) * $mcuPackage->harga_normal, 0, ',', '.') }}</span></strong>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="alert alert-success">
                                            <strong>Final Price: Rp.<span id="finalPrice">{{ number_format($mcuPackage->harga_final, 0, ',', '.') }}</span></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update Package</button>
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
</script>
@endpush
