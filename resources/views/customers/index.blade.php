@extends('layout.master')
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-body">
            <div class="row">
               <div class="col-md-12">
                  <h4 class="m-0 text-dark col-md-6 float-left">{{$title}}</h4>
                  <a class="btn btn-primary float-right btn-sm" href="/{{$url}}/create">NEW </a>
               </div>
            </div>
            <br>
            <div class="row">
               <form action="" method="GET"  role="form">
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group">
                           <label class="" for="">GSTIN</label>
                           <input type="text" name="gst_no" class=" form-control"  value="{{ $gst_no }}" autocomplete="off" placeholder="Gst No">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label class="" for="">Phone No</label>
                           <input type="text" name="phone" class="form-control"  value="{{ $phone }}" autocomplete="off" placeholder="Phone">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label class="" for="">Customer Name</label>
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
            <table id="example" class="table table-hover table-light" style="width:100%">
               <thead class="thead-light">
                  <tr>
                     <th>S.No</th>
                     <th>Customer</th>
                     <th>Phone</th>
                     <th>Count</th>
                     
                     <th>Status</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($customers as $key => $item)
                  <tr>
                     <td>{{ $key + 1 }}</td>
                     <td><a href="/{{$url}}/{{ $item->id }}">{{ $item->name }}</a></td>
                     <td>{{ $item->phone }}</td>
                     <td>{{$item->count}}</td>
                    
                     <td> <input data-id="{{$item->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $item->status ? 'checked' : '' }}></td>
                     <td>
                        <a href="/customers/{{$item->id}}/edit"><i class= "fa fa-edit"></i></a>
                        @if(auth()->user()->privilege == "admin")
                        <a href="/customers/{{$item->id}}/delete"><i class="fa fa-trash" ></i></a>
                        @endif
                     </td>
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
             url: '/changeStatus',
             data: {'status': status, 'user_id': user_id},
             success: function(data){
               console.log(data.success)
             }
         });
     })
   })
</script>
@stop