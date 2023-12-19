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

                    <img src="{{ $logo }}" width="200" height="80">
                </div>
                <h1 class="text-center mt-3" style="font-size: 39px;">{{ $title}}</h1>
                <p class="text-center mt-3"> <b>To Whom It May Concern</b></p>
                <address class="text-end mt-4" style="">
                    BVM Infotech<br>
                    Address: 1051, Silver Business Point<br>
                    VIP Circle, Uttran, Surat, Gujarat<br>
                    Email: info@bvminfotech.com<br>
                    Mobile Number: +91 70694 59872<br><br>
                    Date: {{ date_formate($employee_details['created_at']) }}
                </address>
            </div>
            <div class="col-md-12">
                <p class="text-star">Dear {{ $employee_details['first_name'] }} {{ $employee_details['last_name'] }},</p>
                <p >We are pleased to offer you the full-time position of {{ $employee_details['designation_name'] }} at BVM InfoTech with a start date of {{ $employee_details['DOJ'] }}. We believe that your abilities and experience will be the perfect fit for our company.</p>
                <p>We are starting with a probationary period of two months starting from the date of your joining. However, this period can be cut short or extended based on the individual’s performance and at the discretion of the management.</p>
                <p>After successfully completing the probation period, you'll be a regular team member of BVM InfoTech, and you will get paid    {{$employee_details['salary']}}/- on a monthly basis by direct deposit.</p>
                <p>We look forward to having you on our team! If you have any questions, please feel free to reach out at
                    your earliest convenience.</p>
                <p>To accept our offer, please sign and date this full-time offer letter as indicated below and email it back to us by {{ date_formate(date('Y-m-d H:i:s', strtotime($employee_details['created_at'] . ' +1 day'))) }}.</p>

            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div>Sincerely, <span style="padding-left: 400px;">Date:</span></div>
                @php
                    if(file_exists( public_path().'/upload/company_info/'. $systemDetails[0]['signature']) && $systemDetails[0]['signature'] != ''){
                        $signature = public_path("upload/company_info/". $systemDetails[0]['signature']);
                    }else{
                        $signature = public_path("upload/company_image/sign.png");
                    }
                @endphp

                {{-- <img src="{{ asset('employee/signature/sign.png') }}" width="200" height="80"> --}}
                <img src="{{ $signature }}" width="150" height="50">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div><span style="padding-left: 465px;">Sign:__________</span></div>
            </div>
        </div>
        </div>
    </div>
</body>
</html>

