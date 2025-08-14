@extends('layout.master')


@section('content')
<div class="row" id="test">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

    <div class="col-md-12">

        <h4 class="text-dark col-md-12 float-left">Update Payment Method</h4>

    </div>
</div>
<br>


                <form action="/payment-methods/{{$unit->id}}" method="POST" role="form" class="col-md-12 " autocomplete="off">
                    {{ csrf_field() }}
                    {{method_field('PUT')}}

                    <div class="row">

                        <div class="col-md-6">


                        
                            <div class="form-group @if($errors->has('name')) text-danger @endif">
                                <label for="">Payment Method Name</label>
                                <input type="text" name="name" class="form-control" value="{{$unit->name}}" required="required">
                                @if($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif

                            </div>

                            

                             <div class="form-group @if($errors->has('hsn_code')) text-danger @endif">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control">{{$unit->description}}</textarea>

                            </div>

                            
                            
                           
                        </div>
                        <div class="col-md-6">

                            
                       
                              <div class="form-group @if($errors->has('status')) text-danger @endif">
                                <label for="">Status</label>
                                <select name="status" id="input" class="form-control" required="required">
                                    <option @if($unit->status == 'active') selected="" @endif value="active">Active</option>
                                    <option @if($unit->status == 'inactive') selected="" @endif value="inactive">Inactive</option>
                                </select>
                                @if($errors->has('status'))
                                    <div class="error text-danger">{{ $errors->first('status') }}</div>
                                @endif
                            </div>
                            
                            


                        </div>

                            

                        </div>



                    
                    
                  <button type="submit" class="btn btn-primary col-md-2 offset-md-3 btn-sm">Update</button>
                   <a class="btn btn-danger col-md-2 btn-sm" href='/payment-methods/{{$unit->id}}'>Cancel </a>
                </form>



            </div>
        </div>
    </div>
</div>

@stop

