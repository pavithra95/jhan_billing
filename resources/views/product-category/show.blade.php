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

        <h4 class="m-0 text-dark col-md-6 float-left">View Product Category</h4>
        <a href="/product-categories" class="btn btn-warning float-right ml-3 btn-sm">Back</a>
        <a href="/product-categories/{{$product->id}}/edit" class="btn btn-success float-right ml-3 btn-sm">Edit</a>

    </div>
</div>
<br>


              
                    <div class="row">

                        <div class="col-md-6">


                        
                            <div class="form-group @if($errors->has('name')) text-danger @endif">
                                <label for=""> Category Name</label>
                               <span>{{$product->name}}</span>
                            </div>
                           
                            <div class="form-group @if($errors->has('hsn_code')) text-danger @endif">
                                <label for=""> Hsn Code</label>
                                <span>{{$product->hsn_code}}</span>
                                

                            </div>

                            
                            
                           
                        </div>
                        <div class="col-md-6">

                             <div class="form-group @if($errors->has('description')) text-danger @endif">
                                <label for=""> Description</label>
                               <span>{{$product->description}}</span>

                            </div>



    
                            

                           

                           
                             <div class="form-group @if($errors->has('status')) text-danger @endif">
                                <label for="">Status</label>
                               <span>{{$product->status}}</span>
                            </div>
                            


                        </div>

                            

                        </div>



                    
                    
                   

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


