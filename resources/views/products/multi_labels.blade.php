<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Labels</title>
<style>
  @page { size: A4; margin: 0; }   /* printing on A4 with multiple labels */
  body { margin:0; padding:0; }

  .sheet {
      display: flex;
      flex-wrap: wrap;   /* flow horizontally across page */
      width: 100%;
  }

  .label {
      width: 40mm;      /* exact sticker size */
      height: 28mm;     /* exact sticker size */
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-size: 8px;   /* optimized for small size */
      line-height: 1.1;
      padding: 1mm;
      text-align: center;
      overflow: hidden;
      /* border: 1px dashed #ccc; */ /* use for testing only */
  }

  .brand {
      font-weight: bold;
      font-size: 8px;
      margin-bottom: 1mm;
  }
  .barcode {
      margin: 0 auto 0.5mm auto;
  }
  .barcode-text {
      font-size: 6px;
      margin-bottom: 1mm;
  }
  .details {
      font-size: 6.5px;
      line-height: 1.1;
      text-align: center;
  }

  @media print {
      .controls { display:none; }
      .label { border:none; margin:0; }
  }
</style>
</head>
<body>

<div class="controls" style="margin:10px; text-align:right;">
  <button onclick="window.print()" class="btn">Print</button>
</div>

<div class="sheet">
@foreach ($products as $product)
    <div class="label">
        <div class="brand">Jhan's Collections</div>
        <div class="barcode">
            {!! DNS1D::getBarcodeHTML($product->barcode, 'C128', 1, 14) !!}
        </div>
        <div class="barcode-text">{{ $product->barcode }}</div>
        <div class="details">
            Product: {{ $product->name }}<br>
            Size: {{ $product->Size->name ?? '' }}<br>
            MRP: Rs. {{ $product->mrp }}<br>
            Discount: Rs. {{ $product->sale_price }}
        </div>
    </div>
@endforeach
</div>

</body>
</html>
