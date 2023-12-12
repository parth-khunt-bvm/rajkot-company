<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Offer Letter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <div class="mt-5 ml-5 mr-5">
        <div class="m-4">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    @php
                        if(file_exists( public_path().'/upload/company_info/'.$systemDetails[0]['logo']) &&$systemDetails[0]['logo'] != ''){
                            $logo= public_path("upload/company_info/".$systemDetails[0]['logo']);
                        }else{
                            $logo = public_path("upload/company_image/logo.png");
                        }
                    @endphp

                    <img src="{{ $logo }}" width="130" height="75">
                </div>
                <h1 class="text-center mt-3" style="font-size: 39px;">{{ $title}}</h1>
                <address class="text-end mt-4" style="">
                  <b> BVM Infotech<br>
                    1051, Silver Business Point<br>
                    VIP Circle, Uttran, Surat,<br>
                    Gujarat- 395000<br>
                    Date: {{ date_formate($employee_details['created_at']) }}
                 </b>
                </address>
            </div>

            <div class="col-md-12">
                <strong><p class="text-start">Dear {{ $employee_details['first_name'] }} {{ $employee_details['last_name'] }},</p></strong><br>
                <p style="font-size:17px;" >We are pleased to offer you the position of <b>{{ $employee_details['designation_name'] }}</b> with <b>BVM Infotech (Silver Branch).</b></p><br>
                <p style="font-size:18px;"><b>Date of Joining:</b> {{ date_formate($employee_details['DOJ']) }}</p>
                <p style="font-size:18px;"><b>Job Title:</b> {{ $employee_details['designation_name'] }}</p>
                <p style="font-size:18px;"><b>Job Location:</b> 1051, Silver Business Point VIP Circle, Uttran, Surat, Gujarat- 395000</p>
                <p style="font-size:18px;"><b>Working Hours:</b> 09:00 AM to 06:00 PM Monday to Friday</p><br>
                <p style="font-size:18px;"><b>Reporting Manager:</b> Pankaj Godhani</p><br>
                <p style="font-size:18px;"><b>We would like to wish you a good luck</b></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" style="padding-left: 490px;">
                <div><span style="font-size:18px;" >Sincerely,</span></div>
                @php
                if(file_exists( public_path().'/upload/company_info/'. $systemDetails[0]['signature']) && $systemDetails[0]['signature'] != ''){
                    $signature = public_path("upload/company_info/". $systemDetails[0]['signature']);
                }else{
                    $signature = public_path("upload/company_image/sign.png");
                }
                @endphp
                <img src="{{ $signature }}" width="150" height="50">
            </div>
        </div>
        </div>
    </div>
</body>
</html>

