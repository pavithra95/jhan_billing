@extends('layout.master')

@section('content')
<div class="container">
    <h2>Edit Purchase Return Invoice</h2>

    <form action="{{ route('purchase-return-invoices.update', $invoice->id) }}" method="POST" class="col-md-12" autocomplete="off">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="mb-3 col-md-4">
                <label>Supplier Phone</label>
                <input type="text" id="supplierPhone" class="form-control" name="supplier_phone" value="{{ $invoice->supplier_phone }}">
            </div>

            <div class="mb-3 col-md-4">
                <label>Supplier Name</label>
                <input type="text" id="supplierName" class="form-control" name="supplier_name" value="{{ $invoice->supplier_name }}">
            </div>

            <div class="mb-3 col-md-4">
                <div class="form-group @if($errors->has('invoice_no')) text-danger @endif">
                    <label>Invoice Number</label>
                    <input type="text" name="invoice_no" class="form-control" id="invoice_no" required value="{{ $invoice->invoice_no }}">
                    @if($errors->has('invoice_no'))
                        <div class="error text-danger">{{ $errors->first('invoice_no') }}</div>
                    @endif
                </div>
            </div>

            <div class="mb-3 col-md-4">
                <label>Against Invoice No</label>
                <input type="text" class="form-control" name="against_invoice_no" id="salesInvoiceInput" value="{{ $invoice->against_invoice_no }}">
            </div>

            <div class="mb-3 col-md-4">
                <label>Against Invoice Date</label>
                <input type="date" class="form-control" name="invoice_date" value="{{ $invoice->invoice_date }}">
            </div>

            <div class="mb-3 col-md-4">
                <label>Payment Method</label>
                <select class="form-select" name="payment_method">
                    @foreach($paymentMethods as $method)
                        <option value="{{ $method->id }}" {{ $invoice->payment_method_id == $method->id ? 'selected' : '' }}>
                            {{ $method->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Items Table -->
        <table class="table table-bordered" id="itemTable">
            <thead>
                <tr>
                    <th>Bar Code</th>
                    <th>Item Name</th>
                    <th>QTY</th>
                    <th>Rate</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->purchaseReturnItem as $index => $item)
                <tr>
                    <td><input type="text" name="items[{{ $index }}][barcode]" class="form-control barcode" value="{{ $item->barcode }}"></td>
                    <td>
                        <select name="items[{{ $index }}][id]" class="form-control itemName">
                            <option value=""></option>
                            @foreach($items as $i)
                                <option value="{{ $i->id }}" {{ $i->id == $item->id ? 'selected' : '' }}>
                                    {{ $i->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="items[{{ $index }}][qty]" class="form-control qty" value="{{ $item->quantity }}" min="1"></td>
                    <td><input type="number" name="items[{{ $index }}][rate]" class="form-control rate" value="{{ $item->rate }}" min="0"></td>
                    <td class="amount">0.00</td>
                    <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end"><strong>Sub Total:</strong></td>
                    <td id="subTotal">0.00</td>
                    <td></td>
                </tr>
                <tr id="gstRow" style="display:none;">
                    <td colspan="4" class="text-end"><strong>GST 5%:</strong></td>
                    <td id="gstAmount">0.00</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end"><strong>Total:</strong></td>
                    <td id="totalAmount">0.00</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <button type="button" id="addRow" class="btn btn-primary">Add Row</button>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary col-md-2 offset-md-5 btn-sm">Update</button>
            <a class="btn btn-danger col-md-2 btn-sm" href='/purchase-return-invoices'>Cancel</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const gstRow = document.getElementById('gstRow');
    const phoneInput = document.getElementById('supplierPhone');
    const nameInput = document.getElementById('supplierName');
    const salesInvoiceInput = document.getElementById('salesInvoiceInput');

    // Calculate totals
    function calculateTotals() {
        let rows = document.querySelectorAll("#itemTable tbody tr");
        let subTotal = 0;
        rows.forEach(row => {
            let qty = parseFloat(row.querySelector(".qty").value) || 0;
            let rate = parseFloat(row.querySelector(".rate").value) || 0;
            let amount = qty * rate;
            row.querySelector(".amount").textContent = amount.toFixed(2);
            subTotal += amount;
        });
        document.querySelector("#subTotal").textContent = subTotal.toFixed(2);
        let gst = subTotal * 0.05;
        gstRow.style.display = '';
        document.querySelector("#gstAmount").textContent = gst.toFixed(2);
        document.querySelector("#totalAmount").textContent = (subTotal + gst).toFixed(2);
    }

    // Add new row
    document.getElementById('addRow').addEventListener('click', () => {
        let tbody = document.querySelector("#itemTable tbody");
        let rowCount = tbody.querySelectorAll('tr').length;
        let newRow = document.createElement('tr');

        // Build the select options
        let options = `<option value=""></option>`;
        document.querySelectorAll('#itemTable .itemName option').forEach(opt => {
            if(opt.value) options += `<option value="${opt.value}">${opt.textContent}</option>`;
        });

        newRow.innerHTML = `
            <td><input type="text" name="items[${rowCount}][barcode]" class="form-control barcode"></td>
            <td>
                <select name="items[${rowCount}][id]" class="form-control itemName">
                    ${options}
                </select>
            </td>
            <td><input type="number" name="items[${rowCount}][qty]" class="form-control qty" value="1" min="1"></td>
            <td><input type="number" name="items[${rowCount}][rate]" class="form-control rate" value="0" min="0"></td>
            <td class="amount">0.00</td>
            <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
        `;

        tbody.appendChild(newRow);
    });

    // Remove row
    document.querySelector("#itemTable tbody").addEventListener('click', (e) => {
        if (e.target.classList.contains('removeRow')) {
            let row = e.target.closest('tr');
            if (document.querySelectorAll("#itemTable tbody tr").length > 1) {
                row.remove();
                calculateTotals();
            } else {
                alert("Can't remove the last row");
            }
        }
    });

    // Quantity / rate changes
    document.querySelector('#itemTable').addEventListener('input', (e) => {
        if (e.target.classList.contains('qty') || e.target.classList.contains('rate')) {
            calculateTotals();
        }
    });

    // Barcode or product select lookup (dynamic delegation)
    document.querySelector('#itemTable').addEventListener('change', (e) => {
        const row = e.target.closest('tr');

        if (e.target.classList.contains('barcode')) {
            const barcode = e.target.value.trim();
            if (barcode) {
                fetch(`/get-purchase-item-by-barcode?barcode=${encodeURIComponent(barcode)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data) {
                            row.querySelector('.itemName').value = data.id;
                            row.querySelector('.rate').value = data.price;
                            calculateTotals();
                        } else {
                            alert('Item not found');
                            row.querySelector('.itemName').value = '';
                            row.querySelector('.rate').value = '';
                            calculateTotals();
                        }
                    });
            }
        }

        if (e.target.classList.contains('itemName')) {
            const productId = e.target.value;
            if (productId) {
                fetch(`/get-purchase-item-by-id?id=${encodeURIComponent(productId)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data) {
                            row.querySelector('.barcode').value = data.barcode;
                            row.querySelector('.rate').value = data.price;
                            calculateTotals();
                        } else {
                            row.querySelector('.barcode').value = '';
                            row.querySelector('.rate').value = '';
                            calculateTotals();
                        }
                    });
            } else {
                row.querySelector('.barcode').value = '';
                row.querySelector('.rate').value = '';
                calculateTotals();
            }
        }
    });

    // Supplier phone lookup
    phoneInput.addEventListener('input', () => {
        const phone = phoneInput.value.trim();
        if (phone.length >= 5) {
            fetch(`/get-vendor-by-phone-return?phone=${encodeURIComponent(phone)}`)
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        nameInput.value = data.name || '';
                        salesInvoiceInput.value = data.purchase_invoice_no || '';
                    } else {
                        nameInput.value = '';
                        salesInvoiceInput.value = '';
                    }
                });
        } else {
            nameInput.value = '';
            salesInvoiceInput.value = '';
        }
    });

    // Initial calculation
    calculateTotals();
});
</script>
@endsection
