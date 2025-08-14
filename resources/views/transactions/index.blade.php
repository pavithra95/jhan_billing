@extends('adminlte::page')

@section('title', 'ZetBooks')

@section('content_header')
<div class="row">

    <div class="col-md-12">

        <h1 class="m-0 text-dark col-md-6 float-left">{{$title}}</h1>

       
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
                            <th>Transaction Id</th>
                            <th>Account Id</th>
                            <th style="text-align: right">Debit</th>
  
                            <th style="text-align: right">Credit</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                          @foreach ($transactions as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{$item->transaction_id}}</td>
                            <td>{{$item->account->account_name}}</td>
                            <td  style="text-align: right">
                            
                             <?php if($item->type=="debit"){                               
                             echo number_format($item->amount,2);
                                
                            }else{
                             echo "0.00";

                            } ?>
                            </td>
                            <td  style="text-align: right">
                            
                             <?php if($item->type=="credit"){                               
                             echo number_format($item->amount ,2);
                                
                            }else{
                             echo "0.00";

                            } ?>
                          
                            </td>
                            
                           
                           
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td><b>Total</b></td>
                            <td style="text-align: right"><b>{{number_format( $debit,2)}}</b></td>
                            <td style="text-align: right"><b>{{number_format($credit,2)}}</b></td>
                        </tr>
                       
                    </tbody>
                </table>
                  {{$transactions->links()}}




            </div>
        </div>
    </div>
</div>
@stop
