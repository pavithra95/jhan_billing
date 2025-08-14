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

        <h4 class="m-0 text-dark col-md-12 float-left">Create Expense</h4>

    </div>
</div>
<br>


                <form action="/expenses" method="POST" role="form" class="col-md-6 offset-md-3" autocomplete="off"enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="row">

                        <div class="col-md-12">


                        
                            <div class="form-group @if($errors->has('date')) text-danger @endif">
                            <label for="">Expense Date</label>
                            <input type="text" name="date" class="form-control date-picker " value="" required="">
                            @if($errors->has('date'))
                            <div class="error text-danger">{{ $errors->first('date') }}</div>
                            @endif

                        </div>
                         <!--<div class="form-group ">
                                <label for="">Add Image</label>
                                <input type="file" name="image" class="form-control " value="">
                              

                            </div>-->

                        <div class="form-group @if($errors->has('expense_account')) text-danger @endif">
                                <label>Amount</label>
                                
                                <input type="number" name="amount" class="form-control" min="1" required="">
                           </div>

                            
                             
                        <div class="form-group @if($errors->has('amount')) text-danger @endif">
                                <label for="">Category</label>
                                <select name="category_id" id="inputCate" class="form-control" required="required">
                                  @foreach ($category as $item)
                                    {{-- expr --}}
                                  <option value="{{$item->id}}">{{$item->name}}</option>
                                  @endforeach
                                </select>
                               
                            </div>

                          
                           

                           <div class="form-group @if($errors->has('notes')) text-danger @endif">
                            <label for=""> Notes</label>
                            <textarea type="text" name="notes" class="form-control" id="notes" style="height: 100px"></textarea>
                            @if($errors->has('notes'))
                            <div class="error text-danger">{{ $errors->first('notes') }}</div>
                            @endif

                        </div>
                        
                        

                            

                        </div>

                            

                        </div>



                    
                    {{-- <div class="col-md-6 offset-md-3"> --}}
                    <button type="submit" class="btn btn-primary col-md-5 offset-md-1 btn-sm">Save</button>
                   <a class="btn btn-danger col-md-5 btn-sm" href='/expenses'>Cancel </a>
                </form>
              {{-- </div> --}}



            </div>
        </div>
    </div>
</div>

@stop
@section("js")
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">


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
