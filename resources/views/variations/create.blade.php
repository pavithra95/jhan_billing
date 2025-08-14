@extends('layout.master')
@section('content')

<h4>Add Variation</h4>

<form action="{{ route('variations.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Variation Name *</label>
        <input type="text" name="name" class="form-control" placeholder="e.g. Weight, Size" required>
    </div>

    <div class="form-group">
        <label>Variation Values *</label>
        <div id="variation-values">
            <div class="input-group mb-2">
                <input type="text" name="values[]" class="form-control" placeholder="e.g. 1kg" required>
                <div class="input-group-append">
                    <button type="button" class="btn btn-success add-value">+</button>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>

@endsection

@section('js')
<script>
$(document).ready(function(){
    $(document).on('click', '.add-value', function(){
        let html = `
        <div class="input-group mb-2">
            <input type="text" name="values[]" class="form-control" placeholder="e.g. 2kg" required>
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
