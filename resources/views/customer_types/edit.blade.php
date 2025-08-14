<!-- resources/views/customer_types/edit.blade.php -->
@extends('layout.master')

@section('content')
<div class="container">
    <h2>Edit Customer Type</h2>
    <form method="POST" action="{{ route('customer-types.update', $customerType->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Type Name</label>
            <input type="text" name="type_name" value="{{ $customerType->type_name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $customerType->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('customer-types.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
