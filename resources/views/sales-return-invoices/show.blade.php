@extends('layout.master')

@section('content')
<div class="container">
    <h2>Sales Return Invoice Details</h2>

    <!-- Invoice Info -->
    <div class="row mb-4">
        <div class="col-md-4">
            <strong>Customer Phone:</strong> {{ $invoice->customer_phone }}
        </div>
        <div class="col-md-4">
            <strong>Customer Name:</strong> {{ $invoice->customer_name }}
        </div>
        <div class="col-md-4">
            <strong>Invoice Number:</strong> {{ $invoice->invoice_no }}
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <strong>Against Invoice No:</strong> {{ $invoice->against_invoice_no }}
        </div>
        <div class="col-md-4">
            <strong>Invoice Date:</strong> 
            {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}
        </div>
        <div class="col-md-4">
            <strong>Payment Method:</strong> {{ $invoice->paymentMethod->name ?? '-' }}
        </div>
    </div>

    <!-- Items Table -->
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
            @php $subTotal = 0; @endphp
            @foreach($invoice->salesReturnItem as $item)
                @php 
                    $amount = $item->quantity * $item->rate;
                    $subTotal += $amount;
                @endphp
                <tr>
                    <td>{{ $item->barcode }}</td>
                    <td>{{ $item->item->name ?? '-' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->rate, 2) }}</td>
                    <td>{{ number_format($amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-end"><strong>Sub Total:</strong></td>
                <td>{{ number_format($subTotal, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-end"><strong>GST 5%:</strong></td>
                <td>{{ number_format($subTotal * 0.05, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                <td>{{ number_format($subTotal + ($subTotal * 0.05), 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="mt-3">
        <a href="{{ route('sales-return-invoices.edit', $invoice->id) }}" class="btn btn-primary btn-sm">Edit</a>
        <a href="{{ route('sales-return-invoices.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>
</div>
@endsection
