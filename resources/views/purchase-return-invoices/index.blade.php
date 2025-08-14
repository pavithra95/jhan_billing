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
                           <label class="" for="">Supplier Name</label>
                           <select name="supplier" id="inputsupplier" class="form-control select2" >
                              <option value="">All</option>
                              @foreach ($suppliers as $supplier)
                              <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <!--<div class="col-md-3">
                        <div class="form-group">
                           <label class="" for="">Pay Status</label>
                           <select name="pay_status" id="inputsupplier" class="form-control select2" >
                              <option value="">All</option>
                              <option @if ($pay_status == "paid") selected=""  @endif value="paid">Paid</option>
                              <option   @if ($pay_status == "partial") selected=""  @endif value="partial">Partial</option>
                              <option @if ($pay_status == "pending") selected=""  @endif value="pending">Pending</option>
                           </select>
                        </div>
                     </div>-->
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
            <!--<div class="col-md-12">
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group @if($errors->has('customer_id')) text-danger @endif">
                        <label>Total Bill Amount</label>
                        <div>
                           <span class="hidden-xs">{{ $total_bill_amount }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group @if($errors->has('customer_id')) text-danger @endif">
                        <label>Total Paid Amount</label>
                        <div>
                           <span class="hidden-xs">{{ $total_paid_amount }}</span>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group @if($errors->has('customer_id')) text-danger @endif">
                        <label>Total Due Amount</label>
                        <div>
                           <span class="hidden-xs">{{ $total_due_amount }}</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>-->
            <br>
            <table id="example" class="table table-hover table-light" style="width:100%">
               <thead class="thead-dark">
                  <tr>
                     <th>S.No</th>
                     <th>Debit Note No</th>
                     <th>Against Inv No</th>
                     <th>Debit Note Date</th>
                     <th>Supplier Name</th>
                     <!--<th>Phone</th>-->
                     <th>Bill Amount</th>
                     <!--<th>Paid Amount</th>
                     <th>Due Amount</th>
                     <th>Pay Status</th>-->
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($purchase as $key => $item)
                  <tr>
                     <td>{{ $key + 1 }}</td>
                     <td>
                        <a href="/{{$url}}/{{ $item->id }}">
                           {{$item->invoice_no}}
                     </td>
                     <td>{{$item->reference_no}}</td>
                     <td>{{ $item->invoice_date }}</td>
                     <td>{{ $item->vendor->name}}</td>
                    <!-- <td>{{ $item->vendor->phone}}</td>-->
                     <td>{{ number_format($item->total_amount, 2) }}</td>
                     <!--<td>{{ $item->paid_amount }}</td>
                     <td>{{ number_format(($item->total_amount - $item->paid_amount), 2) }}</td>
                     @if ($item->pay_status == "paid")
                     <td><span class="badge badge-pill badge-success">{{ucwords($item->pay_status)}}</span></td>
                     @else
                     @if ($item->pay_status == "partial")
                     <td><span class="badge badge-pill badge-warning">{{ucwords($item->pay_status)}}</span></td>
                     @else
                     <td><span class="badge badge-pill badge-danger">{{ucwords($item->pay_status)}}</span></td>
                     @endif
                     @endif-->
                     <td>
                     <!--<a href="/create-payment-from-purchase-return-invoice/{{$item->id}}"><i class= "fa fa-inr"></i></a>-->
                     <a href="/purchase-return-invoices/{{$item->id}}/edit"><i class= "fa fa-edit"></i></a>
                     @if(auth()->user()->privilege == "admin")
                     <a href="/purchase-return-invoices/{{$item->id}}/delete"><i class="fa fa-trash" ></i></a>
                     @endif
                     </td>
                     {{--  
                     <td><a href="/{{$url}}/{{ $item->id }}/edit" class="btn btn-warning">Edit</a></td>
                     <td><a href="/{{$url}}/{{ $item->id }}/delete" class="btn btn-danger">Delete</a></td>
                     --}}
                  </tr>
                  @endforeach 
               </tbody>
            </table>
            {{$purchase->links()}}
         </div>
      </div>
   </div>
</div>
@stop
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link href="{{ asset('/css/vue-select.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('vendor/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/select2/select2-bootstrap4.min.css') }}">
<script src="{{ asset('vendor/select2/select2.full.min.js') }}"></script>
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