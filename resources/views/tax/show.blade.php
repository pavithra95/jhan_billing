@extends('layout.master')

@section('title', 'ZetBooks')

@section('content_header')

@stop

@section('content')
<div class="row" id="test">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

    <div class="col-md-12">

        <h4 class="m-0 text-dark col-md-6 float-left">View Tax</h4>
          <a class="btn btn-primary float-right ml-3 btn-sm" href='/taxes'>Back </a>

           <a href="/taxes/{{$tax->id}}/delete" class="btn btn-danger float-right ml-3 btn-sm">Delete</a>
       
       
        <a class="btn btn-warning float-right ml-3 btn-sm" href="/taxes/{{ $tax->id }}/edit"> Edit </a>

    </div>
</div>
<br>


              

                    <div class="row">

                        <div class="col-md-6">


                        
                            <div class="form-group @if($errors->has('name')) text-danger @endif">
                                <label for=""><b>Tax Name: </b></label>
                               <span>{{$tax->name}}</span>
                            </div>

                            

                              
                            <div class="form-group @if($errors->has('hsn_code')) text-danger @endif">
                                <label for=""><b>Description: </b></label>
                               <span>{{$tax->description}}</span>

                            </div>

                            
                            
                            {{-- <div class="form-group @if($errors->has('price')) text-danger @endif">
                                <label for=""><b>Selling Price: </b></label>
                                <input type="number" name="price" class="form-control" value="" required="required" min="1">
                                @if($errors->has('price'))
                                    <div class="error text-danger">{{ $errors->first('price') }}</div>
                                @endif

                            </div> --}}
                        </div>
                        <div class="col-md-6">
                            
                                <div class="form-group @if($errors->has('hsn_code')) text-danger @endif">
                                <label for=""><b>Tax Percentage: </b></label>
                               <span>{{$tax->percentage}}</span>

                            </div>
                        </div>
                       
                            

                        </div>



                    
                 

            </div>
        </div>
    </div>
</div>

@stop

