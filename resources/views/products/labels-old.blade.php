<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Horizontal Label</title>
<style>
@page { size: 50mm 25mm; margin: 0; }

body { margin:0; padding:0; }

.label-row {
  display: grid;
  grid-template-columns: repeat(2, 50mm); /* two labels in a row */
  width: 100%;
}

.label {
  width: 50mm;
  height: 25mm;
  position: relative;
  box-sizing: border-box;
  /* border: 0.1mm dashed #ccc; */ /* Uncomment for testing alignment */
}

.inner {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 46mm;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.brand { 
  font-weight: bold; 
  font-size: 11px; 
  margin-bottom: 1mm; 
  white-space: nowrap;
}

.barcode { 
  margin: 0.5mm 0; 
}

.barcode-text { 
  font-size: 11px; 
}

.details { 
  font-size: 11px; 
  line-height: 1.2; 
  margin-top: 1mm; 
}
</style>
</head>
<body>

<div class="label-row">
  <!-- Left Label -->
  <div class="label">
    <div class="inner">
      <div class="brand">Jhan's Collections</div>
      <div class="barcode">
        {!! DNS1D::getBarcodeHTML($product->barcode, 'C128', 1.5, 20) !!} 
      </div>
      <div class="barcode-text">{{ $product->barcode }}</div>
      <div class="details">
        Product: {{ $product->name }}<br>
        MRP: Rs. {{ $product->mrp }}<br>
        Discount: Rs. {{ $product->sale_price }}
      </div>
    </div>
  </div>

  <!-- Right Label -->
  <div class="label">
    <div class="inner">
      <div class="brand">Jhan's Collections</div>
      <div class="barcode">
        {!! DNS1D::getBarcodeHTML($product->barcode, 'C128', 1.5, 20) !!}
      </div>
      <div class="barcode-text">{{ $product->barcode }}</div>
      <div class="details">
        Product: {{ $product->name }}<br>
        MRP: Rs. {{ $product->mrp }}<br>
        Discount: Rs. {{ $product->sale_price }}
      </div>
    </div>
  </div>
</div>

</body>
</html>
