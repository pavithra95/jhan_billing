@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/dragula/dragula.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

    <div class="col-md-12">

        <h4 class="m-0 text-dark col-md-6 float-left">All Units</h4>

        <a class="btn btn-primary float-right btn-sm" href="/units/create">NEW </a>
    </div>
</div>
<br>


                 <table id="example" class="table table-hover table-light" style="width:100%">
               <thead class="thead-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                           
                          
                            {{-- <th>Stock Quantity</th> --}}
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($units as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="/units/{{ $item->id }}" >{{ $item->name }}</a></td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->status }}</td>
                             <td>
                              <a href="/units/{{$item->id}}/edit"><i class= "fa fa-edit"></i></a>
                                @if(auth()->user()->privilege == "admin")
                              <a href="/units/{{$item->id}}/delete"><i class="fa fa-trash" ></i></a>
                              @endif
                              
                            </td>
                           
                           
                            {{-- <td>{{$item->stockQuantity()}}</td>
                            --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                 {{$units->links()}}




            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/dragula/dragula.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dragula.js') }}"></script>
@endpush
