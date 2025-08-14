@extends('layout.master')
@section('content')
<div class="row">
<div class="col-12">
   <div class="card">
      <div class="card-body">
         <div class="row">
            <div class="col-md-12">
               <h4 class="m-0 text-dark col-md-6 float-left">{{ $title }}</h4>
            </div>
         </div>
         <br>
         <form action="/{{ $url }}" method="POST" role="form" class="col-md-12" autocomplete="off">
            @csrf
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group @error('name') text-danger @enderror">
                     <label>Customer Name *</label>
                     <input type="text" name="name" class="form-control" required>
                     @error('name') <div class="error text-danger">{{ $message }}</div> @enderror
                  </div>
               </div>

               <div class="col-md-6">
                  <div class="form-group @error('customer_type') text-danger @enderror">
                     <label>Customer Type *</label>
                     <select name="customer_type" class="form-control" required>
                        <option value="">Select Type</option>
                       @foreach($customerTypes as $type)
                           <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                       @endforeach
                     </select>
                     @error('customer_type') <div class="error text-danger">{{ $message }}</div> @enderror
                  </div>
               </div>

               <div class="col-md-6">
                  <div class="form-group @error('phone') text-danger @enderror">
                     <label>Phone No *</label>
                     <input type="tel" name="phone" class="form-control" required pattern="[0-9]{10}" onkeypress="return isNumber(event)">
                     @error('phone') <div class="error text-danger">{{ $message }}</div> @enderror
                  </div>
               </div>

               <div class="col-md-6">
                  <div class="form-group @error('alt_phone') text-danger @enderror">
                     <label>Alternate Phone</label>
                     <input type="tel" name="alt_phone" class="form-control" pattern="[0-9]{10}" onkeypress="return isNumber(event)">
                     @error('alt_phone') <div class="error text-danger">{{ $message }}</div> @enderror
                  </div>
               </div>

               <div class="col-md-6">
                  <div class="form-group @error('address') text-danger @enderror">
                     <label>Address</label>
                     <textarea name="address" class="form-control"></textarea>
                     @error('address') <div class="error text-danger">{{ $message }}</div> @enderror
                  </div>
               </div>

               <div class="col-md-6">
                  <div class="form-group @error('shipping_address') text-danger @enderror">
                     <label>Shipping Address</label>
                     <textarea name="shipping_address" class="form-control"></textarea>
                     @error('shipping_address') <div class="error text-danger">{{ $message }}</div> @enderror
                  </div>
               </div>

               <div class="col-md-6">
                  <div class="form-group @error('gstin') text-danger @enderror">
                     <label>GSTIN</label>
                     <input type="text" name="gstin" class="form-control">
                     @error('gstin') <div class="error text-danger">{{ $message }}</div> @enderror
                  </div>
               </div>

               <div class="col-md-6">
                  <div class="form-group @error('gst_state_id') text-danger @enderror">
                     <label>GST State</label>
                   <select name="gst_state_id" id="gst_state_id" class="form-control select2" required>
                           <option value="">Select State</option>
                           @foreach($state as $st)
                              <option value="{{ $st->id }}" data-code="{{ $st->code }}">{{ $st->name }}</option>
                           @endforeach
                        </select>
               </div>
               </div>

               <div class="col-md-6">
                  <div class="form-group @error('gst_state_code') text-danger @enderror">
                     <label>GST State Code</label>
                     <input type="text" name="gst_state_code" id="gst_state_code" class="form-control" readonly>
                     @error('gst_state_code') <div class="error text-danger">{{ $message }}</div> @enderror
                  </div>
               </div>

               <div class="col-md-6">
                  <div class="form-group @error('credit_limit') text-danger @enderror">
                     <label>Credit Limit</label>
                     <input type="number" step="0.01" name="credit_limit" class="form-control">
                     @error('credit_limit') <div class="error text-danger">{{ $message }}</div> @enderror
                  </div>
               </div>

               <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                  <a class="btn btn-danger btn-sm" href="/customers">Cancel</a>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
</div>
@endsection

@section('js')
<script>
function isNumber(evt) {
    evt = evt || window.event;
    let charCode = evt.which || evt.keyCode;
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
}

// Auto-fill GST State Code on selection
$(document).ready(function () {
    $('.select2').select2({ theme: 'bootstrap4' });

    $('#gst_state_id').on('change', function () {
        let stateCode = $(this).find(':selected').data('code');
        $('#gst_state_code').val(stateCode || '');
    });
});
</script>
@endsection
