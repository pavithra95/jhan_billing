@extends('layout.master')


@section('content')
<div class="row" id="test">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

    <div class="col-md-12">

        <h4 class="text-dark col-md-6 float-left">Payment Method Details</h4>
        <a href="/payment-methods" class="btn btn-warning float-right ml-3 btn-sm">Back</a>
        <a href="/payment-methods/{{$unit->id}}/edit" class="btn btn-success float-right ml-3 btn-sm">Edit</a>
          @if(auth()->user()->privilege == "admin")
        <a href="/payment-methods/{{$unit->id}}/delete" class="btn btn-danger float-right ml-3 btn-sm">Delete</a>
        @endif


    </div>
</div>
<br>


                
                    <div class="row">

                        <div class="col-md-6">


                        
                            <div class="form-group @if($errors->has('name')) text-danger @endif">
                                <label for=""><b>Unit Name :</b></label>
                               <span>{{$unit->name}}</span>

                            </div>

                            

                             <div class="form-group @if($errors->has('hsn_code')) text-danger @endif">
                                <label for=""><b>Description :</b></label>
                               <span>{{$unit->description}}</span>

                            </div>

                            
                            
                            {{-- <div class="form-group @if($errors->has('price')) text-danger @endif">
                                <label for="">Selling Price</label>
                                <input type="number" name="price" class="form-control" value="" required="required" min="1">
                                @if($errors->has('price'))
                                    <div class="error text-danger">{{ $errors->first('price') }}</div>
                                @endif

                            </div> --}}
                        </div>
                        <div class="col-md-6">

                            
                       
                              <div class="form-group @if($errors->has('status')) text-danger @endif">
                                <label for=""><b>Status :</b></label>
                               <span>{{$unit->status}}</span>
                            </div>
                            
                            


                        </div>

                            

                        </div>



                    
                    
                   

            </div>
        </div>
    </div>
</div>

@stop

