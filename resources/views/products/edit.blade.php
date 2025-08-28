@extends('layout.master')

@section('content')
<div class="row" id="test">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="m-0 text-dark col-md-6 float-left">Edit {{$title}}</h4>
                    </div>
                </div>
                <br>

                <form action="/{{$url}}/{{$product->id}}" method="POST" role="form" class="col-md-12" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('item_name')) text-danger @endif">
                                <label for="">Product Name</label>
                                <input type="text" name="item_name" class="form-control" value="{{ old('name', $product->name) }}" required>
                                @if($errors->has('item_name'))
                                    <div class="error text-danger">{{ $errors->first('item_name') }}</div>
                                @endif
                            </div> 
                            <div class="form-group @if($errors->has('age')) text-danger @endif">
                                <label for="">Age</label>
                                <input type="text" name="age" class="form-control" value="{{ old('age', $product->age) }}">
                                @if($errors->has('age'))
                                    <div class="error text-danger">{{ $errors->first('age') }}</div>
                                @endif
                            </div>

                            <div class="form-group @if($errors->has('category_id')) text-danger @endif">
                                <label for="">Product Category</label>
                                <select class="form-control select2" id="category_id" name="category_id">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('category_id'))
                                    <div class="error text-danger">{{ $errors->first('category_id') }}</div>
                                @endif
                            </div>

                            <div class="form-group @if($errors->has('subcategory_id')) text-danger @endif">
                                <label for="">Product Sub Category</label>
                                <select class="form-control select2" id="subcategory_id" name="subcategory_id">
                                    <option value="">-- Select Sub Category --</option>
                                    @if($product->subcategory_id)
                                        @foreach ($subcategories as $subcat)
                                            <option value="{{ $subcat->id }}" {{ $product->subcategory_id == $subcat->id ? 'selected' : '' }}>{{ $subcat->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group @if($errors->has('type_id')) text-danger @endif">
                                <label for="">Product Type</label>
                                <select class="form-control select2" id="type_id" name="type_id">
                                    <option value="">-- Select Type --</option>
                                    @if($product->type_id)
                                        @foreach ($types as $value)
                                            <option value="{{ $value->id }}" {{ $product->type_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group @if($errors->has('hsn_code')) text-danger @endif">
                                <label for="">HSN Code</label>
                                <input type="text" name="hsn_code" class="form-control hsn_code" value="{{ old('hsn_code', $product->hsn_code) }}"  id="hsn_code">
                                @if($errors->has('hsn_code'))
                                    <div class="error text-danger">{{ $errors->first('hsn_code') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Sale Price</label>
                                <input type="number" name="sale_price" class="form-control" min="0" step="0.01" value="{{ old('sale_price', $product->sale_price) }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="">Wholesale Price</label>
                                <input type="number" name="wholesale_price" class="form-control" min="0" step="0.01" value="{{ old('wholesale_price', $product->wholesale_price) }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="">Purchase Price</label>
                                <input type="number" name="purchase_price" class="form-control" value="{{ old('purchase_price', $product->purchase_price) }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="">Reselling Price</label>
                                <input type="number" name="reselling_price" class="form-control" value="{{ old('reselling_price', $product->reselling_price) }}">
                            </div>

                            <div class="form-group">
                                <label for="">Barcode (Code 128)</label>
                                <div class="input-group">
                                    <input type="text" name="barcode" id="barcode_input" class="form-control" value="{{ old('barcode', $product->barcode) }}" placeholder="e.g. BHG-000123" required>
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
                            <div class="form-group">
                                <label for="">Size</label>
                                <select name="size" class="form-control">
                                    <option value="">-- Select Size --</option>
                                    @foreach($sizes as $size)
    
                                    <option value="{{ $size->id }}" {{ $product->size == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group @if($errors->has('brand')) text-danger @endif">
                                <label for="">Brand</label>
                                <select name="brand_id" class="form-control">
                                    <option value="">-- Select Brand --</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $product->brand == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">MRP</label>
                                <input type="number" name="mrp" class="form-control" min="0" step="0.01" value="{{ old('mrp', $product->mrp) }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="">Retail Price</label>
                                <input type="number" name="retail_price" class="form-control" min="0" step="0.01" value="{{ old('retail_price', $product->retail_price) }}">
                            </div>

                            <div class="form-group">
                                <label for="">Quantity</label>
                                <input type="number" name="quantity" class="form-control" min="0" value="{{ old('quantity', $product->quantity) }}">
                            </div>

                            <div class="form-group @if($errors->has('status')) text-danger @endif">
                                <label for="">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @if($errors->has('status'))
                                    <div class="error text-danger">{{ $errors->first('status') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label><input type="checkbox" id="enable_discount" name="enable_discount" {{ $product->discount_price ? 'checked' : '' }}> Enable Discount</label>
                            </div>

                            <div id="discount_fields" style="display: {{ $product->discount_price ? 'block' : 'none' }};">
                                <div class="form-group">
                                    <label for="discount_price">Discount Price</label>
                                    <input type="number" name="discount_price" class="form-control" min="0" step="0.01" value="{{ old('discount_price', $product->discount_price) }}">
                                </div>

                                <div class="form-group">
                                    <label for="discount_from">From Date</label>
                                    <input type="date" name="discount_from" class="form-control" value="{{ old('discount_from', $product->discount_from) }}">
                                </div>

                                <div class="form-group">
                                    <label for="discount_to">To Date</label>
                                    <input type="date" name="discount_to" class="form-control" value="{{ old('discount_to', $product->discount_to) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary col-md-2 offset-md-5 btn-sm">Update</button>
                    <a class="btn btn-danger col-md-2 btn-sm" href='/products'>Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section("js")
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4'
    });

    // Initialize datepicker
    $('.date-picker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    // Category change handler
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

                    // Set HSN code if not already set
                    if (!$('#hsn_code').val()) {
                        $('#hsn_code').val(data.hsn_code);
                    }
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                }
            });
        }
    });

    // Subcategory change handler
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
                    
                    // Select the existing type if available
                    @if($product->type_id)
                        $('#type_id').val('{{ $product->type_id }}').trigger('change');
                    @endif
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                }
            });
        }
    });

    // Trigger initial change if category is already selected
    @if($product->category_id)
        $('#category_id').trigger('change');
    @endif

    // Discount toggle
    $('#enable_discount').on('change', function() {
        if ($(this).is(':checked')) {
            $('#discount_fields').slideDown();
        } else {
            $('#discount_fields').slideUp();
        }
    });

    // Barcode generation and preview
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

    // Initial barcode render
    renderBarcode($('#barcode_input').val().trim());

    // Manual typing updates preview
    $('#barcode_input').on('input', function() {
        renderBarcode($(this).val().trim());
    });

    // Button to regenerate
    $('#generate_barcode').on('click', function() {
        $('#barcode_input').val(autoGenerateBarcode());
        renderBarcode($('#barcode_input').val().trim());
    });
});
</script>
@stop