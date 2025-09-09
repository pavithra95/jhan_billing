@extends('layout.master')


@section('content')
<div class="row" id="test">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
              <div class="row">

    <div class="col-md-12">

        <h4 class="m-0 text-dark col-md-6 float-left">{{$title}}</h4>

    </div>
</div>
<br>


                <form action="/{{$url}}" method="POST" role="form" class="col-md-12 " autocomplete="off">
                    {{ csrf_field() }}

                    <div class="row">

                        <div class="col-md-6">


                        
                            <div class="form-group @if($errors->has('item_name')) text-danger @endif">
                                <label for=""> Product Name</label>
                                <input type="text" name="item_name" class="form-control" value="" required="required">
                                @if($errors->has('item_name'))
                                    <div class="error text-danger">{{ $errors->first('item_name') }}</div>
                                @endif

                            </div> 
                            <div class="form-group @if($errors->has('age')) text-danger @endif">
                                <label for=""> Age</label>
                                <input type="text" name="age" class="form-control" value="">
                                @if($errors->has('age'))
                                    <div class="error text-danger">{{ $errors->first('age') }}</div>
                                @endif

                            </div>

 <div class="form-group @if($errors->has('category_id')) text-danger @endif">
    <label for="">Product Category</label>
    <select class="form-control select2" id="category_id" name="category_id">
        <option value="">-- Select Category --</option>
        @foreach ($category as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select>
</div>

{{-- Product Sub Category Dropdown --}}
<div class="form-group @if($errors->has('subcategory_id')) text-danger @endif">
    <label for="">Product Sub Category</label>
    <select class="form-control select2" id="subcategory_id" name="subcategory_id">
        <option value="">-- Select Sub Category --</option>
    </select>
</div>
{{-- Type --}}
<div class="form-group @if($errors->has('type_id')) text-danger @endif">
    <label for="">Product Type</label>
    <select class="form-control select2" id="type_id" name="type_id">
        <option value="">-- Select Type --</option>
    </select>
</div>





                             <div class="form-group @if($errors->has('hsn_code')) text-danger @endif">
                                <label for="">HSN Code</label>
                                <input type="text" name="hsn_code" class="form-control hsn_code" value="" id="hsn_code">
                                @if($errors->has('hsn_code'))
                                    <div class="error text-danger">{{ $errors->first('hsn_code') }}</div>
                                @endif

                            </div>
                           



                             <div class="form-group">
                            <label for="">Sale Price</label>
                            <input type="number" name="sale_price" class="form-control" min="0" step="0.01" required>
                        </div>
                         <div class="form-group">
                            <label for="">Wholesale Price</label>
                            <input type="number" name="wholesale_price" class="form-control" min="0" step="0.01">
                        </div> 
                        <div class="form-group">
                            <label for="">Purchase Price</label>
                            <input type="number" name="purchase_price" class="form-control" >
                        </div>
                         <div class="form-group">
                            <label for="">Reselling Price</label>
                            <input type="number" name="purchase_price" class="form-control" >
                        </div>

                       <div class="form-group">
  <label for="">Barcode (Code 128)</label>
  <div class="input-group">
    <input type="text" name="barcode" id="barcode_input" class="form-control" placeholder="e.g. BHG-000123" required>
    <div class="input-group-append">
      <button type="button" id="generate_barcode" class="btn btn-secondary">Auto</button>
    </div>
  </div>
  <small class="text-muted">Leave blank or click Auto to generate — you can still edit it manually.</small>
  <div class="mt-2">
    <svg id="barcode_preview"></svg>
  </div>
</div>

                        </div>
                        <div class="col-md-6">

                            
                           
                           

 <div class="form-group @if($errors->has('brand')) text-danger @endif">
    <div class="form-group">
                            <label for="">Size</label>
                            <select name="size" class="form-control">
                                    <option value="">-- Select Size --</option>
                                    @foreach($sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                                    @endforeach
                                </select>
                        </div>
                                <label for=""> Brand</label>
                                <select name="brand_id" class="form-control">
                                    <option value="">-- Select Brand --</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                              

                            </div>

                            {{-- Pricing Fields --}}
                        <div class="form-group">
                            <label for="">MRP</label>
                            <input type="number" name="mrp" class="form-control" min="0" step="0.01" required>
                        </div>
                       
                        <div class="form-group">
                            <label for="">Retail Price</label>
                            <input type="number" name="retail_price" class="form-control" min="0" step="0.01">
                        </div>

                        <div class="form-group">
                            <label for="">Quantity</label>
                            <input type="number" name="quantity" class="form-control" min="0" required>
                        </div>
                       
                    


                       
                             <div class="form-group @if($errors->has('status')) text-danger @endif">
                                <label for="">Status</label>
                                <select name="status" id="input" class="form-control" required="required">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                @if($errors->has('status'))
                                    <div class="error text-danger">{{ $errors->first('status') }}</div>
                                @endif
                            </div>

                                                   {{-- Discount Checkbox --}}
<div class="form-group">
    <label><input type="checkbox" id="enable_discount" name="enable_discount"> Enable Discount</label>
</div>

{{-- Discount Fields (Hidden by default) --}}
<div id="discount_fields" style="display: none;">
    <div class="form-group">
        <label for="discount_price">Discount Price</label>
        <input type="number" name="discount_price" class="form-control" min="0" step="0.01">
    </div>

    <div class="form-group">
        <label for="discount_from">From Date</label>
        <input type="date" name="discount_from" class="form-control">
    </div>

    <div class="form-group">
        <label for="discount_to">To Date</label>
        <input type="date" name="discount_to" class="form-control">
    </div>
</div>
                            


                        </div>

 


                            

                        </div>



                    
                    
                    <button type="submit" class="btn btn-primary col-md-2 offset-md-5 btn-sm">Create</button>
                   <a class="btn btn-danger col-md-2 btn-sm" href='/products'>Cancel </a>
                </form>



            </div>
        </div>
    </div>
</div>

@stop

@section("js")
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

<script >
   $(document).ready(
    function() { 


        $('.date-picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

                //Initialize Select2 Elements
                $('.select2').select2({
                  theme: 'bootstrap4'
              })

            });
</script>
 <script >
              var app = new Vue({
                el:'#test',
                data:{
                 
                   editId: 0,
     
             isEditLoading: false,
                    isPageLoading: false,
                    isLoading: false,
                    selectedCategory: 0,
                    selectedTest: 0,
                    tests: [],
                    view_items: [],
                    items: [],
                    values: []

                },

                // created: function () {
                //     console.log('works');
                //     this.getReportItems();
                //   },
                  methods: {


                     getTest: function() {
        var self = this;
        self.isLoading = true;
        var url = "/getCategory/" + this.selectedCategory;
        axios.get(url)

        .then(function (response) {
          // handle success
            self.values = [];
          self.tests = response.data;
          if (self.tests.length == 0) {
            self.item_message = 'No Test Found';
          }
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
        .finally(function () {
          self.isLoading = false;
        });


     },


     

    

     
    }

    });




               
          
    
  </script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
     $(document).ready(function() {
    $('#category_id').on('change', function() {
        var categoryId = $(this).val();

        // Clear existing subcategories
        $('#subcategory_id').empty().append('<option value="">-- Select Sub Category --</option>');
        $('#hsn_code').val(''); // Clear HSN

        if (categoryId) {
            // Get subcategories
            $.ajax({
                url: '/get-subcategories/' + categoryId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $.each(data.subcategories, function(key, value) {
                        $('#subcategory_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });

                    // Set HSN code
                    $('#hsn_code').val(data.hsn_code);
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                }
            });
        }
    });

    $('#subcategory_id').on('change', function() {
        var subcategoryId = $(this).val();

        // Clear existing types
        $('#type_id').empty().append('<option value="">-- Select Type --</option>');

        if (subcategoryId) {
            // Get types
            $.ajax({
                url: '/get-product-types/' + subcategoryId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(key, value) {
                        $('#type_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                }
            });
        }
    });

    $('.select2').select2({ theme: 'bootstrap4' });
});




$("#withinStateGst").change(function() {

  var id = $(this).children(":selected").attr("id");
  console.log(id);
  $("#outSideStateGst option[id='out" + id + "']").attr("selected", "selected");

});

$(document).ready(function() {

    // On change of Sale Unit
    $('select[name="sale_unit"]').on('change', function() {
        let selectedUnitText = $(this).find('option:selected').text().trim();
        let selectedUnitVal = $(this).val();

        // Set last field in Purchase Unit (conversion unit)
        $('select[name="conversion_unit"]').val(selectedUnitVal).trigger('change');

        // If "I have milligrams" is already Yes, also fill mg_from_value and mg_from_unit
        let hasMG = $('select[name="has_mg"]').val();
        if (hasMG === 'Yes') {
            $('input[name="mg_from_value"]').val('1 ' + selectedUnitText);
            $('select[name="mg_from_unit"]').val(selectedUnitVal).trigger('change');
        }
    });

    // On change of "I have milligrams?"
    $('select[name="has_mg"]').on('change', function() {
        let value = $(this).val();
        let saleUnitText = $('select[name="sale_unit"] option:selected').text().trim();
        let saleUnitVal = $('select[name="sale_unit"]').val();

        if (value === 'Yes') {
            $('input[name="mg_from_value"]').val('1 ' + saleUnitText);
            $('select[name="mg_from_unit"]').val(saleUnitVal).trigger('change');
        } else {
            $('input[name="mg_from_value"]').val('');
            $('select[name="mg_from_unit"]').val('').trigger('change');
        }
    });

});


$(document).ready(function() {
    // When purchase unit changes
    $('#purchase_unit').on('change', function() {
        let unitText = $(this).find('option:selected').text().trim();
        $('#conversion_value_text').val('1 ' + unitText);
    });

    // Optional: set default on load
    let defaultUnitText = $('#purchase_unit option:selected').text().trim();
    $('#conversion_value_text').val('1 ' + defaultUnitText);
});

$(document).ready(function() {
    // Toggle discount section
    $('#enable_discount').on('change', function() {
        if ($(this).is(':checked')) {
            $('#discount_fields').slideDown();
        } else {
            $('#discount_fields').slideUp();
        }
    });
});

function renderBarcode(val) {
    if (!val) {
        document.getElementById('barcode_preview').innerHTML = '';
        return;
    }
    JsBarcode("#barcode_preview", val, { 
        format: "code128", 
        lineColor: "#000", 
        width: 2, 
        height: 60, 
        displayValue: true 
    });
}

// Auto-generate barcode value
function autoGenerateBarcode() {
    let timestamp = Date.now().toString().slice(-8); // last 8 digits of timestamp
    let randomPart = Math.floor(100 + Math.random() * 900); // 3-digit random
    return `${timestamp}-${randomPart}`;
}

document.addEventListener("DOMContentLoaded", function() {
    let barcodeInput = document.getElementById('barcode_input');

    // Initial auto-fill if empty
    if (!barcodeInput.value.trim()) {
        barcodeInput.value = autoGenerateBarcode();
    }
    renderBarcode(barcodeInput.value.trim());

    // Manual typing updates preview
    barcodeInput.addEventListener('input', function() {
        renderBarcode(this.value.trim());
    });

    // Button to regenerate
    document.getElementById('generate_barcode').addEventListener('click', function() {
        barcodeInput.value = autoGenerateBarcode();
        renderBarcode(barcodeInput.value.trim());
    });
});


</script>
@stop


