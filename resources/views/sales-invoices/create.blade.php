@extends('layout.master')

@section('content')
<div class="container">
    <h2>Create Sales Invoice</h2>

    <!-- Customer Info -->
    <form action="/sales-invoices" method="POST" role="form" class="col-md-12" autocomplete="off">
        {{ csrf_field() }}
        <div class="row">
            <div class="mb-3 col-md-4">
                <label>Customer Phone</label>
                <input type="text" id="customerPhone" class="form-control" name="customer_phone">
            </div>

            <div class="mb-3 col-md-4">
                <label>Customer Name</label>
                <input type="text" id="customerName" class="form-control" name="customer_name">
            </div>

            <div class="mb-3 col-md-4">
                <label>Customer Type</label>
                <select id="customerType" class="form-select" name="customer_type">
                    <option value="Retail">Retail</option>
                    <option value="Whole Sale">Whole Sale</option>
                    <option value="Reselling">Reselling</option>
                </select>
            </div>

            <div class="mb-3 col-md-4">
                <label>Invoice No</label>
                <input type="text" class="form-control" name="invoice_no" value="{{generateSalesInvoiceNo()}}">
            </div>

            <div class="mb-3 col-md-4">
                <label>Invoice Date</label>
                <input type="date" class="form-control" name="invoice_date" value="{{ date('Y-m-d') }}">
            </div>
            <div class="mb-3 col-md-4">
                <label>Payment Method</label>
                <select class="form-select" name="payment_method">
                    @foreach($paymentMethods as $method)
                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Items Table with Footer for Totals -->
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
            <td><input type="number" name="items[0][rate]" class="form-control rate" value="" min="0"></td>
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
            <button type="submit" class="btn btn-primary col-md-2 offset-md-5 btn-sm">Create</button>
            <a class="btn btn-danger col-md-2 btn-sm" href='/sales-invoices'>Cancel</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Initialize variables
    const customerType = document.getElementById('customerType');
    const gstRow = document.getElementById('gstRow');
    const phoneInput = document.getElementById('customerPhone');
    const nameInput = document.getElementById('customerName');

    // Main calculation function
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

        // Update table footer cells
        document.querySelector("#itemTable #subTotal").textContent = subTotal.toFixed(2);

        if (customerType.value === "Whole Sale") {
            let gst = subTotal * 0.05;
            document.querySelector("#itemTable #gstRow").style.display = '';
            document.querySelector("#itemTable #gstAmount").textContent = gst.toFixed(2);
            document.querySelector("#itemTable #totalAmount").textContent = (subTotal + gst).toFixed(2);
        } else {
            document.querySelector("#itemTable #gstRow").style.display = 'none';
            document.querySelector("#itemTable #gstAmount").textContent = "0.00";
            document.querySelector("#itemTable #totalAmount").textContent = subTotal.toFixed(2);
        }
    }

    // Add new row
    // Add new row
document.getElementById('addRow').addEventListener('click', () => {
    let tbody = document.querySelector("#itemTable tbody");
    let rowCount = tbody.querySelectorAll('tr').length;
    let newRow = document.createElement('tr');

    newRow.innerHTML = `
        <td><input type="text" name="items[${rowCount}][barcode]" class="form-control barcode"></td>
        <td>
            <select name="items[${rowCount}][id]" class="form-control itemName">
                ${[...document.querySelectorAll('#itemTable .itemName option')]
                    .map(opt => `<option value="${opt.value}">${opt.textContent}</option>`).join('')}
            </select>
        </td>
        <td><input type="number" name="items[${rowCount}][qty]" class="form-control qty" value="1" min="1"></td>
        <td><input type="number" name="items[${rowCount}][rate]" class="form-control rate" value="0" min="0"></td>
        <td class="amount">0.00</td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
    `;
    
    tbody.appendChild(newRow);
});

    // Customer phone lookup
    phoneInput.addEventListener('input', () => {
        let phone = phoneInput.value.trim();
        if (phone.length >= 5) {
            fetch(`/get-customer-by-phone?phone=${encodeURIComponent(phone)}`)
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        nameInput.value = data.name;
                    } else {
                        nameInput.value = '';
                    }
                })
                .catch(err => console.error("Error:", err));
        } else {
            nameInput.value = '';
        }
    });

    // Handle all dynamic changes in the table
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
                            calculateTotals();
                        } else {
                            alert('Item not found');
                            row.querySelector('.itemName').value = '';
                            row.querySelector('.rate').value = '';
                            calculateTotals();
                        }
                    })
                    .catch(err => console.error(err));
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
                            calculateTotals();
                        } else {
                            row.querySelector('.barcode').value = '';
                            row.querySelector('.rate').value = '';
                            calculateTotals();
                        }
                    })
                    .catch(err => console.error(err));
            } else {
                row.querySelector('.barcode').value = '';
                row.querySelector('.rate').value = '';
                calculateTotals();
            }
        }
    });

    // Handle quantity and rate changes
    document.querySelector('#itemTable').addEventListener('input', (e) => {
        if (e.target.classList.contains('qty') || e.target.classList.contains('rate')) {
            calculateTotals();
        }
    });

    // Handle customer type change
    customerType.addEventListener('change', calculateTotals);

    // Handle row removal
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

    // Prevent form submission on Enter key
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