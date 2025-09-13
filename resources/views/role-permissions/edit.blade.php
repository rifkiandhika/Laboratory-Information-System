@extends('layouts.admin')
@section('title', 'Role & Permissions')

@section('content')
<style>
    .select2-container .select2-selection--multiple {
    border: 1px solid #d1d5db; /* abu-abu lembut */
    border-radius: 0.475rem;
    padding: 0.5rem;
    min-height: 45px;
}

.select2-container .select2-selection--multiple .select2-selection__choice {
    background-color: #6366f1; /* ungu indigo */
    border: none;
    color: #fff;
    padding: 3px 8px;
    border-radius: 0.375rem;
}

.select2-container .select2-selection--multiple .select2-selection__choice__remove {
    color: #fff;
    margin-right: 4px;
}

</style>
{{-- <h3 class="py-3 mb-4"><span class="text-muted fw-light">{{ tr('role_permissions') }}/</span> Edit {{ tr('role_permissions', 1) }}</h3> --}}
<div class="content">
    <!-- <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header">Role & Permissions</div>
            <div class="card-body">
                <div class="d-flex row justify-content-between">
                    <div class="col-md-6">
                        Role & Permissions
                    </div>
                    <div class="col-md-6 text-end">
                        Home
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Basic Layout -->
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
             Role & Permission
            </div>
            <div class="card-body">
                <form class="needs-validation" action="{{ route('role-permissions.update', $role->id) }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label" for="bs-validation-name">Nama Role</label>
                        <input type="text" name="name" class="form-control" id="bs-validation-name" placeholder="ex. Admin Staff" value="{{ $role->name }}" required />
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Harap isi nama role.</div>
                    </div>
                    @foreach($permissions as $name => $perm)
                        <div class="mb-3">
                            <label for="{{ $name }}">{{ ucwords(str_replace('-', ' ', $name) ) }} Permissions</label>
                            <div class="select2-primary">
                                <select class="select2-custom form-control select2" id="{{ $name }}" data-placeholder="Pilih Item" name="{{ $name }}[]" multiple="multiple">
                                    <option></option>
                                    @foreach($perm as $item)
                                        <option value="{{ $item->name }}" {{ $role->hasPermissionTo($item->name) ? "selected":'' }}>{{ ucwords(explode('_', $item->name)[0].' '.str_replace('-', ' ', explode('_', $item->name)[1])) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                    <div class="row text-end">
                        <div class="col-12">
                            <a href="{{ route('role-permissions.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection
@push('script')
<script type="text/javascript">
    $(function() {

        
        $(".select2-custom").select2({
            placeholder: $(this).attr('data-placeholder')
        });

        /*------------------------------------------
         --------------------------------------------
         Pass Header Token
         --------------------------------------------
         --------------------------------------------*/
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /*------------------------------------------
        --------------------------------------------
        Render DataTable
        --------------------------------------------
        --------------------------------------------*/
        var table = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('role-permissions.index') }}",
            bDestroy: true,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });
    });
</script>
@endpush