<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Horizontal Label</title>
<style>
    @page { size: 100mm 25mm; margin: 0; }
    *{
      font-size: 10px;
    }
    body { margin:0; padding:0; font-size: 10px;}
    
    .page {
    
      width: 100mm;
      height: 25mm;
      display: grid;
      grid-template-columns: repeat(2, 1fr); 
      justify-items: center;
        /* display: flex;
       justify-content: flex-start;
        align-items: center;  */

    }
    
    .label {
      
      width: 50mm;   /* half width */
      height: 25mm;  /* full height */
      position: relative;
      box-sizing: border-box;
      overflow: hidden; /* prevents spilling out */
      border: .05px dashed grey;
    }
    
    .inner {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 50mm;
      text-align: center;
      /* font-size: 7px;   reduced */
      line-height: 1.1; /* tighter */
    }
    .inner1{
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 50mm;
      text-align: center;
      /* font-size: 7px;   reduced */
      line-height: 1.1; /* tighter */
    }
    .barcode{
      display: flex;
      justify-content: center;
    }
    
    .brand { 
      font-weight: bold; 
      /* font-size: 8px;  */
      margin-bottom: 0.5mm; 
      white-space: nowrap;
    }
    
   
    
    .details { 
      /* border: 1px solid #000; */
      /* font-size: 7px;  */
      line-height: 1.1; 
      /* margin-top: 0.2mm;  */
      /* padding: 0.2mm; */
      word-wrap: break-word;
    }
    .brand{
      font-weight: bold;
      font-size: 15px;
    }
    </style>
    
</head>
<body>

<div class="page">
  <!-- Left Label -->
  <div class="label">
    <div class="inner">
      <div class="brand">Jhan's Collections</div>
      <div class="barcode">
        {!! DNS1D::getBarcodeHTML($product->barcode, 'C128', 1, 25) !!} 
      </div>
      <div class="barcode-text">{{ $product->barcode }}</div>
      <div class="details">
        Product: {{ $product->name }}<br>
        MRP: Rs. <s style="font-size: 12px;"> {{ $product->mrp }}</s><br>
        Our Price:Rs.<b style="font-size: 15px;">{{ $product->sale_price }}</b>
      </div>
    </div>
  </div>

  <!-- Right Label -->
  <div class="label">
    <div class="inner">
      <div class="brand">Jhan's Collections</div>
      <div class="barcode">
        {!! DNS1D::getBarcodeHTML($product->barcode, 'C128', 1, 25) !!}
      </div>
      <div class="barcode-text">{{ $product->barcode }}</div>
      <div class="details">
        Product: {{ $product->name }}<br>
        MRP: Rs. <s style="font-size: 12px;"> {{ $product->mrp }}</s><br>
        Our Price:Rs.<b style="font-size: 15px;">{{ $product->sale_price }}</b>
      </div>
    </div>
  </div>
</div>

</body>
</html>
