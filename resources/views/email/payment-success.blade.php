<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }
                #printable-content, #printable-content * {
                    visibility: visible;
                }
                #printable-content {
                    position: absolute;
                    left: 0;
                    right:0;
                    top: 0;
                    bottom:0;
                }
            }
        </style>
    </head>
    <body>
        <div id="printable-content">
            <table style="width: 100%; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: 400; vertical-align: middle; line-height: 1.5em;">
                <tr>
                    <td style="text-align: right;">
                        <b>Dr Umed Cosmetics</b><br>
                        0407194519<br>
                        <a href="mailto:info@drumedcosmetics.com.au">info@drumedcosmetics.com.au</a><br>
                        ABN # xx-xxx-xxx
                    </td>
                </tr>
            </table>
            <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">TAX INVOICE / RECEIPT</h3>
            <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">CUSTOMER</p>
            <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">DATE OF ISSUE<br> <b>{{ date('d-m-Y', strtotime($invoice->invoice_date)) }}</b></p>
            <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em; text-align: right;">INVOICE NUMBER: <b>#INV{{$invoice->id}}</b></p>
            <br>
            <table style="width: 100%; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: 400; vertical-align: middle; line-height: 1.5em;">
                <tr>
                    <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: left;" >Quantity</th>
                    <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: left;">Service</th>
                    <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: right;" >Price</th>
                </tr>
                
                @foreach ($invoice->products as $product)
                <tr>
                    <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;">{{ $product->product_quantity }}</td>
                    <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;">{{ $product->product_name }}</td>
                    <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">${{ ($product->product_price * $product->product_quantity) - $product->discount_value}}</td>
                </tr>
                @endforeach
                
                <tr>
                    <td colspan="3" style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">
                        Subtotal: ${{ $invoice->subtotal }}<br>
                        Total: <strong style="font-size: 20px;">${{ $invoice->total }}</strong><br>
                        GST: ${{ $invoice->gst }}
                    </td>
                </tr>
                
                <tr>
                    <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;" colspan="2">PAYMENTS</td>
                    <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;"></td>
                </tr>
                
                @foreach ($invoice->payments as $payment)
                <tr>
                    <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;"><b>{{ $payment->payment_type }}</b></td>
                    <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;">{{ date('d-m-Y', strtotime($payment->date)) }}</td>
                    <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">${{ $payment->amount }}</td>
                </tr>
                @endforeach
                
                <tr>
                    <td colspan="3" style="padding: 0.9rem; text-align: right;">
                        Total Paid: <strong style="font-size: 20px;">${{ $invoice->total_paid }}</strong><br>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>