@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="m-0 text-dark">{{ $title }}</h4>
                <br>

                <form action="/{{ $url }}/{{ $vendor->id }}" method="POST" class="col-md-12" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <label>Supplier Name *</label>
                            <input type="text" name="name" class="form-control" value="{{ $vendor->name }}" required>
                        </div>

                       <div class="col-md-6">
    <label>Supplier Type *</label>
    <select name="category_ids[]" class="form-control select2" multiple>
        @foreach($subCategory as $sub)
            <option value="{{ $sub->id }}" 
                {{ in_array($sub->id, $vendor->supplier_type ?? []) ? 'selected' : '' }}>
                {{ $sub->name }}
            </option>
        @endforeach
    </select>
</div>



                        <div class="col-md-6">
                            <label>Company Name</label>
                            <input type="text" name="company_name" class="form-control" value="{{ $vendor->company_name }}">
                        </div>

                        <div class="col-md-6">
                            <label>Phone *</label>
                            <input type="tel" name="phone" class="form-control" value="{{ $vendor->phone }}" required pattern="[0-9]{10}" onkeypress="return isNumber(event)">
                        </div>

                        <div class="col-md-6">
                            <label>Alt Phone</label>
                            <input type="tel" name="alt_phone" class="form-control" value="{{ $vendor->alt_phone }}" pattern="[0-9]{10}" onkeypress="return isNumber(event)">
                        </div>

                        <div class="col-md-6">
                            <label>Address</label>
                            <textarea name="address" class="form-control">{{ $vendor->address }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label>City</label>
                            <input type="text" name="city" class="form-control" value="{{ $vendor->city }}">
                        </div>

                        <div class="col-md-6">
                            <label>GST No</label>
                            <input type="text" name="gst_no" class="form-control" value="{{ $vendor->gst_no }}">
                        </div>

                        <div class="col-md-6">
                            <label>GST State</label>
                            <select name="gst_state_id" id="gst_state_id" class="form-control select2">
                                <option value="">Select</option>
                                @foreach($state as $st)
                                    <option value="{{ $st->id }}" data-code="{{ $st->code }}"
                                        {{ $vendor->state_id == $st->id ? 'selected' : '' }}>
                                        {{ $st->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>GST State Code</label>
                            <input type="text" name="gst_state_code" id="gst_state_code" class="form-control" value="{{ $vendor->gst_state_code }}" readonly>
                        </div>

                        <div class="col-md-12 text-right mt-4">
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            <a class="btn btn-danger btn-sm" href="/vendors">Cancel</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery (must be before Select2 JS) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
function isNumber(evt) {
    evt = evt || window.event;
    var charCode = evt.which || evt.keyCode;
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
}

$(document).ready(function () {
    $('.select2').select2({ theme: 'bootstrap4' });

    $('#gst_state_id').on('change', function () {
        let code = $(this).find(':selected').data('code');
        $('#gst_state_code').val(code || '');
    });
});
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Select Category",
        allowClear: true
    });
});

</script>
@endsection
