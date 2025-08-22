@extends('layout.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Sales Invoice #{{ $invoice->id }}</h2>

    <!-- Customer Details -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Customer Details</h5>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $invoice->customer->name ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $invoice->customer->phone ?? 'N/A' }}</p>
            <p><strong>Customer Type:</strong> {{ $invoice->customer_type ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Invoice Items -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Invoice Items</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Barcode</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->SaleItem as $item)
                    <tr>
                        <td>{{ $item->product->barcode ?? '-' }}</td>
                        <td>{{ $item->product->name ?? 'Deleted Product' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->rate, 2) }}</td>
                        <td>{{ number_format($item->quantity * $item->rate, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total</th>
                        <th>
                            {{ number_format($invoice->SaleItem->sum(function($i) { return $i->quantity * $i->rate; }), 2) }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Footer Buttons -->
    <div class="d-flex justify-content-between">
        <a href="{{ route('sales-invoices.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('sales-invoices.edit', $invoice->id) }}" class="btn btn-primary">Edit</a>
    </div>
</div>
@endsection
