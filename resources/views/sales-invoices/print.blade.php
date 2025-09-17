<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bill</title>
    <style>
        @media print {
            @page {
                margin: 0mm;
                width: 80mm;
            }
            body{
            display: flex;
            justify-content: center;
            background-color: #333;
        }
        .container{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 80mm;
            background-color: white;
            padding: 2px;
        }
        .logo{
            margin-top: 0;
            margin-bottom: 0;
            font-size: 1.5em ;
        }
        .line{
            margin-top: 0;
            width: 100%;
            border-bottom: 1px groove black;
        }
        table,th,td{
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }
        .details{
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 0 5px;
        }
       
        table{
            font-size: 16px;
            width: 100%;
            margin-top: 5px;
            margin-bottom: 5px;

        }
        .add{
            text-align: center;
            font-size: 14px;
            margin-top: 0;
        }
        .total p{
            text-align: right;
            font-size: 18px;
            margin-top: 5px;
        }
        .total {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            width: 100%;
            padding: 0 5px;
        
        }
        span{
            font-weight: 700;
            
        }
        .total span{
            font-size: 18px;
            margin-bottom: 0;
        }
        .thank h4{
            text-align: center;
            font-size: 20px;
            margin-top: 0;
            margin-bottom: 5px;
        }
        .foot h4{
            text-align: center;
            font-size: 14px;
            width: 100%;
            margin-top: 0;
            margin-bottom: 2px;
        }
        .line1 {
            margin-top: 0;
            width: 100%;
            height: 0.5px;
            border-bottom: 1px dashed black;
        }
        }
         table,th,td{
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }
         
          
        
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <h3 class="logo">Jhan's Collections</h3>
        <div class="add" ><h3>
            Thudiyalur Rd,<br>
            Saravanampatti. <br>
            Phone Number: <span style="font-weight: 700;">7339402937</span> <br>
            GSTIN NO: <span style="font-weight: 700;">33BYFPJ2178C1ZR</span>
        </h3></div>
        <div class="line"></div>
        <div class="details">
            <div class="bill">
                <p>Bill No: <span>{{$invoice->invoice_no}}</span><br>
                Date: <span>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}</span>
                </p>
            </div>
            <div class="customer"><p>Customer: <span>{{$invoice->customer_name}}</span><br>
            Mobile No: <span>{{$invoice->customer_phone}}</span>
            </p></div>
        </div>
        <div class="line"></div>
            <table>
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
        <div class="total">
            <p>Total MRP: <span><s>Rs.{{$mrp}}</s></span><br>
            You Save: <span>Rs.{{$mrp - $invoice->total_amount}}</span><br>
            Sub Total: <span>Rs.{{$invoice->total_amount}}</span> <br>
            Mode Of Payment: <span>{{$invoice->Payment->name ?? ''}}</span>
            </p>
        </div>
        <div class="thank">
            <h4>Thank You...Visit Again...</h4>
        </div>
        <div class="foot">
            <h4>No Return..... No Exchange.....</h4>
        </div>
        <div class="line1"></div>
    </div>
</body>
</html>