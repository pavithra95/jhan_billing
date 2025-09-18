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

        <h4 class="m-0 text-dark col-md-6 float-left">{{ucwords($supplier->name)}}'s Invoice Details</h4>

         <a class="btn btn-primary float-right btn-sm" href="/supplier-report"> Back </a>

         

       
       
    </div>
    <br>
    
    <div class="col-md-12">
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
</div>

<div class="col-md-12 row">
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
            
            <div class="col-md-4">
              <div class="form-group">
                <label class="" for=""></label>
                 <button type="submit" class="btn btn-primary" style="margin-left: 10px">Filter</button>
            @if(!empty($_GET))


      <a style="margin-left: 10px;" href="/{{ request()->path() }}" class="btn btn-primary float-right">
          Clear Filter
      </a>
      @endif
                
               
              </div>
            </div>
            

           

  </div>
</form>
</div>

<br>
</div>
<br>



                <table id="example" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Purchase Inv No</th>
                            <th>Purchase Date</th>
                           
                            
                             <th>Bill Amount</th>
                            <th>Paid Amount</th>
                            <th>Due Amount</th>
                            <th>Pay Status</th>
                           
                            
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($purchases as $key => $item)

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{$item->invoice_no}}</td>

                            <td>{{ $item->invoice_date }}</td>
                           
                            
                            
                           
                            <td>{{ number_format($item->total_amount, 2) }}</td>
                            @if (!empty($item->paid_amount))
                            <td>{{ $item->paid_amount }}</td>
                            @else
                            <td>0</td>
                                
                          
                            @endif
                            <td>{{ number_format(($item->total_amount - $item->paid_amount), 2) }}</td>
                             <td>{{$item->pay_status}}</td>
                           
                          {{--  <td><a href="/{{$url}}/{{ $item->id }}" class="btn btn-warning">Show</a></td>  --}}
                            {{-- <td><a href="/{{$url}}/{{ $item->id }}/delete" class="btn btn-danger">Delete</a></td> --}}
                        </tr>
                        @endforeach 
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

