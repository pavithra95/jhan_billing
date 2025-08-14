@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-body">
        <h4>Add Store</h4>
        <form action="{{ route('stores.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Store Name *</label>
                <input type="text" name="store_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Store Code *</label>
                <input type="text" name="store_code" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <button class="btn btn-primary">Submit</button>
            <a href="{{ route('stores.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
