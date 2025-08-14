@extends('layout.master')

@section('title', 'ZetBooks')

@section('content_header')
<div class="row">

    <div class="col-md-12">

        <h1 class="m-0 text-dark col-md-6 float-left">All Purchase Payments</h1>

        <a class="btn btn-primary float-right margin-right btn-sm" href='/payment-purchase-invoices'>Back </a>
 <button type="button" class="btn btn-danger float-right margin-right btn-sm" data-toggle="modal" data-target="#exampleModalLong">
             Delete
        </button>
         <a class="btn btn-warning float-right margin-right btn-sm" href="/edit-purchase-payment/{{ $payment->id }}"> Edit </a>

    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

              <div class="row">
                <div class="col-md-3">
                  <label>Vendor</label>
                  <div>
                  <span class="hidden-xs">{{$payment->vendor->first_name}} {{$payment->vendor->last_name}}</span>
                </div>
                </div>
                <div class="col-md-3">
                  <label>Payment Date</label>
                  <div>
                  <span class="hidden-xs">{{$payment->payment_date}}</span>
                  </div>
                </div>
                <div class="col-md-3">
                  <label>Amount</label>
                  <div>
                  <span class="hidden-xs">{{$payment->payment}}</span>
                </div>
                </div>
                <div class="col-md-3">
                  <label>Payment mode</label>
                  <div>
                    </div>
                  <span class="hidden-xs">{{$payment->payment_mode}}</span>
                </div>
                 <br/>
                <div class="col-md-3">
                  <label>Deposit to</label>
                  <div>
                  <span class="hidden-xs">{{$payment->deposit_to}}</span>
                </div>
                </div>
              </div>

              <div class="row">
                
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>S.No</th>
                      
                      <th>Date</th>
                      <th>Invoice No</th>
                      <th>Invoice amount</th>
                      <th>Amount Due</th>
                      <th>Amount</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($payment->paymentItems as $key => $item)
                      
                    
                    <tr>
                      <td>{{$key + 1}}</td>
                      
                      <td>{{$item->purchaseInvoice->invoice_date}}</td>
                      <td>{{$item->purchaseInvoice->invoice_no}}</td>
                      <td>{{$item->purchaseInvoice->total_amount}}</td>
                      <td>{{$item->purchaseInvoice->total_amount - $item->purchaseInvoice->paid_amount}}</td>
                      <td>{{$item->amount}}</td>

                    </tr>
                    @endforeach
                  </tbody>
                </table>

              </div>


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
       Are You Sure..You Want to Delete
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
       <a class="btn btn-danger" href="/delete-purchase-payment/{{ $payment->id }}/delete">Delete</a>
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

@section("js")

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
