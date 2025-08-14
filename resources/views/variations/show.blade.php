@extends('layout.master')

@section('title', 'View Variation')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="text-dark">Variation Details</h4>
                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <strong>Variation Name:</strong>
                        <p>{{ $variation->name }}</p>
                    </div>

                    <div class="col-md-6">
                        <strong>Variation Values:</strong>
                        <p>
                            @foreach($variation->values as $val)
                                <span class="badge badge-info">{{ $val->value }}</span>
                            @endforeach
                        </p>
                    </div>
                </div>

                <a href="{{ route('variations.edit', $variation->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <a href="{{ route('variations.index') }}" class="btn btn-secondary btn-sm">Back</a>

            </div>
        </div>
    </div>
</div>
@endsection
