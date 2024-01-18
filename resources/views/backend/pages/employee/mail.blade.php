<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Platform</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
            text-align: center;
        }

        p {
            color: #666666;
            text-align: center;
        }

        .logo {
            display: block;
            margin: 20px auto; /* Center the logo */
        }

        .btn {
            display: inline-block;
            padding: 8px 15px; /* Adjust the padding to make it smaller */
            background-color: #3498db;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            margin: 20px auto; /* Center the button */
            display: block;
            font-size: 14px; /* Adjust the font size to make it smaller */
        }
    </style>
</head>

@php
 $systemDetails = get_system_details(1);
if(file_exists( public_path().'/upload/company_info/'.$systemDetails[0]['logo']) &&$systemDetails[0]['logo'] != ''){
    $logo= public_path("upload/company_info/".$systemDetails[0]['logo']);
}else{
    $logo = public_path("upload/company_image/logo.png");
}
@endphp
<body>
    <div class="container">
        {{-- <img src="{{ asset('public/upload/company_info/'.$systemDetails[0]['logo'] ) }}" alt="Your Logo" class="logo" width="150"> --}}
        {{-- <img alt="Logo" src="{{  asset('public/upload/company_info/logo.png') }}" class="logo-default max-h-60px" style="width: 250px;" /> --}}
        <img alt="Logo" src="{{ asset("upload/company_image/logo.png") }}" class="logo-default max-h-60px" style="width: 250px;" />

        <h1>Welcome to Our  {{ $data['company'] }}</h1>
        <p>Hello {{ $data['first_name'] }} {{ $data['last_name'] }},</p>
        <p>We're excited to welcome you to our platform! Thank you for joining us.</p>
        <p>Here are some things you can do on our platform:</p>
        <ul>
            <li><strong>Email:</strong> {{ $data['gmail'] }}</li>
            <li><strong>Passwprd:</strong> {{ $data['password'] }}</li>
        </ul>
        <p>Feel free to get started right away!</p>
        <a href="{{ route('my-login')}}" class="btn">Get Started</a>
        <p>If you have any questions or need assistance, feel free to contact our support team.</p>
        <p>Thank you again for choosing our platform!</p>
        <p>Best regards,<br>{{ $data['company'] }}</p>
    </div>
</body>
</html>
