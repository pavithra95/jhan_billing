@extends('layout.master')

@section('title', 'Edit Brand')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="m-0 text-dark"><i class="fas fa-edit text-info"></i> Edit Brand</h1>
        <a href="{{ route('brands.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-info shadow-sm rounded-lg">
                <div class="card-header">
                    <h3 class="card-title">Update Brand</h3>
                </div>
                <form method="POST" action="{{ route('brands.update', $brand) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @include('brands.form')
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('brands.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save"></i> Update Brand
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
