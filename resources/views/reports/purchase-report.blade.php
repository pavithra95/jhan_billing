@extends('layout.master')

@section('title', 'ZetBooks')

@section('content_header')

@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

    <div class="col-md-12">

        <h4 class="m-0 text-dark col-md-6 float-left">Purchase Report</h4>

      
    </div>
</div>
<br>
 <div class="row">
       <form action="" method="GET"  role="form">

        
          
          <div class="row">


            <div class="col-md-6">
              <div class="form-group">
                <label class="" for="">From Date</label>
                
                <input type="text" name="from_date" class="date-picker form-control" value="{{ $from }}" autocomplete="off" placeholder="From Date">
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label class="" for="">To Date</label>
                
                <input type="text" name="to_date" class="date-picker form-control"  value="{{ $to }}" autocomplete="off" placeholder="To Date">
              </div>
            </div>
         
        
            
         
            {{--  <div class="col-md-4">
              <div class="form-group">
                <label class="" for="">Supplier Name</label>
                
             <select name="supplier_id" id="inputsupplier" class="form-control" >
                 <option value="">All</option>
                 @foreach ($suppliers as $supplier)
                    <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                 @endforeach
             </select>
              </div>
            </div> --}}

            <button type="submit" class="btn btn-primary float-right ml-3" >Filter</button>
            @if(!empty($_GET))


      <a  href="/{{ request()->path() }}" class="btn btn-primary float-right ml-3">
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
                            <th>Serial No</th>
                            <th>Supplier Name</th>
                            <th>Supplier GSTIN</th>
                            
                            <th>Pur.Invoice No</th>
                            <th>Invoice Date</th>
                          
                            <th>Total Bill  Value</th>
                            <th>Taxable Value</th>
                            <th>Non Taxable Value</th>
                            <th>Tax Rate</th>
                            <th>Cess Rate</th>
                            <th>IGST Amt</th>
                            <th>CGST Amt</th>
                            <th>SGST Amt</th>
                            <th>CESS Amt</th>
                           
                           
                            
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($original as $key => $o)
                        @foreach ($o as $key => $t)
                          <tr> 
                          <td>{{$t['invoice_no']}}</td>
                          <td>{{$t['name']}} </td> 
                          <td>{{$t['gst_no']}}</td>
                          
                          <td>{{$t['reference_no']}}</td>
                          <td>{{$t['invoice_date']}}</td> 
                          <td>{{$t['bill_amount']}}</td>
                          @if ($t['gst_rate'] > 0 )
                            <td>{{$t['taxable_amount'] }} </td>
                           <td>0</td>
                           @else
                            <td>0</td>
                            <td>{{$t['taxable_amount']}} </td>

                           @endif 
                        
                          <td>{{$t['gst_rate']}}</td>
                          <td>{{$t['cess_rate']}}</td>
                          <td>{{round($t['igst_total_amount'],2)}}  </td>
                          <td>{{round($t['gst_total_amount'] / 2 ,2)}}  </td>
                          <td>{{round($t['gst_total_amount'] / 2 ,2)}}  </td>
                          <td>{{round($t['cess_total_amount'],2)}}  </td>
                          </tr>
                        @endforeach
                      @endforeach
                     
                       {{-- @foreach ($sales_items as $key => $item)
                     
                         
                      
                      

                       @php
                         $tax = $item->igst_total_amount + $item->gst_total_amount + $item->cess_total_amount;
                         $taxable = $item->price_without_tax * $item->quantity;
                         $total_tax = $tax +  $taxable;

                       @endphp
                         
                      

                        <tr>
                            
                          
                             
                            

                            <td>{{$item->sales->customer->gst_no ?? '-'}}</td>
                            <td>{{ $item->sales->customer->name ?? '-' }}</td>
                            <td>{{ $item->sales->invoice_no ?? '-'}}</td>
                            <td>{{ $item->sales->reference_no ?? '-'}}</td>
                            <td>{{ $item->sales->invoice_date ?? '-'}}</td>
                            <td>{{ $item->item_name ?? '-'}}</td>
                            <td>{{ $item->item_price?? '-'}}</td>
                            <td>{{ $item->total_amount ?? '-'}}</td>
                            <td>{{$item->sales->total_amount ?? '-'}}</td>
                            @if ($item->gst_rate > 0 && $item->cess_rate > 0)
                             
                            <td>{{$taxable}}</td>
                            <td>0</td>
                            @else
                            <td>0</td>

                            <td>{{$taxable}}</td>
                            @endif
                            <td>{{$item->gst_rate}}</td>
                            <td>{{$item->cess_rate}}</td>
                            <td>{{$item->igst_total_amount}}</td>
                            <td>{{$item->gst_total_amount / 2}}</td>
                            <td>{{$item->gst_total_amount / 2}}</td>
                           
                            <td>{{$item->cess_total_amount}}</td>

                           
                           
                           
                            </tr> --}}
                            
                       {{--  @endforeach  --}}
                    </tbody>
                </table>
                




            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
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
@stop


