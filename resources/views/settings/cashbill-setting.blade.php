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

        <h4 class="m-0 text-dark col-md-6 float-left">Update Cash Bill Invoice Number</h4>

    </div>
</div>
<br>


                <form action="/cashbill-settings/{{$cashbill->id}}" method="POST" role="form" class="col-md-6 offset-md-3" autocomplete="off">
                    {{ csrf_field() }}
                    {{method_field('PUT')}}

                    <div class="row">

                        <div class="col-md-12">


                        
                            

                        <div class="form-group @if($errors->has('cashbill_account')) text-danger @endif">
                                <label>Prefix</label>
                                
                                <input type="text" name="prefix" class="form-control" required="" value="{{$cashbill->prefix}}">
                           </div>
                           <div class="form-group @if($errors->has('cashbill_account')) text-danger @endif">
                                <label>Suffix</label>
                                
                                <input type="text" name="suffix" class="form-control"  value="{{$cashbill->suffix}}">
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
