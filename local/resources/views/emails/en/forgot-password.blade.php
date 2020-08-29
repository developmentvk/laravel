<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $subject }}</title>
</head>
<body>
   <h4>Hello {{ $name }}</h4>
   <p>There was recently a request to change the password for your account {{ $username }}.</p>
   <p>If you requested this change, set a new password here:</p>
   <p><a href="{{ $buildUrl }}">{{ $buildUrl }}</a></p>
   <p></p>
   <br>
   <br>
   <br>
   <p>Best Regards,</p>
   <p>Team Laravel</p>
</body>
</html>