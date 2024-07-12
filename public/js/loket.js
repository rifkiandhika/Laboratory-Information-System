
function previewPasien(nolab) {
    var y = document.getElementById("preview-pasien-close");

    fetch('/api/previewpasien/'+nolab)
        .then(response => {
            if (!response.ok) {
                throw new Error("HTTP error " + response.status);
            }
            return response.json();
        })
        .then(data => {
            y.style.display = "none";
            var container = document.getElementById("container-preview");

            var dob = new Date(data.data_pasien.lahir);
            var today = new Date();
            var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

            var diagnosa = data.icd10.filter(function (el) {
                return el.code == data.data_pasien.diagnosa;
            });

            const html = `<div class="container-preview">
                            <form action="#" class="row table-preview" style="overflow-y: scroll; max-height: 515px;">
                            <div class="pasien col-xl-6 col-lg-12 col-sm-12 mb-3">
                                <p class="h5 text-gray-800 mb-2">Pasien</p>
                                <hr>
                                <div class="row">`;
                                if(data.data_pasien.cito == 1){
                                    html += `<label for="staticEmail" class="col-sm-5 col-form-label">Cito</label>
                                    <div class="col-sm-7">
                                        <i class='bx bxs-bell-ring mt-2 ml-1 text-danger' style="font-size: 23px;"></i>
                                    </div>`;
                                }else{
                                    html += `<label for="staticEmail" class="col-sm-5 col-form-label">Cito</label>
                                    <div class="col-sm-7">
                                        <i class='bx bxs-bell-ring mt-2 ml-1 text-secondary' style="font-size: 23px;"></i>
                                    </div>`;
                                };
                                html +=`</div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">No LAB</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.no_lab +`">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">No RM</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.no_rm +`">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">NIK</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.nik +`">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Nama</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.nama +`">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Gender</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.jenis_kelamin +`">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Umur</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ age +` tahun">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Alamat</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.alamat +`">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Telp</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.no_telp +`">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Jenis Pasien</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.jenis_pelayanan +`">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Ruangan</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ data.data_pasien.asal_ruangan +`">
                                </div>
                                </div>
                            </div>
                            <div class="dokter col-xl-6 col-lg-12 col-sm-12 mb-3">
                                <p class="h5 text-gray-800">Dokter</p>
                                <hr>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Nama Dokter</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": Dr. Bande">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Ruangan</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": Abu Thalib">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Telp</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": 0812313">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Email</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": gmail.com">
                                </div>
                                </div>
                                <div class="row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Diagnosa</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value=": `+ diagnosa[0].name_id +`">
                                </div>
                                </div>
                            </div>
                            <div class="detail_pemeriksaan col-12 ">
                                <p class="h5 text-gray-800 mb-2">Detail Pemeriksaan</p>
                                <hr>
                                <div class="row">
                                <div class="col-md-4">
                                    <p class="h6 text-gray-800">Darah Lengkap</p>
                                    <div class="sub-detail p-2">
                                        <p class="text-gray-600 offset-md-3" style="margin-top: -10px;">Eritrosit</p>
                                        <p class="text-gray-600 offset-md-3" style="margin-top: -10px;">Hemoglobin</p>
                                        <p class="text-gray-600 offset-md-3" style="margin-top: -10px;">more...</p>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </form>
                            <hr class="sidebar-divider">
                            <div class="mt-4 text-right small">
                                <a class="btn btn-outline-info font-weight-bold mx-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</a>
                                <a class="btn btn-outline-success font-weight-bold mx-2" data-bs-toggle="modal" data-bs-target="#exampleModalScrollable">Pembayaran</a>
                                <a class="btn btn-outline-danger font-weight-bold mx-2">Delete</a>
                            </div>
                        </div>`;

            document.getElementById("preview-pasien-open").innerHTML = html;

        })
        .catch(error => ('Error:', error));

}
