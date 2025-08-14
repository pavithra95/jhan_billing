@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

    <div class="col-md-12">

        <h4 class="m-0 text-dark col-md-6 float-left">Stock Report</h4>       
    </div>
</div>
<br>
<div class="row">
       <form action="" method="GET"  role="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="" for="">Product Name</label>
                <input type="text" name="product" class="date-picker form-control" value="{{ $pro }}" autocomplete="off" placeholder="Product Name">
              </div>
            </div>
        </div>
          
           <div class="row">  
            <button type="submit" class="btn btn-primary" style="margin-left: 10px">Filter</button>
            @if(!empty($_GET))
      <a style="margin-left: 10px;" href="/{{ request()->path() }}" class="btn btn-primary float-right">
          Clear Filter
      </a>
      @endif

  </div>
</form>
</div>
<br>


                <table id="example" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Product Name</th>
                            <th>Pur. Qty</th>
							<th>AR.Pur.Qty</th>
                            <th>Sales Qty</th>
                            <th>Stock Qty</th>
                           {{--  <th>Total Sale Amount</th> --}}
                            <th>Total Pur.Net Amt</th>
                            <th>Ava.Stock Net T.Amt</th>
                            <th>Total Purchase Value</th>
                            <th>Sales.Return Qty</th>
                            <th>Pur.Return Qty</th>
                            <th>Pur.Return Amt</th>
                            <th>AR. Total Pur.Value</th>
                            <!--<th>AR. Ava.Stock Qty</th>--><th>Available Quantity</th>
                            <!--<th>AR. Ava.Stock Net Amt</th>--><th>Average Price Per Unit</th>
                            <!--<th>AR. Ava.Stock Net T.Amt</th>--><th>Total Value</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->name }}</a></td>
                            <td>{{$item->purchaseQuantity()}}</td>
                           <td>{{$item->returnstockQuantity()}}</td>
						   <td>{{$item->salesQuantity() + $item->cashQuantity()}}</td>
						   <!--<td>{{$item->totalSaleQuantity()}}</td>-->
                          
                            <td>{{ $item->quantity }}</td>
                           <!--  
                            @if($item->quantity > 0)
                          
                           <td>{{  number_format($item->purchaseAmount()/ $item->quantity,2)  }}</td>
                           @else
                                 <td>0</td>
                                 @endif -->

                             @if($item->purchaseQuantity() > 0)

                            <td>{{  number_format($item->purchaseAmount()/ $item->purchaseQuantity(),2)  }}</td>
                                 
                            @else
                          
                            <td>0</td>
                            @endif
							
                            @if($item->purchaseQuantity() > 0)
                            <td>{{number_format($item->quantity *  $item->purchaseAmount()/ $item->purchaseQuantity(),2)}}</td>
                            @else
                            <td>0</td>
                            @endif

                            <td>{{ $item->purchaseAmount() }}</td>
                            <td>{{ $item->salesreturnQuantity() }}</td>
							<td>{{ $item->purchasereturnQuantity() }}</td>
							<td>{{ $item->purchasereturnAmount() }}</td>
							<td>{{ $item->netAmount()}}</td>
							
                           <td>{{$item->stockavilableQuantity()}}</td>
                           
                           @if($item->returnstockQuantity() > 0)
                          
                           <td>{{  number_format($item->netAmount()/ $item->returnstockQuantity(),2)  }}</td>
                           @else
                                 <td>0</td>
                                 @endif
								 
                             <!--<td>{{$item->stockavilableQuantity()}}</td>-->
                             
							@if($item->returnstockQuantity() > 0)
                          
                           <td>{{ number_format($item->stockavilableQuantity() * $item->netAmount()/ $item->returnstockQuantity(),2)  }}</td>
                           @else
                                 <td>0</td>
                                 @endif 
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                 {{$products->links()}}

            </div>
        </div>
    </div>
</div>
@stop
