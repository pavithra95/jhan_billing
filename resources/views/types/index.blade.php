@extends('layout.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Type Management</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Type List</h3>
                <div class="card-tools">
                    <a href="{{ route('types.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Type
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <table id="example" class="table table-hover table-light" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Type Name</th>
                            <th>Sub Category</th>
                            <th>Status</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($types as $type)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $type->name }}</td>
                                <td>{{ $type->sub->name }}</td>
                                <td>
                                    <span class="badge {{ $type->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($type->status) }}
                                    </span>
                                </td>
                                <td>
                                     <a href="/types/{{$type->id}}/edit"><i class= "fa fa-edit"></i></a>
                        @if(auth()->user()->privilege == "admin")
                        <a href="/types/{{$type->id}}/delete"><i class="fa fa-trash" ></i></a>
                        @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No types found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $types->links() }}
            </div>
        </div>
    </div>
</section>
@endsection