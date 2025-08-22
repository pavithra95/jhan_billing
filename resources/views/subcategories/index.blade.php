@extends('layout.master')

@section('title', 'ZetBooks')

@section('content_header')
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="m-0 text-dark col-md-6 float-left">All Sub Categories</h4>
                        <a class="btn btn-primary float-right btn-sm" href="{{ route('subcategories.create') }}">NEW</a>
                    </div>
                </div>

                <br>

                <table id="example" class="table table-hover table-light" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Sub Category Name</th>
                            <th>Parent Category</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($subCategories as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="{{ route('subcategories.show', $item->id) }}">{{ $item->name }}</a></td>
                            <td>{{ $item->category->name ?? 'N/A' }}</td>
                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('subcategories.edit', $item->id) }}"><i class="fa fa-edit text-primary"></i></a>
                                
                                @if(auth()->user()->privilege == "admin")
                                <a href="{{ url('/subcategories/'.$item->id.'/delete') }}">
                                    <i class="fa fa-trash text-danger ml-2"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                {{ $subCategories->links() }}

            </div>
        </div>
    </div>
</div>
@stop
