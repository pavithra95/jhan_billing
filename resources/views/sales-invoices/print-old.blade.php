<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @media print{
            @page{
                width: 80mm;
                margin: 0;
            }
        
                body{
            display: flex;
            justify-content: center; 
            align-items: center;
            background-color: black;
        }
        .container{
        width: 80mm; 
        margin: 1px;
        padding: 0 5px 5px ; 
        background-color: #fff; 
        color: #000; 
        /* border: 1px solid red;  */
            }
        .logo{
            text-align: center;
            /* margin-top: 10px; */
            padding: 0;
            /* background-color: red; */
        }
       
        .head1{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin-top: 10px;
            border-bottom: 1px solid red;
            padding-bottom: 10px;
        }
        .head2{
            font-size: 10px;
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid red;
        }
        .head3{
            font-size: 10px;
            margin-top: 10px;
            border-bottom: 1px solid red;
            display: flex;
            justify-content: space-around;
        }
        table{
            /* border: 1px solid red; */
            width: 100%;
            border-collapse: collapse;
            
        }
        thead,th {
            border: 1px solid red;
            border-collapse: collapse;
        }
        tbody{
            text-align: center;
        }
        tbody  td{
            border: 1px solid red;
            border-collapse: collapse;
        }
        .head4{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-end;
            font-size: 15px;
            font-weight: 600;
        }
        .foot1{
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }
        .foot2{
            display: flex;
            /* flex-direction: column; */
            /* align-items: center; */
            justify-content: center;
            /* text-decoration: dashed underline; */
        }
        .foot2 {
            /* text-decoration: underline dashed black 0.8px; */
            border-bottom: 1px dashed red ;
            /* width: 100vw; */
        }
    
        /* h1{
            color: crimson;
        } */
        .bill p, .date p{
            font-weight: 800;
        }
        .bill p span,
.date p span {
    font-weight: normal; /* overrides bold inside span */
}
h3{
    margin: 0;
}
p{
    margin: 4px;
}
        }
        
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="logo">
            <h3>JHAN's Collections</h3>
            </div>
        <div class="head1">
        <div class="address">Thudiyalur Rd,<br> Saravanampatti</div>
        <div class="phone">Phone Number: 9874563210</div>
        <div class="gst" style="font-weight: 500;">GSTIN NO: <span style="font-weight: 700;">33BYFPJ2178C1ZR</span></div>
        </div>
        <div class="head2">
            <div class="bill">
                 <p>Bill No: {{$invoice->invoice_no}}</p>
                <p>Customer: {{$invoice->customer_name}}</p>
                <p>Mobile No: {{$invoice->customer_phone}}</p>
            </div>
            <div class="date">
                <p>Date: <span>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}</span></p>
                <!-- <p>Time: <span>{{ $invoice->created_at->format('h:i A') }}</span></p> -->
            </div>
        </div>
        <div class="bill-table head3">
            <table style="font-size: 12px;">
                <thead>
                    <tr>
                       
                        <th>Item</th>
                        <th>Rate</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                     @foreach ($invoice->SaleItem as $key => $item)
                    
                    <tr>
                        <td>{{  $item->product->name }}</td>
                        <td>{{ $item->rate }}</td>
                        <td>{{  $item->quantity }}</td>
                        <td>{{ $item->amount }}</td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
        <div class="head4">
           <!-- <p>Grand Total: <span></span></p>
            <p>Discount:<span>600.00</span></p> -->
            <p>Grand Total:<span>{{$invoice->total_amount}}</span></p>
        </div>
        <!-- <div class="foot1">
            <h3>Receiver Signature</h3>
            <h3>Authorized Signatory</h3>
        </div> -->
        <div class="foot2">
            <h4>Thank You...Visit Again...</h4>
            <!-- <p></p> -->
        </div>
    
</body>
</html>