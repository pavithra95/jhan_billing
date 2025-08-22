<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Sales Invoice</title>
	<link href="/assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="/assets/css/styles.css" rel="stylesheet">
	<link href="/assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<style>
		body, p, h1, h2, h3, h4, h5, h6 {
			font-family: 'Calibri', sans-serif !important;
			font-size: 15px;
		}
		.table-bordered {
			border: 2px solid #0c0c0c;
		}
		.table-bordered>thead>tr>td, 
		.table-bordered>thead>tr>th,
		.table-bordered>tbody>tr>td {
			border: 1px solid #0c0c0c;
		}
	</style>
</head>
<body onload="window.print()">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">

				{{-- Company + Customer Details --}}
				<table class="table table-bordered">
					<tr>
						<td colspan="2">
							<div class="col-xs-6">
								<!-- <img src="/assets/images/srlogo.png" style="width:200px;"> -->
								<p><strong>Jhan's Collections</strong></p>
								<p><strong>GSTIN:</strong> 33IESPS8823D1ZX</p>
								<p><strong>Address:</strong> 15, Thudiyalur Rd, Vasantham Nagar, Saravanampatti<br>
								Coimbatore, Tamil Nadu 641035</p>       
								<p><strong>Mobile:</strong> +91 73394 02937</p>
								<p><strong>Email:</strong> srdistributors@gmail.com</p>
							</div>
							<div class="col-xs-6 text-right">
								<h3 style="letter-spacing: 4px; font-weight: 600;">INVOICE</h3>
								<p><strong>Invoice No:</strong> {{ $invoice->invoice_no }}</p>
								<p><strong>Date:</strong> {{ $invoice->invoice_date }}</p>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="col-xs-7">
								<h5><strong>BILLED TO:</strong></h5>
								<p><b>Name:</b> {{ $invoice->customer->name ?? '-' }}</p>
								<!-- <p><b>GSTIN:</b> {{ $invoice->customer->gst_no ?? '-' }}</p> -->
								<!-- <p><b>Address:</b> {{ $invoice->customer->address ?? '-' }}</p> -->
								<p><b>Phone:</b> {{ $invoice->customer->phone ?? '-' }}</p>
							</div>
						</td>
					</tr>
				</table>

				{{-- Invoice Items --}}
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>S.No</th>
							<th>Product</th>
							<th>HSN Code</th>
							<th>Qty</th>
							<th>Rate</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($invoice->SaleItem as $key => $item)
							<tr>
								<td>{{ $key+1 }}</td>
								<td>{{ $item->product->name ?? 'Deleted Product' }}</td>
								<td>{{ $item->product->hsn_code ?? '-' }}</td>
								<td>{{ $item->quantity }}</td>
								<td>{{ number_format($item->rate,2) }}</td>
								<td>{{ number_format($item->quantity * $item->rate,2) }}</td>
							</tr>
						@endforeach
						<tr>
							<td colspan="3"><strong>TOTAL</strong></td>
							<td>{{ $invoice->SaleItem->sum('quantity') }}</td>
							<td></td>
							<td>{{ number_format($invoice->sub_total,2) }}</td>
						</tr>
					</tbody>
				</table>

				{{-- Totals --}}
				<table class="table table-bordered">
					<tr>
						<td style="width:60%;">
							<h5><b>Total Amount in Words:</b> {{ ucwords(getIndianCurrency($invoice->total_amount)) }}</h5>
						</td>
						<td style="width:40%; text-align:right;">
							<p><b>Sub Total:</b> {{ number_format($invoice->sub_total,2) }}</p>
							<p><b>GST:</b> {{ number_format($invoice->gst_amount,2) }}</p>
							<p><b>Total:</b> {{ number_format($invoice->total_amount,2) }}</p>
						</td>
					</tr>
				</table>

				{{-- Footer --}}
				<table class="table table-bordered">
					<tr>
						<td style="text-align:center;">
							<p><b>Receiver Signature</b></p><br><br>
						</td>
						<td style="text-align:center;">
							<p><b>For SR DISTRIBUTORS</b></p>
							<br><br>
							<p>Authorised Signatory</p>
						</td>
					</tr>
				</table>

			</div>
		</div>
	</div>
</body>
</html>
