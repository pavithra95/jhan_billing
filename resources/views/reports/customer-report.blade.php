@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

    <div class="col-md-12">

        <h4 class="m-0 text-dark col-md-6 float-left">Customer Report</h4>

       
    </div>
</div>
<br>
 <div class="row">
       <form action="" method="GET"  role="form">

        
          
          <div class="row">


            
            
            <div class="col-md-3">
              <div class="form-group">
                <label class="" for="">GstIn</label>
                
                <input type="text" name="gst_no" class=" form-control"  value="{{ $gst_no }}" autocomplete="off" placeholder="Gst No">
              </div>
            </div>
            
            <div class="col-md-3">
              <div class="form-group">
                <label class="" for="">Phone</label>
                <input type="text" name="phone" class="form-control"  value="{{ $phone }}" autocomplete="off" placeholder="Phone">
                
               
              </div>
            </div>
             <div class="col-md-3">
              <div class="form-group">
                <label class="" for="">Customer</label>
                
                   
                     <input type="text" name="customer_id" class=" form-control"  value="{{ $customer_id }}" autocomplete="off" placeholder="Customer">
            </div>


  </div> 
  <div class="col-md-3">
              <div class="form-group">
                <label class="" for="">State</label>
                
                    <select name="state_id" id="input" class="form-control select2">
                        <option value="">All</option>
                        @foreach ($states as $state)
                           <option value="{{$state->id}}">{{$state->name}}</option>
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
                            <th>Customer</th>
                          
                            <th>Phone</th>
                            <th>GstIn</th>
                            <th>State</th>
                            <th>City</th>
                          
                           

                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="/reports-customer-invoice/{{ $item->id }}">{{ $item->name }}</a></td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->gst_no }}</td>
                            <td>{{ $item->State->name }}</td>
                            <td>{{ $item->city }}</td>
                           
                            
                           
                         
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                 {{$customers->links()}}




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


