@extends('layout.master')

@section('title', 'ZetBooks')

@section('content_header')
<div class="row">

    <div class="col-md-12">

        <h1 class="m-0 text-dark col-md-6 float-left">All Purchase Invoice Payments</h1>

         <a class="btn btn-primary float-right btn-sm" href="new-purchase-payment"><i class="fa fa-plus" aria-hidden="true"> New</i> </a>

         

       
        
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">


                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Payment Date</th>
                           
                            <th>Vendor</th>
                            <th>Amount</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payment as $key => $item)

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            
                            <td><a href="/payment-purchase-invoices/{{$item->id}}">{{ $item->payment_date }}</td>
                            
                            <td> {{$item->vendor->first_name ?? ''}} {{$item->vendor->last_name ?? '-'}}</td>
                           
                            <td>{{ $item->payment }}</td>
                            
                        @endforeach  
                    </tbody>
                </table>
                {{$payment->links()}}



            </div>
        </div>
    </div>
</div>
@stop
