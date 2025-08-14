@extends('layout.master')

@section('title', 'Create Brand')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="m-0 text-dark"><i class="fas fa-plus-circle text-success"></i> Create Brand</h1>
        <a href="{{ route('brands.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-success shadow-sm rounded-lg">
                <div class="card-header">
                    <h3 class="card-title">Brand Details</h3>
                </div>
                <form method="POST" action="{{ route('brands.store') }}">
                    @csrf
                    <div class="card-body">
                        @include('brands.form', ['brand' => new \App\Models\Brand])
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('brands.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Create Brand
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
