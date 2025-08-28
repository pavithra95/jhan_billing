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

        <h4 class="m-0 text-dark col-md-6 float-left">Update Product Category</h4>
        <a href="/product-categories/{{$product->id}}" class="btn btn-warning float-right btn-sm">Back</a>

    </div>
</div>
<br>


                <form action="/product-categories/{{$product->id}}" method="POST" role="form" class="col-md-12" autocomplete="off">
                    {{ csrf_field() }}
                    {{method_field('PUT')}}

                    <div class="row">

                        <div class="col-md-12">
                        <div class="col-md-6">


                        
                            <div class="form-group @if($errors->has('name')) text-danger @endif">
                                <label for=""> Category Name</label>
                                <input type="text" name="name" class="form-control" value="{{$product->name}}" required="required">
                                @if($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif

                            </div> 
                            <div class="form-group @if($errors->has('hsn_code')) text-danger @endif">
                                <label for=""> Hsn Code</label>
                                <input type="text" name="hsn_code" class="form-control" value="{{$product->hsn_code}}">
                                @if($errors->has('hsn_code'))
                                    <div class="error text-danger">{{ $errors->first('hsn_code') }}</div>
                                @endif

                            </div>
                        </div>

                            
                            
                           
                        </div>
                        <div class="col-md-12">
                        <div class="col-md-6">

                             <div class="form-group @if($errors->has('description')) text-danger @endif">
                                <label for=""> Description</label>
                                <textarea name="description" id="" class="form-control">{{$product->description}}</textarea>

                            </div>



    
                            

                           

                           
                             <div class="form-group @if($errors->has('status')) text-danger @endif">
                                <label for="">Status</label>
                                <select name="status" id="input" class="form-control" required="required">
                                    <option @if ($product->status == "active") selected="" @endif value="active">Active</option>
                                    <option @if ($product->status == "inactive") selected="" @endif value="inactive">Inactive</option>
                                </select>
                                @if($errors->has('status'))
                                    <div class="error text-danger">{{ $errors->first('status') }}</div>
                                @endif
                            </div>
                            


                        </div>
                    </div>

                            

                        </div>



                    
                    
                    <button type="submit" class="btn btn-primary col-md-2 offset-md-1 btn-sm">Update</button>
                   <a class="btn btn-danger btn-sm" href='/product-categories/{{$product->id}}'>Cancel </a>
                </form>



            </div>
        </div>
    </div>
</div>

@stop

@section("js")

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


