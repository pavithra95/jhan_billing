@extends('layout.master')


@section('content')
<div class="row" id="test">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

    <div class="col-md-12">

        <h4 class="m-0 text-dark col-md-6 float-left">View Supplier</h4>
        <a href="/vendors" class="btn btn-warning float-right ml-3 btn-sm">Back</a>
        <a href="/vendors/{{$vendor->id}}/edit" class="btn btn-success float-right ml-3 btn-sm">Edit</a>
          @if(auth()->user()->privilege == "admin")
        <a href="/vendors/{{$vendor->id}}/delete" class="btn btn-danger float-right ml-3 btn-sm">Delete</a>
        @endif


    </div>
</div>
<br>


                
                     <div class="row">

                           
                            <div class="col-md-6">

                        <div class="form-group @if($errors->has('name')) text-danger @endif">
                                <label for=""><b> Supplier Name : </b></label>
                                <span>{{$vendor->name}}</span>

                            </div>
                            </div>
                        

                           
                       

                            <div class="col-md-6">

                        <div class="form-group @if($errors->has('address')) text-danger @endif">
                                <label for=""><b> Address : </b></label>
                                 <span>{{$vendor->address}}</span>

                            </div>
                            </div>


                            <div class="col-md-6">

                        <div class="form-group @if($errors->has('phone')) text-danger @endif">
                                <label for=""><b> Phone : </b></label>
                                 <span>{{$vendor->phone}}</span>
                            </div>
                            </div>
                            



                            

                           
                         
                             <div class="col-md-6">

                            <div class="form-group @if($errors->has('gst_no')) text-danger @endif">
                                <label for=""><b> GST No : </b></label>
                                <span>{{$vendor->gst_no}}</span>

                            </div>
                        </div>
                            <div class="col-md-6">

                        <div class="form-group @if($errors->has('city')) text-danger @endif">
                                <label for=""><b>City : </b></label>
                                <span>{{$vendor->city}}</span>

                            </div>
                        </div>
                           

                          
                            
                             <div class="col-md-6">

                             <div class="form-group @if($errors->has('state')) text-danger @endif">
                                <label for=""><b>State : </b></label>
                                <span>{{$vendor->State->name}}</span>
                            </div>
                        </div>
                        



            </div>
        </div>
    </div>
</div>
@stop