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

        <h4 class="m-0 text-dark col-md-6 float-left">View Category</h4>
         <a class="btn btn-primary float-right ml-3 btn-sm" href='/expense-categories'>Back </a>
         @if(auth()->user()->privilege == "admin")
           <a href="/expense-categories/{{$expense->id}}/delete" class="btn btn-danger float-right ml-3 btn-sm">Delete</a>
        @endif
       
       
        <a class="btn btn-warning float-right ml-3 btn-sm" href="/expense-categories/{{ $expense->id }}/edit"> Edit </a>

    </div>
</div>
<br>

               

                    <div class="row">

                        <div class="col-md-6">


                        
                            <div class="form-group @if($errors->has('name')) text-danger @endif">
                                <label for=""> Category Name : </label>
                               <span>{{$expense->name}}</span>

                            </div>

                          

                            

                           
                        </div>
                        <div class="col-md-6">
                       

                       
                             <div class="form-group @if($errors->has('status')) text-danger @endif">
                                <label for="">Status : </label>
                                <span>{{$expense->status}}</span>
                            </div>
                            </div>
                            


                        </div>

                            

                        </div>



                    
                   

            </div>
        </div>
    </div>
</div>

@stop

@section("js")
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

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


