<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Labels - {{ $product->name }}</title>
<style>
  @page { size: auto; margin: 5mm; }
  .sheet { display: grid; grid-template-columns: repeat(3, 40mm); gap: 4mm; }
  .label {
      width: 40mm; height: 28mm;
      border: 1px dashed #ccc; padding: 2mm;
      box-sizing: border-box; text-align: center;
      display: flex; flex-direction: column; justify-content: center;
      font-size: 10px; line-height: 1.1;
  }
  .name { font-weight: 600; margin-bottom: 2mm; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .barcode { margin: 0 auto; }
  @media print { .controls { display:none; } .label { border: 0; } }
</style>
</head>
<body>
<div class="controls" style="margin-bottom:10px">
  <button onclick="window.print()">Print</button>
</div>

<div class="sheet">
  @for ($i = 0; $i < 2; $i++) {{-- 24 labels per sheet example --}}
    <div class="label">
      <div class="name">Jhan's Collections</div>
      <div class="barcode">
        {!! DNS1D::getBarcodeHTML($product->barcode, 'C128', 1.4, 22) !!}
      </div>
      <div>{{ $product->barcode }}</div>
       <div class="name">Product : {{ $product->name }}</div>
       <div class="name">MRP : RS.{{ $product->mrp }}</div>
       <div class="name">Sale Price : RS.{{ $product->sale_price }}</div>
    </div>
  @endfor
</div>
</body>
</html>
