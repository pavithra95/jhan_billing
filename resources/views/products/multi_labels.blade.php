<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Labels</title>
<style>
  @page { size: 80mm 28mm; margin:0; }
  body { margin:0; padding:0; }

  .page {
      position: relative;
      width: 80mm;
      height: 28mm;
      page-break-after: always;
  }

  .label {
      width: 40mm;
      height: 28mm;
      box-sizing: border-box;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      font-size: 9px;
      line-height: 1.1;
      overflow: hidden;
      position: absolute;
      top: 0;
  }

  .left  { left: 0mm; }
  .right { left: 40mm; }

  .barcode {
      margin: 0 auto;
  }

  /* Print button container */
  .controls {
      margin: 15px 20px;
      text-align: right;   /* align button to right */
  }

  /* Print button style */
  .btn {
      background: #007bff;
      color: #fff;
      border: none;
      padding: 8px 16px;
      font-size: 14px;
      border-radius: 4px;
      cursor: pointer;
  }
  .btn:hover {
      background: #0056b3;
  }

  @media print {
      .controls { display:none; }
      .label { border: none; }
  }
</style>
</head>
<body>

<div class="controls">
  <button onclick="window.print()" class="btn">Print</button>
</div>

@foreach ($products as $i => $product)
    {{-- Start a new sheet every 2 labels --}}
    @if($i % 2 == 0)
        <div class="page">
    @endif

        <div class="label {{ $i % 2 == 0 ? 'left' : 'right' }}">
            <div>Jhan's Collections</div>
            <div class="barcode">
                {!! DNS1D::getBarcodeHTML($product->barcode, 'C128', 1, 18) !!}
            </div>
            <div>{{ $product->barcode }}</div>
            <div>Product: {{ $product->name }}</div>
            <div>Size: {{ $product->Size->name ?? '' }}</div>
            <div>MRP: Rs.{{ $product->mrp }}</div>
            <div>Discount Price: Rs.{{ $product->sale_price }}</div>
        </div>

    @if($i % 2 == 1 || $loop->last)
        </div>
    @endif
@endforeach

</body>
</html>
