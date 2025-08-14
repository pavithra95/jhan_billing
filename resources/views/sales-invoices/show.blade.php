@extends('layout.master')

@section('title', 'ZetBooks')

@section('content_header')

@stop

@section('content')
<div class="row" id="invoice-app">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

    <div class="col-md-12">

        <h4 class="m-0 text-dark col-md-6 float-left">{{$title}}</h4>

         <a class="btn btn-primary float-right margin-right btn-sm" href='/sales-invoices'>Back </a>
           @if(auth()->user()->privilege == "admin")
        <button type="button" class="btn btn-danger float-right margin-right btn-sm" data-toggle="modal" data-target="#exampleModalLong">
             Delete
        </button>
        @endif



       <!--  <a class="btn btn-danger float-right margin-right btn-sm" href="/{{$url}}/{{ $sales->id }}/delete">Delete</a>
 -->
         @if ($sales->paid_amount != $sales->total_amount)
       
              <a class="btn btn-success float-right margin-right btn-sm" href="/create-payment-from-invoice/{{ $sales->id }}"> Record Payment </a>
        
        @endif

       
        <a class="btn btn-warning float-right margin-right btn-sm" href="/{{$url}}/{{ $sales->id }}/edit"> Edit </a>

    </div>
</div>
<br>


               

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group @if($errors->has('customer_id')) text-danger @endif">
                                <label>Customer Name</label>
                                <div>
                                
                               <span class="hidden-xs">{{ $sales->customer->name }}</span>
                               
                           </div>
                       </div>
                   </div>
                   <div class="col-md-4">
                            <div class="form-group @if($errors->has('customer_id')) text-danger @endif">
                                <label>Customer Phone</label>
                                <div>
                                
                               <span class="hidden-xs">{{ $sales->customer->phone }}</span>
                               
                           </div>
                       </div>
                   </div>
                   <div class="col-md-4">
                            <div class="form-group @if($errors->has('customer_id')) text-danger @endif">
                                <label>Customer State</label>
                                <div>
                                
                               <span class="hidden-xs">{{ $sales->customer->State->name }}</span>
                               
                           </div>
                       </div>
                   </div>
                       <div class="col-md-4">

                        <div class="form-group @if($errors->has('invoice_no')) text-danger @endif">
                            <label for=""> Invoice No</label>
                            <div>
                                <span class="hidden-xs">{{ $sales->invoice_no}}</span>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">

                        <div class="form-group ">
                            <label for=""> Invoice Date</label>
                            <div>
                                <span class="hidden-xs">{{ $sales->invoice_date}}</span>
                            </div>
                            

                        </div>
                    </div>
               
                    <div class="col-md-4">

                        <div class="form-group ">
                            <label for=""> Due Date</label>
                            <div>
                                <span class="hidden-xs">{{ $sales->due_date}}</span>
                            </div>
                            
                        </div>
                    </div>
               
                 <div class="col-md-4">

                        <div class="form-group @if($errors->has('due_date')) text-danger @endif">
                            <label for="">Reference No</label>
                           <div>
                                <span class="hidden-xs">{{ $sales->reference_no}}</span>
                            </div>

                        </div>
                    </div> 
                    <div class="col-md-4">

                        <div class="form-group @if($errors->has('due_date')) text-danger @endif">
                            <label for="">Payment Method</label>
                           <div>
                                <span class="hidden-xs">{{ $sales->Payment->name}}</span>
                            </div>

                            </div>
                        </div> 
                        <div class="col-md-4">

                            <div class="form-group @if($errors->has('due_date')) text-danger @endif">
                                <label for="">Invoice Notes</label>
                               <div>
                                <span class="hidden-xs">{{ $sales->notes}}</span>
                            </div>

                            </div>
                        </div>
                </div>

                <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">


                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Qty</th>
                            <th>Rate</th>
                            <th>GST Tax</th>
                            <th>Cess Tax</th>
                            <th>Amount</th>
                            <th>Taxable Amount</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales_item as  $item)
                         

                        <tr >
                            
                           
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->item_price, 2) }}</td>
                            <td>{{ $item->ProductTax->group_type_name}}</td>
                            <td>{{ $item->CessProductTax->group_type_name }}</td>
                            <td>{{ number_format($item->total_amount, 2) }}</td>
                            <td>{{ number_format($item->taxable_amount, 2) }}</td>
                         
                            </tr>
                            @endforeach
                            
                            <tr>
                                 
                                  <td></td>
                                <td></td>
                                <td></td>
                                 <td></td>
                                 <td></td>
                                <td>Sub Total</td>
                                <td>{{ number_format($sub_total->total_amount,2) }}</td>
                               
                                
                            </tr>
                            @foreach ($gst as $element)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                
                                <td>{{ $element->item_name }} </td>
                                <td>{{number_format($element->total_amount,2)}}</td>
                                
                            </tr>
                            @endforeach
                           
                            @foreach ($cess as $i)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                
                                <td>{{ $i->item_name }}  </td>
                                <td>{{number_format($i->total_amount,2)}}</td>
                                
                            </tr>
                            @endforeach
                                
                           
                            <tr>
                                 
                                  <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Round Off</td>
                                <td>{{ number_format($roundoff->total_amount,2) }}</td>
                                
                                
                            </tr>

                            <tr>
                                 
                                  <td></td>
                                <td></td>
                                <td></td>
                                 <td></td>
                                 <td></td>
                                <td>Total Amount</td>
                                <td>{{ number_format($sales->total_amount,2) }}</td>

                                
                            </tr>

                           
                            



                           
                           
                                
                             

                         
                    </tbody>
                </table>

                 
    <a href="/sales-invoice/print/{{$sales->id}}" class="btn btn-outline-primary btn-icon-text float-right ml-2" target="_blank"> <i class="btn-icon-prepend" href="" data-feather="printer">Print</i></a>



            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       Are You Sure You Want to Delete
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <a class="btn btn-danger" href="/{{$url}}/{{ $sales->id }}/delete">Delete</a>
      </div>
    </div>
  </div>
</div>

<style>
    .margin-right {
        margin-left: 10px;
    }
</style>
@stop


                 