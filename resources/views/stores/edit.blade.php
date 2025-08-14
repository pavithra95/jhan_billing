@extends('layout.master')

@section('content')
<div class="card">
    <div class="card-body">
        <h4>Edit Store</h4>

        <form action="{{ route('stores.update', $store->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Store Name *</label>
                <input type="text" name="store_name" class="form-control" value="{{ old('store_name', $store->store_name) }}" required>
                @error('store_name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Store Code *</label>
                <input type="text" name="store_code" class="form-control" value="{{ old('store_code', $store->store_code) }}" required>
                @error('store_code') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" class="form-control">{{ old('address', $store->address) }}</textarea>
                @error('address') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $store->phone) }}">
                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $store->email) }}">
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('stores.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
