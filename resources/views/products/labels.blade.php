<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Label - {{ $product->name }}</title>
<style>
  @page {
      size: 40mm 28mm;   /* exact label size */
      margin: 0;         /* no extra margin */
  }
  body {
      margin: 0;
      padding: 0;
  }
  .label {
      width: 40mm;
      height: 28mm;
      box-sizing: border-box;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      font-size: 8px;         /* slightly smaller text */
      line-height: 1.1;
      overflow: hidden;
  }
  .name {
      font-weight: 600;
      margin-bottom: 1mm;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
  }
  .barcode {
      margin: 0 auto;
  }
  @media print {
      .controls { display:none; }
      .label { border: none; }
  }
</style>
</head>
<body>
<div class="controls" style="margin-bottom:10px">
  <button onclick="window.print()">Print</button>
</div>

<div class="label">
  <div class="name">Jhan's Collections</div>
  <div class="barcode">
    {{-- Adjusted barcode size for 40×28mm --}}
    {!! DNS1D::getBarcodeHTML($product->barcode, 'C128', 1, 18) !!}
  </div>
  <div>{{ $product->barcode }}</div>
  <div class="name">Product: {{ $product->name }}</div>
  <div class="name">Size: {{ $product->Size->name ?? '' }}</div>
  <div class="name">MRP: Rs. {{ $product->mrp }}</div>
  <div class="name">Discount Price: Rs. {{ $product->sale_price }}</div>
</div>

</body>
</html>
