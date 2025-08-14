@extends('layout.master')

@section('title', 'Variation List')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h4 class="m-0 text-dark float-left">All Variations</h4>
                        <a class="btn btn-primary float-right btn-sm" href="{{ route('variations.create') }}">NEW</a>
                    </div>
                </div>

                <table class="table table-hover table-light" id="example" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Variation Name</th>
                            <th>Variation Values</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($variations as $key => $variation)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="{{ route('variations.show', $variation->id) }}">{{ $variation->name }}</a></td>
                            <td>
                                @foreach($variation->values as $val)
                                    <span class="badge badge-info">{{ $val->value }}</span>
                                @endforeach
                            </td>
                            <td>{{ $variation->created_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('variations.edit', $variation->id) }}"><i class="fa fa-edit text-primary"></i></a>

                                <form action="{{ route('variations.destroy', $variation->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" class="btn btn-link p-0 m-0"><i class="fa fa-trash text-danger ml-2"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                {{ $variations->links() }}

            </div>
        </div>
    </div>
</div>
@endsection
