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
                  <h4 class="m-0 text-dark col-md-6 float-left">{{$title}}</h4>
                  <a class="btn btn-primary float-right btn-sm" href="/{{$url}}/create">NEW</a>
               </div>
            </div>
            <br>
            <div class="row">
               <form action="" method="GET"  role="form">
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="" for="">From Date</label>
                           <input type="text" name="from_date" class="date-picker form-control" value="{{ $from }}" autocomplete="off" placeholder="From Date">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="" for="">To Date</label>
                           <input type="text" name="to_date" class="date-picker form-control"  value="{{ $to }}" autocomplete="off" placeholder="To Date">
                        </div>
                     </div>
                     {{--  
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="" for="">Invoice No</label>
                           <input type="text" name="inv_no" class="form-control"  value="{{ $inv_no }}" autocomplete="off" placeholder="Invoice No">
                        </div>
                     </div>
                     --}}
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="" for="">Customer</label>
                           <select name="customer" id="inputCustomer" class="form-control select2" >
                              <option value="">All</option>
                              @foreach ($customers as $customer)
                              <option value="{{$customer->id}}">{{$customer->name}}</option>
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
           
            <br>
            <table id="example" class="table table-hover table-light" style="width:100%">
               <thead class="thead-dark">
                  <tr>
                     <th>S.No</th>
                     <th>Credit Note No</th>
                     <th>Against Invoice No</th>
                     <th>Credit Note Date</th>
                     <th>Customer</th>
                   
                     <th>Bill Amount</th>
                    
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($sales as $key => $item)
                  <tr>
                     <td>{{ $key + 1 }}</td>
                     <td>
                        <a href="/{{$url}}/{{ $item->id }}">
                           {{$item->invoice_no}}
                     </td>
                   <td>{{ $item->against_invoice_no }}</td>
                     <td>{{ $item->invoice_date }}</td>
                     <td>{{ $item->customer->name}}</a></td>
                     <!--<td>{{ $item->customer->phone}}</a></td>-->
                     <td>{{ number_format($item->total_amount, 2) }}</td>
                    
                     <td>
                        <!--<a href="/create-payment-from-invoice/{{$item->id}}"><i class= "fa fa-inr"></i></a>-->
                        <a href="/sales-return-invoices/{{$item->id}}/edit"><i class= "fa fa-edit"></i></a>
                        @if(auth()->user()->privilege == "admin")
                        <a href="/sales-return-invoices/{{$item->id}}/delete"><i class="fa fa-trash" ></i></a>
                        @endif
                     </td>
                     {{--  
                     <td><a href="/{{$url}}/{{ $item->id }}" class="btn btn-warning">Show</a></td>
                     --}}
                     {{-- 
                     <td><a href="/{{$url}}/{{ $item->id }}/delete" class="btn btn-danger">Delete</a></td>
                     --}}
                  </tr>
                  @endforeach 
               </tbody>
            </table>
            {{$sales->links()}}
         </div>
      </div>
   </div>
</div>
@stop
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="{{ asset('/vendor/select2/select2-bootstrap4.min.css') }}">
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