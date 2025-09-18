@extends('layout.master')




@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

    <div class="col-md-12">

        <h4 class="m-0 text-dark col-md-6 float-left">Product Report</h4>

       
    </div>
</div>
<br>
 <div class="row">
       <form action="" method="GET"  role="form">

        
          
          <div class="row">


            
            
            <div class="col-md-4">
              <div class="form-group">
                <label class="" for="">Product Name</label>
                
                <input type="text" name="product" class=" form-control"  value="{{ $product }}" autocomplete="off" placeholder="Product Name">
              </div>
            </div>
            
           
             <div class="col-md-4">
              <div class="form-group">
                <label class="" for="">Category</label>
                 <select name="category_id" id="input" class="form-control select2">
                        <option value="">All</option>
                        @foreach ($category as $c)
                           <option @if ($category_id == $c->id) selected=""
                              
                           @endif  value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </select>
            </div>


  </div> 
  <div class="col-md-4">
              <div class="form-group">
                <label class="" for="">Unit</label>
                
                    <select name="unit_id" id="input" class="form-control select2">
                        <option value="">All</option>
                        @foreach ($units as $unit)
                           <option @if ($unit_id == $unit->id) selected=""
                              
                           @endif value="{{$unit->id}}">{{$unit->name}}</option>
                        @endforeach
                    </select>
            </div>


  </div>
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
                            <th>Product</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th>Hsn Code</th>
                            <th>Gst Tax</th>
                            <th>Igst Tax</th>
                            <th>Cess Tax</th>
                            <th>Stock Quantity</th>
                            <th>Total Purchase Value</th>
                            <th>Stock Amount</th>
                            
                          
                            {{-- <th>Stock Quantity</th> --}}
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->Category->name ?? '' }}</td>
                            <td>{{ $item->Unit->name ?? '' }}</td>
                            <td>{{ $item->hsn_code }}</td>
                            <td>{{ $item->ProductTax->group_type_name ?? '' }}</td>
                            <td>{{ $item->IgstProductTax->group_type_name ?? '' }}</td>
                            <td>{{ $item->CessProductTax->group_type_name ?? '' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->purchaseAmount() }}</td>
                            @if($item->quantity>0)
                           
                            <td>{{  number_format($item->purchaseAmount()/ $item->quantity,2)  }}</td>
                            @else
                              <td>0</td>
                            @endif
                            
                            {{-- <td>{{$item->stockQuantity()}}</td>
                            --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>

    



            </div>
        </div>
    </div>
</div>
@stop




