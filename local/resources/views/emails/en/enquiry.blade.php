<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Enquiry</title>
</head>
<body>
   <h4>Hello,</h4>
   <p>You have a enquiry from website.</p>
   <p>If you requested this change, set a new password here:</p>
   <br>
   <p>Customer Name : {{ $full_name }}</p>
   <p>Customer Email : {{ $email }}</p>
   <p>Customer Mobile : {{ $mobile_number }}</p>
   <p>Customer Message : {{ $content }}</p>
   <br>
   <br>
   <br>
   <p>Best Regards,</p>
   <p>Team Laravel</p>
</body>
</html>