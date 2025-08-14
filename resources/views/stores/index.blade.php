@extends('layout.master')

@section('title', 'ZetBooks')

@section('content_header')
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-md-12">
                        <h4 class="m-0 text-dark col-md-6 float-left">{{ $title ?? 'All Records' }}</h4>
                        <a class="btn btn-primary float-right btn-sm" href="{{ route($url.'.create') }}">NEW</a>
                    </div>
                </div>

                <table id="example" class="table table-hover table-light" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Code / Phone</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($items as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="{{ route($url.'.show', $item->id) }}">{{ $item->store_name }}</a></td>
                            <td>{{ $item->store_code ?? $item->phone ?? 'N/A' }}</td>
                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route($url.'.edit', $item->id) }}"><i class="fa fa-edit text-primary"></i></a>

                                @if(auth()->user()->privilege == "admin")
                                <a href="{{ url('/'.$url.'/'.$item->id.'/delete') }}" onclick="return confirm('Are you sure?')">
                                    <i class="fa fa-trash text-danger ml-2"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $items->links() }}

            </div>
        </div>
    </div>
</div>
@stop
