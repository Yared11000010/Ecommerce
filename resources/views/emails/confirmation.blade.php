<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <tr><td>Dear {{ $name }}</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>Please click on below link to activate your BYT Developers Account :</td></tr>
    <tr></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td><a href="{{ url('user/confirm/'.$code) }}">Confirm Account</a></td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>Thanks $ Regards,</td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>BYT Developers</td></tr>
</body>
</html>