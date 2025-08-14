@extends('layout.master')

@section('title', 'AdminLTE')

@section('content_header')
<div class="row">

    <div class="col-md-12">

        <h1 class="m-0 text-dark col-md-6 float-left">Create Gst State Masters</h1>

    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">


                <form action="/gst-state-masters" method="POST" role="form" class="col-md-6 offset-md-3" autocomplete="off">
                    {{ csrf_field() }}

                    <div class="row">


                        <div class="col-md-12">
                            <div class="form-group @if($errors->has('name')) text-danger @endif">
                                <label for="">State Name</label>
                                <input type="text" name="name" class="form-control" value="" required="required">
                                @if($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif

                            </div>

                            <div class="form-group @if($errors->has('tin')) text-danger @endif">
                                <label for="">TIN</label>
                                <input type="text" name="tin" class="form-control" value="" required="required">
                                @if($errors->has('tin'))
                                    <div class="error text-danger">{{ $errors->first('tin') }}</div>
                                @endif

                            </div>

                            <div class="form-group @if($errors->has('code')) text-danger @endif">
                                <label for="">State Code</label>
                                <input type="text" name="code" class="form-control" value="" required="required">
                                @if($errors->has('code'))
                                    <div class="error text-danger">{{ $errors->first('code') }}</div>
                                @endif

                            </div>

                            <div class="form-group @if($errors->has('status')) text-danger @endif">
                                <label for="">Status</label>
                                <select name="status" id="input" class="form-control" required="required">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                @if($errors->has('status'))
                                    <div class="error text-danger">{{ $errors->first('status') }}</div>
                                @endif
                            </div>


                        </div>



                    </div>
                    
                    <button type="submit" class="btn btn-primary col-md-12">Create</button>
                </form>



            </div>
        </div>
    </div>
</div>

@stop
@section('js')

<script>
      //Date picker
      $(document).ready(
        function() { 


            $('#datepicker').datepicker({
            format: 'yyyy-mm-dd',
              autoclose: true
          });

        });

    </script>
    @stop
