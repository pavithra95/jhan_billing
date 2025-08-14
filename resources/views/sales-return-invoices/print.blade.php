
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Sale Return Invoice</title>
		<meta name="description" content="">
		<meta name="author" content="">
		<link href="/assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="/assets/css/styles.css" rel="stylesheet">
		<link href="/assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	</head>
	<body  onload="window.print()" style="font-family: calibri;">
				<div class="container">
			
						<div class="row">
				<div class="col-xs-12">
					<table class="table table-bordered">
						<tr>
							<td colspan="2">
								<div class="col-xs-6 company_details">
									<!--<img src="assets/images/printlogo.jpg" style="width:250px;padding-top:5px;padding-bottom:5px;text-align:right;">-->
									<!--<h1><b>DISTRIBUTORS</b></h1>-->
									<img src="/assets/images/srlogo.png" style="width:250px;padding-top:5px;padding-bottom:5px;text-align:right;">
									<p><strong>GSTIN :</strong> 33IESPS8823D1ZX</p>
									<p><strong>Address :</strong> SF.NO : 343/D,Green view Telecom Colony, 
									<p>Opp to Visakhapatnam Steels, Peelamedu,</p>
									<p>Coimbatore, Tamil Nadu 641041. </p>       
									<p><strong>Mobile :</strong> +91 9943202090, 9787372757 </p>
									<p><strong>Email Id :</strong> srdistributors@gmail.com </p>
									
								</div>
								<div class="col-xs-2" style="width: 48.333333%;padding-left: 130px;">
									<!--<img src="/assets/images/printlogo.jpg" style="width:170px;padding-top:5px;text-align:right;">-->
									<!--<p><strong>GSTIN    &nbsp;&nbsp;&nbsp;&nbsp;:</strong> 33IESPS8823D1ZX</p>
									<p><strong>Address  &nbsp;:</strong> SF.NO : 343/D,Green view Telecom Colony, Opp to Visakhapatnam Steels, Peelamedu,</p>
									<p>Coimbatore, Tamil Nadu 641041. </p>       
									<p><strong>Mobile   &nbsp;&nbsp;&nbsp;&nbsp;:</strong> +91 9943202090, 9787372757 </p>
									<p><strong>Email Id&nbsp;&nbsp;&nbsp;:</strong> srdistributors@gmail.com </p>-->
									<div class="text-gray-light"><b></b></div><br>
									<h3 class="title text-center" style="letter-spacing: 5px;font-size: 32px;font-weight: 600;">CREDIT NOTE</h3>
									<h4 class="invoice-id text-center" style="line-height: 1.8;"><b>Number	:</b> {{$sales->invoice_no}}</h4>
									<h4 class="date text-center" style="margin-bottom: 0px;"><b>Date	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b> {{$sales->invoice_date}}</h4>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<div class="col-xs-7 customer_details">
								<div class="text-gray-light" style="line-height: 1.8;"><b>BILLED TO:</b></div>
									<h5 class="to"><strong>{{$sales->customer->name}}</strong></h5>
									<div class="address"><b>GSTIN :</b> {{$sales->customer->gst_no}}</div>
									<div class="address"><b>Address : </b> {{$sales->customer->address}}</div>
									<!--<div class="address"><b>City: </b>{{$sales->customer->city}}</div>-->
									<div class="address"><b>Mobile : </b> {{$sales->customer->phone}}</div>
									<!--<div class="address"><b>GSTIN :</b>{{$sales->customer->gst_no}}</div>-->
								</div>
								<div class="col-xs-5" style="vertical-align:middle;text-align:right;margin-top: -10px;">
								<div class="text-gray-light"><b></b></div><br>
									<h3 class="title text-center" style="letter-spacing: 6px;font-size: x-large;font-weight: 600;">AGANIST INVOICE</h3><br>
									<h4 class="invoice-id text-center" style="line-height: 1.8;margin-top: -20px;"><b>Number	&nbsp;:</b> {{$sales->reference_no}}</h4>
									<h4 class="date text-center" style="margin-bottom: 5px;"><b>Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b> {{$sales->due_date}}</h4>
								</div>
							</td>
						</tr>
					</table>
					
					<!--<h4 class="text-center" style="font-weight:bold;">POLO SHIRT - BOYS</h4>-->
					<table class="table table-bordered" style="margin-bottom: 0px;" height="auto">
						<thead>
							<tr>
								<th rowspan="3"style="vertical-align:middle;width:50px;text-align:center;text-transform:uppercase;">S.No</th>
								<th rowspan="3" style="vertical-align:middle;width:150px;text-align:center;text-transform:uppercase;">Product Name</th>
								<th rowspan="3" style="vertical-align:middle;width:120px;text-align:center;text-transform:uppercase;">HSN Code</th>
								<th rowspan="3" style="vertical-align:middle;text-align:center;text-transform:uppercase;">Qty</th>
								<th rowspan="3" style="vertical-align:middle;text-align:center;text-transform:uppercase;">Rate</th>
								<th rowspan="3" style="vertical-align:middle;text-align:center;text-transform:uppercase;">GST %</th>
								<th rowspan="3" style="vertical-align:middle;text-align:center;text-transform:uppercase;">CESS %</th>
								<th rowspan="3" style="vertical-align:middle;width:150px;text-align:center;text-transform:uppercase;">Amount </th>
							</tr>
							
						</thead>
						<tbody>
							@foreach ($sales_item as $key=>$item)

							<tr>
								
							
								<td style="vertical-align:middle;width:50px;text-align:center;text-transform:uppercase;">{{$key + 1}}</td>
								<td style="vertical-align:middle;width:150px;text-align:center;text-transform:uppercase;">{{$item->item_name}}</td>
								<td style="vertical-align:middle;width:120px;text-align:center;text-transform:uppercase;">{{$item->product->hsn_code}}</td>
								<td style="vertical-align:middle;text-align:center;text-transform:uppercase;">{{$item->quantity}}</td>
								<td style="vertical-align:middle;text-align:center;text-transform:uppercase;">{{$item->item_price}}</td>
								<td style="vertical-align:middle;text-align:center;text-transform:uppercase;">{{ $item->ProductTax->group_type_name}}</td>
								<td style="vertical-align:middle;text-align:center;text-transform:uppercase;">{{ $item->CessProductTax->group_type_name }}</td>
								<td style="vertical-align:middle;width:150px;text-align:center;text-transform:uppercase;">{{ number_format($item->total_amount, 2) }} </td>
							</tr>

							@endforeach
													
						<tbody>
							<tr>
								<td class="no text-center" colspan="3"><strong>TOTAL</strong></td>
								<td class="qty" style="vertical-align:middle;text-align:center;">{{$total_qty}}</td>
								<td class="qty" colspan="1"></td>
								<td class="qty" colspan="1"></td>
								<td class="qty" colspan="1"></td>
								<td class="qty" colspan="1" style="vertical-align:middle;text-align:center;"  >{{$total_amount}}</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered" style="margin-bottom: 0px;">
						<thead>
							<tr>
								<th style="vertical-align:middle;text-align:left;width:60%;">
								
								
									
                           
									<h5><b>Tax Split :</b> @foreach ($gst as $g)
										<span>({{$g->item_name}} - {{$g->total_amount}})</span>@endforeach @foreach ($cess as $c) & ({{$c->item_name}} - {{$c->total_amount}}) @endforeach
										
									</h5>
								
                           
									<div class="clearfix"></div>
									<div class="height50"></div>
									<div class="height30"></div>
								</th>
								<th style="vertical-align:middle;text-align:right;width:40%;">
								<div class="col-xs-6">
								<p style="vertical-align:middle;text-align:left;">Total Excl. GST&nbsp;&nbsp;: </p>
								<p style="vertical-align:middle;text-align:left;">Add GST&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </p>
								<p style="vertical-align:middle;text-align:left;">Add CESS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </p>
								<p style="vertical-align:middle;text-align:left;">Round Off&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	: </p>
								</div>
								<div class="col-xs-6 ">
								<p style="vertical-align:middle;text-align:rigth;font-weight: 300;">{{$sub_total}}</p>
								<p style="vertical-align:middle;text-align:rigth;font-weight: 300;">{{$total_gst}}</p>
								<p style="vertical-align:middle;text-align:rigth;font-weight: 300;">{{$total_cess}}</p>
								<p style="vertical-align:middle;text-align:rigth;font-weight: 300;">{{ number_format($roundoff->total_amount,2) }}</p>
								</div>
									<!--<p colspan="2" style="vertical-align:middle;text-align:left;">Total value before GST : <strong colspan="9">6546546</strong></p>
									<div class="clearfix"></div>
									<div class="height10"></div>
									<h5>Total GST: 1251</h5>
									<h5>Total CESS: 1500</h5>
									<h5>Round off: 1500</h5>-->
									<div class="clearfix"></div>
									<div class="height30"></div>
									<div class="height10"></div>
								</th>
							</tr>
							<tr>
								
								<th style="vertical-align:middle;text-align:left;width:60%;">
									<h5><b>Total Amount In Words :</b> {{ucwords(getIndianCurrency($sales->total_amount))}}</h5>
									<div class="clearfix"></div>
									<div class="height20"></div>
									<div class="height10"></div>
								</th>
								<th style="vertical-align:middle;text-align:right;width:40%;">
								<div class="col-xs-6">
									<p style="vertical-align:middle;text-align:left;">GRAND TOTAL &nbsp;&nbsp;: <!--{{ number_format($sales->total_amount,2) }}--></p></div>
									<div class="col-xs-6">
									<p style="vertical-align:middle;text-align:right;"><!--GRAND TOTAL : -->{{ number_format($sales->total_amount,2) }}</p></div>
									<div class="clearfix"></div>
									<div class="height20"></div>
									<div class="height10"></div>
								</th>
							</tr>
							<tr>
								<th style="vertical-align:middle;text-align:left;width:50%;">
								<p style="font-size:16px"><b>Bank Details </b></p>
									<div class="height07"></div>
									<p style="font-size:15px;font-weight:450;line-height: 1.6;">Bank Name : SOUTH INDIAN BANK</p>
									<div class="height07"></div>
									<p style="font-size:15px;font-weight:450;line-height: 1.6;">Account Number : 11235689741055</p>
									<div class="height07"></div>
									<p style="font-size:15px;font-weight:450;">IFSC Code : AMB258963</p>
									<div class="clearfix"></div>
									<div class="height30"></div>
									<div class="height10"></div>
									
								</th>
								<th style="vertical-align:middle;text-align:left;width:50%;">
									<p style="font-size:16px"><b>Terms & Conditions </b></p>
									<h6></h6>
									<p style="font-size:15px;font-weight:450;line-height: 1.6;">1. Goods once sold cannot be taken back.</p>
									<div class="height08"></div>
									<p style="font-size:15px;font-weight:450;line-height: 1.6;">2. Interest @24% p.a will be charged if the payment is not made within the stipulated time.</p>
									<div class="height08"></div>
									<p style="font-size:15px;font-weight:450">3. Subject to 'Coimbatore' Jurisdiction.</p>
									<div class="clearfix"></div>
									<div class="height20"></div>
									<div class="height10"></div>
								</th>
								<!--<th style="vertical-align:middle;text-align:left;width:50%;">
									<h4>DSE NAME : </h4>
									<div class="clearfix"></div>
									<div class="height50"></div>
									<div class="height30"></div>
								</th>
								<th style="vertical-align:middle;text-align:left;width:50%;">
									<h4>ASM NAME : </h4>
									<div class="clearfix"></div>
									<div class="height50"></div>
									<div class="height30"></div>
								</th>-->
								
							</tr>
							<tr>
								<!--<th style="vertical-align:middle;text-align:left;width:50%;">
									<h4>BANK DETAILS : </h4><br>
									<p style="font-size:16px"><b>BANK NAME : SOUTH INDIAN BANK</b></p>
									<div class="height10"></div>
									<p style="font-size:16px"><b>ACCOUNT NUMBER : 11235689741055</b></p>
									<div class="height10"></div>
									<p style="font-size:16px"><b>IFSC CODE : AMB258963</b></p>
									<div class="clearfix"></div>
									<div class="height20"></div>
									<div class="height10"></div>
								</th>-->
								<!--<th style="vertical-align:middle;text-align:left;width:50%;">
									<p style="font-size:16px"><b>Bank Details </b></p>
									<div class="height07"></div>
									<p style="font-size:14px"><b>Bank Name : SOUTH INDIAN BANK</b></p>
									<div class="height07"></div>
									<p style="font-size:14px"><b>Account Number : 11235689741055</b></p>
									<div class="height07"></div>
									<p style="font-size:14px"><b>IFSC Code : AMB258963</b></p>
									<div class="clearfix"></div>
									<div class="height20"></div>
									<div class="height10"></div>
								</th>-->
								<th style="vertical-align:middle;text-align:center;width:50%;">
									<h5>Receiver Signature  </h5><br><br><br>
									<h6></h6>
									<div class="height20"></div>
									<div class="clearfix"></div>
									<div class="height20"></div>
									<div class="height10"></div>
									
								</th>
								<!--<th style="vertical-align:middle;text-align:left;width:50%;">
									<h4>DSE NAME : </h4>
									<div class="clearfix"></div>
									<div class="height50"></div>
									<div class="height30"></div>
								</th>
								<th style="vertical-align:middle;text-align:left;width:50%;">
									<h4>ASM NAME : </h4>
									<div class="clearfix"></div>
									<div class="height50"></div>
									<div class="height30"></div>
								</th>-->
								<th style="vertical-align:middle;text-align:center;width:50%;">
									<h5>For SR DISTRIBUTORS  </h5>
									<div class="clearfix"></div>
									<div class="height50"></div>
									<div class="height30"></div>
									<h6>Authorised Signatory </h6>
									
								</th>
							</tr>
						</thead>
					</table>
					<!--<table class="table table-bordered">
						<tbody>
							<tr>
								<td style="vertical-align:middle;text-align:center;"><strong>ORDER CREATED BY :</strong> SUPER ADMIN</td>
							</tr>
						</tbody>
					</table>
					<h6 style="text-align:center;">This is an automatic system generated invoice, does not require signature of the company personnel.</h6>-->		
				</div>
			</div>
			<div class="pagebreak"></div>
					</div>
				<script src="/assets/bower_components/jquery/dist/jquery.min.js"></script>
		<script src="/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	</body>
</html>