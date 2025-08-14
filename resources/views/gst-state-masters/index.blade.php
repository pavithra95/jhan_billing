@extends('layout.master')

@section('title', 'AdminLTE')

@section('content_header')
<div class="row">

    <div class="col-md-12">

        <h1 class="m-0 text-dark col-md-6 float-left">All Gst State Masters</h1>

        <a class="btn btn-primary float-right" href="/gst-state-masters/create">Add State</a>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">


                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>TIN</th>
                            <th>Code</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($states as $key => $state)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $state->name }}</td>
                            <td>{{ $state->tin }}</td>
                            <td>{{ $state->code }}</td>
                            <td><a href="/gst-state-masters/{{ $state->id }}/edit" class="btn btn-warning">Edit</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>



            </div>
        </div>
    </div>
</div>
@stop
