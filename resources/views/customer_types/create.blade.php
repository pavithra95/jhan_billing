<!-- resources/views/customer_types/create.blade.php -->
@extends('layout.master')

@section('content')
<div class="container">
    <h2>Create Customer Type</h2>
    <form method="POST" action="{{ route('customer-types.store') }}">
        @csrf
        <div class="mb-3">
            <label>Type Name</label>
            <input type="text" name="type_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('customer-types.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
