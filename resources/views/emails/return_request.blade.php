<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<tr><td>Dear {{ $userDetails['name'] }}</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Your return request for Order no. {{$returnDetails['order_id']}} with BYT Multivendor Ecommerce Website is {{$returnDetails['return_status']}}</td></tr>
<tr></tr><br>
<tr><td>Thanks & Regards,</td></tr>
<tr><td>&nbsp;<br></td></tr>
<tr><td>BYT Developers</td></tr>
</body>
</html>
