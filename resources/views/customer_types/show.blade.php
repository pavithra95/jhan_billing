<!-- resources/views/customer_types/show.blade.php -->
@extends('layout.master')

@section('content')
<div class="container">
    <h2>View Customer Type</h2>
    <div class="mb-3">
        <strong>Type Name:</strong> {{ $customerType->type_name }}
    </div>
    <div class="mb-3">
        <strong>Description:</strong> {{ $customerType->description }}
    </div>
    <a href="{{ route('customer-types.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
