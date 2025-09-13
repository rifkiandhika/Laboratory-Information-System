@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="container-fluid">
<div class="card">
    <div class="card-body pb-0">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
          {{-- <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">{{ tr('dashboard') }}</a>
          </li> --}}
          <li class="breadcrumb-item">
            <a href="{{ route('users.index') }}">Users</a>
          </li>
          <li class="breadcrumb-item active">List</li>
        </ol>
      </nav>
    </div>
  </div>
<div class="card my-3">
    <div class="card-header">
        <div>
            <a class="btn btn-primary" href="{{ route('users.create') }}"><i class="fas fa-plus me-2"></i>Create User</a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('users.index') }}" method="GET">
            <div class="row justify-content-end mb-3">
                <div class="col-12 col-lg-3">
                    <div class="input-group">
                        <input type="text" placeholder="Search" name="search" value="{{ old('search', $search ?? '') }}" class="form-control form-search">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $x => $item)
                        <tr>
                            <td>{{ $x+1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->getRoleName() }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical fs-5"></i></button>
                                    <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('users.edit', $item->id) }}"><i class="ti ti-edit"></i> Edit</a>
                                    <a href="{{ route('users.destroy', $item->id) }}" class="dropdown-item btn-delete" type="submit" data-confirm-delete="true"><i class="ti ti-trash me-1"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
</div>
</div>
@endsection