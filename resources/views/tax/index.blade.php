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

        <h4 class="m-0 text-dark col-md-6 float-left">All Taxes</h4>

        <a class="btn btn-primary float-right btn-sm" href="/taxes/create"><i class="fa fa-plus" aria-hidden="true"> New</i> </a>
    </div>
</div>
<br>


                 <table id="example" class="table table-hover table-light" style="width:100%">
               <thead class="thead-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Percentage</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                           
                          
                            {{-- <th>Stock Quantity</th> --}}
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tax as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="/taxes/{{ $item->id }}" >{{ $item->name }}</a></td>
                            <td>{{ $item->percentage }}%</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->status }}</td>
                             <td>
                              <a href="/taxes/{{$item->id}}/edit"><i class= "fa fa-edit"></i></a>
                              <a href="/taxes/{{$item->id}}/delete"><i class="fa fa-trash" ></i></a>
                              
                            </td>
                           
                           
                            {{-- <td>{{$item->stockQuantity()}}</td>
                            --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                 {{$tax->links()}}




            </div>
        </div>
    </div>
</div>
@stop
