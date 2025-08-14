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

        <h4 class="m-0 text-dark col-md-6 float-left">Create Tax</h4>

    </div>
</div>
<br>


                <form action="/taxes" method="POST" role="form" class="col-md-12 " autocomplete="off">
                    {{ csrf_field() }}

                    <div class="row">

                        <div class="col-md-6">


                        
                            <div class="form-group @if($errors->has('name')) text-danger @endif">
                                <label for="">Tax Name</label>
                                <input type="text" name="name" class="form-control" value="" required="required">
                                @if($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif

                            </div>

                             <div class="form-group @if($errors->has('hsn_code')) text-danger @endif">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control"></textarea>

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
                             
                            <div class="form-group @if($errors->has('hsn_code')) text-danger @endif">
                                <label for="">Tax Percentage</label>
                                <input type="text" name="percentage" class="form-control" value="" required="required">

                            </div> 
                        </div>
                       

                            

                        </div>



                    
                    
                    <button type="submit" class="btn btn-primary col-md-2 offset-md-5 btn-sm">Create</button>
                   <a class="btn btn-danger col-md-2 btn-sm" href='/taxes'>Cancel </a>
                </form>



            </div>
        </div>
    </div>
</div>

@stop

