@extends('layout.master')

@section('title', 'AdminLTE')

@section('content_header')
<div class="row">

    <div class="col-md-12">

        <h1 class="m-0 text-dark col-md-6 float-left">Edit State</h1>

    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">


                <form action="/gst-state-masters/{{ $state->id }}" method="POST" role="form" class="col-md-6 offset-md-3" autocomplete="off">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="row">


                        <div class="col-md-12">
                            <div class="form-group @if($errors->has('name')) text-danger @endif">
                                <label for="">State Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $state->name }}" required="required">
                                @if($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif

                            </div>

                            <div class="form-group @if($errors->has('tin')) text-danger @endif">
                                <label for="">TIN</label>
                                <input type="text" name="tin" class="form-control" value="{{ $state->tin }}" required="required">
                                @if($errors->has('tin'))
                                    <div class="error text-danger">{{ $errors->first('tin') }}</div>
                                @endif

                            </div>

                            <div class="form-group @if($errors->has('code')) text-danger @endif">
                                <label for="">State Code</label>
                                <input type="text" name="code" class="form-control" value="{{ $state->code }}" required="required">
                                @if($errors->has('code'))
                                    <div class="error text-danger">{{ $errors->first('code') }}</div>
                                @endif

                            </div>

                            <div class="form-group @if($errors->has('status')) text-danger @endif">
                                <label for="">Status</label>
                                <select name="status" id="input" class="form-control" required="required">
                                    <option @if($state->status == 'active') selected="" @endif value="active">Active</option>
                                    <option @if($state->status == 'inactive') selected="" @endif value="inactive">Inactive</option>
                                </select>
                                @if($errors->has('status'))
                                    <div class="error text-danger">{{ $errors->first('status') }}</div>
                                @endif
                            </div>


                        </div>



                    </div>
                    
                    <button type="submit" class="btn btn-primary col-md-12">Update</button>
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
