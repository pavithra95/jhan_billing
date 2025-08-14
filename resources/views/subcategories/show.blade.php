@extends('layout.master')

@section('content')
<div class="container">
    <h2>Sub Category Details</h2>

    <div class="card mt-3">
        <div class="card-body">
             <div class="row">

    <div class="col-md-12">

        <h4 class="m-0 text-dark col-md-6 float-left">View Sub Category</h4>
        <a href="/subcategories" class="btn btn-warning float-right ml-3 btn-sm">Back</a>
        <a href="/subcategories/{{$subcategory->id}}/edit" class="btn btn-success float-right ml-3 btn-sm">Edit</a>

    </div>
</div>
<br>
            <h5 class="card-title"><strong>Sub Category Name:</strong> {{ $subcategory->name }}</h5>
            <p class="card-text"><strong>Parent Category:</strong> {{ $subcategory->category->name ?? 'N/A' }}</p>
            <!-- <p class="card-text"><strong>Created At:</strong> {{ $subcategory->created_at->format('d-m-Y') }}</p>
            <p class="card-text"><strong>Updated At:</strong> {{ $subcategory->updated_at->format('d-m-Y') }}</p> -->
        </div>
    </div>

    <a href="{{ route('subcategories.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
