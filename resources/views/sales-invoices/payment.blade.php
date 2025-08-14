@extends('layout.master')

@section('title', 'ZetBooks')

@section('content_header')
<div class="row">

    <div class="col-md-12">

        <h1 class="m-0 text-dark col-md-6 float-left">All Sales Invoice Payments</h1>

         <a class="btn btn-primary float-right btn-sm" href="new-sales-payment"><i class="fa fa-plus" aria-hidden="true"> New</i> </a>

         

       
        
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
                           
                            <th>Customer</th>
                            <th>Amount</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payment as $key => $item)

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            
                            <td><a href="/payment-sales-invoices/{{$item->id}}">{{$item->payment_date}}</a></td>
                            <td>{{$item->customer->first_name ?? ''}} {{$item->customer->last_name ?? '-'}}</td>
                           {{-- <td>{{$item->customer_id}}</td> --}}
                           
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
