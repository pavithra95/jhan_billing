@extends('layout.master')

@section('content')
<div class="container">
    <h2>Edit Sales Invoice</h2>

    <!-- Customer Info -->
    <form action="/sales-invoices/{{ $invoice->id }}" method="POST" role="form" class="col-md-12" autocomplete="off">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="mb-3 col-md-4">
                <label>Customer Phone</label>
                <input type="text" id="customerPhone" class="form-control" name="customer_phone" value="{{ $invoice->customer_phone }}">
            </div>

            <div class="mb-3 col-md-4">
                <label>Customer Name</label>
                <input type="text" id="customerName" class="form-control" name="customer_name" value="{{ $invoice->customer_name }}">
            </div>

            <div class="mb-3 col-md-4">
                <label>Customer Type</label>
                <select id="customerType" class="form-select" name="customer_type">
                    <option value="Retail" {{ $invoice->customer_type == 'Retail' ? 'selected' : '' }}>Retail</option>
                    <option value="Whole Sale" {{ $invoice->customer_type == 'Whole Sale' ? 'selected' : '' }}>Whole Sale</option>
                    <option value="Reselling" {{ $invoice->customer_type == 'Reselling' ? 'selected' : '' }}>Reselling</option>
                </select>
            </div>

            <div class="mb-3 col-md-4">
                <label>Invoice No</label>
                <input type="text" class="form-control" name="invoice_no" value="{{ $invoice->invoice_no }}" readonly>
            </div>

            <div class="mb-3 col-md-4">
                <label>Invoice Date</label>
                <input type="date" class="form-control" name="invoice_date" value="{{ $invoice->invoice_date }}">
            </div>

            <div class="mb-3 col-md-4">
                <label>Payment Method</label>
                <select class="form-select" name="payment_method">
                    @foreach($paymentMethods as $method)
                        <option value="{{ $method->id }}" {{ $invoice->payment_method == $method->id ? 'selected' : '' }}>
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
                @foreach($invoice->SaleItem as $key => $item)
                <tr>
                    <td><input type="text" name="products[{{ $key }}][barcode]" class="form-control barcode" value="{{ $item->product->barcode }}"></td>
                    <td>
                        <select name="products[{{ $key }}][id]" class="form-control itemName">
                            <option value=""></option>
                            @foreach($products as $prod)
                                <option value="{{ $prod->id }}" {{ $item->item_id == $prod->id ? 'selected' : '' }}>
                                    {{ $prod->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="products[{{ $key }}][qty]" class="form-control qty" value="{{ $item->quantity }}" min="1"></td>
                    <td><input type="number" name="products[{{ $key }}][rate]" class="form-control rate" value="{{ $item->rate }}" min="0"></td>
                    <td class="amount">{{ number_format($item->quantity * $item->rate, 2) }}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
                    </td>
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
            <a class="btn btn-danger col-md-2 btn-sm" href='/sales-invoices'>Cancel</a>
        </div>
    </form>
</div>

<script>
    // ✅ Generate clean product options (no duplicates)
    const productOptions = `
        <option value=""></option>
        @foreach($products as $prod)
            <option value="{{ $prod->id }}">{{ $prod->name }}</option>
        @endforeach
    `;

document.addEventListener('DOMContentLoaded', () => {
    const customerType = document.getElementById('customerType');
    const gstRow = document.getElementById('gstRow');
    const phoneInput = document.getElementById('customerPhone');
    const nameInput = document.getElementById('customerName');

    // === Totals Calculation ===
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

        document.querySelector("#itemTable #subTotal").textContent = subTotal.toFixed(2);

        if (customerType.value === "Whole Sale") {
            let gst = subTotal * 0.05;
            gstRow.style.display = '';
            document.getElementById("gstAmount").textContent = gst.toFixed(2);
            document.getElementById("totalAmount").textContent = (subTotal + gst).toFixed(2);
        } else {
            gstRow.style.display = 'none';
            document.getElementById("gstAmount").textContent = "0.00";
            document.getElementById("totalAmount").textContent = subTotal.toFixed(2);
        }
    }

    // === Add New Row ===
    document.getElementById('addRow').addEventListener('click', () => {
        let tbody = document.querySelector("#itemTable tbody");
        let rowCount = tbody.querySelectorAll('tr').length;
        let newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td><input type="text" name="products[${rowCount}][barcode]" class="form-control barcode"></td>
            <td>
                <select name="products[${rowCount}][id]" class="form-control itemName">
                    ${productOptions}
                </select>
            </td>
            <td><input type="number" name="products[${rowCount}][qty]" class="form-control qty" value="1" min="1"></td>
            <td><input type="number" name="products[${rowCount}][rate]" class="form-control rate" value="0" min="0"></td>
            <td class="amount">0.00</td>
            <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
        `;

        tbody.appendChild(newRow);
        newRow.querySelector(".barcode").focus(); // ✅ focus barcode immediately
    });

    // === Customer Phone Lookup ===
    phoneInput.addEventListener('input', () => {
        let phone = phoneInput.value.trim();
        if (phone.length >= 5) {
            fetch(`/get-customer-by-phone?phone=${encodeURIComponent(phone)}`)
                .then(res => res.json())
                .then(data => {
                    nameInput.value = data?.name ?? '';
                })
                .catch(err => console.error("Error:", err));
        } else {
            nameInput.value = '';
        }
    });

    // === Table Event Listeners ===
    document.querySelector('#itemTable').addEventListener('change', (e) => {
        const row = e.target.closest('tr');

        if (e.target.classList.contains('barcode')) {
            const barcode = e.target.value.trim();
            if (barcode) {
                fetch(`/get-item-by-barcode?barcode=${encodeURIComponent(barcode)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data) {
                            row.querySelector('.itemName').value = data.id;
                            row.querySelector('.rate').value = data.price;
                        } else {
                            alert('Item not found');
                            row.querySelector('.itemName').value = '';
                            row.querySelector('.rate').value = '';
                        }
                        calculateTotals();
                    });
            }
        }

        if (e.target.classList.contains('itemName')) {
            const productId = e.target.value;
            if (productId) {
                fetch(`/get-item-by-id?id=${encodeURIComponent(productId)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data) {
                            row.querySelector('.barcode').value = data.barcode;
                            row.querySelector('.rate').value = data.price;
                        } else {
                            row.querySelector('.barcode').value = '';
                            row.querySelector('.rate').value = '';
                        }
                        calculateTotals();
                    });
            } else {
                row.querySelector('.barcode').value = '';
                row.querySelector('.rate').value = '';
                calculateTotals();
            }
        }
    });

    document.querySelector('#itemTable').addEventListener('input', (e) => {
        if (e.target.classList.contains('qty') || e.target.classList.contains('rate')) {
            calculateTotals();
        }
    });

    // === Remove Row ===
    document.querySelector("#itemTable tbody").addEventListener('click', (e) => {
        if (e.target.classList.contains('removeRow')) {
            let row = e.target.closest('tr');
            let allRows = document.querySelectorAll("#itemTable tbody tr");
            if (allRows.length > 1) {
                row.remove();
                calculateTotals();
            } else {
                alert("Can't remove the last row");
            }
        }
    });

    // === Prevent Enter Key Submit ===
    document.querySelector('form').addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            const focusable = [...document.querySelectorAll('input, select, textarea')]
                .filter(el => !el.disabled && el.type !== 'hidden');
            const index = focusable.indexOf(document.activeElement);
            if (index > -1 && index + 1 < focusable.length) {
                focusable[index + 1].focus();
            }
        }
    });

    // Initial calculation
    calculateTotals();
});
</script>
@endsection
