@extends('layout.master')

@section('content')
<div class="container">
    <h2>Edit Sub Category</h2>
    <form method="POST" action="{{ route('subcategories.update', $subcategory->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Parent Category</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $subcategory->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Sub Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ $subcategory->name }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('subcategories.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
