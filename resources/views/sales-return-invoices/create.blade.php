@extends('layout.master')

@section('content')
<div class="container">
    <h2>Create Sales Return Invoice</h2>

    <form action="/sales-return-invoices" method="POST" class="col-md-12" autocomplete="off">
        @csrf
        <div class="row">
            <!-- Customer Phone -->
            <div class="mb-3 col-md-4">
                <label>Customer Phone</label>
                <input type="text" id="customerPhone" class="form-control" name="customer_phone">
            </div>

            <!-- Customer Name -->
            <div class="mb-3 col-md-4">
                <label>Customer Name</label>
                <input type="text" id="customerName" class="form-control" name="customer_name">
            </div>

            <!-- Invoice Number -->
            <div class="mb-3 col-md-4">
                <div class="form-group @if($errors->has('invoice_no')) text-danger @endif">
                    <label>Invoice Number</label>
                    <input type="text" name="invoice_no" class="form-control" id="invoice_no" required
                        value="{{ generateSalesReturnInvoiceNo() }}">
                    @if($errors->has('invoice_no'))
                        <div class="error text-danger">{{ $errors->first('invoice_no') }}</div>
                    @endif
                </div>
            </div>

            <!-- Against Invoice Number -->
            <div class="mb-3 col-md-4">
                <label>Against Invoice No</label>
                <input type="text" class="form-control" name="against_invoice_no" id="salesInvoiceInput">
            </div>

            <!-- Against Invoice Date -->
            <div class="mb-3 col-md-4">
                <label>Against Invoice Date</label>
                <input type="date" class="form-control" name="invoice_date" value="{{ date('Y-m-d') }}">
            </div>

            <!-- Payment Method -->
            <div class="mb-3 col-md-4">
                <label>Payment Method</label>
                <select class="form-select" name="payment_method">
                    @foreach($paymentMethods as $method)
                        <option value="{{ $method->id }}">{{ $method->name }}</option>
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
                <tr>
                    <td><input type="text" name="items[0][barcode]" class="form-control barcode"></td>
                    <td>
                        <select name="items[0][id]" class="form-control itemName">
                            <option value=""></option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="items[0][qty]" class="form-control qty" value="1" min="1"></td>
                    <td><input type="number" name="items[0][rate]" class="form-control rate" value="0" min="0"></td>
                    <td class="amount">0.00</td>
                    <td></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end"><strong>Sub Total:</strong></td>
                    <td id="subTotal">0.00</td>
                    <td></td>
                </tr>
                <tr id="gstRow">
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
            <button type="submit" class="btn btn-primary col-md-2 offset-md-5 btn-sm">Create</button>
            <a class="btn btn-danger col-md-2 btn-sm" href='/sales-invoices'>Cancel</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.querySelector("#itemTable tbody");
    const phoneInput = document.getElementById('customerPhone');
    const nameInput = document.getElementById('customerName');
    const salesInvoiceInput = document.getElementById('salesInvoiceInput');
    const gstRow = document.getElementById('gstRow');
    const allItemOptions = [...document.querySelectorAll('#itemTable .itemName option')]
        .map(opt => `<option value="${opt.value}">${opt.textContent}</option>`).join('');

    // Add new row
    function addRow(index, item = {}) {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><input type="text" name="items[${index}][barcode]" class="form-control barcode" value="${item.barcode || ''}"></td>
            <td>
                <select name="items[${index}][id]" class="form-control itemName">
                    ${allItemOptions.replace(
                        new RegExp(`value="${item.id}"`), 
                        `value="${item.id}" selected`
                    )}
                </select>
            </td>
            <td><input type="number" name="items[${index}][qty]" class="form-control qty" value="${item.quantity || 1}" min="1"></td>
            <td><input type="number" name="items[${index}][rate]" class="form-control rate" value="${item.rate || 0}" min="0"></td>
            <td class="amount">${item.quantity && item.rate ? (item.quantity * item.rate).toFixed(2) : '0.00'}</td>
            <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
        `;
        tbody.appendChild(newRow);
        calculateTotals();
    }

    // Calculate totals
    function calculateTotals() {
        let subTotal = 0;
        tbody.querySelectorAll('tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const rate = parseFloat(row.querySelector('.rate').value) || 0;
            const amount = qty * rate;
            row.querySelector('.amount').textContent = amount.toFixed(2);
            subTotal += amount;
        });
        document.getElementById('subTotal').textContent = subTotal.toFixed(2);
        const gst = subTotal * 0.05;
        gstRow.style.display = '';
        document.getElementById('gstAmount').textContent = gst.toFixed(2);
        document.getElementById('totalAmount').textContent = (subTotal + gst).toFixed(2);
    }

    // Add row button
    document.getElementById('addRow').addEventListener('click', () => {
        addRow(tbody.querySelectorAll('tr').length);
    });

    // Remove row
    tbody.addEventListener('click', e => {
        if (e.target.classList.contains('removeRow')) {
            if (tbody.querySelectorAll('tr').length > 1) {
                e.target.closest('tr').remove();
                calculateTotals();
            } else {
                alert("Can't remove the last row");
            }
        }
    });

    // Barcode or item change
    tbody.addEventListener('change', e => {
        const row = e.target.closest('tr');
        if (e.target.classList.contains('barcode')) {
            const barcode = e.target.value;
            if (!barcode) return;
            fetch(`/get-item-by-barcode?barcode=${encodeURIComponent(barcode)}`)
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        row.querySelector('.itemName').value = data.id;
                        row.querySelector('.rate').value = data.price;
                        calculateTotals();
                    }
                });
        }
        if (e.target.classList.contains('itemName')) {
            const id = e.target.value;
            if (!id) return;
            fetch(`/get-item-by-id?id=${encodeURIComponent(id)}`)
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        row.querySelector('.barcode').value = data.barcode;
                        row.querySelector('.rate').value = data.price;
                        calculateTotals();
                    }
                });
        }
    });

    // Quantity or rate change
    tbody.addEventListener('input', e => {
        if (e.target.classList.contains('qty') || e.target.classList.contains('rate')) {
            calculateTotals();
        }
    });

    // Customer phone lookup
    phoneInput.addEventListener('input', () => {
        const phone = phoneInput.value.trim();
        if (phone.length >= 5) {
            fetch(`/get-customer-by-phone-return?phone=${encodeURIComponent(phone)}`)
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        nameInput.value = data.name || '';
                        salesInvoiceInput.value = data.sales_invoice_no || '';
                        // Trigger invoice items autofill
                        salesInvoiceInput.dispatchEvent(new Event('change'));
                    } else {
                        nameInput.value = '';
                        salesInvoiceInput.value = '';
                        tbody.innerHTML = '';
                        addRow(0);
                    }
                });
        } else {
            nameInput.value = '';
            salesInvoiceInput.value = '';
            tbody.innerHTML = '';
            addRow(0);
        }
    });

    // Against Invoice No -> autofill items
    salesInvoiceInput.addEventListener('change', () => {
        const invoiceNo = salesInvoiceInput.value.trim();
        if (!invoiceNo) return;
        fetch(`/get-sales-invoice-items?invoice_no=${encodeURIComponent(invoiceNo)}`)
            .then(res => res.json())
            .then(data => {
                tbody.innerHTML = ''; // clear
                if (data && data.items && data.items.length > 0) {
                    data.items.forEach((item, index) => addRow(index, {
                        id: item.id,
                        barcode: item.barcode,
                        quantity: item.quantity,
                        rate: item.rate
                    }));
                } else {
                    addRow(0); // fallback
                }
            });
    });

    // Prevent form submit on Enter
    document.querySelector('form').addEventListener('keydown', e => {
        if (e.key === 'Enter') {
            e.preventDefault();
            const focusable = [...document.querySelectorAll('input, select')]
                .filter(el => !el.disabled && el.type !== 'hidden');
            const index = focusable.indexOf(document.activeElement);
            if (index > -1 && index + 1 < focusable.length) focusable[index + 1].focus();
        }
    });

    // Initial row and calculation
    if (tbody.querySelectorAll('tr').length === 0) addRow(0);
    calculateTotals();
});
</script>
@endsection