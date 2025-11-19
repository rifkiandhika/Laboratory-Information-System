@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h5 class="mb-3">Detail Data Pasien</h5>

    <div class="card shadow-sm p-3">
        <form action="{{ route('data_pasien.updated', $pasien->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <label>No. Rekam Medis</label>
                    <input type="text" name="no_rm" class="form-control" value="{{ $pasien->no_rm }}">
                </div>
                <div class="col-md-6">
                    <label>NIK</label>
                    <input type="text" name="nik" class="form-control" value="{{ $pasien->nik }}">
                </div>

                <div class="col-md-6 mt-2">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $pasien->nama }}">
                </div>
                <div class="col-md-6 mt-2">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="lahir" class="form-control" value="{{ $pasien->lahir }}">
                </div>

                <div class="col-md-6 mt-2">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="Laki-laki" {{ $pasien->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $pasien->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="col-md-6 mt-2">
                    <label>No. Telepon</label>
                    <input type="text" name="no_telp" class="form-control" value="{{ $pasien->no_telp }}">
                </div>

                <div class="col-md-12 mt-2">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control">{{ $pasien->alamat }}</textarea>
                </div>
            </div>

            <hr>

            <h6>Data BPJS</h6>
            <div class="row">
                <div class="col-md-6 mt-2">
                    <label>No. BPJS</label>
                    <input type="text" name="no_bpjs" class="form-control"
                           value="{{ $pasien->dataBpjs->no_bpjs ?? '' }}">
                </div>
            </div>

            <hr>

            <h6>Data Asuransi</h6>
            <div class="row">
                @foreach ($pasien->dataAsuransi as $asuransi)
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <input type="text" name="penjamin[]" class="form-control"
                                    value="{{ $asuransi->penjamin }}">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="no_penjamin[]" class="form-control"
                                    value="{{ $asuransi->no_penjamin }}">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <a href="{{ route('pasien.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
