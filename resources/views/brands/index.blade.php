@extends('layout.master')

@section('title', 'Brands')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="m-0 text-dark">
            <i class="fas fa-certificate text-primary"></i> Brand Management
        </h1>
       
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow border-0" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="card card-outline card-primary shadow-sm rounded-lg">
        <div class="card-body p-0">
            
            <div class="table-responsive">
                <a class="btn btn-primary float-right btn-sm" href="/brands/create">NEW </a>
               <table id="example" class="table table-hover table-light" style="width:100%">
                    <thead class="thead-light">
                        <tr class="text-center align-middle">
                            <th style="width:60px;">#</th>
                            <th class="text-left">Brand Name</th>
                            <th style="width:120px;">Status</th>
                            <th style="width:160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands as $idx => $brand)
                            <tr>
                                <td class="text-center align-middle font-weight-bold text-secondary">
                                    {{ $brands->firstItem() + $idx }}
                                </td>
                                <td class="align-middle font-weight-semibold">{{ $brand->name }}</td>
                                <td class="text-center align-middle">
                                    <span class="badge {{ $brand->is_active == 1 ? 'badge-success' : 'badge-secondary' }} px-3 py-1"
                                          data-toggle="tooltip"
                                          title="{{ $brand->is_active == 1 ? 'Active Brand' : 'Inactive Brand' }}">
                                        {{ $brand->is_active == 1 ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                     <a href="/brands/{{$brand->id}}/edit"><i class= "fa fa-edit"></i></a>
                        @if(auth()->user()->privilege == "admin")
                        <a href="/brands/{{$brand->id}}/delete"><i class="fa fa-trash" ></i></a>
                        @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted font-italic py-4">
                                    No brands found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($brands->hasPages())
            <div class="card-footer bg-white d-flex justify-content-end">
                {{ $brands->links() }}
            </div>
        @endif
    </div>
@stop

@push('css')
<style>
    .font-weight-semibold { font-weight:600; }
    .card, .btn { border-radius:0.35rem !important; }
    .btn.shadow-sm { box-shadow: 0 2px 6px rgba(0,0,0,0.1); transition: .15s; }
    .btn.shadow-sm:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function(){
    $('[data-toggle="tooltip"]').tooltip({ container: 'body', trigger: 'hover' });

    setTimeout(()=>{ $('.alert').alert('close'); }, 3500);

    $('.delete-form').on('submit', function(e){
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: 'Confirm deletion',
            text: "This will remove the brand permanently.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-check-circle"></i> Delete',
            cancelButtonText: '<i class="fas fa-times-circle"></i> Cancel',
            reverseButtons: true,
        }).then(res => {
            if (res.isConfirmed) form.submit();
        });
    });
});
</script>
@endpush
