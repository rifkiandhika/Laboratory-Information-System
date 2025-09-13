@extends('layouts.admin')
@section('title', 'Role & Permissions')

@section('content')
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
    <h3><span class="text-muted fw-light"></span> Detail Role & Permission</h3>
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
                Detail Role Permission
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Permission Name</th>
                                <th>Create</th>
                                <th>Read</th>
                                <th>Update</th>
                                <th>Delete</th>
                                {{-- <th>Approval</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1;?>
                        @foreach($permissions as $name => $permission)
                            @if(strpos($name, 'dashboard') !== false)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ ucwords($name) }}</td>
                                <td>-</td>
                                <td class="{{ $role->hasPermissionTo('read_'.$name) ? ($role->hasPermissionTo('read_'.$name) ? 'text-primary':'text-danger'):'text-danger' }}">{{ $role->hasPermissionTo('read_'.$name) ? ($role->hasPermissionTo('read_'.$name) ? 'Yes':'No'):'No' }}</td>
                                <td>-</td>
                                <td>-</td>
                                {{-- <td>-</td> --}}
                            </tr>
                            @else
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ ucwords($name) }}</td>
                                <td class="{{ $role->hasPermissionTo('create_'.$name) ? ($role->hasPermissionTo('create_'.$name) ? 'text-primary':'text-danger'):'text-danger' }}">{{ $role->hasPermissionTo('create_'.$name) ? ($role->hasPermissionTo('create_'.$name) ? 'Yes':'-'):'No' }}</td>
                                <td class="{{ $role->hasPermissionTo('read_'.$name) ? ($role->hasPermissionTo('read_'.$name) ? 'text-primary':'text-danger'):'text-danger' }}">{{ $role->hasPermissionTo('read_'.$name) ? ($role->hasPermissionTo('read_'.$name) ? 'Yes':'No'):'No' }}</td>
                                <td class="{{ $role->hasPermissionTo('update_'.$name) ? ($role->hasPermissionTo('update_'.$name) ? 'text-primary':'text-danger'):'text-danger' }}">{{ $role->hasPermissionTo('update_'.$name) ? ($role->hasPermissionTo('update_'.$name) ? 'Yes':'No'):'No' }}</td>
                                <td class="{{ $role->hasPermissionTo('delete_'.$name) ? ($role->hasPermissionTo('delete_'.$name) ? 'text-primary':'text-danger'):'text-danger' }}">{{ $role->hasPermissionTo('delete_'.$name) ? ($role->hasPermissionTo('delete_'.$name) ? 'Yes':'No'):'No' }}</td>
                                {{-- @if(count($permission) > 4)
                                <td class="{{ $role->hasPermissionTo('approval_'.$name) ? ($role->hasPermissionTo('approval_'.$name) ? 'text-success':'text-danger'):'text-danger' }}">{{ $role->hasPermissionTo('approval_'.$name) ? ($role->hasPermissionTo('approval_'.$name) ? 'Yes':'No'):'No' }}</td>
                                @else
                                <td>-</td>
                                @endif --}}
                            </tr>
                            @endif
                            <?php $no++; ?>
                        @endforeach
                        </tbody>
                    </table>
                </div>
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