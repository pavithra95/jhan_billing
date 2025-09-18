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

        <h4 class="m-0 text-dark col-md-6 float-left">All Tax Groups</h4>

        <a class="btn btn-primary float-right btn-sm" href="/tax-groups/create"><i class="fa fa-plus" aria-hidden="true"> New</i> </a>
    </div>
</div>
<br>


                <table id="example" class="table table-hover table-light" style="width:100%">
               <thead class="thead-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Type</th>
                            <th>Tax Group name</th>
                            <th>Taxes</th>
                          
                            <th>State Type</th>
                           
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
                            <td><a href="/tax-groups/{{ $item->id }}" >{{ $item->group_type }}</a></td>
                            <td>{{ $item->group_type_name }}</td>
                            <td>
                                @foreach ($item->taxGroup as $i)
                                    {{$i->Tax->name ?? '-'}}<br>
                                   

                                @endforeach
                            </td>
                           
                            <td>{{ $item->group_state_type }}</td>
                            {{-- <td>{{$item->taxGroup->tax_id[0]}}</td> --}}
                            {{-- <td>{{$item->taxGroup->tax_percentage}}</td> --}}
                           
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->status }}</td>
                             <td>
                              <a href="/tax-groups/{{$item->id}}/edit"><i class= "fa fa-edit"></i></a>
                                @if(auth()->user()->privilege == "admin")
                              <a href="/tax-groups/{{$item->id}}/delete"><i class="fa fa-trash" ></i></a>
                              @endif
                              
                            </td>
                           
                           
                            {{-- <td>{{$item->stockQuantity()}}</td>
                            --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            




            </div>
        </div>
    </div>
</div>
@stop
