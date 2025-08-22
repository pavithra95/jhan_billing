@extends('layout.master')

@section('content')
<div class="container">
    <h2>Purchase Return Invoice #{{ $invoice->invoice_no }}</h2>

    <div class="row mb-3">
        <div class="col-md-4">
            <strong>Supplier Phone:</strong> {{ $invoice->supplier_phone }}
        </div>
        <div class="col-md-4">
            <strong>Supplier Name:</strong> {{ $invoice->supplier_name }}
        </div>
        <div class="col-md-4">
            <strong>Against Invoice No:</strong> {{ $invoice->against_invoice_no }}
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <strong>Invoice Date:</strong> {{ $invoice->invoice_date }}
        </div>
        <div class="col-md-4">
            <strong>Payment Method:</strong> {{ $invoice->payment->name ?? '' }}
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
            @php $subTotal = 0; @endphp
            @foreach($invoice->purchaseReturnItem as $item)
                @php
                    $amount = $item->quantity * $item->rate;
                    $subTotal += $amount;
                @endphp
                <tr>
                    <td>{{ $item->barcode }}</td>
                    <td>{{ $item->item->name ?? '' }}</td>
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
            @php $gst = $subTotal * 0.05; @endphp
            <tr>
                <td colspan="4" class="text-end"><strong>GST 5%:</strong></td>
                <td>{{ number_format($gst, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                <td>{{ number_format($subTotal + $gst, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <a href="{{ route('purchase-return-invoices.edit', $invoice->id) }}" class="btn btn-primary">Edit</a>
    <a href="{{ route('purchase-return-invoices.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
