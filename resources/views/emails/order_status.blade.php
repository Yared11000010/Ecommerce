<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    <table style="width:700px;">
    <h1 style="align-items: center"><strong> BYT Developers</strong></h1>
    <tr><td>&nbsp;</td></tr>
    <tr><td> <img src="" alt=""> </td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>Hello {{ $name }}</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>Your Order #{{ $order_id }} status has been updated to {{ $order_status }}</td></tr>
    <tr><td>&nbsp;</td></tr>
    @if(!empty($courier_name) && !empty($tracking_number))
    <tr><td>
        Courier Name is {{ $courier_name }} and Tracking Number is {{ $tracking_number }}
    </td></tr>
    @endif
    <tr><td> Your Order details are as below.</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>
        <table style="width:95%" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
        <tr bgcolor="#cccccc">
             <td>Product Name</td>
             <td>Product Code</td>
             <td>Product Size</td>
             <td>Product Color</td>
             <td>Product Quantity</td>
             <td>Product Price</td>
        </tr>
        @foreach ($orderDetails['orders_products'] as $order )
        <tr bgcolor="#f9f9f9">
            <td>{{ $order['product_name'] }}</td>
            <td>{{ $order['product_code'] }}</td>
            <td>{{ $order['product_size'] }}</td>
            <td>{{ $order['product_color'] }}</td>
            <td>{{ $order['product_qty'] }}</td>
            <td>{{ $order['product_price'] }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="5" align="right"> Shipping Charges</td>
            <td>{{$orderDetails['shipping_charges']}}.Birr</td>
        </tr>
        <tr>
            <td colspan="5" align="right">Coupon Discount</td>

            <td>
                {{$orderDetails['coupon_amount']}}.Birr
             
            </td>
        </tr>
        <tr>
            <td colspan="5" align="right">Grand Total</td>
            <td>{{$orderDetails['grand_total']}} .Birr</td>
        </tr>
        </table>  
    </td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>
                        <strong>Delivery Address:</strong>
                    </td>
                </tr>
                <tr>
                   <td>{{ $orderDetails['name'] }}</td>
                </tr>
                <tr>
                    <td>{{ $orderDetails['address'] }}</td>
                 </tr>
                 <tr>
                    <td>{{ $orderDetails['city'] }}</td>
                 </tr>
                 <tr>
                    <td>{{ $orderDetails['state'] }}</td>
                 </tr>
                 <tr>
                    <td>{{ $orderDetails['country'] }}</td>
                 </tr>
                 <tr>
                    <td>{{ $orderDetails['pincode'] }}</td>
                 </tr>
                 <tr>
                    <td>{{ $orderDetails['mobile'] }}</td>
                 </tr>
            </table>

        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>For any queries, you can contact us at <a href="">Byt Developers.in</a></td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>Regards,<br>Team Byt Developers</td></tr>
    <tr><td>&nbsp;</td></tr>
    </table>
</body>
</html>