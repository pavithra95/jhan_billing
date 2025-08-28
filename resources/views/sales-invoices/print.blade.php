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
            /* display: flex;
            justify-content: center; */
            /* align-items: center; */
        }
        .container{
        /* width: 80mm; */
        /* margin: 1px; */
        
        /* background-color: #333; */
        /* color: white; */
        /* border: 1px solid red; */
            }
        .logo{
            text-align: center;
            margin-top: 10px;
        }
       
        .head1{
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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
            width: 100vw;
        }
        h1{
            color: crimson;
        }
            }
        
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="logo">
            <!-- <img src="./JHAN’s.png" alt="logo" width="150px" style="backdrop-filter: inherit;"> -->
            <!-- <h1 style="">JHAN's <br> <span style="font-weight: 200; font-size: 15px; color: black;">Collections</span></h1> -->
             <span style="font-size: 30px; font-weight: 700;">JHAN's Collections</span> 
        </div>
        <div class="head1">
        <div class="address">15 Thudiyalur Rd,<br> Vasantham Nagar,<br> Saravanampatti,<br>
            Coimbatore-641035</div>
        <div class="phone">Phone Number: 9874563210</div>
        <div class="gst" style="font-weight: 500;">GSTIN NO: 33IESPS8823D1ZX</div>
        </div>
        <div class="head2">
            <div class="bill">
                <p>Bill No: {{$invoice->invoice_no}}</p>
                <p>Customer: {{$invoice->customer_name}}</p>
                <p>Mobile No: {{$invoice->customer_phone}}</p>
            </div>
            <div class="date">
              <p>Date: {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}</p>

                <!-- <p>Time: {{$invoice->created_at->format('h:i A')}}</p> -->
            </div>
        </div>
        <div class="bill-table head3">
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Item</th>
                        <th>Rate</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->SaleItem as $key => $item)
                    <tr>
                    <tr>
                        <td>{{ $item->barcode }}</td>
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
            <p> Sub Total: Rs. {{$invoice->sub_total}}</p>
            <p> Gst : Rs. {{$invoice->gst_amount}}</p>
            <p> Total: Rs. {{$invoice->total_amount}}</p>
        </div>
        <div class="foot1">
            <h3>Receiver Signature</h3>
            <h3>Authorized Signatory</h3>
        </div>
        <div class="foot2">
            <h3>Thank You... Visit Again...</h3>
            <p></p>
        </div>
    </div>
</body>
</html>