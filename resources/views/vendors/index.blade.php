@extends('layout.master')

@section('title', 'AdminLTE')

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


            
            
            <div class="col-md-3">
              <div class="form-group">
                <label class="" for="">GstIn</label>
                
                <input type="text" name="gst_no" class=" form-control"  value="{{ $gst_no }}" autocomplete="off" placeholder="Gst No">
              </div>
            </div>
            
            {{-- <div class="col-md-3">
              <div class="form-group">
                <label class="" for="">Invoice No</label>
                <input type="text" name="inv_no" class="form-control"  value="{{ $inv_no }}" autocomplete="off" placeholder="Invoice No">
                
               
              </div>
            </div> --}}
             <div class="col-md-3">
              <div class="form-group">
                <label class="" for="">Supplier</label>
                
                   
                     <input type="text" name="supplier_id" class=" form-control"  value="{{ $supplier_id }}" autocomplete="off" placeholder="Supplier">
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



                 <table id="example" class="table table-hover table-light" style="width:100%">
               <thead class="thead-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Vendor Name</th>
                            
                          
                            <th>Phone</th>
                           
                            <th>City</th>
                             <th>GstIn</th>
                           

                            <th>State</th>
                            <th>Status</th>
                            <th>Action</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendor as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="/{{$url}}/{{ $item->id }}" >{{ $item->name }}</td>
                            
                          
                            <td>{{ $item->phone }}</td>
                           
                            <td>{{ $item->city }}</td>
                             <td>{{ $item->gst_no }}</td>
                            <td>{{ $item->State->name ?? '' }}</td>
                             <td> <input data-id="{{$item->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $item->status ? 'checked' : '' }}>
                     </td>
                             <td>
                              <a href="/vendors/{{$item->id}}/edit"><i class= "fa fa-edit"></i></a>
                                @if(auth()->user()->privilege == "admin")
                              <a href="/vendors/{{$item->id}}/delete"><i class="fa fa-trash" ></i></a>
                              @endif
                              
                            </td>
                           
                           
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                 {{$vendor->links()}}




            </div>
        </div>
    </div>
</div>
@stop


@section('js')

   {{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script> --}}

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

<script>
  $(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var user_id = $(this).data('id'); 
         
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/changeVendorStatus',
            data: {'status': status, 'user_id': user_id},
            success: function(data){
              console.log(data.success)
            }
        });
    })
  })
</script>

@stop



