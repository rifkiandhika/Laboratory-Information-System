<div class="mb-3">
  <label for="bs-validation-name" class="form-label is-required">Name <span class="text-danger">*</span></label>
  <input type="text" id="bs-validation-name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g Budi Tabuti" value="{{ old('name', $user->name ?? '') }}" required>
  @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3">
  <label for="username" class="form-label is-required">Username <span class="text-danger">*</span></label>
  <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="budi123" value="{{ old('username', $user->username ?? '') }}" required>
  @error('username')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3">
  <label for="email" class="form-label is-required">Email <span class="text-danger">*</span></label>
  <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="budi@gmail.com" value="{{ old('email', $user->email ?? '') }}" required>
  @error('email')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3">
  <label for="password" class="form-label {{ isset($user->id) ? '':'is-required' }}">Password <span class="text-danger">*</span></label>
  <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="**********" {{ isset($user->id) ? '':'required' }}>
  @error('password')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="mb-3">
  <label for="role" class="form-label is-required">Role <span class="text-danger">*</span></label>
  <select name="role" id="role" class="form-control basic-select2 @error('role') is-invalid @enderror">
    <option value="" hidden>Select a Role</option>
    @foreach ($roles as $item)
      <option value="{{ $item->id }}" {{ old('role', isset($user) ? $user->getRoleId() : '') == $item->id ? 'selected' : '' }}>
        {{ $item->name }}
      </option>
    @endforeach
  </select>
  @error('role')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
{{-- Input tambahan untuk analyst --}}
{{-- Input tambahan untuk analyst --}}
<div id="analyst-extra-fields" style="display: none;">
  <div class="mb-3">
    <label for="fee" class="form-label">Fee (%)</label>
    <div class="input-group">
      <input type="number" name="fee" id="fee" min="0" max="100" step="0.01"
             value="{{ old('fee', $user->fee ?? '') }}"
             placeholder="0"
             class="form-control @error('fee') is-invalid @enderror">
      <span class="input-group-text">%</span>
    </div>
    @error('fee')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="mb-3">
    <label for="feemcu" class="form-label">Fee MCU (%)</label>
    <div class="input-group">
      <input type="number" name="feemcu" id="feemcu" min="0" max="100" step="0.01"
             value="{{ old('feemcu', $user->feemcu ?? '') }}"
             placeholder="0"
             class="form-control @error('feemcu') is-invalid @enderror">
      <span class="input-group-text">%</span>
    </div>
    @error('feemcu')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="mb-3">
    <label for="nik" class="form-label">NIK</label>
    <div class="input-group">
      <input type="number" name="nik" id="nik" min="0"
             value="{{ old('nik', $user->nik ?? '') }}"
             placeholder="e.g AN-24512354"
             class="form-control @error('nik') is-invalid @enderror">
    </div>
    @error('nik')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

{{-- Input tanda tangan untuk analyst & dokter --}}
<div id="signature-field" style="display: none;">
  <div class="mb-3">
    <label for="signature" class="form-label">Tanda Tangan</label>
    <input type="file" name="signature" id="signature" 
           accept="image/*"
           class="form-control @error('signature') is-invalid @enderror">
    <div class="form-text">Format yang didukung: JPG, PNG, GIF (Max: 2MB)</div>
    
    {{-- Preview tanda tangan yang sudah ada --}}
    @if(isset($user->signature) && $user->signature)
      <div class="mt-2">
        <label class="form-label">Tanda Tangan Saat Ini:</label>
        <div class="signature-preview">
          <img src="{{ asset('signatures/' . $user->signature) }}" 
               alt="Current Signature" 
               style="max-width: 200px; max-height: 100px; border: 1px solid #ddd; padding: 5px;">
        </div>
      </div>
    @endif
    
    @error('signature')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>


@push('script')
    <script>
  document.addEventListener("DOMContentLoaded", function () {
  const roleSelect = document.getElementById("role");
  const analystFields = document.getElementById("analyst-extra-fields");
  const signatureField = document.getElementById("signature-field");

  function toggleFields() {
    const selectedRole = roleSelect.options[roleSelect.selectedIndex].text.toLowerCase();
    
    // hanya analyst yg bisa lihat fee, feemcu, nik
    if (selectedRole === "analyst") {
      analystFields.style.display = "block";
    } else {
      analystFields.style.display = "none";
    }

    // analyst & dokter bisa tanda tangan
    if (selectedRole === "analyst" || selectedRole === "doctor") {
      signatureField.style.display = "block";
    } else {
      signatureField.style.display = "none";
    }
  }

  // trigger pertama kali saat edit
  toggleFields();

  // saat role diganti
  roleSelect.addEventListener("change", toggleFields);

  // Preview gambar tanda tangan sebelum upload
  const signatureInput = document.getElementById('signature');
  if (signatureInput) {
    signatureInput.addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
          const oldPreview = document.querySelector('.new-signature-preview');
          if (oldPreview) oldPreview.remove();

          const preview = document.createElement('div');
          preview.className = 'new-signature-preview mt-2';
          preview.innerHTML = `
            <label class="form-label">Preview Tanda Tangan Baru:</label>
            <div>
              <img src="${ev.target.result}" alt="New Signature Preview" 
                   style="max-width: 200px; max-height: 100px; border: 1px solid #ddd; padding: 5px;">
            </div>
          `;
          signatureInput.parentNode.appendChild(preview);
        };
        reader.readAsDataURL(file);
      }
    });
  }
});

</script>
@endpush
