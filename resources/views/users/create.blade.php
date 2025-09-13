@extends('layouts.admin')
<title>Users | Create</title>
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
          <li class="breadcrumb-item active">Create</li>
        </ol>
      </nav>
    </div>
  </div>
<div class="card my-3">
    {{-- <div class="card-header">
        <div>
            <a class="btn btn-secondary" href="{{ route('users.index') }}"><i class="fas fa-arrow-left me-2"></i>Back</a>
        </div>
    </div> --}}
    <form action="{{ route('users.store') }}" method="POST" class="needs-validation" enctype="multipart/form-data">
      @csrf
      <div class="card-body">
          @include('users.form')
      </div>
      <div class="card-footer float-end">
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
</div>
</div>
@endsection