@extends('layout.master')

@section('content')
<div class="container">
    <h2>Purchase Invoice: {{ $purchaseInvoice->invoice_no }}</h2>

    <div class="row mb-3">
        <div class="col-md-4">
            <strong>Supplier Name:</strong> {{ $purchaseInvoice->supplier_name }}
        </div>
        <div class="col-md-4">
            <strong>Supplier Phone:</strong> {{ $purchaseInvoice->supplier_phone }}
        </div>
        <div class="col-md-4">
            <strong>Invoice Date:</strong> {{ $purchaseInvoice->invoice_date }}
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <strong>Payment Method:</strong> {{ $purchaseInvoice->Payment->name ?? '-' }}
        </div>
        <div class="col-md-4">
            <strong>Total Items:</strong> {{ $purchaseInvoice->PurchaseItem->count() }}
        </div>
        <div class="col-md-4">
            <strong>Invoice No:</strong> {{ $purchaseInvoice->invoice_no }}
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Bar Code</th>
                <th>Item Name</th>
                <th>QTY</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseInvoice->PurchaseItem as $item)
            <tr>
                <td>{{ $item->barcode }}</td>
                <td>{{ $item->product->name ?? 'N/A' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->rate, 2) }}</td>
                <td>{{ number_format($item->amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-end"><strong>Sub Total:</strong></td>
                <td>{{ number_format($purchaseInvoice->sub_total, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-end"><strong>GST 5%:</strong></td>
                <td>{{ number_format($purchaseInvoice->gst_amount, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                <td>{{ number_format($purchaseInvoice->total_amount, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="mt-3">
        <a href="{{ url('/purchase-invoices') }}" class="btn btn-secondary">Back</a>
        <a href="{{ url('/purchase-invoices/'.$purchaseInvoice->id.'/edit') }}" class="btn btn-primary">Edit</a>
    </div>
</div>
@endsection
