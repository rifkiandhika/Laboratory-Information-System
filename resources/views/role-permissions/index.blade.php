@extends('layouts.admin')

@section('title', 'Role & Permissions')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="d-sm-flex mb-3">
                <h1 class="h3 mb-0 text-gray-600">Role & Permissions</h1>
            </div>
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <a href="{{ route('role-permissions.create') }}" class="btn btn-primary"><i class="ti ti-plus me-2"></i>Create Data</a>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                  <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $x => $item)
                            <tr>
                                <td>{{ $x+1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical fs-5"></i></button>
                                        <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('role-permissions.edit', $item->id) }}"><i class="ti ti-edit"></i> Edit</a>
                                        @if($item->name != 'Superadmin')
                                        <a href="{{ route('role-permissions.destroy', $item->id) }}" class="dropdown-item btn-delete" type="submit" data-confirm-delete="true"><i class="ti ti-trash me-1"></i> Delete</a>
                                        {{-- <form action="{{ route('role-permissions.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form> --}}
                                        @endif
                                        <a href="{{ route('role-permissions.show', $item->id) }}" class="dropdown-item" ><i class="ti ti-info-circle"></i> Detail</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>  
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 float-end">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection
