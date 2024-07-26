@extends('master')
@section('title', 'Tambah User')

@section('content')
<div class="content" id="scroll-content">
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="d-sm-flex  mt-3">
        <h1 class="h3 mb-0 text-gray-600">Tambah user</h1>
      </div>

      <!-- Content Row -->
      <div class="row mt-3">
          <div class="col-xl-4">
              <!-- Profile picture card-->
              <div class="card mb-4 mb-xl-0">
                  <div class="card-header">Profile Picture</div>
                  <div class="card-body text-center">
                      <!-- Profile picture image-->
                      <img class="img-account-profile rounded-circle mb-2" src="{{ asset('../image/Gambar WhatsApp 2024-02-21 pukul 22.51.27_01f70494.jpg') }}" alt="" />
                      <!-- Profile picture help block-->
                      <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                      <!-- Profile picture upload button-->
                      <button class="btn btn-teal" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Upload new image</button>
                  </div>
              </div>
          </div>
          <div class="col-xl-8">
              <!-- Account details card-->
              <div class="card mb-4">
                  <div class="card-header">Account Details</div>
                  <div class="card-body">
                      <form>
                          <!-- Form Row-->
                          <div class="row gx-3 mb-3">
                              <!-- Form Group (first name)-->
                              <div class="">
                                  <label class="small mb-1" for="inputFirstName">First name</label>
                                  <input class="form-control" id="inputFirstName" type="text" placeholder="Enter your first name" value="" />
                              </div>
                              <!-- Form Group (last name)-->
                              <div class="">
                                  <label class="small mb-1" for="inputLastName">Last name</label>
                                  <input class="form-control" id="inputLastName" type="text" placeholder="Enter your last name" value="" />
                              </div>
                          </div>
                          <!-- Form Group (email address)-->
                          <div class="mb-3">
                              <label class="small mb-1" for="inputEmailAddress">Email address</label>
                              <input class="form-control" id="inputEmailAddress" type="email" placeholder="Enter your email address" value="" />
                          </div>
                          <div class="mb-3">
                              <label class="small mb-1" for="username">Username</label>
                              <input class="form-control" id="username" type="email" placeholder="Username" value="" />
                          </div>
                          <div class="mb-3">
                              <label class="small mb-1">Password</label>
                              <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2" id="password">
                              <div class="eye-visibility" id="togglePassword">
                                  <i class="fas fa-eye-slash eye"></i>
                              </div>
                          </div>
                          <!-- Form Group (Group Selection Checkboxes)-->
                          <div class="mb-3">
                              <label class="small mb-1">Hak Akses</label>
                              <div class="form-check">
                                  <input class="form-check-input" id="admin" type="checkbox" value="" />
                                  <label class="form-check-label" for="admin">Admin</label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" id="loket" type="checkbox" value="" />
                                  <label class="form-check-label" for="loket">Loket</label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" id="dokter" type="checkbox" value="" />
                                  <label class="form-check-label" for="dokter">Dokter</label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" id="lab" type="checkbox" value="" />
                                  <label class="form-check-label" for="lab">Lab</label>
                              </div>
                          </div>
                          <!-- Form Group (Roles)-->
                          <div class="mb-3">
                              <label class="small mb-1">Role</label>
                              <select class="form-control" id="exampleFormControlSelect1" name="role">
                                  <option selected>Pilih</option>
                                  <option value="1">Superadmin</option>
                                  <option value="2">Admin</option>
                                  <option value="3">User</option>
                              </select>
                          </div>
                          <!-- Submit button-->
                          <div class="text-right">
                              <button class="btn btn-teal" type="button">Tambah user</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>

  </div>



  <script>
    $(document).ready(function(){
      $("#togglePassword").click(function(){
        var x = document.getElementById("password");
        if (x.type === "password") {
          x.type = "text";
          $('#togglePassword i').removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
          x.type = "password";
          $('#togglePassword i').removeClass('fa-eye').addClass('fa-eye-slash');
        }
      });
    });
  </script>
@endsection

@section('modal')
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Upload Foto</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body py-0" style="max-height: 700px; overflow-y: auto;">
          <form action="#" class="dropzone-box">
            <h2>Upload and attach files</h2>
            <p>Click to upload or drag and drop</p>
            <div class="dropzone-area">
                <div class="file-upload-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload-cloud"><polyline points="16 16 12 12 8 16"></polyline><line x1="12" y1="12" x2="12" y2="21"></line><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path><polyline points="16 16 12 12 8 16"></polyline></svg>
                </div>
                <input type="file" required id="upload-file" name="upload-file">
                <p class="file-info">No Files Selected</p>
            </div>
            <div class="dropzone-action">
                <button type="reset">Cancel</button>
                <button id="submit-button" type="submit">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
<script src="{{ asset('js/upload.js') }}"></script>
@endsection
