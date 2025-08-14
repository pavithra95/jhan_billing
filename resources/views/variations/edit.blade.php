@extends('layout.master')
@section('content')

<h4>Edit Variation</h4>

<form action="{{ route('variations.update', $variation->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Variation Name *</label>
        <input type="text" name="name" class="form-control" value="{{ $variation->name }}" required>
    </div>

    <div class="form-group">
        <label>Variation Values *</label>
        <div id="variation-values">
            @foreach ($variation->values as $value)
            <div class="input-group mb-2">
                <input type="text" name="values[]" class="form-control" value="{{ $value->value }}" required>
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-value">−</button>
                </div>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-success add-value">+ Add Value</button>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('variations.index') }}" class="btn btn-secondary">Cancel</a>
</form>

@endsection

@section('js')
<script>
$(document).ready(function(){
    $(document).on('click', '.add-value', function(){
        let html = `
        <div class="input-group mb-2">
            <input type="text" name="values[]" class="form-control" placeholder="e.g. 3kg" required>
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove-value">−</button>
            </div>
        </div>`;
        $('#variation-values').append(html);
    });

    $(document).on('click', '.remove-value', function(){
        $(this).closest('.input-group').remove();
    });
});
</script>
@endsection
