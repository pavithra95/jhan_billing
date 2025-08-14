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

        <h4 class="m-0 text-dark col-md-6 float-left">All Product Categories</h4>

        <a class="btn btn-primary float-right btn-sm" href="/product-categories/create">NEW</a>
    </div>
</div>
<br>


                 <table id="example" class="table table-hover table-light" style="width:100%">
               <thead class="thead-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Hsn Code</th>
                            
                            <th>Status</th>
                            <th>Action</th>
                           
                            {{-- <th>Stock Quantity</th> --}}
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="/product-categories/{{ $item->id }}" >{{ $item->name }}</a></td>
                            <td>{{ $item->hsn_code }}</td>
                            <td>{{ $item->status }}</td>
                             <td>
                              <a href="/product-categories/{{$item->id}}/edit"><i class= "fa fa-edit"></i></a>
                                @if(auth()->user()->privilege == "admin")
                              <a href="/product-categories/{{$item->id}}/delete"><i class="fa fa-trash" ></i></a>
                              @endif
                              
                            </td>
                           
                            {{-- <td>{{$item->stockQuantity()}}</td>
                            --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                 {{$products->links()}}




            </div>
        </div>
    </div>
</div>
@stop
